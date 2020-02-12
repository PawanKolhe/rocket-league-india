<?php namespace JF;

/**
PHP 5.3+ is required.
If mailgun is used AND the form has file upload field, PHP 5.5+ is required.
*/

require_once( __DIR__ . '/form.config.php' );

$dbFile = __DIR__ . '/form.db.php';
if( file_exists( $dbFile ) ){
    require_once( $dbFile );
}

use JF\Config;

// --------------------------------------------------------------
class Form {

    public static function setDataDir( $dir ){
        self::$dataDir = $dir ;
    }

    public static function getFormDataFile(){
        return self::$dataDir . '/form-data.php' ;
    }

    public static function getEmailLogFile(){
        return self::$dataDir . '/email-log.php' ;
    }

    public static function getSmsLogFile(){
        return self::$dataDir . '/sms-log.php' ;
    }

    public static function validate( $post = array() ){
        if( empty($post) ){
            $post = $_POST;
        };

        self::$post        = $post;
        self::$values      = array();
        self::$attachments = array();
        self::$invalid     = array();
        self::$columns     = array( self::csvfield('RecordID'), self::csvfield('Date'), self::csvfield('IP') );
        self::$csvValues   = array( self::csvfield(self::getRecordID()), self::csvfield(date("Y-m-d H:i:s")), self::csvfield($_SERVER['REMOTE_ADDR']) );
        self::$serverValidationFields = empty(self::$post['serverValidationFields']) ? array(): explode(',', self::$post['serverValidationFields']);

        // add preset tags
        self::presetTags();

        if( self::hasField('page_break') ){
            self::$serverValidationFields = array('skip-serverside-validation');
        };

        self::$style  = 'font-family:Verdana, Arial, Helvetica, sans-serif; font-size : 13px; color:#474747;padding:6px;border:1px solid #cccccc;' ;
        self::$rows   = array();
        self::$sms = array();
        $config = self::getConfig();

        foreach( $config['fields'] as $f ){
            switch ($f['field_type']) {
                case 'section_break':
                case 'page_navigation':
                case 'page_break':
                case 'submit':
                    // are not data fields, ignore them, do nothing
                    break;

                case 'recaptcha':
                    $ok = self::validateReCaptcha( $post, $f['recaptcha']['secretKey'] );
                    if( !$ok ) {
                        self::reCaptchaInvalidHandler( $f );
                    };
                    break;

                // creditcard field contains extra fields, have to validate them one by one
                case 'creditcard':
                    self::_validateCreditcardFields( $f );
                    break;

                case 'payment':
                    self::_validatePaymentField( $f );
                    break;

                case 'address':
                    self::_validateAddressField( $f );
                    break;

                default:
                    self::_validateField( $f );
            };
        }; // foreach

        self::$values['dataTable'] = empty(self::$rows) ? '' : '<table cellspacing="0" cellpadding="0" border="1" bordercolor="#cccccc" style="border:1px solid #cccccc;"><tbody>' .
               join( "\n", self::$rows ).
               '</table>';
        self::$values['dataText'] = join( "\n\n", self::$sms );

        self::validateOneEntry();

        // save form data to file
        if( self::isValid() ){
            self::saveRecord();
        };

        self::$isValidated = true; // validation checked
    }

    private static function _validateCreditcardFields($field){
        foreach ($field['subfields'] as $name => $f ) {
            // remove spaces that are created by javascript jquery.payment plugin
            self::$post[$name] = str_replace(' ', '', self::$post[$name]);
            self::_validateField( $f );
        };
    }

    private static function _validatePaymentField( $field ){
        $paymentClasses = array(
            'stripe'    => '\JF\StripePayment',
            'paypal'    => '\JF\PaypalPayment',
            'braintree' => '\JF\BraintreePayment',
        );

        $method = $field['payments']['method'];
        $class = $paymentClasses[$method];
        $include = __DIR__ . "/{$method}/validate.php";
        if( !file_exists($include) ){
            return false;
        };

        require_once( $include );
        $payment = new $class( $field );
        $payment->validate( self::$post );
        if( !$payment->isPaid() ){
            self::$invalid[] = $field['id'];
            self::exitError( $payment->getErrMsg() );
        };
    }

    private static function _validateAddressField($field){
        foreach ($field['subfields'] as $name => $f ) {
            if( ! $f['field_options']['enabled'] ){
                continue;
            };
            $f['id'] = $field['id'] . '_' . $name;
            self::_validateField( $f );
        };
    }

