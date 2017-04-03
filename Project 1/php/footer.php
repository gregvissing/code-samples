<?php
  /*
   * Partial Name: Footer
   */
?>
<?php
// Custom Fields
$emma_form = get_field('subscription_form_shortcode', 4);
?>

<div class="fl-page-footer">
	<div class="fl-page-footer-container container">
		<div class="fl-page-footer-row row">
			<div class="col-md-4 text-center clearfix">
				<div class="fl-page-footer-text fl-page-footer-text-1">
					<p class="venue">LIVE AT THE LUDLOW GARAGE</p>
					<p>342 Ludlow Ave</p>
					<p>Cincinnati, OH 45220</p>
					<p>(513) 221-4111</p>
				</div>
			</div>	
			<div class="col-md-4 text-center clearfix">
				<div class="fl-page-footer-text fl-page-footer-text-1">
<!--
					<?php
						gravity_form(2, false, false, false, '', true, 1);
					?>
-->
					<button class="btn btn-lg join-email-list" data-toggle="modal" data-target="#emailListModal">JOIN OUR EMAIL LIST</button>	
					<button id="parking" class="btn btn-lg parking-info" data-toggle="modal" data-target="#myModal">PARKING INFORMATION</button>			
				</div>
			</div>
			<div class="col-md-4 text-center clearfix">
				<a class="footer-logo" href="<?php echo home_url(); ?>" itemprop="url"><?php FLTheme::logo(); ?></a>
			</div>					
		</div>
	</div>
</div>
<!-- MODAL ================= -->
<div class="modal parking fade" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h3 class="modal-title" id="myModalLabel">PARKING INFORMATION</h3>
				<div class="clearfix" ></div>
				
			</div>
			
			<div class="modal-body">
				<?php
					
						$page_id = get_the_id();	
						$value = get_field( "parking_information", 4 );
						echo $value;

				?>
				
			</div>
		
		</div>
	</div>
</div>
<div class="modal emailList fade" id="emailListModal">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h3 class="modal-title" id="myModalLabel">JOIN OUR EMAIL LIST</h3>
				<div class="clearfix" ></div>
				
			</div>
			
			<div class="modal-body">
				<?php 

					echo $emma_form;
					 
				?>
				<p><small>By providing your email you consent to receiving occasional emails about upcoming shows. <br>No Spam. We respect your privacy &amp; you may unsubscribe at any time.</small></p>
				
			</div>
		
		</div>
	</div>
</div>
