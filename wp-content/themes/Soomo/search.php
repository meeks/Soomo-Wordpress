<?php
/**
 * The main template file for display search page.
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
						
						<!-- posts starts here -->
<?php

if (have_posts()) : while (have_posts()) : the_post();

?>
						
						
						<!-- Begin each blog post -->
						<div class="post_wrapper">
							<div class="post_header">
								<div class="left">
									<h3>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<?php the_title(); ?>
										</a>
									</h3>
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/user_suit.png" class="mid_align" alt=""/>
									<?php the_author(); ?>&nbsp;&nbsp;&nbsp;
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/tag_blue.png" class="mid_align" alt=""/>
									<?php the_tags(''); ?>&nbsp;&nbsp;&nbsp;
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/calendar.png" class="mid_align" alt=""/>
									<?php the_time('F j, Y'); ?> <?php edit_post_link('edit post', ', ', ''); ?>
								</div>
								<div class="comment">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/comments.png" class="mid_align" alt=""/>
									<?php comments_number('No comment', 'Comment', '% Comments'); ?>
								</div>
							</div>
							<br class="clear"/><br/>
							
							<?php
								//Get Blog post image header
								$image_header = get_post_meta(get_the_ID(), 'blog_header_image_url', true);
									
								if(!empty($image_header))
								{
							?>
							
									<div class="frame">
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<img src="<?php echo $image_header; ?>" alt=""/>
										</a>
									</div>
									<br/>
							
							<?php
								}
							?>
							
							<?php the_content("Continue Reading&hellip;"); ?>
							
						</div>
						<!-- End each blog post -->
						
						<br class="clear"/><br/><div class="line"></div><br/><br/>


<?php endwhile; else : ?>

<?php include (TEMPLATEPATH . "/page-nothingfound.php"); ?>

<?php endif; ?>

						<div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
						
					</div>
					
					<div class="two_column_right"><div class="content"><?php get_sidebar('blog'); ?></div></div>
					
				</div>
				<!-- End two column content -->
				
			</div>
		</div>
		<!-- End content -->
		
		<br class="clear"/><br/><br/>
				

<?php get_footer(); ?>
