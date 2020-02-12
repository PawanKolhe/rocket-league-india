<?php include("../login/runtime.php"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php perch_pages_title(); ?> | Rocket League India</title>

<!-- Favicons Start -->
<link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="../favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="../favicons/manifest.json">
<link rel="mask-icon" href="../favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#122C3E">
<!-- Favicons End -->

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:title" content="<?php perch_pages_title(); ?> | Rocket League India">
<meta property="og:image" content="<?php perch_content('Thumbnail Image'); ?>">
<meta property="og:description" content="<?php perch_content('Description'); ?>">
<meta property="og:url" content="http://rocketleagueindia.com/<?php perch_content('Slug'); ?>">
<meta name="description" content="<?php perch_content('Description'); ?>">
<meta name="keywords" content="Rocket League India,<?php perch_pages_title(); ?>,India,e-sports">
<meta name="author" content="<?php perch_content('Author'); ?>">
<meta name="robots" content="noindex, nofollow">

<?php perch_page_attributes(); ?>

<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/footer-basic-centered.css" rel="stylesheet" type="text/css">
<link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<!-- HEADER -->
<?php include("../navigation.php"); ?>
<!-- HEADER END -->
<!-- TRADING -->
<div id="container2" class="container">
    	<div class="inner_container">
             <h1 class="title"><?php perch_content('Main heading'); ?></h1><hr class="title_line">
             <?php perch_content('Article'); ?>
       	</div>
</div>
<!-- TRADING END -->
<!-- FOOTER -->
<?php include("../footer.php"); ?>
<!-- FOOTER END -->
</body>
</html>
