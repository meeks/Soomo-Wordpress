<div class="post entry clearfix">
	<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php include(TEMPLATEPATH . '/includes/postinfo.php'); ?>
	<?php
		$thumb = '';
		$width = 178;
		$height = 178;
		$classtext = 'post-thumb';
		$titletext = get_the_title();
		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
		$thumb = $thumbnail["thumb"];
	?>
	<?php if($thumb <> '' && get_option('feather_thumbnails_index') == 'on') { ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				<span class="post-overlay"></span>
			</a>
		</div> 	<!-- end .post-thumbnail -->
	<?php } ?>
	<?php if (get_option('feather_blog_style') == 'on') the_content(''); else { ?>
		<p><?php truncate_post(500); ?></p>
	<?php }; ?>
	<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More','Feather'); ?></a>
</div> 	<!-- end .post-->