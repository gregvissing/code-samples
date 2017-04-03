<?php
  /*
   * Partial Name: Header
   */
?>
<?php
	gravity_form_enqueue_scripts(2, true);	
?>
<header class="fl-page-header fl-page-header-primary<?php FLTheme::header_classes(); ?>" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
	<div class="fl-page-header-wrap">
		<div class="fl-page-header-container container">
			<div class="fl-page-header-row row">
				<div class="col-md-4 col-sm-12">
					<div class="fl-page-header-logo" itemscope="itemscope" itemtype="http://schema.org/Organization">
						<a href="<?php echo home_url(); ?>" itemprop="url"><?php FLTheme::logo(); ?></a>
					</div>
				</div>
				<div class="fl-page-nav-col col-md-8 col-sm-12">
					<div class="fl-page-nav-wrap">
						<nav class="fl-page-nav fl-nav navbar navbar-default" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".fl-page-nav-collapse">
<!-- 								<span><?php FLTheme::nav_toggle_text(); ?></span> -->
								<div id="menu-container" class="close-menu" style="top:20px;">
								<div id='warped'> 
									<span class='w0'>MENU</span>
								</div>
								<div id="guitar-container" class="guitar">
									<img src="http://ludlowgarage.wpengine.com/wp-content/themes/twentysixty-child/library/images/guitar-white-r.png" class="guitar-top">
									
									<img src="http://ludlowgarage.wpengine.com/wp-content/themes/twentysixty-child/library/images/guitar-white-l.png" class="guitar-middle">
									
									<img src="http://ludlowgarage.wpengine.com/wp-content/themes/twentysixty-child/library/images/guitar-white-r.png" class="guitar-bottom">
								</div>
								<div id="drumstick-container" class="stick rotateXaxis">
									<img src="http://ludlowgarage.wpengine.com/wp-content/themes/twentysixty-child/library/images/drumstick-white-l.png" class="drumstick-top">
									<img src="http://ludlowgarage.wpengine.com/wp-content/themes/twentysixty-child/library/images/drumstick-white-r.png" class="drumstick-bottom">
								</div>
							</div>
							</button>
							<div class="connect-with-us">
								<span>CONNECT WITH US</span>
								<span class="fl-icon">
									<a href="https://twitter.com/ludlowgarage" target="_blank"><i class="fa fa-twitter"></i></a>
								</span>
								<span class="fl-icon">
										<a href="https://www.facebook.com/pages/Live-at-the-ludlow-garage/247674622101020" target="_blank"><i class="fa fa-facebook-f"></i></a></span>
								<span class="fl-icon">
										<a href="https://www.instagram.com/ludlowgarage/" target="_blank"><i class="fa fa-instagram"></i></a></span>
								<span>(513) 221-4111</span>
							</div><div class="clearfix"></div>
							<div class="fl-page-nav-collapse collapse navbar-collapse">
								<?php							

								wp_nav_menu(array(
									'theme_location' => 'header',
									'items_wrap' => '<ul id="%1$s" class="nav navbar-nav navbar-right %2$s">%3$s</ul>',
									'container' => false,
									'fallback_cb' => 'FLTheme::nav_menu_fallback'
								));
								
								// FLTheme::nav_search();

								?>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</header><!-- .fl-page-header -->