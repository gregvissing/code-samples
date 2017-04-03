/*
	THIS SECTION CHECKS THE BROWSER WIDTH. 
	When equal to or less than 768 the class 'mobile' is added to the page header.	
*/
/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
    var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
    return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();
 
 
/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
    var timers = {};
    return function (callback, ms, uniqueId) {
        if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
        if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
        timers[uniqueId] = setTimeout(callback, ms);
    };
})();
 
(function($) {
 
  var setBodyClasses = function() {
    waitForFinalEvent(function(){
      var viewport = updateViewportDimensions();
			
      	if ( viewport.width >= 768 ) {     

			/* *********************************** */
			/* SHOWS FILTER */
			/* *********************************** */
			
			// Filter by current or next month
			$('.month-container.current-month, .month-container.next-month').on('click', function() {
				$('#other-months').slideUp();		// Slide up More Months drop-down if open
				
				$('.btn.load-more').fadeOut('fast');
				$('.no-more-events').fadeIn(); 
				
				$('.added-month-container.active').removeClass('active');
				$('.added-month-container').remove();
				
				$('.month-container.active, .other-month-container').removeClass('active');
				$(this).addClass('active');
				$( '.show-card-container.is-animated' ).removeClass('is-animated').addClass('hide-show');
				$( '.show-card-container:not(.just-announced)' + '.' + (event.target.id) ).removeClass('hide-show').addClass('is-animated').delay(50000);
				
				if ($('.show-card-container:visible').length === 0) {
					$('#outer-shows-container').fadeIn("slow", function() { $(this).addClass('no-shows'); });
					$('#no-shows-text').fadeIn();
					$('#load-more-shows').fadeOut();
				} else {
					$('#outer-shows-container').removeClass('no-shows');
					$('#no-shows-text').fadeOut();
					$('#load-more-shows').fadeIn();
				}
			});
			
			// Filter by months in drop down
			$('.other-month-container').on('click', function() {
				$('.btn.load-more').fadeOut();
				$('.no-more-events').fadeIn();
				var str = $(this).text(); // assign text from clicked month to variable
				
				$('.month-container.active, .other-month-container').removeClass('active');
				$(this).addClass('active');
				$('.added-month-container.active').removeClass('active');
				$('.added-month-container').fadeOut();
				// put text from variable inside new list item and prepend it to list items
				$('<li class="added-month-container active"></li>').html(str).hide().prependTo('#filter-container #months').slideDown('slow');
				$( '.show-card-container.is-animated' ).removeClass('is-animated').addClass('hide-show');
				$( '.show-card-container:not(.just-announced)' + '.' + (event.target.id) ).removeClass('hide-show').addClass('is-animated').delay(50000);
				
				if ($('.show-card-container:visible').length === 0) {
					$('#outer-shows-container').fadeIn("slow", function() { $(this).addClass('no-shows'); });
					$('#no-shows-text').fadeIn();
					$('#load-more-shows').fadeOut();
				} else {
					$('#outer-shows-container').removeClass('no-shows');
					$('#no-shows-text').fadeOut();
					$('#load-more-shows').fadeIn();
				}
			});
		
			// Filter by Just Announced
			$('.month-container.just-announced').on('click', function() {
				$('#other-months').slideUp();		// Slide up More Months drop-down if open
				
				$('.btn.load-more').fadeOut();		// Hide Load More Shows button
				$('.no-more-events').fadeIn();		// Display No More Shows text
				$( '.added-month-container.active' ).fadeOut();
				$('.month-container.active, .other-month-container').removeClass('active');
				$( this ).addClass( 'active' );
				$( '.show-card-container.is-animated' ).removeClass('is-animated').addClass('hide-show');		// Hide all shows that are displayed
		
				$( '.show-card-container.just-announced' ).removeClass('hide-show').addClass('is-animated').delay(50000);	// Display 8 most recent shows JUST ANNOUNCED
				
				if ($('.show-card-container:visible').length === 0) {
					$('#outer-shows-container').fadeIn("slow", function() { $(this).addClass('no-shows'); });
					$('#no-shows-text').fadeIn();
					$('#load-more-shows').fadeOut();
				} else {
					$('#outer-shows-container').removeClass('no-shows');
					$('#no-shows-text').fadeOut();
					$('#load-more-shows').fadeIn();
				}
		
			});
			
			// Filter by Upcoming
			$('#months .month-container.upcoming').on('click', function() {
				$('#other-months').slideUp();		// Slide up More Months drop-down if open
				
				$('.no-more-events').fadeOut();		// Hide No More Shows text
				$('.btn.load-more').fadeIn();		// Display Load More Shows button
				$( '.added-month-container.active' ).fadeOut();
				$('.month-container.active, .other-month-container').removeClass('active');
				$( this ).addClass( 'active' );
				$( '.show-card-container.is-animated' ).removeClass('is-animated').addClass('hide-show');		// Hide all shows that are displayed
		
				$( '.show-card-container.hide-show:lt(4)' ).removeClass('hide-show').addClass('is-animated').delay(50000);	// Display first 4 shows Upcoming
				
				if ($('.show-card-container:visible').length === 0) {
					$('#outer-shows-container').addClass('no-shows');
					$('#no-shows-text').fadeIn();
					$('#load-more-shows').fadeOut();
				} else {
					$('#outer-shows-container').removeClass('no-shows');
					$('#no-shows-text').fadeOut();
					$('#load-more-shows').fadeIn();
				}
		
			});
			
			// Toggle Slide Up/Down more months selector
			$('.month-container.more-months').on('click', function() {
				$('#other-months').slideToggle();
				
				if ( $('.month-container.more-months span').hasClass('open') ) {
				   	// drop down is open so change the text to "LESS -" and change class name
				   	$('.month-container.more-months span').text('MORE +');
				   	$('.month-container.more-months span').removeClass('open').addClass('closed');
					} else {
				   	// drop down is closed so change text to "MORE +" and change class name
					$('.month-container.more-months span').text('LESS -');
					$('.month-container.more-months span').removeClass('closed').addClass('open');	
				}
			}); 
        	
        	/* ****************** */
			// Display/Hide Individual Show with all content
			/* ****************** */
			$('.btn.more-info').click(function() {
				//var $titleID = (event.target.id);		
		        
		        $(this).parents('.show-card-container').next().fadeIn(500);
		        
				$( 'body').addClass('overlay');

			});
			
			$('.close-show, .bottom-close-show').click(function() {				
				$('.individual-show-container').fadeOut(500);
				
/*
				if($('.chevron').is('#top')) {
					$('#scroll').scrollTop(0);
					$('.chevron').attr('id', 'bottom');
				}
*/
				$( 'body').removeClass('overlay');
				$( '#individual-show-container' ).fadeOut();
				
				//$('#bottom.chevron').removeClass('show-chevron');
			});
			
			/* *********************************** */
			/* INDIVIDUAL SHOW */
			/* *********************************** */
				 
			$('.click-zoom').click(function() {
				$('.image-zoom').fadeToggle();
			});
			
			$('.close-zoomed-image').click(function() {
				$('.image-zoom').fadeToggle();
			}); 
						
			/* ******************
			/* MAILING LIST FORM 
			/* ****************** */
			// Add class to expand height of modal if there is an error
			$('#gform_submit_button_2').click(function() {
				setTimeout(function (){

					if ( $('#gform_2 .validation_error').css('display') === 'block' ){
					    $('.emailList > .modal-dialog').addClass('error');
					} else {
						$('.emailList > .modal-dialog').removeClass('error');
					}
				
				}, 700);					
			});
	     		
      	} else {
	      	// Scripts for mobile ONLY

			// change height based on which message displays
			$('#gform_submit_button_2').click(function() {
				setTimeout(function() {
	                if($('.emailList .mc-gravity > .validation_error').is(':visible')) {
					    $('.emailList .modal-dialog').css('height','451px');
					} else {
						$('.emailList .modal-dialog').css('height','136px');
					}
	            }, 400);				
	      	});
	      	
	      	// Slide Info Down for this show
			$('.btn.btn-lg.more-info').click(function() {
				var $buttonID = (event.target.id);				
				
				$('#' + $buttonID + '.mobile-more-info').fadeIn('slow');

			});
			
			// Slide Info Up for this show
			$('.bottom-close-show, .top-close-show').click(function() {
				// Get button ID
				var $closeID = (event.target.id);
				
				$('#' + $closeID + '.mobile-more-info').fadeOut('slow');
				
			});
			
			/* *********************************** */
			/* SHOWS FILTER (MOBILE) */
			/* *********************************** */
			$('.inner-primary-navigation-m > li').on('click', function() {
				
				// Get text from selected filter item and replace text from currently selected filter item
				var $filterText = ($(this).text());
			    $('#mobile-press').html($filterText);
			    
			    // Remove active class from filter item that wasn't selected
			    $('.inner-primary-navigation-m > li').removeClass('active');
			    // Add active class to filter item that was selected
			    $(this).addClass('active');
			    
			    // Hide all shows that are currently displayed.
				$( '.show-card-container.is-animated' ).removeClass('is-animated').addClass('hide-show');
			    
			    var filterID = (event.target.id);
			
				if (filterID === 'upcoming') {
					// Upcoming filter
					// Remove hide-show class from first four shows
					$( '.show-card-container.hide-show:lt(4)' ).removeClass('hide-show').addClass('is-animated');
					
					// Check to see if there are any more shows that are hidden. If not display NO MORE SHOWS text.
					if ($('.show-card-container:visible').length === 0) {
						$('#outer-shows-container').fadeIn("slow", function() { $(this).addClass('no-shows'); });
						$('#no-shows-text').fadeIn();
						$('#load-more-shows').fadeOut();
					} else {
						$('#outer-shows-container').removeClass('no-shows');
						$('#no-shows-text').fadeOut();
						$('#load-more-shows').fadeIn();
					}
					
				} else if (filterID === 'just-announced') {
					// Just Announced filter 
					// Remove hide-show class from most recent 8 shows JUST ANNOUNCED and hide everything else
					$( '.show-card-container.just-announced' ).removeClass('hide-show').addClass('is-animated');
					
					// Check to see if there are any more shows that are hidden. If not display NO MORE SHOWS text.
					if ($('.show-card-container:visible').length === 0) {
						$('#outer-shows-container').fadeIn("slow", function() { $(this).addClass('no-shows'); });
						$('#no-shows-text').fadeIn();
						$('#load-more-shows').fadeOut();
					} else {
						$('#outer-shows-container').removeClass('no-shows');
						$('#no-shows-text').fadeOut();
						$('#load-more-shows').fadeIn();
					}
					
				} else {
					// Month filter
					// Remove hide-show class from shows for month selected and hide other shows
					$( '.show-card-container' + '.' + (event.target.id) ).removeClass('hide-show').addClass('is-animated');
					
					// Check to see if there are any more shows that are hidden. If not display NO MORE SHOWS text.
					if ($('.show-card-container:visible').length === 0) {
						$('#outer-shows-container').fadeIn("slow", function() { $(this).addClass('no-shows'); });
						$('#no-shows-text').fadeIn();
						$('#load-more-shows').fadeOut();
					} else {
						$('#outer-shows-container').removeClass('no-shows');
						$('#no-shows-text').fadeOut();
						$('#load-more-shows').fadeIn();
					}
					
				}
				
				// rotate chevron to point down
		        $('.primary-navigation-m > #month-filter > li > .chevron').toggleClass('active');
		        // Toggle slide up/down
		        $('.inner-primary-navigation-m').stop().slideToggle('slow', function (){
				    
				});
				
			});
			
						
			// Open/Close mobile filter drop down
		    $('.primary-navigation-m > #month-filter > li').click(function () {	
				
				var mobileNavDropdown = $('.inner-primary-navigation-m');
                if (mobileNavDropdown.is(':visible')) {
                    mobileNavDropdown.slideUp(); 
                    $('.primary-navigation-m .chevron').removeClass('active');
                    // $('#mobile-press').text('PRESS TO SHOW MENU');
                } else {
                    mobileNavDropdown.slideDown();
                    $('.primary-navigation-m .chevron').addClass('active');
                    // $('#mobile-press').text('PRESS TO HIDE MENU');
                }
			                   
		    });  
		    		    
		    /* *********************************** */
			/* MENU ICON */
			/* *********************************** */
			$('.fl-page-nav-collapse.navbar-collapse.collapse').attr('aria-expanded','false');
			
			$('#menu-container').click(function(e) {				
			
				e.preventDefault();    
						 
				if ( $(this).hasClass('open') ) {
					$('body').removeClass('menu-open');
					//$('.fl-page-nav-collapse.navbar-collapse.collapse').animate({width:'toggle'}, { duration: 350, queue: false });
					//$('.fl-page-nav-collapse.navbar-collapse.collapse').removeClass('in');
					$('.drumstick-top').removeClass('rotate45degUp'); 		// rotate drumstick back down
					$('.drumstick-bottom').removeClass('rotate45degDown'); 	// rotate drumstick back down 
					$('#drumstick-container').addClass('rotateXaxis');
					$('#guitar-container').delay(500).removeClass('rotateXaxis');
					$('.guitar-top').removeClass('move-top');
					$('.guitar-bottom').removeClass('move-bottom');
					$('.w0').text('MENU');
					$(this).removeClass('open').addClass('close-menu');
					
				} else {
					//$('.fl-page-nav-collapse.navbar-collapse.collapse').animate({width:'toggle'}, { duration: 350, queue: true });
					
					$('body').addClass('menu-open');
					//$('.fl-page-nav-collapse.navbar-collapse.collapse').addClass('in');
					$('.guitar-top').addClass('move-top');
					$('.guitar-bottom').addClass('move-bottom');
					$('#guitar-container').addClass('rotateXaxis');
					$('#drumstick-container').delay(500).removeClass('rotateXaxis');
					$('.drumstick-top').addClass('rotate45degUp');
					$('.drumstick-bottom').addClass('rotate45degDown');
					$('.w0').text('CLOSE');
					$('#menu-container').removeClass('close-menu').addClass('open');	
				}
				
			});  
			
			/* ******************
			/* MAILING LIST FORM 
			/* ****************** */
			// Add class to expand height of modal if there is an error
			$('#gform_submit_button_2').click(function() {
				setTimeout(function (){

				 if ( $('#gform_2 .validation_error').css('display') === 'block' ){
				    $('.emailList .modal-dialog .modal-content .modal-body').addClass('error-mobile');
				} else {
					$('.emailList .modal-dialog .modal-content .modal-body').removeClass('error-mobile');
				}
				
				}, 700);				
			});
      	}  
    });
  };
   
 // Viewport width related actions
  $(window).resize(function() {
    setBodyClasses();
  });
 
  $(document).ready(function() {
    setBodyClasses();
  });
})(jQuery);

