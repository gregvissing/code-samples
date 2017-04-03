/******************************************************************
	THIS SECTION IS FOR THE NEWS & EVENTS PAGE. 	
******************************************************************/
(function($) {
$(document).ready(function(){
	// Scripts for Facebook and Twitter share buttons
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) { return; }
		js = d.createElement(s); js.id = id; 
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	
	window.twttr = (function(d, s, id) { 
		var js, fjs = d.getElementsByTagName(s)[0],
		t = window.twttr || {};
		if (d.getElementById(id)) { return t; }
		js = d.createElement(s);
		js.id = id;
		js.src = "https://platform.twitter.com/widgets.js";
		fjs.parentNode.insertBefore(js, fjs);
		
		t._e = [];
		t.ready = function(f) {
		t._e.push(f);
	};
	
	return t;
	}(document, "script", "twitter-wjs")); 

	// Populate News & Events Modal with Title, Date and Content
	$('.btn.event').click(function() {
	    $( '.event-container' ).fadeOut();
	    $( '.single-event-container' ).delay(400).fadeIn();
        var $titleID = (event.target.id);
        var $text = $('#' + $titleID + '.event-title').text();
        var $contenttext = $('#' + $titleID + '.event-content').html();
        var $eventmonth = $('#' + $titleID + '.event-month').text();
        var $eventday = $('#' + $titleID + '.event-day').text();
        
        // Set values to populate in single event container
        $('.single-event-container .date-container .event-day').html($eventday);
        $('.single-event-container .date-container .event-month').html($eventmonth);
        $('.single-event-container .event-title').html($text);
        $('.single-event-container #event-content').html($contenttext).delay(5000);
		
		$('.single-event-container #event-content').each(function(){
	        var h = parseInt($(this).parent().css('min-height'),10) || parseInt($(this).parent().css('height'),10);
	        if (h > 600) {
		        var newHeight = h + 100;
		        $('#news-events').css('min-height', newHeight+'px');
	        }
	    });
	});
    
    $('.viewAll').click(function() {
	    $( '.single-event-container' ).fadeOut(); 
		$( '#outer-events-container .event-container' ).not('.hide-event').delay(400).fadeIn();
    });
});
})(jQuery);