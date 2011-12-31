<?php get_header(); ?>	
<?php 
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
      ?>
<div id="container">
	
<div id="left-div">
		
<div id="left-inside">

<?php if (get_option('artsee_format') == 'Blog Style') { ?>
<?php include(TEMPLATEPATH . '/includes/blogstyle.php'); ?>
<?php } else { include(TEMPLATEPATH . '/includes/default.php'); } ?>

</div>
		
</div>

<?php get_sidebar(); ?>    
<?php get_footer(); ?>   
	
</body>
</html>