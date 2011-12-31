<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
 * @subpackage Soomo
*/


get_header(); 

/**
*	Get blog page ID
**/
$mx_blog_page = get_option('mx_blog_page');


//Make blog menu active
if(!empty($mx_blog_page))
{
?>

<script>
$('ul#main_menu li.page-item-<?php echo $mx_blog_page; ?>').addClass('current_page_item');
</script>

<?php
}
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
									<h1>
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
											<?php the_title(); ?>
										</a>
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
											<img src="<?php echo $image_header; ?>" alt=""/>
										</a>
									</div>
									<br/>
							
							<?php
								}
							?>
							
							<br/><?php the_content(); ?>
							
						</div>
						<!-- End each blog post -->
						
						
						<br class="clear"/><br/><br/>
						
						<h5>About the author</h5><br/>
						<div id="about_the_author">
							<div class="thumb"><?php echo get_avatar( get_the_author_email(), '50' ); ?></div>
							<div class="description">
								<strong><?php the_author_link(); ?></strong><br/>
								<?php the_author_description(); ?>
							</div>
						</div>
						
						<br class="clear"/><br/><br/>
						
						<h5>Share this</h5>
						<ul class="social_media blog" style="margin-top:15px">
							<li>
								<a href="http://twitter.com/home?status=<?=the_title()?> <?=the_permalink()?>" title="Retweet">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/twitter_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://delicious.com/post?url=<?=the_permalink()?>&title=<?=the_title()?>" title="Delicious">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/delicious_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://digg.com/submit?url=<?=the_permalink()?>&title=<?=the_title()?>" title="Digg it">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/digg_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://www.facebook.com/share.php?u=<?=the_permalink()?>&t=<?=the_title()?>" title="Share to Facebook">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/facebook_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://posterous.com/share?linkto=<?=the_permalink()?>&title=<?=the_title()?>" title="Posterous">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/posterous_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://www.mixx.com/submit?page_url=<?=the_permalink()?>&title=<?=the_title()?>" title="Mixx">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/mixx_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://www.stumbleupon.com/submit?url=<?=the_permalink()?>&title=<?=the_title()?>" title="Stumbleupon">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/stumbleupon_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="mailto:?body=&subject=<?=the_title()?>" title="Email this">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/email_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://www.tumblr.com/share?u=<?=the_permalink()?>&t=<?=the_title()?>" title="Tumblr">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/tumblr_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://reporter.nl.msn.com/?fn=contribute&URL=<?=the_permalink()?>&Title=<?=the_title()?>" title="MSN">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/windows_32.png" alt=""/>
								</a>
							</li>
							<li>
								<a href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?=the_permalink()?>&title=<?=the_title()?>&annotation=" title="Google Bookmark">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/google_32.png" alt=""/>
								</a>
							</li>
						</ul>
						
						<br class="clear"/><br/><br/><br/>


						<?php comments_template( '' ); ?>
						

<?php endwhile; endif; ?>

						<div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
						
					</div>
					
					<div class="two_column_right">
                    <div class="content"><?php get_sidebar('single'); ?></div>
                    </div>
					
				</div>
<!-- End two column content -->
				
			</div>
		</div>
<!-- End content -->
		
		<br class="clear"/><br/><br/>

				

<?php get_footer(); ?>