    private static function _validateField($f){
        $key = $f['id'];
        $value = "";
        switch ($f['field_type']) {
            case 'file':
                $value = self::handleUploadFile($f);
                break;

            case 'phone':
                $value = self::$post[$key];
                $value = self::un_quotes( $value );
                $dialCode = self::$post[$key . '_phonelib_dialcode'];
                if( !empty($dialCode) ){
                    $value = '+' . $dialCode . $value;
                };
                break;

            default:
                if( !array_key_exists( $key, self::$post ) ){
                    self::$values[ $key ] = '';
                    continue;
                };

                $value = self::$post[$key];

                // checkboxes or select-multiple
                if( is_array($value) ){
                    $tmp = array();
                    foreach( $value as $v ){
                        $tmp[] = self::un_quotes($v);
                    };
                    $value = join(" | \n", $tmp);

                // other input/textarea ...
                }else{
                    $value = self::un_quotes( $value );
                };
                break;
        }; // switch

        // sanitize input value
        $value = trim(self::stripTags($value));

        if(  !empty($f['field_options']['sender']) ){
            switch (true){
                case ( 'verify_sender' == $f['field_type'] && true == $f['field_options']['sender'] && stripos($value,'@') !== false ) :
                case ( 'email' == $f['field_type'] && true == $f['field_options']['sender'] ) : 
                    $f['field_options']['sender'] = 'email';
                    break;

                case ( 'verify_sender' == $f['field_type'] && true == $f['field_options']['sender'] && stripos($value,'@') === false ) :
                case ( 'phone' == $f['field_type'] && true == $f['field_options']['sender'] ) : 
                    $f['field_options']['sender'] = 'phone';
                    break;
            };
            self::$values[ 'sender.' . $f['field_options']['sender'] ] = $value;
        };

        if( self::isRequired($f) && "" == $value ){
            if( empty(self::$serverValidationFields) || (!empty(self::$serverValidationFields) && in_array($key, self::$serverValidationFields))  ){
                self::$invalid[] = $key;
            };
        };

        self::addColumnValue( $key, $f['label'], $value );
/*
        self::$columns[]   = self::csvfield( $f['label'] );
        self::$csvValues[] = self::csvfield( $value );

        if( "" == $value ){
            $config = self::getConfig();
            if( !empty(self::$config['email']['skipEmptyFields']) ){
                // skip adding field with empty value to {dataTable} and {dataText}
                return;
            }; // if
        }; // if

        self::$rows[] = "<tr> <td valign=top style='" . self::$style."font-weight:bold;width:25%;'>" . $f['label'] . "&nbsp;</td> <td valign=top style='" . self::$style.";'>" . nl2br($value) . "&nbsp;</td></tr>" ;
        self::$sms[] = strip_tags($f['label']) . ":\n" . strip_tags($value);
*/        
    } // _validateField

    // add field or its' sub fields label and value, for saving to csv file, to email, and to sms 
    public static function addColumnValue( $key, $label, $value ){
        self::$values[ $key ] = $value;
        self::$columns[]      = self::csvfield( $label );
        self::$csvValues[]    = self::csvfield( $value );

        if( "" == $value ){
            $config = self::getConfig();
            if( !empty(self::$config['email']['skipEmptyFields']) ){
                // skip adding field with empty value to {dataTable} and {dataText}
                return;
            }; // if
        }; // if

        self::$rows[] = "<tr> <td valign=top style='" . self::$style."font-weight:bold;width:25%;'>" . $label . "&nbsp;</td> <td valign=top style='" . self::$style.";'>" . nl2br($value) . "&nbsp;</td></tr>" ;
        self::$sms[] = strip_tags($label) . ":\n" . strip_tags($value);
    }

    private static function validateReCaptcha( $post, $secretKey ){
        if( !empty($secretKey) && isset($post['g-recaptcha-response']) ){
            $get = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey. '&response=' . $post['g-recaptcha-response'];
            $response = file_get_contents( $get );
            //echo $get . "\n" . $response;
            $success = false;
            if( function_exists('json_decode') ){
                $json = json_decode( $response, true );
                //var_dump($json);
                $success = $json['success'] === true;
            }else{
                $success = preg_match( '/success[\"\']*\\:\\s*(true|1|y)/i', $response );
            };
            return $success;
        };

        return true; // recaptcha is not enabled
    }

    // $f : field config
    private static function reCaptchaInvalidHandler( $f ){
        //self::$invalid[] = 'recaptcha';
        if( !isset($_SESSION['recaptcha_fail_counter']) ){
            $_SESSION['recaptcha_fail_counter'] = 0;
        };
        $_SESSION['recaptcha_fail_counter'] ++;
        $maxFailed = intval($f['recaptcha']['maxFailed']) >= 0 ? $f['recaptcha']['maxFailed'] : 3;
        if( $maxFailed > 0 && $_SESSION['recaptcha_fail_counter'] <= $maxFailed ){
            $errMsg = empty($f['recaptcha']['errMsg']) ? 'Google reCaptcha validation error. Please try again.' : $f['recaptcha']['errMsg'];
            self::exitError(  $errMsg );
        };
    }

    private static function hasField( $type ){
        $config = self::getConfig();
        foreach( $config['fields'] as $field ){
            if( $type == $field['field_type'] ){
                return true;
            }; // if
        }; // foreach

        return false;
    }

    public static function exitError( $msg ){
        $msg = self::replaceTags( $msg, self::$values );
        echo $msg;
        exit;
    }

    private static function validateOneEntry(){
        if( self::hasEntry() ){
            $config = self::getConfig();
            $msg = empty($config['admin']['limitActivity']['message']) ? 'Multiple submissions not accepted.' : $config['admin']['limitActivity']['message'];
            self::exitError( $msg );
        };
    }

