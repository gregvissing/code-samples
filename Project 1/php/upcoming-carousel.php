<?php
  /*
   * Partial Name: Upcoming Shows carousel
   */
?>
<?php
// Ensure the global $post variable is in scope
global $post;
 
// Retrieve all upcoming events
$events = tribe_get_events( array(
    'posts_per_page' => 3,
    'start_date' => date( 'Y-m-d' )
) );

?>

<div class="container">
	<div id="myCarousel" class="carousel slide" data-ride="carousel">	
	
	  <!-- Wrapper for slides -->
	  <div class="carousel-inner" role="listbox">
		<div class="item active">
	      <div class="performer-img" >
			<?php
				if( have_rows('eat_at_the_ludlow_garage_slide') ):
							
				 	// loop through the rows of data
				    while ( have_rows('eat_at_the_ludlow_garage_slide') ) : the_row();
				
				        // display a sub field value
				        $food_bg_URL = get_sub_field('food_background');
			?>
						<div class="food-bg-img" style="background-image:url(<?php echo $food_bg_URL; ?>)"></div>
			<?php			
				    endwhile;
				
				endif;
			?>
			<img class="eat-slide-logo" src="<?php echo get_field('eat_at_lg_slide_logo'); ?>" />
	      </div>
	      
	      <div class="carousel-show-info">
		      <div class='show-text'>
			      <p class='title'>
				      <?php echo get_field('eat_at_lg_slide_text'); ?>
			      </p>
		      </div>
	      </div>
	      
	<!--       Mobile Upcoming Shows Carousel -->
	      <div class="carousel-show-info-m">
		      <div class="info-container-m">
			      <p class="title">
				      <?php echo get_field('eat_at_lg_slide_text'); ?>
			      </p>
		      </div>
	      </div>
	    </div>
		<?php $firstMarked = false; ?>
		<?php 
			
			foreach ( $events as $post ) {
			
			$shows = get_the_terms(get_the_id(), 'tribe_events', '', '', ''); 
			
			$showID	= get_the_id();
			
			$feat_image = wp_get_attachment_url(get_post_thumbnail_id($showID));
			
			// Format date for Shows
			$showDate = $post->EventStartDate;				// Get Show Start Date
			// extract Y,M,D
			$y = substr($showDate, 0, 4);					// Parse Date to get Day of Week, Day and Month
			 
			$dayNumber = date('j',strtotime($showDate));
			$dayOfWeek = date('l',strtotime($showDate));
			$showMonth = date('M',strtotime($showDate));
			$showMonthClass = date('F',strtotime($showDate));
			
			// Ticket fields
			$ticketURL = tribe_get_event_meta( $showID, '_EventURL', true );
			$soldOut = get_field("sold_out", $showID);
			if($soldOut) {
				$ticketsText = "SOLD OUT!";
			} else {
				$ticketsText = "GET TICKETS";
			}
			
			// 
			// check if the Featured Image Position repeater field has rows of data
			if( have_rows('featured_image_position') ):
			
			 	// loop through the rows of data
			    while ( have_rows('featured_image_position') ) : the_row();
			
			        // display a sub field value
			        $horizontalAlign = get_sub_field('horizontal_position');
			        $verticalAlign = get_sub_field('vertical_position');
			
			    endwhile;
			
			endif;
	
		?>
	    <div class="item">
	      <div class="performer-img" style="background-image: url(<?php echo $feat_image; ?>);background-position: <?php echo $horizontalAlign . " " . $verticalAlign; ?>;"></div>
	      <div class="carousel-show-info">
		      <?php echo "<div class='show-text'><p class='title'>" . get_the_title() . "</p>" ?>
		      <?php echo "<p>" . $dayOfWeek. ' ' .$showMonth. '. ' .$dayNumber. ' ' .$y . "</p>"; ?>
		      <a href="<?php echo $ticketURL; ?>" class="btn get-tickets"><?php echo $ticketsText; ?></a></div>
	      </div>
	      
	<!--       Mobile Upcoming Shows Carousel -->
	      <div class="carousel-show-info-m">
		      <?php echo "<div class='info-container-m'><p class='title'>" . get_the_title() . "</p>" ?>
		      <?php echo "<p class='mobile-date'>$dayOfWeek $showMonth. $dayNumber $y</p>" ?>
		      <a href="<?php echo $ticketURL; ?>" class="btn get-tickets">GET TICKETS</a></div>
	      </div>
	    </div>
	    <?php $firstMarked = true;?>
		<?php } ?>
	
	  </div>

	  <div class="fl-post-slider-navigation">
		  <a class="slider-prev" href="#myCarousel" data-slide="prev"><div class="fl-post-slider-svg-container"><?php include FL_BUILDER_DIR .'img/svg/arrow-left.svg'; ?></div></a>
	      <a class="slider-next" href="#myCarousel" data-slide="next"><div class="fl-post-slider-svg-container"><?php include FL_BUILDER_DIR .'img/svg/arrow-right.svg'; ?></div></a>
	  </div>
	</div>
</div>