<?php
/**
 * The main template file for display blog page.
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

<!-- Begin content -->
<div id="content_wrapper_caption">
<div class="inner">
<div class="one_column">

<!-- Begin Main Content -->

				
<div class="two_column_left">
						

<!-- posts starts here -->

<?php

global $more; $more = false; # some wordpress wtf logic
//Get blog post category id
$mx_blog_cat = get_option('mx_blog_cat'); 

$query_string ="cat=$mx_blog_cat&paged=$paged";

query_posts($query_string);

if (have_posts()) : while (have_posts()) : the_post();

?>

<!-- Begin each blog post -->
<div class="post_wrapper">

	<div class="post_header">

		<div class="two_column_left">

			<h1>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </h1>
			<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/user_suit.png" class="mid_align" alt=""/>
			<?php the_author(); ?>&nbsp;&nbsp;&nbsp;
			<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/tag_blue.png" class="mid_align" alt=""/>
			<?php the_tags(''); ?>&nbsp;&nbsp;&nbsp;
			<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/calendar.png" class="mid_align" alt=""/>
			<?php the_time('F j, Y'); ?> <?php edit_post_link('edit post', ', ', ''); ?>

		</div>


        
	</div>

<br class="clear"/>

<?php
//Get Blog post image header
$image_header = get_post_meta(get_the_ID(), 'blog_header_image_url', true);
if(!empty($image_header))
{
?>

<div class="frame">

<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
<img src="<?php echo $image_header; ?>" alt=""/></a>
</div>

<br/>

<?php } ?>
<?php the_content("Continue Reading&hellip;"); ?>

</div>

<!-- End each blog post -->
						
<br class="clear"/>


<?php endwhile; endif; ?>

<div class="pagination">

<p><?php posts_nav_link(' '); ?></p>

</div>
						
</div>

</div>

<div class="two_column_right">

<?php get_sidebar('blog'); ?>

</div>
				
</div>
<!-- End Main Content -->
				
</div>
<!-- End content -->
		
		<br class="clear"/><br/><br/>
				

<?php get_footer(); ?>