    private static function hasEntry(){
        $config = self::getConfig();
        $la = $config['admin']['limitActivity'];
        if( $la['enabled'] !== true ){
            return false;
        };

        $dataFile = self::getFormDataFile();
        if( !file_exists($dataFile) ){
            return false;
        };

        $found = false ;
        $query = $la['by'] == 'email'  ? self::getSenderEmail() : $_SERVER['REMOTE_ADDR'] ;
        if( empty($query) ){
            return false ;
        };

        $query = '"'. strtolower( $query ) . '"';
        $handle = fopen($dataFile,'r');
        if (!$handle) {
            return false;
        };

        while (!feof($handle)) {
           $entry = strtolower(fgets($handle, 4096));
           if( strpos($entry,$query) !== false ){
                $found = true ;
                break;
           };
        };
        fclose($handle);

        return $found ;
    }


    private static function presetTags(){
        self::setValue( 'AutoID', self::getRecordID() );
        self::setValue( 'HTTP_HOST', $_SERVER['HTTP_HOST'] );
        self::setValue( 'IP', $_SERVER['REMOTE_ADDR'] );
        self::setValue( 'Date', date("Y-m-d") );
        self::setValue( 'Time', date("H:i:s") );
        self::setValue( 'HTTP_REFERER', $_SERVER['HTTP_REFERER'] );
        //self::setValue( 'FormURL', '' );
        //self::setValue( 'AdminURL', '' );
        // sender.email
        // sender.firstname
        // sender.lastname
        // sender.fullname
    }

    private static function un_quotes($str){
        return str_replace( array('&quot;', '&#039;'), array('"', "'"), $str );
    }

    private static function handleUploadFile($field){
        if( !isset($_FILES[ $field['id'] ]) ){
            return '';
        };

        $dir = self::getDataDir();
        $files = self::getUploadFileArray($field);
        $names = array();
        // iOS image upload always use same name image.jpeg for all uploads, need to rename it with counter
        $counter = 1;
        $isMultiple = count($files) > 1;

        foreach( $files as $file ){
        	$prefix = $isMultiple ? $counter . '-' : '';
            $fileName =  $prefix . $file['name'];
            if( !is_uploaded_file($file['tmp_name']) ){
                continue;
            }; // is_uploaded

            $safeName = $prefix . self::renameHarmfulFile($file['name']);
            $safeName = preg_replace( "/[^0-9a-zA-Z\.]+/", "-",  $safeName );
            $filePath = $dir . '/' . self::getRecordID() . '-' . $field['id'] . '-' . $safeName ;
            $ok = @move_uploaded_file( $file['tmp_name'], $filePath );

            $link = false;
            if( $ok ) {
                $link = self::checkFile2Link( $field, $filePath );
                if( !empty($link) ){
                    self::setValue( $field['id'] . '.name' . $prefix, $fileName );
                    $fileName = "<a href='{$link}' target='_blank'>{$fileName}</a>";
                };
            };

            // if the file is not a link, then send it as attachment
            if( empty($link) ){
                self::$attachments[] = array('path' => $ok ? $filePath : $file['tmp_name'], 'name' => $fileName );
            };
            $names[] = $fileName;
            $counter ++;
            
        }; // for each

        return join(", ",$names);
    }

    private static function getUploadFileArray($field){
        $upload = $_FILES[ $field['id'] ];
        $isMultiple = is_array( $upload['tmp_name'] );

        if( !$isMultiple ) {
            return array( $upload );
        };

        $names = array();
        foreach( $upload as $key => $values ){
            for( $i = 0, $n = count($values); $i < $n; $i ++){
                $names[$i][$key] = $values[$i];
            };
        }
        return $names;
    }

    private static function checkFile2Link($field, $filepath){
        $kb = $field['field_options']['file']['fileToLinkSize'];
        if( empty($kb) ){
            return false ;
        };

        $filesize = filesize($filepath);
        if( $filesize >= $kb ){
            $link = self::getFileLink( $filepath );
            self::setValue( $field['id'] . '.link', $link );
            return $link;
        };

        return false;
    }

    private static function getFileLink($filepath){
        $realpath = self::dir2unix( realpath($filepath) );
        $link = self::getAdminUrl() . '?method=downloadAttachment&id=' . urlencode(basename($filepath));
        return $link;
    }

    public static function dir2unix( $dir ){
        return str_replace( array("\\", '//'), '/', $dir );
    }

    // parse full admin url to view large size uploaded file online
    public static function getAdminUrl(){
        $url = 'admin.php';
        $http = 'http' . ( empty($_SERVER['HTTPS']) ? '' : 's' ) . '://' ;
        $http_host = $http . "{$_SERVER['HTTP_HOST']}";
        switch( true ){
            case (0 === strpos($url, $http )) :
                $url = $url;
                break;
            case ( '/' == substr($url,0,1) ) :
                $url = $http_host . $url ;
                break;
            default:
                $uri = self::requestUri();
                $pos = strrpos( $uri, '/' );
                $vdir = substr( $uri, 0, $pos );
                $url  = $http_host . $vdir . '/' . $url ;
        };
        return $url;
    }


    public static function requestUri(){
        $uri = getEnv('REQUEST_URI'); // apache has this
        if( false !== $uri && strlen($uri) > 0 ){
            return $uri ;
        } else {

            $uri = ($uri = getEnv('SCRIPT_NAME')) !== false
                   ? $uri
                   : getEnv('PATH_INFO') ;
            $qs = getEnv('QUERY_STRING'); // IIS and Apache has this
            return $uri . ( empty($qs) ? '' : '?' . $qs );

        };
        return "" ;
    }