(function($) { 
$(document).ready(function() {
	
	/* *********************************** */
	/* BISTRO */
	/* *********************************** */
	$('.fl-icon-wrap').on('click', function() {
		$(this).parents('.menu-item').next().fadeIn();
	});
	
	$('.image-container > .close-image').on('click', function() {
		$(this).parent().fadeOut();
	});
	
	/* *********************************** */
	/* SHOWS! */
	/* *********************************** */
	// Remove hide-show class from first four shows
	$( '.show-card-container.hide-show:lt(4):not(.past-show)' ).removeClass('hide-show').addClass('is-animated');
	
	$('.load-more').on('click', function() {

	  	var numItems = 0;

		$( '#outer-shows-container' ).find( '.show-card-container.hide-show:lt(4):not(.just-announced)' ).delay(50000).removeClass('hide-show').addClass('is-animated');
		numItems = $('.show-card-container.hide-show:not(.just-announced)').length;
		
		if(numItems === 0) {
		    $('.btn.load-more').fadeOut();
		    $('.no-more-events').fadeIn();
		}

	});
	
	$( '.show-card-container.past-show.hide-show:lt(6)' ).removeClass('hide-show').addClass('is-animated');
		
	// Artist bio scroll up/down
/*
    var height = 0;
    function scroll(height, ele) {
        this.stop().animate({ scrollTop: height }, { duration: 2500 }, function () {            
            var dir = height ? "top" : "bottom";
            $(ele).attr({ id: dir });
        }); 
        
    }
    var wtf = $('#scroll').is('visible');
    $('#bottom, #top').click(function () {
        height = height < wtf[0].scrollHeight ? wtf[0].scrollHeight : 0;
        scroll.call(wtf, height, this);
        $(this).toggleClass('top-chevron bottom-chevron');
    });
*/
	    
	// Functions for closing individual show modal //
	// Return bottom right chevron to point down.
	// Remove show-chevron class for next MORE INFO click
	
	

	//$('.bottom-close-show').click(function() {
		
		//var $titleID = (event.target.id);
        //alert($titleID);
        //$('#' + $titleID + '.show-card-container').next().fadeOut();
        //$('#' + $titleID + '#individual-show-container').addClass('display-show');		
        //alert('#' + $titleID);
        //$('#' + $titleID + '.individual-show-container').fadeOut();
        
		//$( 'body').addClass('overlay');
	    //$( '#individual-show-container' ).delay(100).fadeIn();	        	

	//});
		
	/* ******************
	/* SHARE EVENTS 
	/* ****************** */
	
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
	
});
})(jQuery);