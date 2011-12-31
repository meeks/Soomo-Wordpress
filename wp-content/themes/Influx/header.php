<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php if (is_home()) : ?><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>
<?php else : ?>
<?php wp_title('', 'false'); ?> - <?php bloginfo('name'); ?>
<?php endif; ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
<?php wp_get_archives('type=monthly&format=link'); ?>

<?php 
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/<?php echo $artsee_theme; ?>style.css" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://feeds2.feedburner.com/Polisilo" />


<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if IE 7]>	
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/iestyle.css" />
<![endif]-->	
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/ie6style.css" />
<![endif]-->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/idtabs.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/slider.js"></script>
</head>

<body>

<?php 
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
      ?>
<div id="pages">
<ul>
<li class="page_item"><a href="<?php bloginfo('url'); ?>" class="title" title="home again woohoo">Home</a></li>
<?php wp_list_pages("sort_order=$artsee_order_page&depth=1&exclude=$artsee_exclude_page&title_li="); ?>
</ul>
</div>

<div id="wrapper2">

<!--This controls pages navigation bar-->
<div id="header">
<a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/PolisiloHeader.png" alt="logo" class="logo" /></a> <!--This is your company's logo-->
</div>

<div class="main-page-nav">
  <ul>
    <li><a href="http://polisilo.com">Home</a></li>
    <?php wp_list_pages('title_li='); ?>
  </ul>
</div>

<!--End category navigation-->

