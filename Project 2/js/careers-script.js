/******************************************************************
	THIS SECTION IS FOR THE JOBS PAGE. 
	When a position is clicked the description comes down in an accordion animation.	
******************************************************************/
(function($) {
$(document).ready(function(){
	// Expand job description when position is clicked. Collapse open description when other position is clicked.
	$('#accordion').find('.accordion-toggle').click(function(){

		//Expand or collapse this description
		$(this).next().slideToggle(); 

		//Hide the other description sections
		$(".accordion-content").not($(this).next()).slideUp(); 

	});

	// Populate Job Application Modal with Position, Location and Date
    $(".btn-success").click(function(event) {
        var $titleID = (event.target.id);
        var $text = $('#' + $titleID + ".job-title").text();
        var $locationtext = $('.location-' + $titleID).text();
        var $postdate = $('.date-' + $titleID).text();
        // Set values to populate in modal
        $("h3.modal-title#myModalLabel").html($text);
        $("#input_2_6").val($text);
        $("h4.modal-location").html($locationtext);
        $("p.modal-post-date").html($postdate);
    });

	// POSITION DROPDOWN

	// Toggle subnavigation when Filter by Position is clicked
    $('.primary-navigation-m #jobs-filter > li').click(function () {
        var mobileNavDropdown = $(".inner-primary-navigation-m");
        if (mobileNavDropdown.is(':visible')) {
            mobileNavDropdown.slideUp();
            
            // rotate chevron back to original state
            $('.chevron').css("transform","");
        } else {
	        // close Location dropdown if open
	        $(".inner-primary-navigation-m-loc").slideUp();
	        // rotate chevron back to original state
            $('.chevron-loc').css("transform","");
            mobileNavDropdown.slideDown();
            
            // rotate chevron to point down
            $('.chevron').css("transform","rotate(180deg)");
        }
    });

	// Select / Deselect All Positions
    $("#selecctall-pos").change(function(){
		$(".pos-filt").prop('checked', $(this).prop("checked"));
    });    
    $("#jobs-list .SelectAllClose > label").click(function() {
	    $(".pos-filt").prop('checked', $(this).prop("checked"));
    });
    
    // Select / Deselect All Locations
    $("#selecctall-loc").change(function(){
		$(".loc-filt").prop('checked', $(this).prop("checked"));
    });    
    $("#locations-list .SelectAllClose > label").click(function() {
	    $(".loc-filt").prop('checked', $(this).prop("checked"));
    });    
    $(".btn-close-positions, .btn-close-locations").click(function() {
	    $(".inner-primary-navigation-m").slideUp();
	    $('.chevron').css("transform","");
    });
    $(".btn-close-locations").click(function() {
	    $(".inner-primary-navigation-m-loc").slideUp();
	    $('.chevron-loc').css("transform","");
    });
    // Remove all Position / Location selections from dropdown and display all
    $('.reset-filter').click(function () {
  		$('#mobile-press').html('Filter by Position');
  		$('#mobile-press-loc').html('Filter by Location');
  		$(".pos-filt, #selecctall-pos").prop('checked', false);
  		$(".loc-filt, #selecctall-loc").prop('checked', false);
  		$('.accordion-toggle').slideDown();
	  });	

	
	// Filter by Position and/or Location 
	var byProperty = [], byLocation = [];
	
	$("input[name=fl-colour]").on( "change", function() {
		if (this.checked) {
			byProperty.push("[data-category~='" + $(this).attr("value") + "']");
		} else {
			removeA(byProperty, "[data-category~='" + $(this).attr("value") + "']");
		}
	});
	
	$("input[name=fl-cont]").on( "change", function() {
		if (this.checked) {
			byLocation.push("[data-category~='" + $(this).attr("value") + "']");
		} else { 
			removeA(byLocation, "[data-category~='" + $(this).attr("value") + "']");
		}
	});
	
	$("input").on( "change", function() {
		var str = "Include items \n";
		var selector = '', cselector = '', nselector = '';
				
		var $lis = $('#accordion > .accordion-toggle'),
			$checked = $('input:checked');	
			
		if ($checked.length) {	
		
			if (byProperty.length) {		
				if (str === "Include items \n") {
					str += "    " + "with (" +  byProperty.join(',') + ")\n";				
					$($('input[name=fl-colour]:checked')).each(function(index, byProperty){
						if(selector === '') {
							selector += "[data-category~='" + byProperty.id + "']";  					
						} else {
							selector += ",[data-category~='" + byProperty.id + "']";	
						}				 
					});					
				} else {
					str += "    AND " + "with (" +  byProperty.join(' OR ') + ")\n";				
					$($('input[name=fl-size]:checked')).each(function(index, byProperty){
						selector += "[data-category~='" + byProperty.id + "']";
					});
				}							
			}
			
			if (byLocation.length) {			
				if (str === "Include items \n") {
					str += "    " + "with (" +  byLocation.join(' OR ') + ")\n";				
					$($('input[name=fl-cont]:checked')).each(function(index, byLocation){
						if(selector === '') {
							selector += "[data-category~='" + byLocation.id + "']";  					
						} else {
							selector += ",[data-category~='" + byLocation.id + "']";	
						}				 
					});				
				} else {
					str += "    AND " + "with (" +  byLocation.join(' OR ') + ")\n";				
					$($('input[name=fl-cont]:checked')).each(function(index, byLocation){
						if(nselector === '') {
							nselector += "[data-category~='" + byLocation.id + "']";  					
						} else {
							nselector += ",[data-category~='" + byLocation.id + "']";	
						}	
					});
				}			 
			}
			
			$lis.slideUp(); 
			window.console.log(selector);
			window.console.log(cselector);
			window.console.log(nselector);
			
			if (cselector === '' && nselector === '') {			
				$('#accordion > .accordion-toggle').filter(selector).slideDown();
			} else if (cselector === '') {
				$('#accordion > .accordion-toggle').filter(selector).filter(nselector).slideDown();
			} else if (nselector === '') {
				$('#accordion > .accordion-toggle').filter(selector).filter(cselector).slideDown();
			} else { 
				$('#accordion > .accordion-toggle').filter(selector).filter(cselector).filter(nselector).slideDown();
			}
			
		} else {
			$lis.slideDown();
		}	
							  
		$("#result").html(str);	

	});
	
	function removeA(arr) {
		var what, a = arguments, L = a.length, ax;
		while (L > 1 && arr.length) {
			what = a[--L];
			while ((ax= arr.indexOf(what)) !== -1) {
				arr.splice(ax, 1);
			}
		} 
		return arr;
	}	

	// LOCATION DROPDOWN

	// Toggle subnavigation when Filter by Location is clicked
    $('.primary-navigation-m-loc #locations-filter > li').click(function () {
        var mobileNavDropdown = $(".inner-primary-navigation-m-loc");
        if (mobileNavDropdown.is(':visible')) {
            mobileNavDropdown.slideUp();
            
            // rotate chevron back to original state
            $('.chevron-loc').css("transform","");
        } else {
	        // close Position dropdown if open
	        $(".inner-primary-navigation-m").slideUp();
	        // rotate chevron back to original state
            $('.chevron').css("transform","");
            mobileNavDropdown.slideDown();
            
            // rotate chevron to point down
            $('.chevron-loc').css("transform","rotate(180deg)");
        }
    });
});
})(jQuery);