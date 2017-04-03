<?php
  /*
   * Partial Name: Shows Filter
   */
?>

<div id="filter-container">
	<ul id="months">
		<li class="month-container upcoming active">UPCOMING</li>
		<li class="month-container just-announced">JUST ANNOUNCED</li>
		<?php 
			echo "<li class='month-container current-month' id='" .date('F',strtotime('today'))."'>".date('F',strtotime('today'))."</li>";
			echo "<li class='month-container next-month' id='" .date('F', strtotime('first day of next month'))."'>".date('F', strtotime('first day of next month'))."</li>";
		?> 
		<li class="month-container more-months"><span class="closed">MORE +</span>
			<ul id="other-months">
				<?php
				// Get months of year starting with 2 months from CURRENT MONTH
				for ($i = 2; $i < 12; $i++) {
				    echo "<li class='other-month-container' id='" . date('F', strtotime('first day of +'.$i.' month')) ."'>".date('F', strtotime('first day of +'.$i.' month'))."</li>";
				}
				
				?>
			</ul>
		</li>
	</ul>
</div>

<div id="filter-container-mobile" class="primary-navigation-m">
	<ul id="month-filter">
		<li>
			<span id="mobile-press" style="font-family:'Montserrat';">UPCOMING</span>
			<span class="chevron" style="background-repeat: no-repeat; background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/library/images/chevron.png);" >
<!-- 				<img src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/chevron.png"> -->
			</span>
		</li>
			<ul class="inner-primary-navigation-m">
		        <li id="upcoming" class="upcoming active">UPCOMING</li>
				<li id="just-announced" class="just-announced">JUST ANNOUNCED</li>				
					<?php
						for ($i = 0; $i <= 11; $i++) 
						{
						   echo "<li id='" .date('F',strtotime('+'.$i.' month', strtotime('today')))."' class='month " .date('M',strtotime('+'.$i.' month', strtotime('today')))."".date('y',strtotime('+'.$i.' month', strtotime('today')))."' >".date('F',strtotime('+'.$i.' month', strtotime('today')))."</li>";
						}
					?>
				</li>
		    </ul>
<!-- 		</li> -->		
	</ul>
</div>

<div class="clearfix"></div>