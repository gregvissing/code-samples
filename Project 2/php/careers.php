<?php
  /*
   * Partial Name: Careers
   */
?>
<?php 
 
//Define your custom post type name in the arguments
 
$args = array('post_type' => 'career');

//Define the loop based on arguments

$loop = new WP_Query( $args );
?>

<!-- FILTER BY POSITION -->
<div class="primary-navigation-m">
<ul id="jobs-filter">
	<li><span id="mobile-press">Filter by Position</span><img class="chevron" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/chevron.png"></li>
	<ul id="jobs-list" class="inner-primary-navigation-m" style="display: none;" >
		<?php 
			$terms = get_terms("position");
			foreach ($terms as $term) {
				echo "<li><input type='checkbox' class='pos-filt' name='fl-colour' value='".str_replace(' ', '', $term->name)."' id='".str_replace(' ', '', $term->name)."'>".$term->name."</li>";
			}
		?>
		<li class="SelectAllClose"><input type="checkbox" id="selecctall-pos" rel="all-pos" name="fl-colour" value="AllPositions"><label id="label" for="selecctall-pos">Show All Positions</label> <button class="btn btn-close-positions">Close</button><div class="clearfix"></div></li>
	</ul>
</ul>
</div>
<!-- FILTER BY LOCATION -->
<!--
<div class="primary-navigation-m-loc">
<ul id="locations-filter">
	<li><span id="mobile-press-loc">Filter by Location</span><img class="chevron-loc" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/chevron.png"></li>
	<ul id="locations-list" class="inner-primary-navigation-m-loc" style="display: none;" >
		<li><input type="checkbox" class="loc-filt" name="fl-cont" id="CincinnatiOH" value="CincinnatiOH">Cincinnati, OH</li>
		<li class="SelectAllClose"><input type="checkbox" id="selecctall-loc" name="fl-cont" id="AllLocations" value="AllLocations"><label rel="CincinnatiOH ClevelandOH ColumbusOH DaytonOH" id="label" for="selecctall-loc">Show All Locations</label> <button class="btn btn-close-locations">Close</button><div class="clearfix"></div></li>
	</ul>
</ul>
</div>
-->
<p class="reset-filter">Reset filter</p>
<div class="clearfix"></div>
<div id="outer-jobs-container">
	<div id="job-top-container">
		<div class="job-title-top job-title">Job Title</div>
		<div class="job-location-top job-location">Location</div>
		<div class="job-post-date-top job-post-date">Date Posted</div>
	</div><!-- end job-top-container -->
	<div id="accordion">
<?php 

	while ( $loop->have_posts() ) : $loop->the_post();
	
	$positions = get_the_terms(get_the_id(), 'position', '', '', ''); 

?>
		
		<div class="accordion-toggle" data-category="<?php if(!empty($positions)) foreach ($positions as $position) { echo str_replace(' ', '', $position->name).' '; } ?><?php echo str_replace(array(',', ' '), '', get_post_meta(get_the_id(), "wpcf-location", true)); ?>">
			<div id="job<?php the_id(); ?>" class="job-title"><?php the_title(); ?></div>

<?php
$jobID = get_the_id();
$job_location = types_render_field("location", array("raw"=>"true"));
$post_date = types_render_field("date-posted", array("text"=>"true"));

//Output the trainer email
 
			echo "<div class='job-location location-job$jobID'>".$job_location."</div>";
			echo "<div class='job-post-date date-job$jobID'>".date('n/d/Y',strtotime($post_date))."</div>";
?>

		</div><!-- end accordion-toggle -->
		<div class="accordion-content">
			<?php echo "<button id='job$jobID' class='btn btn-success btn-lg btn-block' data-toggle='modal' data-target='#myModal'>Apply Now</button>" ?>
			<?php the_content(); ?><br />
			<?php echo "<button id='job$jobID' class='btn btn-success btn-lg btn-block' data-toggle='modal' data-target='#myModal' style='float:none;margin:0 auto;'>Apply Now</button>" ?>
		</div><!-- end accordion-content -->

<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
	</div><!-- end accordion -->
</div><!-- end outer-jobs-container -->
<!-- MODAL ================= -->
<div class="modal careers fade" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h3 class="modal-title" id="myModalLabel"> </h3> | <h4 class="modal-location"></h4>
				<div class="clearfix" ></div>
				<p>Posted on:&nbsp;</p><p class="modal-post-date"></p>
				
			</div><!-- modal-header -->
			
			<div class="modal-body">
				
				[gravityform id="2" title="false" description="false" ajax=true]
				
			</div><!-- modal-body -->
		
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->
