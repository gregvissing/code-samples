<?php
  /*
   * Partial Name: Menu Items
   */
?>

<div id="outer-menu-container">
<!-- <img class="menu-header-img" src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/menu-header.png"> -->
<h1>LUDLOW GARAGE BISTRO</h1>
<p id="chef"><strong>Chef Jerry Rush</strong></p>
<?php

$courseNames = get_terms("course", array("hide_empty" => true));

foreach($courseNames as $course)
{

		$posts = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'menu-items',
			'orderby' => 'menu_order',
			'course' => $course->slug,
			'order' => 'ASC'
		));
		
		echo '<div class="course-section" id='.$course->slug.'>';
		
		if($posts)
		{
			echo '<h1>' . $course->name . '</h1>';
			
			if ($course->description <> "")
			{
				echo '<p class="side-note">' . $course->description .'<p>';
			}
			foreach($posts as $post)
			{
				$postID = $post->ID;
				$showTime = the_sub_field("menu_item", $postID);

				echo '<div class="menu-item">';
				echo '<div class="item-price"><h3>' . get_field("menu_item", $post->ID) . '</h3>';
				
				if (get_field('food_image', $post->ID) <> "")
				{
					?>
					<span class="fl-icon-wrap">
						<span class="fl-icon">
							<i class="fa fa-camera"></i> 
						</span>							
					</span>
					<?php
				}
				
				echo '<span class="price">' . get_field("price", $post->ID) . '</span></div>';
				echo '<p class="item-description">' . get_field("item_description", $post->ID) . '</p>';
				echo '</div>';
				if (get_field('food_image', $post->ID) <> "")
				{
					?>
						<div class="image-container">
							<span class="close-image">&times;</span>
							<img src="<?php echo get_field("food_image", $post->ID); ?>" class="dish-image">
						</div><!-- END: .image-container -->
					<?php
				}
			}
		
		}
		
		echo '</div>'; // End course-section class

}

?>

</div>
