<?php include("../login/runtime.php"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>LAN Events | Rocket League India</title>

<!-- Favicons Start -->
<link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="../favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="../favicons/manifest.json">
<link rel="mask-icon" href="../favicons/safari-pinned-tab.svg">
<meta name="theme-color" content="#122C3E">
<!-- Favicons End -->

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:title" content="LAN Events | Rocket League India">
<meta property="og:image" content="http://rocketleagueindia.com/img/events.jpg">
<meta property="og:description" content="Rocket League India hosts LAN events, community meetups and much more. Check it out!">
<meta property="og:url" content="http://rocketleagueindia.com/events">
<meta name="description" content="Rocket League India hosts LAN events, community meetups and much more. Check it out!">
<meta name="keywords" content="Rocket League India,Rocket League Events,Events,Youtube,esports,India">
<meta name="author" content="Pawan Kolhe">
<meta name="robots" content="index, follow">

<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/events.css" rel="stylesheet" type="text/css">
<link href="../css/footer-basic-centered.css" rel="stylesheet" type="text/css">
<link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<!-- HEADER -->
<?php include("../navigation.php"); ?>
<!-- HEADER END -->
<!-- TOURNAMENTS -->
<div id="container2" class="container">
    	<div class="inner_container">
             <h1 class="title">LAN Events</h1> <!-- Title -->
             <hr class="title_line">
             
             <!--======================================= UPCOMING EVENTS ========================================-->
             <h2 class="sub_title center">Upcoming Events</h2> <!-- Sub-Title -->
             <div id="upcomingContainer">

				<?php perch_content("Coming Soon text"); ?>
				<?php perch_content("Upcoming Events"); ?>
				
             </div>
             <!--======================================= UPCOMING EVENTS END =========================================-->
             <hr class="thin_line" style="margin-top: 50px !important">
             <!--======================================= PREVIOUS EVENTS =============================================-->
             <h2 class="sub_title center">Previous Events</h2> <!-- Sub-Title -->
             <div id="previousContainer">

			 	<?php perch_content("Previous Events"); ?>
             
             </div>
             <!--======================================= PREVIOUS EVENTS END =========================================-->
             
             <hr class="thin_line">
      	
			<div id="buyContainer">				
					<p class="buy_message center"><b>Join the Community</b></p>
					<a href="https://www.facebook.com/groups/rocketleagueindia/"><div class="platform_buy" id="buySteam"><img class="platform_logo" alt="Steam" src="../img/facebook-logo.png"></div></a>
					<a href="https://discord.gg/kScFfwc"><div class="platform_buy" id="buyPs4"><img class="platform_logo" alt="PS4" src="../img/discord_logo.png"></div></a>
				</div>
			</div>
       	</div>
</div>
<!-- FOOTER -->
<?php include("../footer.php"); ?>
<!-- FOOTER END -->
</body>
</html>