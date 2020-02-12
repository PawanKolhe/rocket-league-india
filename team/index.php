<?php include("../login/runtime.php"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Our Team | Rocket League India</title>

<!-- Favicons Start -->
<link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="../favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="../favicons/manifest.json">
<link rel="mask-icon" href="../favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#122C3E">
<!-- Favicons End -->

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:title" content="Our Team | Rocket League India">
<meta property="og:image" content="http://rocketleagueindia.com/img/team.jpg">
<meta property="og:description" content="Get in touch with the Admins, Moderators, Casters, Streamers, Graphics Designers and Video Editors at Rocket League India.">
<meta property="og:url" content="http://rocketleagueindia.com/team">
<meta name="description" content="Get in touch with the Admins, Moderators, Casters, Streamers, Graphics Designers and Video Editors at Rocket League India.">
<meta name="keywords" content="Rocket League India,Rocket League team,our team,admin,casters,esports,India">
<meta name="author" content="Pawan Kolhe">
<meta name="robots" content="index, follow">

<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/team.css" rel="stylesheet" type="text/css">
<link href="../css/footer-basic-centered.css" rel="stylesheet" type="text/css">
<link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<link href="fontawesome-5.0.0-beta5/css/font-awesome-svg-framework.css" rel="stylesheet" type="text/css">
<link href="fontawesome-5.0.0-beta5/css/font-awesome-solid.css" rel="stylesheet" type="text/css">
<link href="fontawesome-5.0.0-beta5/css/font-awesome-light.css" rel="stylesheet" type="text/css">
<link href="fontawesome-5.0.0-beta5/css/font-awesome-regular.css" rel="stylesheet" type="text/css">
<link href="fontawesome-5.0.0-beta5/css/font-awesome-brands.css" rel="stylesheet" type="text/css">
<link href="fontawesome-5.0.0-beta5/css/font-awesome-core.css" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<!-- HEADER -->
<?php include("../navigation.php"); ?>
<!-- HEADER END -->
<div id="container2" class="container">
    	<div class="inner_container">
			<h2 class="title">Our Team</h2><hr class="title_line">
            <?php perch_content("Image"); ?>
			<?php perch_content("Intro"); ?>
        </div>
        <hr class="thin_line" style="margin:0px auto;max-width: 1322px;">
</div>
<div id="container2" class="container">
    	<div class="inner_container">
             
             <!------------------------------------------------------ TEAM MEMBERS ------------------------------------------------------>
             <div id="upcomingContainer">
				 <!--<p style="padding-top: 70px; font-size: 2rem; color: #D7D7D7">- Coming Soon -</p>-->

				 <?php perch_content("Team Members"); ?>
				  
             </div>
             <!------------------------------------------------------ TEAM MEMBERS END ------------------------------------------------------>
             
             <hr class="thin_line">
             
             <h4 class="sub_title center">Join Our Staff</h4>
			<a href="http://rocketleagueindia.com/apply"><div class="platform_buy" style="color: #FFFFFF; font-weight: bold">APPLY NOW</div></a>
             
             <hr class="thin_line">
             
             <h4 class="sub_title center">E-mail us at:</h4>
			<p class="center"><i class="email_address">contact@rocketleagueindia.com</i></p>
		</div>
</div>
<!-- FOOTER -->
<?php include("../footer.php"); ?>
<!-- FOOTER END -->
</body>
</html>
