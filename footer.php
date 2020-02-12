<footer class="footer-basic-centered">
	<a href="https://rocketleagueindia.com/"><img alt="Logo" src="https://i.ibb.co/d5Hgr67/RLILogo.png" width="100" /></a>

		<p class="footer-company-name" style="max-width: 500px; text-align: center; margin: 0 auto; margin-bottom: 20px; margin-top: 20px; font-family: 'Play', sans-serif; line-height:normal;">We're just a community, we have no rights to the game Rocket League.
All material about Rocket League belongs to Psyonix, Inc.</p>

		<p class="footer-documents center" style="line-height:normal;">
			<a href="https://www.rocketleague.com/" id="blueFooterLink" style="margin-bottom: 3px" target="_blank">Official Rocket League Website</a><span style="vertical-align:top;"> / </span>
			<a href="http://psyonix.com/" id="blueFooterLink" style="margin-bottom: 3px" target="_blank">Psyonix Website</a><span style="vertical-align:top;"> / </span>
			<a href="https://pawankolhe.com/project/rli/terms-and-conditions" id="blueFooterLink" style="margin-bottom: 3px">Terms and Conditions</a>
		</p>
	
    	<div style="padding-bottom: 20px !important; padding-top: 30px !important;">
   			<a class="email_button social_button" href="mailto:contact@rocketleagueindia.com"><i class="far fa-envelope" aria-hidden="true" style="vertical-align: text-bottom !important;"></i>&nbsp; E-mail</a>
   			<a class="donate_button social_button" href="https://pawankolhe.com/project/rli/donate"><i class="far fa-rupee-sign" aria-hidden="true" style="vertical-align: text-bottom !important;"></i>&nbsp; Donate</a>
    	</div>
	
	<p class="footer-company-name center">Created with <span style="color: #E24939; font-family:Impact, Haettenschweiler, Franklin Gothic Bold, Arial Black,' sans-serif'  !important">&#x2764;</span> by <a href="https://pawankolhe.com" id="pawankolhe">Pawan Kolhe</a></p>
</footer>

<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://rocketleagueindia.com/fontawesome-5.0.0-rc4-win/js/bundles/everything.min.js"></script>
<script type="text/javascript" src="https://pawankolhe.com/project/rli/js/index.js"></script>

<script type="text/javascript">
(function() {

  var user_name, api_key, twitch_widget;
  
  user_name = "rlindia";
  api_key = "e1074uyttmfvg3qi1mrf9m8oeklzrt";
  twitch_widget = $("#twitch-widget");

  twitch_widget.attr("href","https://twitch.tv/" + user_name);

  $.getJSON('https://api.twitch.tv/kraken/streams/' + user_name + '?client_id=' + api_key + '&callback=?', function(data) {	
	  if (data.stream) {
		  twitch_widget.html("<span class='online'></span>&nbsp;");
	  } else {
		  twitch_widget.html("<span class='offline'></span>");
	  }  
  });

})();
</script>