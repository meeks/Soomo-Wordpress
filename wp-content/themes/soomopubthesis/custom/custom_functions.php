<?php

// Using hooks is absolutely the smartest, most bulletproof way to implement things like plugins,
// custom design elements, and ads. You can add your hook calls below, and they should take the 
// following form:
// add_action('thesis_hook_name', 'function_name');
// The function you name above will run at the location of the specified hook. The example
// hook below demonstrates how you can insert Thesis' default recent posts widget above
// the content in Sidebar 1:
// add_action('thesis_hook_before_sidebar_1', 'thesis_widget_recent_posts');

// DPL removing the footer attribution
remove_action('thesis_hook_footer', 'thesis_attribution');
remove_action('thesis_hook_after_post', 'thesis_comments_link');

function custom_add_scripts() {
	if (!is_admin()) {
	
		wp_enqueue_style('colorbox-style',
			get_stylesheet_directory_uri('') . '/custom/js/colorbox/colorbox.css'
		);   		
	
		wp_enqueue_script('colorbox',
			get_stylesheet_directory_uri('') . '/custom/js/colorbox/jquery.colorbox-min.js',
			array('jquery')
		);   
	
		wp_enqueue_script('misc-scripts',
			get_stylesheet_directory_uri('') . '/custom/js/scripts.js',
			array('jquery')
		);	
	}
}
add_action('init', 'custom_add_scripts',20);  


add_theme_support( 'post-thumbnails' );

//TCJ moving the nav bar below the header
remove_action(’thesis_hook_before_header’, ‘thesis_nav_menu’);
add_action(’thesis_hook_after_header’, ‘thesis_nav_menu’);

function custom_bookmark_links() {
	global $post;
?>
<ul class="bookmark_links">
	<li><a rel="nofollow" href="http://delicious.com/save?url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>" onclick="window.open('http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>', 'delicious', 'toolbar=no,width=550,height=550'); return false;" title="Bookmark this post on del.icio.us">Bookmark this article on Delicious</a></li>
</ul>
<?php
}

// TCJ adding feature box with rotating image to Home
function header_rotator() {
echo thesis_image_rotator();
}
//add_action('thesis_hook_feature_box','header_rotator');

//TCJ suppressing titles on Home, SLE, and Partners
function suppress_title() {
    return (is_page(array('22','2839','50','140','2284'))) ? false : true;
}
add_filter('thesis_show_headline_area', 'suppress_title');

//TCJ adding custom footer
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Footer Widgets Left',
'before_widget' => '<li class="widget %2$s" id="%1$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>'
));

if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Footer Widgets Middle',
'before_widget' => '<li class="widget %2$s" id="%1$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>'
));

if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Footer Widgets Right',
'before_widget' => '<li class="widget %2$s" id="%1$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>'
));

function my_widgetized_footer() { ?>
<div id="footer-widget-block">
	<div class="my-footer-one footer-widgets sidebar">
		<ul class="sidebar_list">
			<?php thesis_default_widget(3); ?>
		</ul>
	</div>

	<div class="my-footer-two footer-widgets sidebar">
		<ul class="sidebar_list">
			<?php thesis_default_widget(4); ?>
		</ul>
	</div>

	<div class="my-footer-three footer-widgets sidebar">
		<ul class="sidebar_list">
			<?php thesis_default_widget(5); ?>
		</ul>
	</div>
</div>
			<?php
	}
add_action('thesis_hook_footer','my_widgetized_footer','1');

add_action('thesis_hook_before_content_area', 'joomo_slideshow_function');

function joomo_slideshow_function() {

	if ( function_exists('easing_slider') && is_front_page() ){
?>
	<div id="feature_area" class="full_width">
		<div class="page">
			<?php easing_slider(); ?>
		</div>
	</div>
<?php 	
	}
	
	if( has_post_thumbnail() && !is_front_page() ) { 
	
	?>
	<div id="feature_area" class="full_width">
		<div class="page">
			<?php the_post_thumbnail( 'full' );   ?>
		</div>
	</div>
<?php 	

	}

}

add_action('thesis_hook_after_headline','custom_post_byline');

function custom_post_byline() {
	
	
	
	if(!is_page()) { ?>
		<span class="entry-author"><?php the_author(); ?></span>
		<span class="entry-date"><?php echo get_the_date(); ?></span>
<?php } 
}