    public static function getAttachments(){
        return self::$attachments;
    }

    public static function isValid(){
        return empty(self::$invalid);
    }

    public static function isValidated(){
        return self::$isValidated;
    }

    public static function getInvalidFields(){
        return self::$invalid;
    }

    public static function getValue( $id ){
    	return array_key_exists( $id, self::$values ) ? self::$values[$id] : '';
    }

    public static function getAdminUsers(){
        $config = self::getConfig();
        $default = array();
        $admin = empty($config['admin']['users']) ? $default : $config['admin'];

        $users = array();
        $parts = explode(',', $admin['users']);
        foreach( $parts as $part ){
            $pos = strpos( $part, ':' );
            if( false === $pos ){
                continue;
            };
            $user = trim(substr($part,0,$pos));
            $pass = trim(substr($part,$pos+1));
            $users[$user] = array('user' => $user, 'password' => $pass);
        };

        return $users;
    }

    // avoid email header injection by removing line breaks for email headers 
    private static function removeLineBreaks( $str ){
        return trim(preg_replace('/[\r\n]+/', '', $str));
    }

    // Email for mail header
    public static function getFromEmail( $forAutoResponse = false ){
        $email = self::getSenderEmail();
        if( $forAutoResponse || empty($email) ){
            $email = self::$config['email']['to'];
        };

        $sendmail_from = self::$config['email']['sendmail_from'];
        if( !empty($sendmail_from) ){
            ini_set("sendmail_from", $sendmail_from);
            $email = $sendmail_from;
        };

        return self::removeLineBreaks( $email );
    }

    // Name for mail header
    public static function getFromName( $forAutoResponse = false ){
        if( $forAutoResponse ){
            $fromName = self::$config['email']['fromName'];
            return self::removeLineBreaks( self::renderContent($fromName) );
        };

        $fromName = self::getSenderName();
        return self::removeLineBreaks( self::renderContent( $fromName ) );
    }

    public static function getSenderEmail(){
        $email = self::getValue('sender.email');
        return self::removeLineBreaks( $email );
    }

    public static function getFormOwnerPhone(){
        $config = self::getConfig();
        $phone = trim(self::$config['twilio']['toPhone']);
        return $phone;
    }

    public static function getSenderPhone(){
        $phone = self::getValue('sender.phone');
        return $phone;
    }

    public static function getSenderName(){
        $fullname = self::getValue('sender.fullname');
        $name = !empty($fullname) ? $fullname : trim(self::getValue('sender.firstname') . ' ' . self::getValue('sender.lastname')) ;
        return $name;
    }

    public static function getToEmail(){
        self::getConfig();
        return self::removeLineBreaks( self::renderContent(self::$config['email']['to']) );
    }

    public static function getReplyToEmail(){
        self::getConfig();
        return self::removeLineBreaks( self::$config['autoResponse']['replyTo'] );
    }

    public static function getReplyToName(){
        self::getConfig();
        return self::removeLineBreaks( self::renderContent( self::$config['autoResponse']['replyToName'] ) );
    }

    public static function getId(){
        return 'test-form-id';
    }

    public static function getDataDelivery(){
        $config = self::getConfig();
        return self::$config['admin']['dataDelivery'];
    }

    public static function getValues(){
    	return self::$values;
    }


    public static function getMailSubject(){
    	return self::removeLineBreaks( self::renderContent( self::$config['email']['subject'] ) );
    }


    public static function getMailBody(){
    	return self::getHtmlHeader() .
               self::renderContent( self::mailTemplate() ) .
               self::getHtmlFooter();
    }


    public static function getAutoResponseMailSubject(){
    	return self::removeLineBreaks( self::renderContent( self::$config['autoResponse']['subject'] ) );
    }


    public static function getAutoResponseMailBody(){
        $body = self::autoResponseTemplate();
        return empty($body) ? "" :
               self::getHtmlHeader() .
               self::renderContent( $body ) .
               self::getHtmlFooter();
    }


    public static function setValue( $key, $value ){
    	self::$values[$key] = $value ;
    }


	public static function replaceTags( $content, $tags, $start='{', $end='}' ){
		$attrs = array();
		foreach ($tags as $tag => $value) {
			$attrs[$start.$tag.$end] = $value;
		};

		$names  = array_keys($attrs);
		$values = array_values($attrs);
		return str_replace( $names, $values, $content );
	}


    public static function renderContent( $content ){
        $content = self::replaceTags( $content, self::$values );
        $content = preg_replace_callback( '/\\\u[a-zA-Z0-9]{4}/', array('Form', 'utf8codeToChar'), $content );
        return $content;
    }

    public static function utf8codeToChar( $code ){
      $json = json_decode( "\"{$code}\"" );
      return $json ? $json : $code;
    }


    private static function getHtmlHeader(){
        ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }


