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
						
						<!-- Begin portfolio content -->
						
						<?php

							/**
							*	Get portfolio categories
							**/
							$mx_portfolio_cat = get_option('mx_portfolio_cat');
							$categories =  get_categories('hide_empty=0&child_of='.$mx_portfolio_cat);
							$categories_name = array();
							
						?>
						
						<ul class="portfolio_tab">
							<li class="all active">
							    All
							</li>
							<?php
								foreach($categories as $cat)
								{
									$categories_name[$cat->cat_ID] = $cat->slug;
									
									if($mx_portfolio_cat == $cat->parent)
									{
							?>		
							
										<li class="<?php echo $cat->slug; ?>">
							    			<?php echo $cat->name; ?>
										</li>
							
							<?php
									}
								}
							?>
						</ul>
						
						<br class="clear"/>
						
						
						<?php
							
							$portfolio_items = array();
							$portfolio_items = get_posts('numberposts=-1&order=DESC&orderby=date&category='.$mx_portfolio_cat);
						
		
							if(isset($portfolio_items) && !empty($portfolio_items))
							{
								
						?>
						
								<!-- Begin portfolio list -->
								<div class="portfolio_container">
										<ul class="portfolio_photos">
										
											<?php

												foreach($portfolio_items as $key => $portfolio_item)
												{
													
													$portfolio_type = get_post_meta($portfolio_item->ID, 'portfolio_type', true);
													$small_image_url = get_post_meta($portfolio_item->ID, 'portfolio_small_image_url', true);
													$medium_image_url = get_post_meta($portfolio_item->ID, 'portfolio_medium_image_url', true);
													$full_size_image_url = get_post_meta($portfolio_item->ID, 'portfolio_full_size_image_url', true);
													$link_url = get_post_meta($portfolio_item->ID, 'portfolio_link_url', true);
													
													$item_cat = get_the_category($portfolio_item->ID);
													
													$item_cat_id= '';
													foreach($item_cat as $cat)
													{
														if($cat->parent == $mx_portfolio_cat)
														{
															$item_cat_id = $cat->cat_ID;
															break;
														}
													}
													
													switch($portfolio_type)
													{
														case 'Image':
											?>
										
														    <li data-id="<?=$key?>" data-type="<?php echo $categories_name[$item_cat_id]; ?>">
														    	
														    	<div class="wrapper">
														    		<a href="<?=$full_size_image_url?>" class="portfolio_image">
														    			<img src="<?=$small_image_url?>" alt=""/>
														    		</a>
														    	
														    		<div class="hover_content">
																		<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_zoom.png" alt=""/>
																	</div>
																</div>
																
																
														    	<br class="clear"/>
														    	<span><?=$portfolio_item->post_title?></span>
														    	<p>
														    		<?=$portfolio_item->post_content?>
														    	</p>
														    </li>
											<?php
														break;
														//End image portfolio
														
														case 'Youtube Video':
											?>
												    
														    <li data-id="<?=$key?>" data-type="<?php echo $categories_name[$item_cat_id]; ?>">
														    	
														    	<div class="wrapper">
														    		<a href="#youtube_video<?=$key?>" class="portfolio_youtube">
														    			<img src="<?=$small_image_url?>" alt=""/>
														    		</a>
														    	
														    		<div class="hover_content">
																		<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_play.png" alt=""/>
																	</div>
																	
																</div>
																
																
														    	<br class="clear"/>
														    	<span><?=$portfolio_item->post_title?></span>
														    	<p>
														    		<?=$portfolio_item->post_content?>
														    	</p>
														    </li>
												    
											<?php
														break;
														//End youtube video portfolio
														
														case 'Vimeo Video':
											?>
												    
												    		<li data-id="<?=$key?>" data-type="<?php echo $categories_name[$item_cat_id]; ?>">
														    	
														    	<div class="wrapper">
														    		<a href="#vimeo_video<?=$key?>" class="portfolio_vimeo">
														    			<img src="<?=$small_image_url?>" alt=""/>
														    		</a>
														    	
														    		<div class="hover_content">
																		<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_play.png" alt=""/>
																	</div>
																	
																</div>
																
																
														    	<br class="clear"/>
														    	<span><?=$portfolio_item->post_title?></span>
														    	<p>
														    		<?=$portfolio_item->post_content?>
														    	</p>
														    </li>
										    
										    <?php
										    			break;
										    			//End vimeo video portfolio
										    			
														case 'Link':
										   	?>
										   	
										   				<li data-id="<?=$key?>" data-type="<?php echo $categories_name[$item_cat_id]; ?>">
														    	
														    <div class="wrapper">
														    	<a href="<?=$link_url?>">
														    		<img src="<?=$small_image_url?>" alt=""/>
														    	</a>
															</div>
																
																
														    <br class="clear"/>
														    <span><?=$portfolio_item->post_title?></span>
														    <p>
														    	<?=$portfolio_item->post_content?>
														    </p>
														</li>
										   	
										    <?php 	
										    			break;
										    			//End link portfolio
										    			
													}
												
												}
												//End foreach loop
												
										    ?>
										    
										</ul>
								</div>		
								<!-- End photos list -->
								
							<?php
							}
							//End if have portfolio items
							?>
						
						    
						<!-- End portfolio content -->
						
					</div>
					
				</div>
				<!-- End one column content -->
				
				
				<?php
					foreach($portfolio_items as $key => $portfolio_item)
					{
													
						$portfolio_type = get_post_meta($portfolio_item->ID, 'portfolio_type', true);
						$youtube_id = get_post_meta($portfolio_item->ID, 'portfolio_youtube_id', true);
						$vimeo_id = get_post_meta($portfolio_item->ID, 'portfolio_vimeo_id', true);
						
						if($portfolio_type == 'Youtube Video')
						{
				?>
				
							<!-- Begin youtube video content -->
							<div style="display:none;">
							    <div id="youtube_video<?=$key?>" style="width:640px;height:385px">
							        
							        <object type="application/x-shockwave-flash" data="http://www.youtube.com/v/<?=$youtube_id?>" style="width:640px;height:385px">
			        		    		<param name="movie" value="http://www.youtube.com/v/<?=$youtube_id?>" />
			    			    	</object>
							        
							    </div>	
							</div>
							<!-- End youtube video content -->
				
				<?php
				
						}
						elseif($portfolio_type == 'Vimeo Video')
						{
				?>
				
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
				
				
				<?php 
				
						}
					}	
				
				?>

				<br class="clear"/>
				
			</div>
		</div>
		<!-- End content -->
		
		<br class="clear"/><br/><br/>
				

<?php get_footer(); ?>