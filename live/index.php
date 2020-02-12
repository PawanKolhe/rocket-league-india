<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>LIVE Streaming | Rocket League India</title>

<!-- Favicons Start -->
<link rel="apple-touch-icon" sizes="180x180" href="../favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="../favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="../favicons/manifest.json">
<link rel="mask-icon" href="../favicons/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#122C3E">
<!-- Favicons End -->

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:title" content="LIVE Streaming | Rocket League India">
<meta property="og:image" content="http://rocketleagueindia.com/img/live.jpg">
<meta property="og:description" content="Rocket League India is LIVE on YouTube and Twitch. Tune in!">
<meta property="og:url" content="http://rocketleagueindia.com/live">
<meta name="description" content="Rocket League India is LIVE on YouTube and Twitch. Tune in!">
<meta name="keywords" content="Rocket League India,Rocket League,Live streaming,Youtube,Twitch,India">
<meta name="author" content="Pawan Kolhe">
<meta name="robots" content="index, follow">

<link href="../css/index.css" rel="stylesheet" type="text/css">
<link href="../css/live.css" rel="stylesheet" type="text/css">
<link href="../css/footer-basic-centered.css" rel="stylesheet" type="text/css">
<link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<div id="fb-root"></div>
<!-- HEADER -->
<?php include("../navigation.php"); ?>
<!-- HEADER END -->
<!-- LIVE -->
<div id="container2" class="container">
    	<div class="inner_container">
             <h1 class="title">LIVE Stream</h1><hr class="title_line">
             <!--<h4 style="color: #E62F27">YouTube Stream</h4>
             <iframe class="video_stream" width="100%" height="600" src="https://www.youtube-nocookie.com/embed/0LmcfVj_8ls" frameborder="0" allowfullscreen></iframe>-->
             <h4 class="center" style="color: #6542A6">Twitch</h4>
             <div id="twitch-embed"></div>
             
             <!--<iframe class="video_stream" src="https://player.twitch.tv/?channel=rlindia" frameborder="0" allowfullscreen="true" scrolling="no" height="600" width="100%"></iframe>-->
             
             <!--<a href="http://rocketleagueindia.com/tournaments/cc5/"S class="join_button" style="margin-bottom: 0px;margin-top: 20px">CC5 Brackets and Details</a>-->
			<!--<p style="padding-top: 20px;">Tournament Page: <a href="http://rocketleagueindia.com/tournaments/dropshot1/">Link</a></p>-->
            
             <!--<h4 style="color: #3B5999">Facebook Stream</h4>
             <iframe class="video video_fb" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FESLinIndia%2Fvideos%2F637196603146743%2F&width=560&show_text=0&appId=800501536768703" width="853" height="480" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>-->
             
             <!--<h4>Brackets</h4>
             <iframe src="http://challonge.com/speedchallonge2/module" width="100%" height="700" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>-->
       	</div>
</div>
<!--<div id="containerSocial" class="container">
    	<div class="inner_container">
    		<a href="https://twitter.com/RocketLeagueIN" class="twitter-follow-button social_button" data-size="large" data-show-count="true">Follow @RocketLeagueIN</a>
			<a class="fb_button social_button" href="https://www.facebook.com/groups/rocketleagueindia/" target="_blank"><i class="fa fa-facebook" aria-hidden="true" style="vertical-align: text-bottom !important;"></i>&nbsp; Join Facebook Group</a>
   			<div class="fb-like social_button" style="margin-right:20px;" data-href="https://www.facebook.com/rocketleagueindia" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>
   			<div class="g-ytsubscribe social_button" data-channelid="UC_s9G5byunr30DEVgeY8qHA" data-layout="default" data-count="default"></div>
   			<a class="email_button social_button" href="mailto:contact@rocketleagueindia.com" target="_blank"><i class="fa fa-envelope" aria-hidden="true" style="vertical-align: text-bottom !important;"></i>&nbsp; E-mail</a>
   			<a class="donate_button social_button" href="http://rocketleagueindia.com/donate" target="_blank"><i class="fa fa-inr" aria-hidden="true" style="vertical-align: text-bottom !important;"></i>&nbsp; Donate</a>
    	</div>
</div>-->
<!--<div id="container3" class="container">
    	<div class="inner_container" style="padding-top: 60px;">
             <h4 style="color: #E52D27; padding-top: 0">YouTube</h4>
             <iframe class="video_stream" width="100%" height="600" src="https://www.youtube.com/embed/live_stream?channel=UC_s9G5byunr30DEVgeY8qHA&autoplay=0" frameborder="0" allowfullscreen></iframe>
             <h4>Brackets</h4>
             <iframe src="http://challonge.com/speedchallonge2/module" width="100%" height="700" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>
       	</div>
</div>-->
<!-- LIVE END -->
<!-- FOOTER -->
<?php include("../footer.php"); ?>
<!-- FOOTER END -->
<script src="https://embed.twitch.tv/embed/v1.js"></script>
<script type="text/javascript">
      new Twitch.Embed("twitch-embed", {
        width: "100%",
        height: 560,
        channel: "rlindia"
      });
</script>
<script async src="https://apis.google.com/js/platform.js"></script>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=800501536768703";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
