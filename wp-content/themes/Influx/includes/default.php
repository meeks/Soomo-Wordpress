<?php if (get_option('artsee_featured2') == 'Hide') { ?>
<?php { echo ''; } ?>
<?php } else { include(TEMPLATEPATH . '/includes/rightcolumn.php'); } ?>

<!--Begind recent post (single)-->
<?php if (have_posts()) : while (have_posts()) : the_post(); 
  if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

<!--The Following code checks for yout thumbnail image-->
<?php 
// check for thumbnail
$thumb = get_post_meta($post->ID, 'Thumbnail', $single = true);
// check for thumbnail class
$thumb_class = get_post_meta($post->ID, 'Thumbnail Class', $single = true);
// check for thumbnail alt text
$thumb_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
?>
<div class="home-post-wrap">	

<!--Display thumbnail if found-->
<div class="thumbnail-div">
<?php // if there's a thumbnail
if($thumb !== '') { ?>
<a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php echo $thumb; ?>&amp;h=130&amp;w=281&amp;zc=1&amp;q=100" alt="<?php if($thumb_alt !== '') { echo $thumb_alt; } else { echo the_title(); } ?>"  style="border: none;" /></a>
<?php } // end if statement
// if there's not a thumbnail
else { echo ''; } ?>
<!--End display thumbnail if found-->
</div>	
<h2 class="titles"><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title(); ?>"><?php the_title2('', '...', true, '26') ?></a></h2>
<?php if (function_exists('the_content_limit')) { the_content_limit(400, ""); } else { echo 'You have not uploaded and acivated the limit posts plugin. This is required.'; } ?>
<div class="readmore"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">Read More</a></div>
</div>

<?php endwhile; ?>

<div style="clear: both; margin-bottom: 10px;">
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } 
else { ?>
<p class="pagination"><?php next_posts_link('&laquo; Previous Entries') ?> <?php previous_posts_link('Next Entries &raquo;') ?></p>
<?php } ?>
</div>

<!--end recent post (single)-->

<?php else : ?>

<!--If no results are found-->
<div class="home-post-wrap2">
<h2 >No Results Found</h2>
<p>Sorry, your search returned zero results. </p>
</div>
<!--End if no results are found-->

<?php endif; ?>