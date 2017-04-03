<?php
  /*
   * Partial Name: Event Calendar PRO
   */
?>

<?php
// Ensure the global $post variable is in scope
global $post;
 
// Retrieve all upcoming events
$events = tribe_get_events( array(
    'posts_per_page' => -1,
    'start_date' => date( 'Y-m-d' )
) );

?>

<div class="clearfix"></div>
<div id="outer-shows-container">
	<h1 id="no-shows-text">No shows are scheduled this month.<br />Please check back later!</h1>
	<?php
	 
	foreach ( $events as $post ) {
	    setup_postdata( $post );

	    $shows = get_the_terms(get_the_id(), 'tribe_events', '', '', ''); 
	    $showID	= get_the_id();
	    
		$feat_image = wp_get_attachment_url(get_post_thumbnail_id($showID));	// Featured Image URL
		
		$showDate = $post->EventStartDate;				// Get Show Start Date
		// extract Y,M,D
		$y = substr($showDate, 0, 4);					// Parse Date to get Day of Week, Day and Month
		 
		$dayNumber = date('j',strtotime($showDate));
		$dayOfWeek = date('l',strtotime($showDate));
		$showMonth = date('M',strtotime($showDate));
		$showYear = date('Y',strtotime($showDate));
		$showMonthClass = date('F',strtotime($showDate));
		
		$showTitle = $post->post_title;						// Event Title
		$shortenedTitle = wp_trim_words($showTitle, 8, '...');	// Trim Event Title if more than 8 words long
		
		$showTime = tribe_get_start_time( $showID );		// Start Time
		
		$terms = get_the_terms( $post->ID , 'tribe_events_cat' );	// Event Category
		foreach ( $terms as $term ) {
			$showType = $term->name;
		}
		
		// Additional Fields
		$custom_fields = tribe_get_custom_fields();
		$doorTime = $custom_fields[ 'Door Time' ];
		
		if ( !empty($custom_fields ['Restrictions'] )) {
			$restrictions = $custom_fields[ 'Restrictions' ];
		}
		if ( !empty($custom_fields ['Ticket Prices'] )) {
			$ticketPrice = $custom_fields[ 'Ticket Prices' ];
		}
		$ticketURL = tribe_get_event_meta( $showID, '_EventURL', true );
		
		// check if the Featured Image Position repeater field has rows of data
		if( have_rows('featured_image_position') ):
		
		 	// loop through the rows of data
		    while ( have_rows('featured_image_position') ) : the_row();
		
		        // display a sub field value
		        $horizontalAlign = get_sub_field('horizontal_position');
		        $verticalAlign = get_sub_field('vertical_position');
		
		    endwhile;
		
		endif;
		
		$ticketsText = "PURCHASE TICKETS";
		
		$limitedAvailability = get_field("limited_availability", $showID);
		if($limitedAvailability) {
			$ticketsText = "LIMITED AVAILABILITY";
		}
		
		$soldOut = get_field("sold_out", $showID);
		if($soldOut) {
			$ticketsText = "SOLD OUT!";
		}	
		
		$artistBio = get_field("artist_bio", $showID);
		
	?>
    <!-- show-card-container -->
	<div class="show-card-container hide-show <?php echo $showMonthClass; ?>" data-month="<?php echo $showMonth; ?>" >
		<div id="show<?php the_id(); ?>" class="show-date">
			<?php echo "<span class='date'>" . $dayOfWeek . ' ' . $showMonth. '. ' . $dayNumber . ' ' . $showYear . "</span>"; ?><span class="show-time"><?php echo $showTime; ?></span>
		</div>
		<span class="mobile-title"><?php echo $showTitle; ?></span>
		<div class="show-info">
			
			<div id="show<?php the_id(); ?>" class="show-image" style="background-image: url(<?php echo $feat_image; ?>);background-position: <?php echo $horizontalAlign . " " . $verticalAlign; ?>">
			</div>
			
			<div id="show<?php the_id(); ?>" class="show-title">
				<span class="title"><?php echo $shortenedTitle; ?></span>
				<div class="show-button-container">
					<a href="<?php echo $ticketURL; ?>" class="btn btn-lg purchase"><?php echo $ticketsText; ?></a>

					<div id="show<?php the_id(); ?>" class="btn btn-lg more-info">MORE INFO</div>
				</div>
			</div>
		</div>
		<div id="show<?php the_id(); ?>" class="mobile-more-info">
			
			<div id="show<?php the_id(); ?>" class="show-date">
			<?php echo "<span class='date'>" . $dayOfWeek . ' ' . $showMonth. '. ' . $dayNumber . ' ' . $y . "</span>"; ?>
				
				<span class="show-time"><?php echo "@ " . $showTime; ?></span>
				<span id="show<?php the_id(); ?>" class="top-close-show">&times;</span>
				<span class="clearfix"></span>
			</div>
			<div class="more-info-cols">
				<span class="mobile-label">Doors open at: </span><span class="door-time"><?php echo $doorTime; ?></span>
				<span class="mobile-label">Ticket Price: </span><span class="ticket-price"><?php echo $ticketPrice; ?></span>
				<span class="mobile-label">Show Type: </span><span class="show-type"><?php echo $showType; ?></span>
				<span class="mobile-label">Restrictions: </span><span class="restrictions"><?php echo $restrictions; ?></span>
			</div>
			<div id="social-media">
				<span class="connect-label">CONNECT: </span>
				<div class="fl-icon-group fl-icon-group-center">
					<div id="show<?php the_id(); ?>" class="fl-icon-group fl-icon-group-center">						
						<?php if ( !empty($custom_fields ['Website URL'] )): ?>
							<span class="fl-icon">
								<a href="<?php echo $custom_fields[ 'Website URL' ]; ?>" title="Official website of <?php echo $showTitle; ?>" target="_blank" alt="website">
									<i class="fa-link"></i> 
								</a>	
							</span>					
						<?php endif; ?>
						<?php if ( !empty($custom_fields ['Facebook'] )): ?>
							<span class="fl-icon">
								<a href="<?php echo $custom_fields[ 'Facebook' ]; ?>" target="_blank">
									<i class="fa fa-facebook"></i> 
								</a>	
							</span>	
						<?php endif; ?>	
						<?php if ( !empty($custom_fields ['Twitter'] )): ?>		
							<span class="fl-icon">	
								<a href="<?php echo $custom_fields[ 'Twitter' ]; ?>" target="_blank">
									<i class="fa fa-twitter"></i> 
								</a>
							</span>					
						<?php endif; ?>	
						<?php if ( !empty($custom_fields ['Soundcloud'] )): ?>	
							<span class="fl-icon">
								<a href="<?php echo $custom_fields[ 'Soundcloud' ]; ?>" target="_blank">
									<i class="fa fa-soundcloud"></i> 
								</a>	
							</span>						
						<?php endif; ?>
						<?php if ( !empty($custom_fields ['YouTube'] )): ?>
							<span class="fl-icon">
								<a href="<?php echo $custom_fields[ 'YouTube' ]; ?>" target="_blank">
									<i class="fa fa-youtube"></i> 
								</a>	
							</span>						
						<?php endif; ?>	
					</div>
				</div>	
				<div id="share">
					<h4>SHARE:</h3>
					<div id="show<?php the_id(); ?>" class="share-container">
						<div class="fb-share-button" data-href="<?php echo the_permalink(); ?>" data-layout="button"></div>
										
						<span class="fl-icon">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink(); ?>"></a>
						</span>
							
						<a href="mailto:?subject=Live at the Ludlow Garage event: <?php echo get_the_title(); ?>&body=%20<?php echo the_permalink(); ?>"><img class="email" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/email.png"></a>
					</div>
				</div>  
			</div>
			<a href="<?php echo $ticketURL; ?>" class="btn btn-lg purchase mobile"><?php echo $ticketsText; ?></a>
			<span class="bio mobile-label">ARTIST BIO</span>
			<span class="bio-content"><?php echo $artistBio; ?></span>
			<div id="show<?php the_id(); ?>" class="bottom-close-show">&times; Close</div>
		</div>		
	</div> <!-- end: show-card-container -->
	
	<!-- 	.individual-show-container -->
	<div class="individual-show-container" id="show<?php the_id(); ?> individual-show-container" style="background-image: url('http://ludlowgarage.wpengine.com/wp-content/uploads/2016/05/stage.jpg');">
		<div class="image-zoom" style="background-image: url(<?php echo $feat_image; ?>);">
			<div class="close-zoomed-image">
				<span>&times;</span>
			</div>
		</div>
		<div class="close-show">&times;</div>
		<div id="individual-artist-container">
			<h1 class="show-title"><?php echo get_the_title(); ?></h1>
		</div>
		<div id="show-details">
			<div class="artist-img" style="background-image: url(<?php echo $feat_image; ?>);background-position: <?php echo $horizontalAlign . " " . $verticalAlign; ?>"></div>
			<span class="click-zoom">CLICK TO ZOOM <span class="fl-icon"><i class="fa fa-search-plus"></i></span></span>
			<div class="date-time">
				<h3>SHOW DETAILS</h3>
				<h4 class="show-date">WHEN: <?php echo $dayOfWeek . ' ' . $showMonth. '. ' . $dayNumber . ' ' . $y; ?></h4>
				<h4 class="show-time">TIME: <?php echo $showTime; ?></h4>
				<h4 class="ticket-price">TICKET PRICE: <?php echo $ticketPrice; ?></h4>
				<h4 class="show-type">SHOW TYPE: <?php echo $showType; ?></h4>
				<h4 class="restrictions">RESTRICTIONS: <?php echo $restrictions; ?></h4>
			</div>
			<a href="#" class="btn btn-lg purchase">PURCHASE TICKETS</a>
		</div>		
		<div id="connect">
			<h4>CONNECT:</h3>
			<div class="fl-icon-group fl-icon-group-center">
				<div id="show<?php the_id(); ?>" class="fl-icon-group fl-icon-group-center">						
					<?php if ( !empty($custom_fields ['Website URL'] )): ?>
						<span class="fl-icon">
							<a href="<?php echo $custom_fields[ 'Website URL' ]; ?>" title="Official website of <?php echo $showTitle; ?>" target="_blank" alt="website">
								<i class="fa-link"></i> 
							</a>	
						</span>					
					<?php endif; ?>
					<?php if ( !empty($custom_fields ['Facebook'] )): ?>
						<span class="fl-icon">
							<a href="<?php echo $custom_fields[ 'Facebook' ]; ?>" target="_blank">
								<i class="fa fa-facebook"></i> 
							</a>	
						</span>	
					<?php endif; ?>	
					<?php if ( !empty($custom_fields ['Twitter'] )): ?>		
						<span class="fl-icon">	
							<a href="<?php echo $custom_fields[ 'Twitter' ]; ?>" target="_blank">
								<i class="fa fa-twitter"></i> 
							</a>
						</span>					
					<?php endif; ?>	
					<?php if ( !empty($custom_fields ['Soundcloud'] )): ?>	
						<span class="fl-icon">
							<a href="<?php echo $custom_fields[ 'Soundcloud' ]; ?>" target="_blank">
								<i class="fa fa-soundcloud"></i> 
							</a>	
						</span>						
					<?php endif; ?>
					<?php if ( !empty($custom_fields ['YouTube'] )): ?>
						<span class="fl-icon">
							<a href="<?php echo $custom_fields[ 'YouTube' ]; ?>" target="_blank">
								<i class="fa fa-youtube"></i> 
							</a>	
						</span>						
					<?php endif; ?>	
				</div>
			</div>
		</div>		
		<div id="share">
			<h4>SHARE:</h3>
			<div id="show<?php the_id(); ?>" class="share-container">
				<div class="fb-share-button" data-href="<?php echo the_permalink(); ?>" data-layout="button"></div>
								
				<span class="fl-icon">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink(); ?>"></a>
				</span>
					
				<a href="mailto:?subject=Live at the Ludlow Garage event: <?php echo get_the_title(); ?>&body=%20<?php echo the_permalink(); ?>"><img class="email" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/email.png"></a>
			</div>
		</div> 		
		<div id="bio-details">
			<h3>ARTIST BIO</h3>
			<div id="scroll" class="bio-content"><?php the_field('artist_bio'); ?></div>
		</div>
		
		<div id="show<?php the_id(); ?>" class="bottom-close-show">
			&times; Close
		</div>
	</div>
	<!-- 	END: .individual-show-container -->
	
	<?php
	}
	?>

	<?php wp_reset_postdata(); ?>
	
	<?php
	global $post;
	// Retrieve all just announced events
	$events = get_posts( array(
        'posts_per_page' => 8,
        'post_type' => 'tribe_events',
        'orderby' => 'date', 
        'order' => 'DESC', 
        'post_status' => 'publish'
    ) );
	
	?>
	
	<?php
	$loop = new WP_Query( $events );	
	 
	foreach ( $events as $post ) {
	    setup_postdata( $post );
	    
	    $shows = get_the_terms(get_the_id(), 'tribe_events', '', '', ''); 
	    $showID	= get_the_id();
	    
		$feat_image = wp_get_attachment_url(get_post_thumbnail_id($showID));	// Featured Image URL
		
		$dayNumber = tribe_get_start_date( get_the_id(), false, 'j' );
		$dayOfWeek = tribe_get_start_date( get_the_id(), false, 'l' );
		$showMonth = tribe_get_start_date( get_the_id(), false, 'M' );
		$showYear = tribe_get_start_date( get_the_id(), false, 'Y' );
		$showMonthClass = tribe_get_start_date( get_the_id(), false, 'F' );
		
		$showTitle = $post->post_title;						// Event Title
		$shortenedTitle = wp_trim_words($showTitle, 8, '...');	// Trim Event Title if more than 8 words long
		
		$showTime = tribe_get_start_time( $showID );		// Start Time
		
		$terms = get_the_terms( $post->ID , 'tribe_events_cat' );	// Event Category
		foreach ( $terms as $term ) {
			$showType = $term->name;
		}
		
		// Additional Fields
		$custom_fields = tribe_get_custom_fields();
		$doorTime = $custom_fields[ 'Door Time' ];
		
		if ( !empty($custom_fields ['Restrictions'] )) {
			$restrictions = $custom_fields[ 'Restrictions' ];
		}
		if ( !empty($custom_fields ['Ticket Prices'] )) {
			$ticketPrice = $custom_fields[ 'Ticket Prices' ];
		}
		$ticketURL = tribe_get_event_meta( $showID, '_EventURL', true );
	
		// check if the Featured Image Position repeater field has rows of data
		if( have_rows('featured_image_position') ):
		
		 	// loop through the rows of data
		    while ( have_rows('featured_image_position') ) : the_row();
		
		        // display a sub field value
		        $horizontalAlign = get_sub_field('horizontal_position');
		        $verticalAlign = get_sub_field('vertical_position');
		
		    endwhile;
		
		endif;
		
		$limitedAvailability = get_field("limited_availability", $showID);
		if($limitedAvailability) {
			$ticketsText = "LIMITED AVAILABILITY";
		} else {
			$ticketsText = "PURCHASE TICKETS";
		}
		
		$soldOut = get_field("sold_out", $showID);
		if($soldOut) {
			$ticketsText = "SOLD OUT!";
		} else {
			$ticketsText = "PURCHASE TICKETS";
		}
		
		$artistBio = get_field("artist_bio", $showID);
		
	?>
    <!-- show-card-container -->
	<div class="show-card-container just-announced hide-show <?php echo $showMonthClass; ?>" data-month="<?php echo $showMonth; ?>" >
		<div id="JAshow<?php the_id(); ?>" class="show-date">
			<?php echo "<span class='date'>" . $dayOfWeek . ' ' . $showMonth. '. ' . $dayNumber . ' ' . $showYear . "</span>"; ?><span class="show-time"><?php echo $showTime; ?></span>
		</div>
		<span class="mobile-title"><?php echo $showTitle; ?></span>
		<div class="show-info">
			
			<div id="JAshow<?php the_id(); ?>" class="show-image" style="background-image: url(<?php echo $feat_image; ?>);background-position: <?php echo $horizontalAlign . " " . $verticalAlign; ?>">
			</div>
			
			<div id="JAshow<?php the_id(); ?>" class="show-title">
				<span class="title"><?php echo $shortenedTitle; ?></span>
				<div class="show-button-container">
					<a href="<?php echo $ticketURL; ?>" class="btn btn-lg purchase"><?php echo $ticketsText; ?></a>

					<div id="JAshow<?php the_id(); ?>" class="btn btn-lg more-info">MORE INFO</div>
				</div>
			</div>
		</div>
		<div id="JAshow<?php the_id(); ?>" class="mobile-more-info">
			
			<div id="JAshow<?php the_id(); ?>" class="show-date">
			<?php echo "<span class='date'>" . $dayOfWeek . ' ' . $showMonth. '. ' . $dayNumber . ' ' . $y . "</span>"; ?>
				
				<span class="show-time"><?php echo "@ " . $showTime; ?></span>
				<span id="JAshow<?php the_id(); ?>" class="top-close-show">&times;</span>
				<span class="clearfix"></span>
			</div>
			<div class="more-info-cols">
				<span class="mobile-label">Doors open at: </span><span class="door-time"><?php echo $doorTime; ?></span>
				<span class="mobile-label">Ticket Price: </span><span class="ticket-price"><?php echo $ticketPrice; ?></span>
				<span class="mobile-label">Show Type: </span><span class="show-type"><?php echo $showType; ?></span>
				<span class="mobile-label">Restrictions: </span><span class="restrictions"><?php echo $restrictions; ?></span>
			</div>
			<div id="social-media">
				<span class="connect-label">CONNECT: </span>
				<div class="fl-icon-group fl-icon-group-center">
					<div id="JAshow<?php the_id(); ?>" class="fl-icon-group fl-icon-group-center">						
						<?php if ( !empty($custom_fields ['Website URL'] )): ?>
							<span class="fl-icon">
								<a href="<?php echo $custom_fields[ 'Website URL' ]; ?>" title="Official website of <?php echo $showTitle; ?>" target="_blank" alt="website">
									<i class="fa-link"></i> 
								</a>	
							</span>					
						<?php endif; ?>
						<?php if ( !empty($custom_fields ['Facebook'] )): ?>
							<span class="fl-icon">
								<a href="<?php echo $custom_fields[ 'Facebook' ]; ?>" target="_blank">
									<i class="fa fa-facebook"></i> 
								</a>	
							</span>	
						<?php endif; ?>	
						<?php if ( !empty($custom_fields ['Twitter'] )): ?>		
							<span class="fl-icon">	
								<a href="<?php echo $custom_fields[ 'Twitter' ]; ?>" target="_blank">
									<i class="fa fa-twitter"></i> 
								</a>
							</span>					
						<?php endif; ?>	
						<?php if ( !empty($custom_fields ['Soundcloud'] )): ?>	
							<span class="fl-icon">
								<a href="<?php echo $custom_fields[ 'Soundcloud' ]; ?>" target="_blank">
									<i class="fa fa-soundcloud"></i> 
								</a>	
							</span>						
						<?php endif; ?>
						<?php if ( !empty($custom_fields ['YouTube'] )): ?>
							<span class="fl-icon">
								<a href="<?php echo $custom_fields[ 'YouTube' ]; ?>" target="_blank">
									<i class="fa fa-youtube"></i> 
								</a>	
							</span>						
						<?php endif; ?>	
					</div>
				</div>	
				<div id="share">
					<h4>SHARE:</h3>
					<div id="JAshow<?php the_id(); ?>" class="share-container">
						<div class="fb-share-button" data-href="<?php echo the_permalink(); ?>" data-layout="button"></div>
										
						<span class="fl-icon">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink(); ?>"></a>
						</span>
							
						<a href="mailto:?subject=Live at the Ludlow Garage event: <?php echo get_the_title(); ?>&body=%20<?php echo the_permalink(); ?>"><img class="email" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/email.png"></a>
					</div>
				</div>  
			</div>
			<a href="<?php echo $ticketURL; ?>" class="btn btn-lg purchase mobile"><?php echo $ticketsText; ?></a>
			<span class="bio mobile-label">ARTIST BIO</span>
			<span class="bio-content"><?php echo $artistBio; ?></span>
			<div id="JAshow<?php the_id(); ?>" class="bottom-close-show">&times; Close</div>
		</div>		
	</div> <!-- end: show-card-container -->
	
	<!-- 	.individual-show-container -->
	<div class="individual-show-container" id="JAshow<?php the_id(); ?> individual-show-container" style="background-image: url('http://ludlowgarage.wpengine.com/wp-content/uploads/2016/05/stage.jpg');">
		<div class="image-zoom" style="background-image: url(<?php echo $feat_image; ?>);">
			<div class="close-zoomed-image">
				<span>&times;</span>
			</div>
		</div>
		<div class="close-show">&times;</div>
		<div id="individual-artist-container">
			<h1 class="show-title"><?php echo get_the_title(); ?></h1>
		</div>
		<div id="show-details">
			<div class="artist-img" style="background-image: url(<?php echo $feat_image; ?>);background-position: <?php echo $horizontalAlign . " " . $verticalAlign; ?>"></div>
			<span class="click-zoom">CLICK TO ZOOM <span class="fl-icon"><i class="fa fa-search-plus"></i></span></span>
			<div class="date-time">
				<h3>SHOW DETAILS</h3>
				<h4 class="show-date">WHEN: <?php echo $dayOfWeek . ' ' . $showMonth. '. ' . $dayNumber . ' ' . $y; ?></h4>
				<h4 class="show-time">TIME: <?php echo $showTime; ?></h4>
				<h4 class="ticket-price">TICKET PRICE: <?php echo $ticketPrice; ?></h4>
				<h4 class="show-type">SHOW TYPE: <?php echo $showType; ?></h4>
				<h4 class="restrictions">RESTRICTIONS: <?php echo $restrictions; ?></h4>
			</div>
			<a href="#" class="btn btn-lg purchase">PURCHASE TICKETS</a>
		</div>		
		<div id="connect">
			<h4>CONNECT:</h3>
			<div class="fl-icon-group fl-icon-group-center">
				<div id="show<?php the_id(); ?>" class="fl-icon-group fl-icon-group-center">						
					<?php if ( !empty($custom_fields ['Website URL'] )): ?>
						<span class="fl-icon">
							<a href="<?php echo $custom_fields[ 'Website URL' ]; ?>" title="Official website of <?php echo $showTitle; ?>" target="_blank" alt="website">
								<i class="fa-link"></i> 
							</a>	
						</span>					
					<?php endif; ?>
					<?php if ( !empty($custom_fields ['Facebook'] )): ?>
						<span class="fl-icon">
							<a href="<?php echo $custom_fields[ 'Facebook' ]; ?>" target="_blank">
								<i class="fa fa-facebook"></i> 
							</a>	
						</span>	
					<?php endif; ?>	
					<?php if ( !empty($custom_fields ['Twitter'] )): ?>		
						<span class="fl-icon">	
							<a href="<?php echo $custom_fields[ 'Twitter' ]; ?>" target="_blank">
								<i class="fa fa-twitter"></i> 
							</a>
						</span>					
					<?php endif; ?>	
					<?php if ( !empty($custom_fields ['Soundcloud'] )): ?>	
						<span class="fl-icon">
							<a href="<?php echo $custom_fields[ 'Soundcloud' ]; ?>" target="_blank">
								<i class="fa fa-soundcloud"></i> 
							</a>	
						</span>						
					<?php endif; ?>
					<?php if ( !empty($custom_fields ['YouTube'] )): ?>
						<span class="fl-icon">
							<a href="<?php echo $custom_fields[ 'YouTube' ]; ?>" target="_blank">
								<i class="fa fa-youtube"></i> 
							</a>	
						</span>						
					<?php endif; ?>	
				</div>
			</div>
		</div>		
		<div id="share">
			<h4>SHARE:</h3>
			<div id="show<?php the_id(); ?>" class="share-container">
				<div class="fb-share-button" data-href="<?php echo the_permalink(); ?>" data-layout="button"></div>
								
				<span class="fl-icon">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink(); ?>"></a>
				</span>
					
				<a href="mailto:?subject=Live at the Ludlow Garage event: <?php echo get_the_title(); ?>&body=%20<?php echo the_permalink(); ?>"><img class="email" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/email.png"></a>
			</div>
		</div> 		
		<div id="bio-details">
			<h3>ARTIST BIO</h3>
			<div id="scroll" class="bio-content"><?php the_field('artist_bio'); ?></div>
		</div>
		
		<div id="JAshow<?php the_id(); ?>" class="bottom-close-show">
			&times; Close
		</div>
	</div>
	<!-- 	END: .individual-show-container -->
	
	<?php
	}
	?>

</div><!-- end: outer-shows-container -->
<div class="clearfix"></div>
<div id="load-more-shows">
	<div class="btn btn-lg load-more">VIEW MORE SHOWS</div>
  	<h2 class="no-more-events" style="display: none;">NO MORE SHOWS</h2>
</div>

