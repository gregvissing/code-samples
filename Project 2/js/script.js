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
        $("header.fl-page-header").removeClass("mobile");
        var setHeight = $(".fl-page-header .col-md-4").height();
		$(".fl-page-header .col-md-8").height(setHeight);		
      } else {
        $("header.fl-page-header").addClass("mobile");
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
