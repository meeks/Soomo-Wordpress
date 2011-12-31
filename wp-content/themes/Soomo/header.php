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
