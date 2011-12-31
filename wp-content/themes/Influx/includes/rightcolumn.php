<div class="home-post-wrap" id="unique">

<!--Begin Feaured Articles-->
<span class="headings">featured articles</span>
<div style="clear: both;"></div>
<?php $my_query = new WP_Query("category_name=Featured Articles&showposts=$artsee_featured;");
while ($my_query->have_posts()) : $my_query->the_post(); ?>
<?php 
// check for thumbnail
$thumb = get_post_meta($post->ID, 'Thumbnail', $single = true);
// check for thumbnail class
$thumb_class = get_post_meta($post->ID, 'Thumbnail Class', $single = true);
// check for thumbnail alt text
$thumb_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
?>
<div class="random">
<div class="random-image">
<!--Display thumbnail if found-->
<?php // if there's a thumbnail
if($thumb !== '') { ?>
<a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php echo $thumb; ?>&amp;h=80&amp;w=80&amp;zc=1&amp;q=100" alt="<?php if($thumb_alt !== '') { echo $thumb_alt; } else { echo the_title(); } ?>"  style="border: none;" /></a>
<?php } // end if statement
// if there's not a thumbnail
else { echo ''; } ?>
<!--End display thumbnail if found-->
</div>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title2('', '...', true, '23') ?></a>
<?php if (function_exists('the_content_limit')) { the_content_limit(80, ""); } else { echo 'You have not uploaded and acivated the limit posts plugin. This is required.'; } ?>
</div>
<?php endwhile; ?>
<!--End Feaured Article-->

<!--Begin Most Commented Articles-->
<span class="headings">popular articles</span>
<div style="clear: both;"></div>
<ul>
<?php
	$sql='SELECT post_title, comment_count, guid
		FROM wp_posts
		ORDER BY comment_count DESC
		LIMIT 8;';
	$results = $wpdb->get_results($sql);

	foreach ($results as $r) {
		echo '<li><a href="' . $r->guid . '" title="' . $r->post_title . '"> ' . $r->post_title .
			' (' . $r->comment_count . ')</a></li>';
	}
?>
</ul>
<!--End Most Commented Articles-->

<!--Begin Random Articles-->
<span class="headings">random articles</span>
<div style="clear: both;"></div>
<ul>
<?php $my_query = new WP_Query("orderby=rand&showposts=$artsee_random;");
while ($my_query->have_posts()) : $my_query->the_post();
?>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title2('', '...', true, '40') ?></a></li>
<?php endwhile; ?>
</ul>
<!--End Random Articles-->


</div>