    private static function getHtmlFooter(){
        ob_start();
?>
</body>
</html>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    private static function mailTemplate(){
        $default = "{dataTable}";
        $config = self::getConfig();
        $template = nl2br( trim(self::$config['email']['template']) );
        return empty($template) ? $default : $template;
    }

    private static function autoResponseTemplate(){
        $config = self::getConfig();
        $template = nl2br( trim(self::$config['autoResponse']['template']) );
        return $template;
    }

    private static function smsTemplate(){
        $default = "{dataText}";
        $config = self::getConfig();
        $template = trim(self::$config['twilio']['toTemplate']);
        return empty($template) ? $default : $template;
    }

    private static function smsAutoResponseTemplate(){
        $config = self::getConfig();
        $template = trim(self::$config['twilio']['autoResponseTemplate']);
        return $template;
    }

    public static function getSmsBody(){
        return self::renderContent( self::smsTemplate() );
    }

    public static function getAutoResponseSmsBody(){
        return self::renderContent( self::smsAutoResponseTemplate() );
    }

    public static function getDataDir(){
        $dir = dirname( self::getFormDataFile() ); 
        if( !is_dir($dir) ){
            @mkdir( $dir );
        };
        return $dir;
    }

    private static function saveRecord(){
        $method = self::getDataDelivery();
        if( 'emailOnly' == $method ){
            return;
        };

        if( class_exists('\JF\Form2DB') ){
            $form2db = new \JF\Form2DB();
            $form2db->saveFormData( self::$values );
        }

        // if there are any real data rather then only 3 columns: ID, Date, and IP
        if( count(self::$csvValues) <= 3 ){
            return;
        };

        $sep = chr(0x09);
        $recordCols = self::data2record( join($sep, self::$columns) ) . PHP_EOL;
        $record     = self::data2record( join($sep, self::$csvValues) ) . PHP_EOL;

        self::getDataDir();
        $dataFile = self::getFormDataFile();
        if( !file_exists($dataFile) ){
            self::secureFile( $dataFile );
            file_put_contents($dataFile, $recordCols, FILE_APPEND );
        };

        file_put_contents($dataFile, $record, FILE_APPEND );
    }

    public static function secureFile( $file ){
        self::getDataDir();
        if( !file_exists($file) ){
            file_put_contents($file, "<?php exit(); /* For security reason. To avoid public user downloading below data! */?>" . PHP_EOL);
        };
    }


    private static function getRecordID(){
        if( !isset($GLOBALS['RecordID']) ){
            $GLOBALS['RecordID'] = date("Ymd") . '-'.  substr( md5(uniqid(rand(), true)), 0,4 );
        };
        return $GLOBALS['RecordID'];
    }

    private static function data2record( $s, $b=true ){
        $from = array( "\r", "\n");
        $to   = array( "\\r", "\\n" );
        return $b ? str_replace( $from, $to, $s ) : str_replace( $to, $from, $s ) ;
    }


    private static function csvfield( $str ){
        $str = str_replace( '"', '""', $str );
        return '"' . trim($str) . '"';
    }

    private static function isRequired($field){
        return true === $field['field_options']['validators']['required']['enabled'];
    }

    private static function renameHarmfulFile( $name ){
        $ext = strrchr(strtolower($name), '.');
        if( $ext !== false ){
            $n = strpos( strtolower(self::$harmfulExts), $ext );
            if( $n !== false ){
                return $name . '.bak' ;
            };
        };
        return $name;
    }

    private static function stripTags( $str ){
        return strip_tags( $str, self::$allowable_tags );
    }

    private static $config;
    private static $post;
    private static $values;
    private static $invalid;
    private static $isValidated = false; 
    private static $attachments;

    private static $dataDir = './data/'; // folder that stores form data file, email traffic log, and upload files
    private static $columns;
    private static $csvValues;

    private static $serverValidationFields;
    private static $style;
    private static $rows;
    private static $sms;

    private static $allowable_tags = "<a><b><blockquote><br><del><div><em><h1><h2><h3><h4><h5><h6><hr><i><img><label><li><ol><p><pre><small><span><strong><style><sub><sup><table><tbody><td><tfoot><th><thead><title><tr><u><ul>";

    private static $harmfulExts = ".php, .php2, .php3, .php4, .php5, .php6, .php7, .html, .css, .js, .exe, .com, .bat, .vb, .vbs, scr, .inf, .reg, .lnk, .pif, .ade, .adp, .app, .bas, .chm, .cmd, .cpl, .crt, .csh, .fxp, .hlp, .hta, .ins, .isp, .jse, .ksh, .Lnk, .mda, .mdb, .mde, .mdt, .mdw, .mdz, .msc, .msi, .msp, .mst, .ops, .pcd, .prf, .prg, .pst, .scf, .scr, .sct, .shb, .shs, .url, .vbe, .wsc, .wsf, .wsh";

    public static function getConfig( $decode = true ){
        self::$config = Config::getConfig($decode);
        self::overwriteConfig( $decode );
        return self::$config;
    }

    private static function overwriteConfig( $decode = true ){
        if( !$decode ){
            return;
        };

        $file = __DIR__.'/myconfig.php';
        if( !file_exists($file) ){
            return;
        };

        $config = include($file);
        if( !is_array($config) ){
            return;
        };

        foreach( $config as $sectionName => $var ){
            if( is_array($var) ){
                foreach( $var as $key => $val ){
                    if( !empty($val) ){
                        self::$config[$sectionName][$key] = $config[$sectionName][$key];
                    };
                };//
            }else{
                if( !empty($var) ){
                    self::$config[$sectionName] = $config[$sectionName];
                };
            }; // if
        }; // foreac

    } // overwriteConfig

}// end of Form class
// --------------------------------------------------------------



// --------------------------------------------------------------
class Mailer {
    private $config;
    private $mailer = 'local';
    private $logs = array();

