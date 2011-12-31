<?php get_header(); ?>	

<div id="container">
	
<div id="left-div">
		
<div id="left-inside">
<?php if (get_option('artsee_format') == 'Blog Style') { ?>
<?php include(TEMPLATEPATH . '/includes/blogstyle.php'); ?>
<?php } else { include(TEMPLATEPATH . '/includes/defaultindex.php'); } ?>
</div>
		
</div>

<?php get_sidebar(); ?>    
<?php get_footer(); ?>   

</body>
</html>