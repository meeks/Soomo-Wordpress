		</div> <!-- end .container -->
	</div> <!-- end #content -->

	<div id="footer">
		<div class="container">
			<div id="footer-widgets" class="clearfix">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
				<?php endif; ?>
			</div> <!-- end #footer-widgets -->

			<div id="footer-bottom" class="clearfix">
				<?php
					$menuID = 'bottom-nav';
					$footerNav = '';

					if (function_exists('wp_nav_menu')) $footerNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_id' => $menuID, 'menu_class' => 'bottom-nav', 'echo' => false, 'depth' => '1' ) );
					if ($footerNav == '') show_page_menu($menuID);
					else echo($footerNav);
				?>
				
			</div> <!-- end #footer-bottom -->
		</div> <!-- end .container -->
	</div> <!-- end #footer -->

	<?php include(TEMPLATEPATH . '/includes/scripts.php'); ?>
	<?php wp_footer(); ?>

</body>
</html>