<?php
/**
 * The main template file for display portfolio page.
 *
 * @package WordPress
 * @subpackage Soomo
*/


get_header(); 


?>
					
					<?php
						/**
						*	Get portfolio slider categories
						**/
						$mx_portfolio_slider_cat = get_option('mx_portfolio_slider_cat');
						$portfolio_slider_items = array();
						$portfolio_slider_items = get_posts('numberposts=-1&order=ASC&orderby=date&category='.$mx_portfolio_slider_cat);
						
		
						if(isset($portfolio_slider_items) && !empty($portfolio_slider_items))
						{
								
					?>
					
							<!-- Begin content slider -->
							<div class="content_slider_frame">
								<div id="img_slider">
								
									<?php
									
										foreach($portfolio_slider_items as $portfolio_slider_item)
										{
											$slider_image_url = get_post_meta($portfolio_slider_item->ID, 'portfolio_slider_image_url', true);
									?>
									
											<img src="<?=$slider_image_url?>" alt="" title="<?=$portfolio_slider_item->post_title?>"/>
											
									<?php

										}
										
									?>	
										
								</div>
							</div>
							<!-- End content slider -->
					
					<?php
						}
					?>
					
					<?php
						/**
						*	Get slide timer
						**/
						$mx_slider_timer = get_option('mx_slider_timer');
						
						if(empty($mx_slider_timer))
						{
						    $mx_slider_timer = 5;
						}
						
						$mx_slider_timer = $mx_slider_timer * 1000;
					?>
					<script>$('#img_slider').nivoSlider({ directionNav:true, pauseTime: <?=$mx_slider_timer?>, captionOpacity: 0.5 });</script>
					
				</div>
			</div>
		</div>
		<!-- End header -->
		
		<br class="clear"/>
				
		<!-- Begin content -->
		<div id="content_wrapper_portfolio">
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
						
<!-- Begin Tag Filter -->
                        
						<ul class="portfolio_tab">
                        
                        <h1></h1>
                        <hr

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
                        
<!-- End Tag Filter -->
						
						
						
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
														    	
                                                                <h2>
																<?=$portfolio_item->post_title?>
                                                                </h2>
														    	
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

<!-- Start Title Boxes -->										   	
	
    									   				<li data-id="<?=$key?>" data-type="<?php echo $categories_name[$item_cat_id]; ?>">
														    	
														    <div class="wrapper">
														    	<a href="<?=$link_url?>">
														    		<img src="<?=$small_image_url?>" alt=""/>
														    	</a>
															</div>
																
																
														    <br class="clear"/>
														    <h3><?=$portfolio_item->post_title?></h3>
														    <p>
														    	<?=$portfolio_item->post_content?>
														    </p>
                                                            <hr/>
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

<!--  Title Boxes -->										   	
									
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