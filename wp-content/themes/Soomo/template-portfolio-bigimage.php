<?php
/**
 * The main template file for display portfolio page.
 *
 * @package WordPress
 * @subpackage Soomo
*/


get_header(); 

?>
					
					<div class="caption">
						<h1><?php the_title(); ?></h1>
					</div>
					
				</div>
			</div>
		</div>
		<!-- End header -->
		
		<br class="clear"/>
				
		<!-- Begin content -->
		<div id="content_wrapper_caption">
			<div class="inner">
				
				<!-- Begin one column content -->
				<div class="one_column">
				
					<div class="main">
						
						
						<?php
							/**
							*	Get portfolio slider categories
							**/
							$mx_portfolio_cat = get_option('mx_portfolio_cat');
							$portfolio_items = array();
							$portfolio_items = get_posts('numberposts=-1&order=DESC&orderby=date&category='.$mx_portfolio_cat);
						
		
							if(isset($portfolio_items) && !empty($portfolio_items))
							{
								
						?>
						
								<!-- Begin portfolio list -->
								<div class="portfolio_one_column">
										
											<?php

												foreach($portfolio_items as $key => $portfolio_item)
												{
													
													$portfolio_type = get_post_meta($portfolio_item->ID, 'portfolio_type', true);
													$small_image_url = get_post_meta($portfolio_item->ID, 'portfolio_small_image_url', true);
													$medium_image_url = get_post_meta($portfolio_item->ID, 'portfolio_medium_image_url', true);
													$full_size_image_url = get_post_meta($portfolio_item->ID, 'portfolio_full_size_image_url', true);
													$link_url = get_post_meta($portfolio_item->ID, 'portfolio_link_url', true);
													$youtube_id = get_post_meta($portfolio_item->ID, 'portfolio_youtube_id', true);
													$vimeo_id = get_post_meta($portfolio_item->ID, 'portfolio_vimeo_id', true);
													
													$item_cat = get_the_category($portfolio_item->ID);
													$item_cat_id = $item_cat[0]->cat_ID;
													
													switch($portfolio_type)
													{
														case 'Image':
											?>
											
														<div class="portfolio_one_column">
														    <div class="detail">
																<h5><?=$portfolio_item->post_title?></h5>
																<p>
																	<?=$portfolio_item->post_content?>
																</p>
															</div>
															<div class="image">
																<a href="<?=$full_size_image_url?>" class="portfolio_image">
																	<img src="<?=$medium_image_url?>" alt=""/>
																</a>
																<div class="hover_content">
																	<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_zoom.png" alt=""/>
																</div>
															</div>
														</div>
															
											<?php
														break;
														//End image portfolio
														
														case 'Youtube Video':
											?>
												    
														    <div class="portfolio_one_column">
																<div class="detail">
																	<h5><?=$portfolio_item->post_title?></h5>
																	<p>
																		<?=$portfolio_item->post_content?>
																	</p>
																</div>
																<div class="image">
																	<a href="#youtube_video<?=$key?>" class="portfolio_youtube">
																		<img src="<?=$medium_image_url?>" alt=""/>
																	</a>
																	<div class="hover_content">
																		<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_play.png" alt=""/>
																	</div>
																</div>
																
																<!-- Begin youtube video content -->
																<div style="display:none;">
																    <div id="youtube_video<?=$key?>" style="width:640px;height:385px">
																        
																        <object type="application/x-shockwave-flash" data="http://www.youtube.com/v/<?=$youtube_id?>" style="width:640px;height:385px">
									        					    		<param name="movie" value="http://www.youtube.com/v/<?=$youtube_id?>" />
									    						    	</object>
																        
																    </div>	
																</div>
																<!-- End youtube video content -->
															</div>
												    
											<?php
														break;
														//End youtube video portfolio
														
														case 'Vimeo Video':
											?>
												    
													    	<div class="portfolio_one_column">
																<div class="detail">
																	<h5><?=$portfolio_item->post_title?></h5>
																	<p>
																		<?=$portfolio_item->post_content?>
																	</p>
																</div>
																<div class="image">
																	<a href="#vimeo_video<?=$key?>" class="portfolio_vimeo">
																		<img src="<?=$medium_image_url?>" alt=""/>
																	</a>
																	<div class="hover_content">
																		<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_play.png" alt=""/>
																	</div>
																</div>
																
																<!-- Begin vimeo video content -->
																<div style="display:none;">
																    <div id="vimeo_video<?=$key?>" style="width:601px;height:338px">
																    
																        <object width="601" height="338" data="http://vimeo.com/moogaloop.swf?clip_id=<?=$vimeo_id?>&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1" type="application/x-shockwave-flash">
									  							    		<param name="allowfullscreen" value="true" />
									  							    		<param name="allowscriptaccess" value="always" />
									  							    		<param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?=$vimeo_id?>&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1" />
																    	</object>
																        
																    </div>	
																</div>
																<!-- End vimeo video content -->
															</div>
										    
										    <?php
										    			break;
										    			//End vimeo video portfolio
										    			
														case 'Link':
										   	?>
										   	
											   				<div class="portfolio_one_column">
												   				<div class="detail">
																	<h5><?=$portfolio_item->post_title?></h5>
																	<p>
																		<?=$portfolio_item->post_content?>
																	</p>
																</div>
																<div class="image">
																	<a href="<?=$link_url?>">
																		<img src="<?=$medium_image_url?>" alt=""/>
																	</a>
																</div>
															</div>
														
										   	
										    <?php 	
										    			break;
										    			//End link portfolio
										    			
													}
												
												}
												//End foreach loop
												
										    ?>
										    
								</div>		
								<!-- End portfolio list -->
								
							<?php
							}
							//End if have portfolio items
							?>
						
						    
						<!-- End portfolio content -->
						
					</div>
					
				</div>
				<!-- End one column content -->

				<br class="clear"/>
				
			</div>
		</div>
		<!-- End content -->
		
		<br class="clear"/><br/><br/>
				

<?php get_footer(); ?>