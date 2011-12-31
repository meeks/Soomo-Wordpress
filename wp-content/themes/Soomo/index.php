<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 * @subpackage Soomo
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title('&lsaquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<?php
	/**
	*	Get favicon URL
	**/
	$mx_favicon = get_option('mx_favicon');
	
	
	if(!empty($mx_favicon))
	{
?>
		<link rel="shortcut icon" href="<?php echo $mx_favicon; ?>" />
<?php
	}
?>

<!-- Template stylesheet -->
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/jqueryui/custom.css" type="text/css" media="all"/>
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/screen.css" type="text/css" media="all"/>
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/tipsy.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/js/nivoslider/nivo-slider.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/js/nivoslider/style/custom-nivo-slider.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/js/fancybox/jquery.fancybox-1.3.0.css" media="screen"/>



<!--[if IE]>
	<link href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/ie.css" rel="stylesheet" type="text/css" media="all">
<![endif]-->

<!--[if IE 7]>
	<link href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/ie7.css" rel="stylesheet" type="text/css" media="all">
<![endif]-->

<!-- Jquery and plugins -->
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.img.preload.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/fancybox/jquery.fancybox-1.3.0.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/nivoslider/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.easing.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.css.transform.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.quicksand.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/browser.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/custom.js"></script>



</head>


<?php

/**
*	Get Current page object
**/
$page = get_page($post->ID);


/**
*	Get current page id
**/
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

/**
*	Check if portfolio page
**/
$mx_portfolio_page = get_option('mx_portfolio_page');

/**
*	if portfolio page
**/
if($current_page_id == $mx_portfolio_page)
{
	$mx_portfolio_style = get_option('mx_portfolio_style');
}

?>



<body <?php if(($mx_portfolio_style != 'slider' && $current_page_id == $mx_portfolio_page) OR $current_page_id != $mx_portfolio_page){ body_class(); } ?>>

	<!-- Begin template wrapper -->
	<div id="wrapper">
			
		<!-- Begin header -->
		<div id="header_wrapper">
			<div id="top_bar">
				<div class="wrapper">
					<div id="logo">
						<a href="<?php bloginfo('url'); ?>">
							<?php
								/**
								*	Check selected logo
								**/
								$mx_logo = get_option('mx_logo');

								if(empty($mx_logo))
								{
									$mx_logo = get_bloginfo( 'stylesheet_directory' ).'/images/logo.png';
								}
							?>
							<img src="<?php echo $mx_logo; ?>" alt=""/>
						</a>
					</div>
					
					<!-- Begin main nav -->
					<?php 	
						
								//Get page nav
								wp_nav_menu( 
										array( 
											'container'			=> 'ul',
											'menu_id'		=> 'main_menu',
											'menu_class'		=> 'nav',
											'theme_location' 	=> 'primary-menu',
										) 
								); 
					?>
					<!-- End main nav -->
					
					<br class="clear"/>


			<!-- Begin content slider --> 
					<div id="content_slider" class="content_slider">
					
						<?php
				
							/**
							*	Get content slider category
							**/
							$mx_slider_cat = get_option('mx_slider_cat');
							
							
							/**
							*	Get number of items
							**/
							$mx_slider_items = get_option('mx_slider_items');
							
							if(empty($mx_slider_items))
							{
								$mx_slider_items = 5;
							}
							
							$slider_posts = get_posts('numberposts='.$mx_slider_items.'&category='.$mx_slider_cat.'&orderby=date&order=ASC');
							
							//This loop to display each slide
							foreach($slider_posts as $key => $slider_post)
				    		{
				    		
				    			$slide_type = get_post_meta($slider_post->ID, 'home_slide_type', true);
				    			$slide_small_image = get_post_meta($slider_post->ID, 'home_slide_small_image_url', true);
				    			$slide_image = get_post_meta($slider_post->ID, 'home_slide_image_url', true);
				    			$slide_link = get_post_meta($slider_post->ID, 'home_slide_link_url', true);
								
								switch($slide_type)
								{
									case 'Youtube Video':
										$youtube_id = get_post_meta($slider_post->ID, 'home_slide_youtube_id', true);
						?>		
					
					
									<div id="slide<?php echo $key ?>" class="slide <?php if($key==0) { ?>active_slide<?php } else { ?> hide<?php } ?>">
										<div class="macbook">
											<a href="#youtube_video<?php echo $key ?>" class="portfolio_youtube">
												<img src="<?php echo $slide_small_image; ?>" alt=""/>
											</a>
										</div>
										
										<div class="content">
											<h1><?php echo $slider_post->post_title; ?></h1>
											<br/>
											<p><?php echo $slider_post->post_content; ?></p>
										</div>
										
										<!-- Begin youtube video content -->
										<div style="display:none;">
				   							<div id="youtube_video<?php echo $key ?>" style="width:640px;height:385px">
				        			
				        						<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/<?php echo $youtube_id; ?>" style="width:640px;height:385px">
        		    								<param name="movie" value="http://www.youtube.com/v/<?php echo $youtube_id; ?>" />
    			    							</object>
				        			
				    						</div>	
										</div>
										<!-- End youtube video content -->
									</div>
						
						
						<?php
									break;
									//End youtube video type
									
									case 'Vimeo Video':
										$vimeo_id = get_post_meta($slider_post->ID, 'home_slide_vimeo_id', true);
						?>
						
						
									<div id="slide<?php echo $key ?>" class="slide <?php if($key==0) { ?>active_slide<?php } else { ?> hide<?php } ?>">
										<div class="macbook">
											<a href="#vimeo_video<?php echo $key ?>" class="portfolio_vimeo">
												<img src="<?php echo $slide_small_image; ?>" alt=""/>
											</a>
										</div>
										
										<div class="content">
											<h1><?php echo $slider_post->post_title; ?></h1>
											<br/>
											<p><?php echo $slider_post->post_content; ?></p>
										</div>
										
										<!-- Begin vimeo video content -->
										<div style="display:none;">
										    <div id="vimeo_video<?php echo $key ?>" style="width:601px;height:338px">
										    
										        <object width="601" height="338" data="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $vimeo_id ?>&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1" type="application/x-shockwave-flash">
  										    		<param name="allowfullscreen" value="true" />
  										    		<param name="allowscriptaccess" value="always" />
  										    		<param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=<?php echo $vimeo_id ?>&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ffffff&amp;fullscreen=1" />
										    	</object>
										        
										    </div>	
										</div>
										<!-- End vimeo video content -->
									</div>
						
						
						<?php
									break;
									//End vimeo video type
									
									case 'Small Image':
										
						?>
						
						
									<div id="slide<?php echo $key ?>" class="slide <?php if($key==0) { ?>active_slide<?php } else { ?> hide<?php } ?>">
										<div class="macbook right">
<!--  class="portfolio_image" -->			<a href="<?php echo $slide_link; ?>">
												<img src="<?php echo $slide_small_image; ?>" alt=""/>
											</a>
										</div>
										
										<div class="content left">
											<h1><?php echo $slider_post->post_title; ?></h1>
											<br/>
											<p><?php echo $slider_post->post_content; ?></p>
										</div>
									</div>
						
						
						<?php
									break;
									//End small image with zoom feature
								
									case 'Image':
									
						?>
						
						
									<div id="slide<?php echo $key ?>" class="slide <?php if($key==0) { ?>active_slide<?php } else { ?> hide<?php } ?>">
										<div class="content_slider_frame">
											<a href="<?php echo $slide_link; ?>" title="<?php echo $slider_post->post_title; ?>">
												<img src="<?php echo $slide_image; ?>" alt="" class="image"/>
											</a>
										</div>
									</div>
						
						
						<?php			
									break;
									//End big image slide
									
									case 'Text':
						?>	
						
						
									<div id="slide<?php echo $key ?>" class="slide <?php if($key==0) { ?>active_slide<?php } else { ?> hide<?php } ?>">
										<div class="content_full">
											<h1><?php echo $slider_post->post_title; ?></h1>
											<br/>
											<p><?php echo do_shortcode($slider_post->post_content); ?></p>
										</div>
									</div>
						
						
						<?php
									break;
									//End custom HTML + text
							
								}
							}
						?>

						
					</div>
					<!-- End content slider -->
					
					<div id="slide_nav" class="slide_nav">
						<?php
							//This loop to display each slide
							foreach($slider_posts as $key => $slider_each)
				    		{
				    	?>
				    	
				    			<a href="#slide<?php echo $key; ?>" <?php if($key==0) { ?> class="active" <?php } ?>><?php echo $key; ?></a>
				    	
				    	<?php
				    		}
				    	?>
					</div>

					
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
					                    
                    
					<script>
					$(function(){ 
						var it = setInterval(function(){
     	
     						if($('#slide_nav a.active').next().length > 0)
     						{
     							
     							var nextSlide = $('#slide_nav a.active').next();
     							var slideTarget = $('#slide_nav a.active').next().attr('href');
							
								// Remove all active slide
								$('#content_slider').children('div').removeClass('active_slide');
								$('#content_slider').children('div').css('display', 'none');
							
								$('#content_slider').children('div'+slideTarget).addClass('active_slide');
								$('#content_slider').children('div'+slideTarget).fadeIn();
								
								$('#slide_nav a').removeClass('active');
								nextSlide.addClass('active');
     							
     						}
     						else
     						{
     						
     							var slideTarget = $('#slide_nav a:first-child').attr('href');
							
								// Remove all active slide
								$('#content_slider').children('div').removeClass('active_slide');
								$('#content_slider').children('div').css('display', 'none');
							
								$('#content_slider').children('div'+slideTarget).addClass('active_slide');
								$('#content_slider').children('div'+slideTarget).fadeIn();
								
								$('#slide_nav a').removeClass('active');
								$('#slide_nav a:first-child').addClass('active');
							
     						}
     					 
    					}, <?php echo $mx_slider_timer; ?>);
						$('#slide_nav a').click(function(){
							var slideTarget = $(this).attr('href');
							
							// Remove all active slide
							$('#content_slider').children('div').removeClass('active_slide');
							$('#content_slider').children('div').css('display', 'none');
							
							$('#content_slider').children('div'+slideTarget).addClass('active_slide');
							$('#content_slider').children('div'+slideTarget).fadeIn();
							
							$('#slide_nav a').removeClass('active');
							$(this).addClass('active');
							
							clearInterval(it);
							
							return false;
						});	
					});	
					</script>
					
				</div>
			</div>
		</div>
		<!-- End header -->

		<br class="clear"/>
		
		<!-- Begin content -->
        
		<div id="content_wrapper">
            	
               
   
                    
                    
				</div>
                
			<div class="inner">
            				
				<?php
					/**
					*	Get homepage box category
					**/
					$mx_box_cat = get_option('mx_box_cat');
					
					$box_posts = get_posts('numberposts=-1&category='.$mx_box_cat.'&orderby=date&order=ASC');
					$all_boxes = count($box_posts);
					
					if($all_boxes > 0)
					{
				?>
				
<!-- Begin three column content -->
<div class="three_column">


				
<div class="wrapper">
						
							<?php
								
								//This loop to display each slide
								foreach($box_posts as $key => $box_post)
					    		{
					    		
					    			$box_icon = get_post_meta($box_post->ID, 'home_box_icon_url', true);
					    	?>
							
<div class="each">
										

<?php echo $box_post->post_content; ?>


</div>
									
									<?php
										//add line break in every 3 items
										if(($key+1)%3 == 0)
										{
									?>
											<br class="clear"/>
									<?php
										}
									?>
							
							<?php
								}
							?>
							
							<?php
								//if below 3 items then add line break
								if($all_boxes%3 != 0)
								{
							?>
									<br class="clear"/>
							<?php
								}
							?>
							
						</div>


						
					</div>
<!-- End three column content -->
					
					<br class="clear"/>
				
				<?php
					}
				?>
				
			</div>
		</div>
		<!-- End content -->
        <br class="clear"/>
		

<?php get_footer(); ?>