    public $From;
    public $FromName;
    public $TO;
    public $Subject;
    public $Body;
    public $CC;
    public $BCC;
    public $ReplyTo;
    public $ReplyToName;
    private $isSent = false;
    private $sendError = '';
    private $sentMIMEMessage = '';


    function __construct(){
        $this->config = Form::getConfig();
    }

    public function Send(){
        $this->mailer   = empty($this->config['mailer']) ? 'local' : $this->config['mailer'];
        switch ( $this->mailer ) {
            case 'local':
            case 'smtp':
              $this->SendByPHPMailer();
              break;

            case 'mailgun':
              if ( function_exists('curl_init') ){
                $this->SendByMailGun();
              } else {
                $this->addLog( "CURL module is not avaiable. Can't use mailgun mailer, use normal sendmail mailer.");
                $this->SendByPHPMailer();
              };
              break;

            default:
              break;
        }; // switch
        $this->saveLogs();
    }

    public function mail( $to , $subject , $message, $from = '', $fromName = '' ){
        $this->TO       = $to;
        $this->From     = $from;
        $this->FromName = $fromName;
        $this->Subject  = $subject;
        $this->Body     = $message;
        return $this->Send();
    }


    public function validateForm( $post = array() ){
        if( !Form::isValidated() ){
            Form::validate($post);
        };
        $this->From     = Form::getFromEmail();
        $this->FromName = Form::getFromName();
        $this->Subject  = Form::getMailSubject();
        $this->Body     = Form::getMailBody();

        $email     = $this->config['email'];
        $this->TO  = Form::getToEmail();
        $this->CC  = empty($email['cc'])  ? '' : $email['cc'];
        $this->BCC = empty($email['bcc']) ? '' : $email['bcc'];
    }

    private function SendByPHPMailer(){
        $email = $this->config['email'];

        $mailer           = new \PHPMailer();
        $mailer->From     = $this->From;
        $mailer->FromName = $this->FromName;
        $mailer->Subject  = $this->Subject;
        $mailer->Body     = $this->Body;
        $mailer->CharSet  = 'UTF-8';
        $mailer->msgHTML($mailer->Body);
        $mailer->IsHtml(true);
        $mailer->AddAddress($this->TO);

        if( empty($this->ReplyTo) ){
            $senderEmail = Form::getSenderEmail();
            $this->ReplyTo = empty($senderEmail) ? $this->From : $senderEmail;
            $this->ReplyToName = $this->FromName;
        };
        $mailer->AddReplyTo($this->ReplyTo, $this->ReplyToName);

        if( !empty($this->CC) ){
            $CCs = explode(',',$this->CC );
            foreach($CCs as $c){
                $mailer->AddCC( $c );
            };
        };

        if( !empty($this->BCC) ){
            $BCCs = explode(',',$this->BCC);
            foreach($BCCs as $b){
                $mailer->AddBCC( $b );
            };
        };

        $attachments = Form::getAttachments();
        //$this->addLog($attachments);
        if( is_array($attachments) ){
            foreach($attachments as $f){
                $mailer->AddAttachment( $f['path'], basename($f['name']) );
            };
        };

        $smtp = $this->config['smtp'];
        $isSMTP = $this->mailer == 'smtp' && !empty($smtp);
        if( $isSMTP ){
            $mailer->IsSMTP();
            $mailer->Host = $smtp['host'];
            $mailer->Username = $smtp['user'];
            $mailer->Password = $smtp['password'];
            $mailer->SMTPAuth = !empty($mailer->Password);
            $mailer->SMTPSecure = $smtp['security'];
            $mailer->Port = empty($smtp['port']) ? 25 : $smtp['port'];
            $mailer->SMTPDebug = empty($smtp['debug']) ? 0 : 2;
        };

        if( $isSMTP && $mailer->SMTPDebug > 0 ){
            ob_start();
        };

        $this->isSent = $mailer->Send();

        if( $isSMTP && $mailer->SMTPDebug > 0 ){
            $debug = ob_get_contents();
            ob_end_clean();
            $this->addLog($debug);
        };

        if( !$sent ){
            $this->sendError = $mailer->ErrorInfo;
        };

        $this->sentMIMEMessage = $mailer->getSentMIMEMessage();

        return $this->isSent;
    }


