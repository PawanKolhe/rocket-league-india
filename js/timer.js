// Set the date we're counting down to
var countDownDate = new Date("December 17, 2017 12:30:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {
	
	var d = new Date();

	var localTime = d.getTime();

	var localOffset = d.getTimezoneOffset() * 60000;

	var utc = localTime + localOffset;

	// obtain and add destination's UTC time offset
	// for example, Bombay 
	// which is UTC + 5.5 hours
	var offset = 5.5;   
	var bombay = utc + (3600000*offset);

    // Get todays date and time
    var now = new Date(bombay).getTime();
	console.log(now);
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
	console.log(distance);
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown").innerHTML = "HAS BEGUN!";
    }
}, 1000);