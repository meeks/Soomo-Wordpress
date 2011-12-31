<span class="current-category">
<?php single_cat_title('Currently Browsing: ', 'display'); ?>
</span>

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

<?php 
// check for thumbnail
$thumb = get_post_meta($post->ID, 'Thumbnail', $single = true);
// check for thumbnail class
$thumb_class = get_post_meta($post->ID, 'Thumbnail Class', $single = true);
// check for thumbnail alt text
$thumb_alt = get_post_meta($post->ID, 'Thumbnail Alt', $single = true);
?>

<!--Begin Post-->
<div class="post-wrapper" style="margin-bottom: 15px !important;">

<!--Begin Share Button-->
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/share.gif" alt="delete" class="share" style="float: right; margin-right: 10px; margin-bottom: 5px; cursor: pointer; clear: left; visibility: <?php echo $artsee_share; ?>;" />
<div class="share-div" style="clear: both;">
<a href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-1.gif" alt="bookmark" style="float: left; margin-left: 15px; margin-right: 8px; border: none;" /></a>
<a href="http://www.digg.com/submit?phase=2&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-2.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://www.reddit.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-3.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-4.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://www.squidoo.com/lensmaster/bookmark?<?php the_permalink() ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-5.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t=<?php the_title(); ?>&amp;u=<?php the_permalink() ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-6.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-7.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=<?php the_permalink() ?>&amp;Title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-8.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://www.technorati.com/faves?add=<?php the_permalink() ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-9.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://www.furl.net/storeIt.jsp?t=<?php the_title(); ?>&amp;u=<?php the_permalink() ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-10.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://cgi.fark.com/cgi/fark/edit.pl?new_url=<?php the_permalink() ?>&amp;new_comment=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-11.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
<a href="http://www.sphinn.com/submit.php?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/bookmark-12.gif" alt="bookmark" style="float: left; margin-right: 8px; border: none;" /></a>
</div>
<div style="clear: both;"></div>
<!--End Share Button-->

<?php if (get_option('artsee_thumbnails') == 'Hide') { ?>
<?php { echo ''; } ?>
<?php } else { include(TEMPLATEPATH . '/includes/thumbnail.php'); } ?>
<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>

<?php $custom_fields = get_post_custom(get_the_ID()); ?>

<h2 class="post-author" style="color:black; font-size:14px">By <strong><?php the_author() ?></strong><?php if ( count($custom_fields['affiliation'];) > 0 ) { echo ', ';
    foreach ( $custom_fields['affiliation'] as $key => $value ) echo $value; }?>
</h2>

<div class="post-info">Filed Under  <?php the_category(', ') ?> on  <?php the_time('m jS, Y') ?> |  <a href="#respond" title="<?php _e("Leave a comment"); ?>"><?php comments_number('Click to Add a Comment','1 Comment','% Comments'); ?></a>  </div>
			
<div style="clear: both;"></div>
<div class="single-entry">

<?php the_content('Read the rest of this entry &raquo;'); ?>

</div>

<?php if (get_option('artsee_foursixeight') == 'Enable') { ?>
<?php include(TEMPLATEPATH . '/includes/468x60.php'); ?>
<?php } else { echo ''; } ?>

<div style="clear: both;"></div>

</div>

<?php endwhile; ?>

<p class="pagination"><?php next_posts_link('&laquo; Previous Entries') ?> <?php previous_posts_link('Next Entries &raquo;') ?></p>

<?php else : ?>

<h2 align="center">Not Found</h2>

<p align="center">Sorry, but the page you requested could not be found.</p>

<?php endif; ?>			