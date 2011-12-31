<?php get_header(); ?>

<div id="content-area" class="clearfix">
	<div id="left-area">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php include(TEMPLATEPATH . '/includes/entry.php'); ?>
		<?php endwhile; ?>
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
			else { ?>
				 <?php include(TEMPLATEPATH . '/includes/navigation.php'); ?>
			<?php } ?>
		<?php else : ?>
			<?php include(TEMPLATEPATH . '/includes/no-results.php'); ?>
		<?php endif; ?>
	</div> 	<!-- end #left-area -->

	<?php get_sidebar(); ?>	
</div> <!-- end #content-area -->

<?php get_footer(); ?>