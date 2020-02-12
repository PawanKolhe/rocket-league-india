<?php include("../login/runtime.php"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Tournaments | Rocket League India</title>

<!-- Favicons Start -->
<link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="../favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="../favicons/manifest.json">
<link rel="mask-icon" href="../favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#122C3E">
<!-- Favicons End -->

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:title" content="Tournaments | Rocket League India">
<meta property="og:image" content="http://rocketleagueindia.com/img/tournaments.jpg">
<meta property="og:description" content="Rocket League India hosts Rocket League tournaments on a regular basis. Join now!">
<meta property="og:url" content="http://rocketleagueindia.com/tournaments">
<meta name="description" content="Rocket League India hosts Rocket League tournaments on a regular basis. Join now!">
<meta name="keywords" content="Rocket League India,Rocket League tournaments,Tournaments,Youtube,esports,India">
<meta name="author" content="Pawan Kolhe">
<meta name="robots" content="index, follow">

<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/tournaments.css" rel="stylesheet" type="text/css">
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
             <h1 class="title">Tournaments</h1> <!-- Title -->
             <hr class="title_line">
             
             <!------------------------------------------------------ UPCOMING TOURNAMENTS ------------------------------------------------------>
             <h2 class="sub_title center">Upcoming Tournaments</h2> <!-- Sub-Title -->
             <div id="upcomingContainer">
				 <!--<p style="padding-top: 70px; font-size: 2rem; color: #D7D7D7">- Coming Soon -</p>-->

         <?php perch_content("Coming Soon text"); ?>
				 <?php perch_content("Upcoming Tournaments"); ?>

             </div>
             <!------------------------------------------------------ UPCOMING TOURNAMENTS END ------------------------------------------------------>
             <hr class="thin_line">
             <!------------------------------------------------------ PREVIOUS TOURNAMENTS ------------------------------------------------------>
             <h2 class="sub_title center">Previous Tournaments</h2> <!-- Sub-Title -->
             <div id="previousContainer">
             
             <?php perch_content("Previous Tournaments"); ?>
            
             </div>
             <!------------------------------------------------------ PREVIOUS TOURNAMENTS END ------------------------------------------------------>
             <hr class="thin_line">
             <!------------------------------------------------------ PAST TOURNAMENTS VIDEOS ------------------------------------------------------>
             <h3 id="pastTournamentTitle" class="title">Past Tournaments Videos</h3> <!-- Title -->
             <p class="video_title center">Community Cup #6</p>
             <iframe class="video" width="100%" height="480" src="https://www.youtube-nocookie.com/embed/ljnTBq2kg74" frameborder="0" allowfullscreen></iframe>
             <p class="video_title center">Community Cup #5</p>
             <iframe class="video" width="100%" height="480" src="https://www.youtube-nocookie.com/embed/DOF8tE4VlLk" frameborder="0" allowfullscreen></iframe>
             <!--<p class="video_title">FGOC 2 2016 Rocket League 1on1 Cup India</p>
             <iframe class="video video_fb" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FESLinIndia%2Fvideos%2F609906549209082%2F&show_text=0&width=560" width="853" height="480" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>-->
             <!------------------------------------------------------ PAST TOURNAMENTS VIDEOS END ------------------------------------------------------>
             
             <hr class="thin_line" style="margin-top: 60px !important; margin-bottom: 60px !important;">
      	
			<div id="buyContainer" style="margin-bottom: 40px;">				
					<p class="buy_message center"><b>Join the Community</b></p>
					<a href="https://www.facebook.com/groups/rocketleagueindia/"><div class="platform_buy" id="buySteam"><img class="platform_logo" alt="Steam" src="../img/facebook-logo.png"></div></a>
					<a href="https://discord.gg/rlindia"><div class="platform_buy" id="buyPs4"><img class="platform_logo" alt="PS4" src="../img/discord_logo.png"></div></a>
				</div>
			</div>
       	</div>
</div>
<!-- FOOTER -->
<?php include("../footer.php"); ?>
<!-- FOOTER END -->
</body>
</html>