    private function SendByMailGun(){
        $mg = $this->config['mailgun'];

        $api_key= $mg['apiKey']; /* Api Key got from https://mailgun.com/cp/my_account */
        $domain = $mg['domain']; /* Domain Name you given to Mailgun*/

        if( empty($this->ReplyTo) ){
            $this->ReplyTo = $this->From;
            $this->ReplyToName = $this->FromName;
        };

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "api:".$api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/".$domain."/messages");
        $fields = array(
            "from" => ( empty($this->FromName) ? $mg['fromName'] : $this->FromName ) . " <" . $mg['fromEmail'] . ">",
            "to" => $this->TO,
            "subject" => $this->Subject,
            "h:Reply-To" => $this->ReplyToName . " <" . $this->ReplyTo . ">",
            "html" => $this->Body
        );

        // php 5.5+
        if( class_exists("\\CURLFile") ){
            // process inline images
            $result = $this->extractEmbededImages( $this->Body );
            if( !empty($result['imgFiles']) ){
                $fields['html'] = $result['message'];
                $inlines = $this->mailgunAddFiles( $result['imgFiles'], 'inline' );
                $fields = array_merge( $fields, $inlines );
            };

            // process normal attachments
            $attachments = Form::getAttachments();
            $fields = array_merge( $fields, $this->mailgunAddFiles($attachments,'attachment') );
        };

        if( !empty($this->CC) ){
            $fields['cc'] = $this->CC;
        };
        if( !empty($this->BCC) ){
            $fields['bcc'] = $this->BCC;
        };
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);

        $this->isSent = $result ? true : false;
        $this->sentMIMEMessage = "CURL paramenters:\n" . var_export($fields,true) . "\n" . var_export($result,true);
        if( !$this->isSent ){
            $this->sendError = curl_error($ch);
        }
        curl_close($ch);

        return $this->isSent;
    }

    private function mailgunAddFiles( $files, $type = 'attachment' ){
        $fields = array();
        if( is_array($files) ){
            $n = count($files);
            for( $i = 0; $i < $n; $i ++ ) {
                $f = $files[$i];
                //$key = "attachment" . ( $i == 0 ? '' : "[{$i}]" );
                $key = $type . ( $i == 0 ? '' : "[{$i}]" );
                $fields[$key] = new \CURLFile($f['path'], null, basename($f['name']) );
            };
        };
        return $fields;
    }

    // for mailgun inline images, ported from phpmailer
    private function extractEmbededImages($message)
    {
        $imgFiles = array();
        preg_match_all('/(src|background)=["\'](.*)["\']/Ui', $message, $images);
        if (isset($images[2])) {
            $dir = Form::getDataDir();
            foreach ($images[2] as $imgindex => $url) {
                // Convert data URIs into embedded images
                if (preg_match('#^data:(image[^;,]*)(;base64)?,#', $url, $match)) {
                    $data = substr($url, strpos($url, ','));
                    if ($match[2]) {
                        $data = base64_decode($data);
                    } else {
                        $data = rawurldecode($data);
                    };
                    $type = basename($match[1]);
                    $id = md5(uniqid(rand(), true));
                    $file = $dir . '/' . $id . '.' . $type;
                    $ok = file_put_contents($file, $data);
                    //$cid = md5($url) . '@phpmailer.0'; // RFC2392 S 2
                    //$cid = md5( $file ) . '@mailgun.0'; // RFC2392 S 2
                    $cid = basename($file);
                    $imgFiles[] = array( 'path' => $file, 'name' => $cid );
                    $message = str_replace(
                        $images[0][$imgindex],
                        $images[1][$imgindex] . '="cid:' . $cid . '"',
                        $message
                    );

                } // if
            } // foreach
        }; // if

        return array(
            'imgFiles' => $imgFiles,
            'message' => $message
        );
    }



    private function saveLogs(){
        $line = str_repeat('--------', 8);
        $this->addLog( "\n\n" . $line );
        $this->addLog( date("Y-m-d H:i:s") );
        $this->addLog( "Email Sent: " . ( $this->isSent ? 'OK' : 'Failed (' . $this->sendError . ')' ) );
        $this->addLog($this->sentMIMEMessage);
        $this->addLog( $line . "\n\n" );

        $logFile = Form::getEmailLogFile();
        Form::secureFile( $logFile );
        file_put_contents($logFile, join("\n", $this->logs), FILE_APPEND);
        $this->logs = array(); // clear
    }

    private function addLog($msg){
        $this->logs[] = is_string($msg) ? $msg : var_export($msg,true);
    }


} // end of class Mailer
// --------------------------------------------------------------

class Twilio {
    private $logs = array();

    public function sendSms(){
        if( !self::smsEnabled() ){
            return;
        };

        $this->addLog( "Sending text message to form owner's phone...\n\n" );
        $this->sendSmsToFormOwner();
        $this->addLog( "\n\nSending auto-response text message to form sender's phone...\n\n" );
        $this->sendSmsToFormSender();
        $this->saveLogs();
    }

    public static function smsEnabled(){
       $config = Form::getConfig();
       $twilio = $config['twilio'];
       $accountSid = $twilio['accountSid'];
       $authToken = $twilio['authToken'];
       $phone = $twilio['phoneNumber']; // twilio verified number
       return !empty($accountSid) && !empty($authToken) && !empty($phone);
    }

    private function sendSmsToFormOwner(){
        $phone   = Form::getFormOwnerPhone();
        $message = Form::getSmsBody();
        return $this->sendMessage( $phone, $message );
    }

    private function sendSmsToFormSender(){
        $phone   = Form::getSenderPhone();
        $message = Form::getAutoResponseSmsBody();
        return $this->sendMessage( $phone, $message );
    }

