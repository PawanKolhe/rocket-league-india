<?php namespace JF;
/**
PHP 5.3+ is required.
If mailgun is used AND the form has file upload field, PHP 5.5+ is required.
*/

class Config {
	private static $config;

    public static function getConfig( $decode = true ){
    	self::$config = self::_getConfig( $decode );
    	self::overwriteConfig();
    	return self::$config;
    }

    private static function _getConfig( $decode = true ){
        ob_start();
        // ---------------------------------------------------------------------
        // JSON format config
        // Note: please make a copy before you edit config manually
        // ---------------------------------------------------------------------

/**JSON_START**/ ?>
{
    "formId": "jqueryform-b89896",
    "email": {
        "to": "rocketleagueindia@gmail.com",
        "cc": "contact@rocketleagueindia.com",
        "bcc": "pawan.kolhe18@gmail.com",
        "subject": "{f9} - RLI CC5 Registration",
        "template": "{f9} has registered for Community Cup #5!\n\nThe web form data:\n{dataTable}\n\nReference ID: {AutoID}\nIP: {IP}\nDate: {Date}\nTime: {Time}\nWebsite: {HTTP_HOST}\nReferer: {HTTP_REFERER}\n",
        "fromName": "Rocket League India",
        "sendmail_from": "contact@rocketleagueindia.com"
    },
    "admin": {
        "users": "admin:Savage1123",
        "dataDelivery": "emailAndFile",
        "limitActivity": {
            "enabled": false
        }
    },
    "thankyou": {
        "url": "http:\/\/rocketleagueindia.com\/tournaments\/cc5\/",
        "message": "You have successfully registered {f9} for RLI - Community Cup #5.",
        "seconds": "5"
    },
    "seo": {
        "trackerId": "UA-93416836-2",
        "title": "RLI - Community Cup #5 Registration",
        "description": "Register Now for Community Cup #5 hosted by Rocket League India. Big prize pool and lots of fun!",
        "keywords": "Rocket League India,community cup 5,rli",
        "author": "Rocket League India"
    },
    "mailer": "mailgun",
    "smtp": {
        "host": "smtp.mailgun.org",
        "user": "postmaster@rocketleagueindia.com",
        "password": "93080cedbb08a43a6080c26a191830e3",
        "port": "25",
        "security": "none"
    },
    "mailgun": {
        "domain": "rocketleagueindia.com",
        "apiKey": "key-a3ebeaf99f0cbc40a16090629b598699",
        "fromEmail": "contact@rocketleagueindia.com",
        "fromName": "Rocket League India"
    },
    "styles": {
        "iCheck": {
            "enabled": true,
            "skin": "flat",
            "colorScheme": "blue"
        },
        "Select2": {
            "enabled": true
        }
    },
    "logics": [
        {
            "disabled": false,
            "action": "enable",
            "selector": "f13",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f42",
                    "condition": "==",
                    "value": "PC"
                }
            ]
        },
        {
            "disabled": false,
            "action": "show",
            "selector": "f13",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f42",
                    "condition": "==",
                    "value": "PC"
                }
            ]
        },
        {
            "disabled": false,
            "action": "hide",
            "selector": "f13",
            "match": "any",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f42",
                    "condition": "==",
                    "value": "Playstation 4"
                }
            ]
        },
        {
            "disabled": false,
            "action": "enable",
            "selector": "f36",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f43",
                    "condition": "==",
                    "value": "PC"
                }
            ]
        },
        {
            "disabled": false,
            "action": "show",
            "selector": "f36",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f43",
                    "condition": "==",
                    "value": "PC"
                }
            ]
        },
        {
            "disabled": false,
            "action": "hide",
            "selector": "f36",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f43",
                    "condition": "==",
                    "value": "Playstation 4"
                }
            ]
        },
        {
            "disabled": false,
            "action": "enable",
            "selector": "f39",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f44",
                    "condition": "==",
                    "value": "PC"
                }
            ]
        },
        {
            "disabled": false,
            "action": "show",
            "selector": "f39",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f44",
                    "condition": "==",
                    "value": "PC"
                }
            ]
        },
        {
            "disabled": false,
            "action": "hide",
            "selector": "f39",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f44",
                    "condition": "==",
                    "value": "Playstation 4"
                }
            ]
        },
        {
            "disabled": false,
            "action": "enable",
            "selector": "f41",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f45",
                    "condition": "==",
                    "value": "PC"
                }
            ]
        },
        {
            "disabled": false,
            "action": "show",
            "selector": "f41",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f45",
                    "condition": "==",
                    "value": "PC"
                }
            ]
        },
        {
            "disabled": false,
            "action": "hide",
            "selector": "f41",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f45",
                    "condition": "==",
                    "value": "Playstation 4"
                }
            ]
        },
        {
            "disabled": false,
            "action": "disable",
            "selector": "f13",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f42",
                    "condition": "==",
                    "value": "Playstation 4"
                }
            ]
        },
        {
            "disabled": false,
            "action": "disable",
            "selector": "f36",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f43",
                    "condition": "==",
                    "value": "Playstation 4"
                }
            ]
        },
        {
            "disabled": false,
            "action": "disable",
            "selector": "f39",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f44",
                    "condition": "==",
                    "value": "Playstation 4"
                }
            ]
        },
        {
            "disabled": false,
            "action": "disable",
            "selector": "f41",
            "match": "all",
            "rules": [
                {
                    "disabled": false,
                    "selector": "f45",
                    "condition": "==",
                    "value": "Playstation 4"
                }
            ]
        }
    ],
    "fields": [
        {
            "label": "Page Navigation",
            "field_type": "page_navigation",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "navigation": {
                    "style": "steps",
                    "showNumber": false,
                    "isButtonPrev": true,
                    "titles": [
                        {
                            "id": "f26",
                            "title": "Member 1"
                        },
                        {
                            "id": "f27",
                            "title": "Member 2"
                        },
                        {
                            "id": "f28",
                            "title": "Member 3"
                        },
                        {
                            "id": "f29",
                            "title": "Member 4"
                        },
                        {
                            "id": "f30",
                            "title": "Team Info"
                        },
                        {
                            "id": "f0",
                            "title": "Submit"
                        }
                    ]
                },
                "hidden": false
            },
            "id": "f25",
            "cid": "c137"
        },
        {
            "label": "MEMBER 1 (CAPTAIN)",
            "field_type": "section_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                }
            },
            "id": "f31",
            "cid": "c189"
        },
        {
            "label": "Member 1 Platform",
            "field_type": "radio",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "options": [
                    {
                        "label": "PC",
                        "checked": false,
                        "image": "pc.png"
                    },
                    {
                        "label": "Playstation 4",
                        "checked": false,
                        "value": "",
                        "image": "ps4.png"
                    }
                ],
                "presetJson": "",
                "style": {
                    "columns": "inline"
                },
                "validators": {
                    "required": {
                        "enabled": true
                    }
                },
                "baseImgUrl": "http:\/\/rocketleagueindia.com\/tournaments\/cc5\/images\/"
            },
            "id": "f42",
            "cid": "c260"
        },
        {
            "label": "Member 1 Steam Profile Link",
            "field_type": "website",
            "required": true,
            "field_options": {
                "placeholder": "",
                "validators": {
                    "url": {
                        "enabled": true
                    },
                    "required": {
                        "enabled": true
                    }
                },
                "hidden": true,
                "description": "Ex: http:\/\/steamcommunity.com\/id\/pawankolhe"
            },
            "id": "f13",
            "cid": "c122",
            "labelHide": false
        },
        {
            "label": "Member 1 PSN ID\/Steam Profile Name",
            "field_type": "name",
            "field_options": {
                "size": "small",
                "sender": "fullname",
                "images": {
                    "urls": "",
                    "slideshow": false
                },
                "validators": {
                    "required": {
                        "enabled": true
                    }
                },
                "placeholder": "",
                "addon": {
                    "leftIcon": "glyphicon glyphicon-user"
                }
            },
            "cid": "c74",
            "id": "f10"
        },
        {
            "label": "Member 1 Discord ID",
            "field_type": "name",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "sender": "",
                "validators": {
                    "required": {
                        "enabled": true
                    }
                },
                "placeholder": "",
                "description": "Include the hashtag (Ex: Popo #6845)\n--> Join our Discord Channel - https:\/\/discord.gg\/kScFfwc",
                "mainDescription": ""
            },
            "cid": "c86",
            "id": "f14"
        },
        {
            "label": "Member 1",
            "field_type": "page_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "page": {
                    "title": "Member 1",
                    "labelPrev": "< Back",
                    "labelNext": "Next",
                    "showPageNumnber": false,
                    "pageNumberText": "{page} \/ {total}",
                    "disabled": false
                }
            },
            "id": "f26",
            "cid": "c126"
        },
        {
            "label": "MEMBER 2",
            "field_type": "section_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                }
            },
            "id": "f32",
            "cid": "c194"
        },
        {
            "label": "Member 2 Platform",
            "field_type": "radio",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "options": [
                    {
                        "label": "PC",
                        "checked": false,
                        "image": "pc.png"
                    },
                    {
                        "label": "Playstation 4",
                        "checked": false,
                        "value": "",
                        "image": "ps4.png"
                    }
                ],
                "presetJson": "",
                "style": {
                    "columns": "col-1"
                },
                "validators": {
                    "required": {
                        "enabled": false
                    }
                },
                "baseImgUrl": "http:\/\/rocketleagueindia.com\/tournaments\/cc5\/images\/"
            },
            "cid": "c266",
            "id": "f43"
        },
        {
            "label": "Member 2 Steam Profile Link",
            "field_type": "website",
            "required": true,
            "field_options": {
                "placeholder": "",
                "validators": {
                    "url": {
                        "enabled": true
                    },
                    "required": {
                        "enabled": false
                    }
                },
                "hidden": true,
                "description": "Ex: http:\/\/steamcommunity.com\/id\/pawankolhe"
            },
            "cid": "c157",
            "labelHide": false,
            "id": "f36"
        },
        {
            "label": "Member 2 PSN ID\/Steam Profile Name",
            "field_type": "name",
            "field_options": {
                "size": "small",
                "sender": "",
                "images": {
                    "urls": "",
                    "slideshow": false
                },
                "validators": {
                    "required": {
                        "enabled": true
                    }
                },
                "placeholder": "",
                "addon": {
                    "leftIcon": "glyphicon glyphicon-user"
                }
            },
            "id": "f1",
            "cid": "c1"
        },
        {
            "label": "Member 2 Discord ID",
            "field_type": "name",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "sender": "",
                "validators": {
                    "required": {
                        "enabled": false
                    }
                },
                "placeholder": "",
                "description": "Include the hashtag (Ex: Popo #6845)\n--> Join our Discord Channel - https:\/\/discord.gg\/kScFfwc",
                "mainDescription": "Optional"
            },
            "cid": "c97",
            "id": "f20"
        },
        {
            "label": "Member 2",
            "field_type": "page_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "page": {
                    "title": "Member 2",
                    "labelPrev": "< Back",
                    "labelNext": "Next",
                    "showPageNumnber": false,
                    "pageNumberText": "{page} \/ {total}",
                    "disabled": false
                }
            },
            "id": "f27",
            "cid": "c146"
        },
        {
            "label": "MEMBER 3",
            "field_type": "section_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                }
            },
            "cid": "c199",
            "id": "f33"
        },
        {
            "label": "Member 3 Platform",
            "field_type": "radio",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "options": [
                    {
                        "label": "PC",
                        "checked": false,
                        "image": "pc.png"
                    },
                    {
                        "label": "Playstation 4",
                        "checked": false,
                        "value": "",
                        "image": "ps4.png"
                    }
                ],
                "presetJson": "",
                "style": {
                    "columns": "col-1"
                },
                "validators": {
                    "required": {
                        "enabled": false
                    }
                },
                "baseImgUrl": "http:\/\/rocketleagueindia.com\/tournaments\/cc5\/images\/"
            },
            "cid": "c279",
            "id": "f44"
        },
        {
            "label": "Member 3 Steam Profile Link",
            "field_type": "website",
            "required": true,
            "field_options": {
                "placeholder": "",
                "validators": {
                    "url": {
                        "enabled": true
                    },
                    "required": {
                        "enabled": false
                    }
                },
                "hidden": true,
                "description": "Ex: http:\/\/steamcommunity.com\/id\/pawankolhe"
            },
            "cid": "c198",
            "labelHide": false,
            "id": "f39"
        },
        {
            "label": "Member 3 PSN ID\/Steam Profile Name",
            "field_type": "name",
            "field_options": {
                "size": "small",
                "sender": "",
                "images": {
                    "urls": "",
                    "slideshow": false
                },
                "validators": {
                    "required": {
                        "enabled": true
                    }
                },
                "placeholder": "",
                "addon": {
                    "leftIcon": "glyphicon glyphicon-user"
                }
            },
            "cid": "c84",
            "id": "f11"
        },
        {
            "label": "Member 3 Discord ID",
            "field_type": "name",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "sender": "",
                "validators": {
                    "required": {
                        "enabled": false
                    }
                },
                "placeholder": "",
                "description": "Include the hashtag (Ex: Popo #6845)\n--> Join our Discord Channel - https:\/\/discord.gg\/kScFfwc",
                "mainDescription": "Optional"
            },
            "cid": "c124",
            "id": "f23"
        },
        {
            "label": "Member 3",
            "field_type": "page_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "page": {
                    "title": "Member 3",
                    "labelPrev": "< Back",
                    "labelNext": "Next",
                    "showPageNumnber": false,
                    "pageNumberText": "{page} \/ {total}",
                    "disabled": false
                }
            },
            "id": "f28",
            "cid": "c151"
        },
        {
            "label": "MEMBER 4 (SUBSTITUTE)",
            "field_type": "section_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "description": "Optional but you cannot add or change your substitute after registration.",
                "mainDescription": ""
            },
            "cid": "c206",
            "id": "f34"
        },
        {
            "label": "Member 4 Platform",
            "field_type": "radio",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "options": [
                    {
                        "label": "PC",
                        "checked": false,
                        "image": "pc.png"
                    },
                    {
                        "label": "Playstation 4",
                        "checked": false,
                        "value": "",
                        "image": "ps4.png"
                    }
                ],
                "presetJson": "",
                "style": {
                    "columns": "col-1"
                },
                "validators": {
                    "required": {
                        "enabled": false
                    }
                },
                "baseImgUrl": "http:\/\/rocketleagueindia.com\/tournaments\/cc5\/images\/"
            },
            "cid": "c289",
            "id": "f45"
        },
        {
            "label": "Member 4 Steam Profile Link",
            "field_type": "website",
            "required": true,
            "field_options": {
                "placeholder": "",
                "validators": {
                    "url": {
                        "enabled": true
                    },
                    "required": {
                        "enabled": false
                    }
                },
                "hidden": true,
                "description": "Ex: http:\/\/steamcommunity.com\/id\/pawankolhe"
            },
            "cid": "c239",
            "labelHide": false,
            "id": "f41"
        },
        {
            "label": "Member 4 PSN ID\/Steam Profile Name",
            "field_type": "name",
            "field_options": {
                "size": "small",
                "sender": "",
                "images": {
                    "urls": "",
                    "slideshow": false
                },
                "validators": {
                    "required": {
                        "enabled": false
                    }
                },
                "placeholder": "",
                "addon": {
                    "leftIcon": "glyphicon glyphicon-user"
                },
                "description": ""
            },
            "cid": "c95",
            "id": "f12"
        },
        {
            "label": "Member 4 Discord ID",
            "field_type": "name",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "sender": "",
                "validators": {
                    "required": {
                        "enabled": false
                    }
                },
                "placeholder": "",
                "description": "Include the hashtag (Ex: Popo #6845)\n--> Join our Discord Channel - https:\/\/discord.gg\/kScFfwc",
                "mainDescription": "Optional"
            },
            "cid": "c108",
            "id": "f21"
        },
        {
            "label": "Member 4",
            "field_type": "page_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "page": {
                    "title": "Member 4",
                    "labelPrev": "< Back",
                    "labelNext": "Next",
                    "showPageNumnber": false,
                    "pageNumberText": "{page} \/ {total}",
                    "disabled": false
                }
            },
            "id": "f29",
            "cid": "c156"
        },
        {
            "label": "TEAM INFO",
            "field_type": "section_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                }
            },
            "id": "f37",
            "cid": "c185"
        },
        {
            "label": "Team Name",
            "field_type": "name",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "sender": "",
                "validators": {
                    "required": {
                        "enabled": true
                    }
                }
            },
            "id": "f9",
            "cid": "c68"
        },
        {
            "label": "Team Logo",
            "field_type": "file",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false,
                    "responsive": false
                },
                "file": {
                    "showPreview": true,
                    "showRemove": true
                },
                "mainDescription": "",
                "description": "Optional"
            },
            "id": "f7",
            "cid": "c58"
        },
        {
            "label": "Team Info",
            "field_type": "page_break",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "page": {
                    "title": "Team Info",
                    "labelPrev": "< Back",
                    "labelNext": "Next",
                    "showPageNumnber": false,
                    "pageNumberText": "{page} \/ {total}",
                    "disabled": false
                }
            },
            "id": "f30",
            "cid": "c162"
        },
        {
            "label": "Email",
            "field_type": "email",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "sender": true,
                "validators": {
                    "email": {
                        "enabled": true
                    },
                    "required": {
                        "enabled": true
                    }
                },
                "hidden": false
            },
            "id": "f18",
            "cid": "c91"
        },
        {
            "label": "Phone",
            "field_type": "phone",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "sender": false,
                "placeholder": "",
                "addon": {
                    "leftIcon": "glyphicon glyphicon-earphone"
                },
                "validators": {
                    "pattern": {
                        "enabled": true,
                        "val": "[0-9 -+.]+",
                        "msg": "Invalid phone number"
                    },
                    "phonenumber": {
                        "enabled": false
                    },
                    "required": {
                        "enabled": false
                    }
                },
                "description": "This will allow us to reach you when you are not online.",
                "mainDescription": ""
            },
            "phone": {
                "validationMethod": "simple",
                "simpleFormat": "xxx-xxx-xxxx",
                "usePhoneLib": "N",
                "preferredCountries": "in",
                "onlyCountries": "in"
            },
            "id": "f5",
            "cid": "c36"
        },
        {
            "label": "Comments",
            "field_type": "paragraph",
            "field_options": {
                "images": {
                    "urls": "",
                    "slideshow": false
                },
                "validators": {
                    "required": {
                        "enabled": false
                    }
                },
                "addon": {
                    "leftIcon": "glyphicon glyphicon-edit"
                },
                "description": "Anything you want to say to us <3"
            },
            "id": "f3",
            "cid": "c3"
        },
        {
            "label": "Google reCaptcha",
            "field_type": "recaptcha",
            "required": true,
            "field_options": {
                "images": {
                    "urls": "",
                    "style": [

                    ],
                    "slideshow": false
                },
                "hidden": false
            },
            "labelHide": true,
            "recaptcha": {
                "theme": "light",
                "siteKey": "6LeNbigUAAAAAAk4xUL9GQzrxL76jBcQPEaSLaCW",
                "secretKey": "6LeNbigUAAAAACksFdxR7sUNawvsqKlGWCF-fwJ1",
                "language": "",
                "errMsg": "Google reCaptcha validation error. Please try again.",
                "maxFailed": 3
            },
            "id": "f16",
            "cid": "c85"
        },
        {
            "label": "Submit Button",
            "field_type": "submit",
            "required": true,
            "field_options": {
                "page": {
                    "title": "Submit",
                    "labelPrev": "< Back",
                    "showPageNumnber": false,
                    "pageNumberText": "{page} \/ {total}"
                },
                "images": {
                    "urls": "",
                    "slideshow": false
                }
            },
            "labelHide": true,
            "submit": {
                "label": "",
                "icon": "glyphicon glyphicon-ok",
                "checkRequiredFields": ""
            },
            "id": "f0",
            "cid": "c0"
        }
    ],
    "autoResponse": {
        "template": "Welcome to Rocket League India : Community Cup #5!\n\nThank you for registering your team {f9}. Here is the copy of your data:\n{dataTable}\n\nBrackets, Live Stream, Rules will be available here:\nhttp:\/\/rocketleagueindia.com\/tournaments\/cc5\n\nBest Regards,\nRocket League India\n\n\nReference ID: {AutoID}\nYour IP: {IP}\nDate: {Date}\nTime: {Time}\n",
        "subject": "RLI Community Cup #5 - {f9} has been registered!",
        "replyTo": "rocketleagueindia@gmail.com",
        "replyToName": "Rocket League India"
    },
    "licenseKey": "JF-3YF04386YX0185639",
    "twilio": {
        "phoneNumber": "",
        "accountSid": "",
        "authToken": "",
        "toPhone": ""
    }
}
<?php /**JSON_END**/

        $json = ob_get_clean() ;

        return $decode ? json_decode( trim($json), true ) : $json;
    } // end of getConfig()

    private static function getValue( $fieldId, $default = NULL ){
        return isset( $_POST[$fieldId] ) ? $_POST[$fieldId] : $default ;
    }

    private static function overwriteConfig(){
    	//self::get_to();
    }

    private static function get_to(){
    	$value = self::getValue( 'c25' );
    	$to = array(
    		'Option 1' => 'a@a.com',
    		'Option 2' => 'b@b.com',
    		'Option 3' => 'c@c.com',
    	);

    	if( isset( $to[$value] ) ){
    		self::$config['email']['to'] = $to[ $value ];
    	};
    }

} // end of Config class