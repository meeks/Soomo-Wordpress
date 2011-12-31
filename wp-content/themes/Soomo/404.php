<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Soomo
*/


get_header(); 

?>

					
				</div>
			</div>
		</div>
		<!-- End header -->
		
		<br class="clear"/>

		<!-- Begin content -->
		<div id="content_wrapper_caption">
			<div class="inner">
				
				<!-- Begin two column content -->
				<div class="one_column">
				
					<div class="two_column_left">
						
						<h1><?php _e( 'Not Found', 'slideo' ); ?></h1>
						<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'slideo' ); ?></p>
						
					</div>
					
				</div>
				<!-- End two column content -->
				
			</div>
		</div>
		<!-- End content -->
		
		<br class="clear"/><br/><br/>
				

<?php get_footer(); ?>