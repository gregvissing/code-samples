<?php
  /*
   * Partial Name: Past Shows
   */
?>

<?php 
 
//Define your custom post type name in the arguments
 
$args = array(
	'post_type' => 'shows', 
	'posts_per_page' => -1, 
	'orderby' => 'show_date', 
	'meta_key' => 'show_date', 
	'meta_query' => array(
	    'relation' => 'AND',
	    array(
	      'key' => 'show_date',
	      'value' => date('Ymd', strtotime('now')),
	      'type' => 'numeric',
	      'compare' => '<',
	    )
	  ),
	'order' => 'DESC', 
	'status' => 'publish');

//Define the loop based on arguments

$loop = new WP_Query( $args );

?>

<div class="clearfix"></div>
<div id="outer-shows-container" class="past">
<?php 

	while ( $loop->have_posts() ) : $loop->the_post();
	
	$shows = get_the_terms(get_the_id(), 'show', '', '', ''); 
	
	$showID	= get_the_id();
	
	$feat_image = wp_get_attachment_url(get_post_thumbnail_id($showID));
	
	// Format date for Shows
	$showDate = get_field('show_date', $showID);
	
	// extract Y,M,D
	$y = substr($showDate, 0, 4);
	 
	$dayNumber = date('j',strtotime($showDate));
	$dayOfWeek = date('l',strtotime($showDate));
	$showMonth = date('M',strtotime($showDate));
	$showMonthClass = date('F',strtotime($showDate));
	
	// check if the Featured Image Position repeater field has rows of data
	if( have_rows('featured_image_position') ):
	
	 	// loop through the rows of data
	    while ( have_rows('featured_image_position') ) : the_row();
	
	        // display a sub field value
	        $horizontalAlign = get_sub_field('horizontal_position');
	        $verticalAlign = get_sub_field('vertical_position');
	
	    endwhile;
	
	endif;
	
	$supportingBands = get_field("supporting_bands", $showID);
	$showTime = get_field("show_time", $showID);
	$ticketPrice = get_field("ticket_price", $showID);
	$doorTime = get_field("door_time", $showID);
	$showType = get_field("showType", $showID); 
	$restrictions = get_field("restrictions", $showID);
	$ticketmaster_link = get_field("ticketmaster_link", $showID);
	
	$soldOut = get_field("sold_out", $showID);
	
	if($soldOut) {
		$ticketsText = "SOLD OUT";
	} else {
		$ticketsText = "PURCHASE TICKETS";
	}
	
	$showTitle = wp_trim_words(get_the_title(), 8, '...');

?>
<!-- show-card-container -->
<div class="show-card-container past-show hide-show <?php echo $showMonthClass . " " . $showType; ?>" data-month="<?php echo $showMonth; ?>" >
	<div id="show<?php the_id(); ?>" class="show-date">
		<?php echo "<span class='date'>" . $dayOfWeek . ' ' . $showMonth. '. ' . $dayNumber . ' ' . $y . ' @ ' . $showTime . "</span>"; ?>
