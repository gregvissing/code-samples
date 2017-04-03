<?php
  /*
   * Partial Name: Patient Stories
   */
?>

<?php   
global $wpdb;

$result = $wpdb->get_results ( "
    SELECT * 
    FROM  $wpdb->posts
        WHERE post_type = 'post'
        AND post_status = 'publish'
" );

foreach ( $result as $page )
{
   echo '<div class="patient-story">'.get_the_post_thumbnail( $page->ID, 'thumbnail' ).'<span>'.$page->post_title.'</span>'.$page->post_excerpt.'<br/><a href="'.$page->guid.'">Read '.$page->post_title.'\'s Story</a></div>';
   
}
?>