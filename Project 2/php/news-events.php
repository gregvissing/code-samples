<?php
  /*
   * Partial Name: News & Events
   */
?>	

<div id="fb-root"></div>
<?php 
	
//Define your custom post type name in the arguments
 
$args = array('post_type' => 'events', 'orderby' => 'wpcf-date-of-event', 'meta_key' => 'wpcf-date-of-event', 'order' => 'ASC', 'status' => 'publish');

//Define the loop based on arguments

$loop = new WP_Query( $args );

?>

<div id="outer-events-container"><?php 

	while ( $loop->have_posts() ) : $loop->the_post();

	$date = get_post_meta(get_the_id(), 'wpcf-date-of-event', true);
	if ($date < strtotime("today")) {
		$newPost = array("ID" => get_the_id(), "post_status" => "draft");
		wp_update_post($newPost);
	} else {
		$event = get_the_terms(get_the_id(), 'events', '', '', ''); 
	
?>
		
		<div class="event-container" >
			

<?php
$eventID = get_the_id();
$event_date = types_render_field("date-of-event", array("text"=>"true"));
$event_time = types_render_field("time-of-event", array("raw"=>"true"));

//Output the trainer email
 
			
			echo "<div class='date-container'><div id='event$eventID' class='event-month'>".date('M',strtotime($event_date))."</div>";
			echo "<div id='event$eventID' class='event-day'>".date('d',strtotime($event_date))."</div></div>";
?>
			<div id="event<?php the_id(); ?>" class="event-title"><?php the_title(); ?></div>
			<div class="social-icons"> 
				<p>Share</p>
				<div class="fb-share-button" data-href="<?php echo the_permalink(); ?>" data-layout="button_count"></div>
						
				<span class="fl-icon">
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink(); ?>"></a>
				</span>
				
				<a href="mailto:?subject=CareBridge event: <?php echo get_the_title(); ?>&body=%20<?php echo the_permalink(); ?>"><img class="email" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/email.png"></a>
			</div>
			<div class="clearfix"></div>
			<div class="event-excerpt"><?php the_excerpt(); ?></div>
			<div id="event<?php the_id(); ?>" class="event-content"><?php the_content(); ?></div>
			<div class="clearfix"></div>
<!-- 			<a href="<?php echo the_permalink(); ?>">Read More</a> -->
			<?php echo "<button id='event$eventID' class='btn btn-primary event'>View Event Information</button>" ?><div class="clearfix"></div>
			
			<div class="clearfix"></div>
			<hr />
		</div><!-- end event-container -->
	<?php	} ?>
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
	<!-- SINGLE EVENT SECTION -->
	<div class="single-event-container">
		
		<div class="date-container">
			<div class="event-month"><?php echo date('M',strtotime($event_date)); ?></div>
			<div class="event-day"><?php echo date('d',strtotime($event_date)); ?></div>
		</div>
		<div class="event-title"><?php the_title(); ?></div> 	
		<div class="clearfix"></div><br />
		<div id="event-content"><?php the_content(); ?></div>
		<div class="social-icons"> 
			<p>Share</p>
			<div class="fb-share-button" data-href="<?php echo the_permalink(); ?>" data-layout="button_count"></div>
					
			<span class="fl-icon">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink(); ?>"></a>
			</span>
			 
			<a href="mailto:?subject=CareBridge event: <?php echo get_the_title(); ?>&body=%20<?php echo the_permalink(); ?>"><img class="email" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/email.png"></a>
		</div>
		<h2 class="viewAll">View All Events</h2>
		<div class="clearfix"></div>
	</div>

<!--
<h2 class="no-more-events" style="display: none;">No More Events</h2>
<button class="btn load-more" style="display: none;">LOAD MORE EVENTS</button>
-->
</div><!-- end outer-events-container -->
<div class="clearfix"></div>