    public function sendMessage( $toPhone, $message ){
        if( empty($toPhone) || empty($message) ){
            $this->addLog( "Phone: $toPhone\nMessage:$message\nEmpty phone or message, no text message to be sent.\n" );
            return false;
        };

        $config = Form::getConfig();

        $twilio = $config['twilio'];
        $accountSid = $twilio['accountSid'];
        $authToken = $twilio['authToken'];
        $url = "https://api.twilio.com/2010-04-01/Accounts/$accountSid/Messages";
        $from = $twilio['phoneNumber']; // twilio verified number
        $data = array (
            'From' => $from,
            'To'   => $toPhone,
            'Body' => $message,
        );
        $post = http_build_query($data);

        $ch = curl_init($url );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$accountSid:$authToken");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($ch);
        curl_close($ch);

        $this->isSmsSent = $result ? true : false;
        $this->addLog( "twilioSendMessage paramenters:\n" . var_export($data,true) . "\nSend result:\n" . var_export($result,true) );
        $this->saveLogs();
        return $result;
    }

    private function saveLogs(){
        $line = str_repeat('--------', 8);
        $str  = "\n\n" . $line . "\n"
            . date("Y-m-d H:i:s"). "\n"
            . $line . "\n\n";

        $logFile = Form::getSmsLogFile();
        Form::secureFile( $logFile );
        file_put_contents($logFile, $str . join("\n", $this->logs), FILE_APPEND);
        $this->logs = array(); // clear
    }

    private function addLog($msg){
        $this->logs[] = is_string($msg) ? $msg : var_export($msg,true);
    }

}
# end of class Twilio




class VerifcationCode {

    public static function send(){
        Form::getConfig();

        $vsSendTo = $_REQUEST['vsSendTo'];
        $code = self::generate( true );
        if( empty($vsSendTo) || empty($code) ){
            return;
        };

        if( stripos( $vsSendTo, '@' ) !== false ){
            self::sendByEmail( $vsSendTo, $code );
        }else{
            $vsSendTo = preg_replace( '/[^0-9]/', '', $vsSendTo );
            self::sendBySms( $vsSendTo, $code );
        };

        echo "Sent verification code to " . $vsSendTo; // . ", code: " . $code;

    }

    public static function verify(){
        $userInputCode = $_REQUEST['vsCode'];
        $vcode = self::generate( false );
        if( empty($userInputCode) || empty($vcode) ){
            return;
        };

        $ok = $userInputCode == $vcode;
        echo ($ok ? "OK: code verified!" : "code failed to verify"); // .": .... session code = " . $vcode . ", userInput= " . $userInputCode;
        if( $ok ) self::generate( true ); // destory verified code
    }

    private static function sendByEmail( $to, $code ){
        $field = self::getVerifySenderFieldConfig();
        $from = Form::getFromEmail(false);
        $fromName = Form::getFromName(false);
        $subject = Form::replaceTags( $field['field_options']['mailSuject'], array('code' => $code) );
        $message = nl2br(Form::replaceTags( $field['field_options']['mailTemplate'], array('code' => $code) ));

        $mailer = new Mailer();
        $ok = $mailer->mail( $to , $subject, $message, $from , $fromName );
        return $ok;
    }

    private static function sendBySms( $to, $code ){
        $field = self::getVerifySenderFieldConfig();
        if( !$field['field_options']['smsEnabled'] ){
            return false;
        };

        $phone = preg_replace( '/[^0-9]/', '', $to );
        $message = Form::replaceTags( $field['field_options']['smsTemplate'], array('code' => $code) );

        $sms = new Twilio();
        $ok = $sms->sendMessage( $phone, $message );
        return $ok;
    }

    private static function generate( $new = false ){
        if( $new || empty($_SESSION['verification_code']) ){
            $_SESSION['verification_code'] = rand(1000, 9999);
            $_SESSION['verification_code_created'] = time();
        };
        return $_SESSION['verification_code'];
    }

    private static function getVerifySenderFieldConfig(){
        $config = Form::getConfig();
        foreach( $config['fields'] as $f ){
            if( 'verify_sender' == $f['field_type'] ){
                return $f;
            };
        };
        return false;
    }
}
# end of class VerifcationCode


class PaymentBase{
    protected $config;
    protected $isPaid;
    protected $errmsg;

    function __construct( $paymentFieldConfig ) {
        $this->config = $paymentFieldConfig;
    }

    // $data is $_POST
    public function validate( $data ){
        return false;
    }

    public function getAmount( $data ){
        $payment  = $this->config['payment'];
        $amount   = $payment['amount'];
        $userAmount = 0;
        if( $payment['changeable'] ){
            $userAmount = $data['payment_amount'];
        };
        $amount = abs( empty($userAmount) ? $amount : $userAmount );
        return $amount;
    }


    public function isPaid(){
        return $this->isPaid;
    }

    public function getErrMsg(){
        return $this->errmsg;
    }

    public function log( $s ){
        $line = str_repeat('--------', 8);
        $str  = "\n\n" . $line . "\n"
            . date("Y-m-d H:i:s"). "\n"
            . $line . "\n\n";

        $logFile = Form::getDataDir() . '/payment-log.php';
        Form::secureFile( $logFile );
        $log = is_string($s) ? $s : var_export( $s, true );
        file_put_contents($logFile, $str . $log, FILE_APPEND);
    }
}
# end of class PaymentBase
