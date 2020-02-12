$(document).ready(function(){
	"use strict";
	
	// Scrolling changes navigation bar
	var a = 100;
	
	$(window).scroll(function() {
		console.log(a);
		console.log($(window).scrollTop());
				if ($(window).scrollTop() > a) {
					$('#logo').addClass('shrink');	
					console.log('add');
				} else {					
					$('#logo').removeClass('shrink');	
					console.log('remove');
				}
	});
	
	// Toggles visibility of mobile menu on Hamburger button click
    $("#hamburgerContainer").click(function(){
        $("#menu").toggle(200);
    });
	
	$("#mob_dropdown_title_1").click(function(){
        $(".link_1").toggle(200);
    });
	
	$("#mob_dropdown_title_2").click(function(){
        $(".link_2").toggle(200);
    });
	
	$("#mob_dropdown_title_3").click(function(){
        $(".link_3").toggle(200);
    });
	
	// Hides visibility of mobile menu on selecting an option in the mobile menu and animates hamburger
	/*$("#menu nav a").click(function(){
        $("#menu").toggle();
		$('#hamburger').toggleClass('rotate');
		$('#hamburger').toggleClass('rotate2');
    });*/
	
	// Toggles hamburger rotate animation
	$('#hamburgerContainer').on("click", function (event) {
		$('#hamburger').toggleClass('rotate');
		$('#hamburger').toggleClass('rotate2');
	});
	
	// Twitch Live Stream Status
	var twitchUserName = 'rlindia'
	
	$.getJSON("https://api.twitch.tv/kraken/streams/"+twitchUserName+"?callback=?",function(streamData) {
      if(streamData && streamData.stream) {
         // displayed if online
         $('#streamWidget').html("<b class='online'>*ONLINE*</b>")
      } else {
         // displayed if offline
         $('#streamWidget').html("<b class='offline'>*OFFLINE*</b>")
      }
   })
	
});