<!-- 		<span class="show-time"><?php echo $showTime; ?></span>  -->
		
		<span class="bg-horizontal-position"><?php echo $horizontalAlign; ?></span>
		<span class="bg-vertical-position"><?php echo $verticalAlign; ?></span>
		<span class="ticketmaster-link"><?php echo $ticketmaster_link; ?></span>
		<span class="permalink"><?php echo the_permalink(); ?></span>
	</div>
	<span class="mobile-title"><?php echo $showTitle; ?></span>
	<span class="mobile-supporting-band"><?php echo $supportingBands; ?></span>
	<div class="show-info">
		
		<div id="show<?php the_id(); ?>" class="show-image" style="background-image: url(<?php echo $feat_image; ?>);background-position: <?php echo $horizontalAlign . " " . $verticalAlign; ?>">
		</div>
		
		<div id="show<?php the_id(); ?>" class="show-title">
			<span class="title"><?php echo $showTitle; ?></span>
			<span class="supporting"><?php echo $supportingBands; ?></span>
			<div class="show-button-container">
				<a href="#" id="show<?php the_id(); ?>" class="btn btn-lg more-info" data-toggle="modal" data-target="#myShowsModal">MORE INFO</a>
			</div>
		</div>
	</div>
	<div id="show<?php the_id(); ?>" class="mobile-more-info">
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
					<?php if( get_field('website_url') ): ?>
						<span class="fl-icon">
							<a href="<?php echo $websiteURL; ?>" target="_blank" alt="website">
								<i class="fa-link"></i> 
							</a>	
						</span>					
					<?php endif; ?>
					<?php if( get_field('facebook_url') ): ?>
						<span class="fl-icon">
							<a href="<?php echo $facebookURL; ?>" target="_blank">
								<i class="fa fa-facebook"></i> 
							</a>	
						</span>	
					<?php endif; ?>	
					<?php if( get_field('twitter_url') ): ?>		
						<span class="fl-icon">	
							<a href="<?php echo $twitterURL; ?>" target="_blank">
								<i class="fa fa-twitter"></i> 
							</a>
						</span>					
					<?php endif; ?>	
					<?php if( get_field('soundcloud_url') ): ?>	
						<span class="fl-icon">
							<a href="<?php echo $soundcloudURL; ?>" target="_blank">
								<i class="fa fa-soundcloud"></i> 
							</a>	
						</span>						
					<?php endif; ?>
					<?php if( get_field('youtube_channel') ): ?>
						<span class="fl-icon">
							<a href="<?php echo $youtubeChannel; ?>" target="_blank">
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
		<span class="bio mobile-label">ARTIST BIO</span><span class="bio-content"><?php echo the_content(); ?></span>
		<button type="button" class="bottom-close-show">
			<span aria-hidden="true">&times; Close</span>
			<span class="sr-only">Close</span>
		</button>
	</div>
	
</div> <!-- end: show-card-container.past-show -->
<?php endwhile; ?>

<?php wp_reset_postdata(); ?>

</div>
<div class="clearfix"></div>
<div id="load-more-shows">
	<button class="btn btn-lg load-more-past">VIEW MORE SHOWS</button>
  	<h2 class="no-more-events" style="display: none;">NO MORE SHOWS</h2>
</div>

<!-- --------------------------- -->
<!-- Individual Show Information -->
<!-- --------------------------- -->
<div id="individual-show-container" style="background-image: url('http://ludlowgarage.wpengine.com/wp-content/uploads/2016/05/stage.jpg');">
	<div class="image-zoom" style="background-image: url(<?php echo $feat_image; ?>);">
		<button type="button" class="close-zoomed-image">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
	</div>
	<button type="button" class="close-show">
		<span aria-hidden="true">&times;</span>
		<span class="sr-only">Close</span>
	</button>
	<div id="individual-artist-container">
		<h1 class="show-title"></h1>
		<span class="supporting-bands"></span>
	</div>
	<div id="show-details">
		<div class="artist-img" style="background-image: url(<?php echo $feat_image; ?>);background-position: top center"></div>
		<span class="click-zoom">CLICK TO ZOOM <span class="fl-icon"><i class="fa fa-search-plus"></i></span></span>
		<div class="date-time">
			<h3>SHOW DETAILS</h3>
			<h4 class="show-date"></h4>
			<h4 class="show-time"></h4>
			<h4 class="ticket-price"></h4>
			<h4 class="show-type"></h4>
			<h4 class="restrictions"></h4>
		</div>
	</div>
	<div id="connect">
		<h4>CONNECT:</h3>
		<div class="fl-icon-group fl-icon-group-center">	
		</div>
	</div>
	
	<div id="share">
		<h4>SHARE:</h3>
		<div class="share-container"></div>	
	</div> 
	<div id="bio-details">
		<h3>ARTIST BIO</h3>
		<p id="scroll" class="bio-content"></p>
	</div>
	<span id="bottom" class="chevron"><img src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/chevron.png"></span>
	<button type="button" class="bottom-close-show">
		<span aria-hidden="true">&times; Close</span>
		<span class="sr-only">Close</span>
	</button>
</div>
