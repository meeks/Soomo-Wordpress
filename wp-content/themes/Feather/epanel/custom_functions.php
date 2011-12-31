<?php 

if (function_exists('create_initial_post_types')) create_initial_post_types(); //fix for wp 3.0 beta 1
if (function_exists('add_custom_background')) add_custom_background();
if (function_exists('add_post_type_support')) add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'automatic-feed-links' );

/* activate shortcodes */
require_once(TEMPLATEPATH . '/epanel/shortcodes/shortcodes.php');

/* activate page templates */
require_once(TEMPLATEPATH . '/epanel/page_templates/page_templates.php'); 
add_filter('widget_text', 'do_shortcode'); 

add_filter('body_class','et_browser_body_class');
function et_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

/* import epanel settings */
require_once(TEMPLATEPATH . '/epanel/import_settings.php'); 


/*this function allows for the auto-creation of post excerpts*/
function truncate_post($amount,$echo=true,$post='') {
	global $shortname;
	
	if ( $post == '' ) global $post;
		
	$postExcerpt = '';
	$postExcerpt = $post->post_excerpt;
	
	if (get_option($shortname.'_use_excerpt') == 'on' && $postExcerpt <> '') { 
		if ($echo) echo $postExcerpt;
		else return $postExcerpt;	
	} else {
		$truncate = $post->post_content;
		
		$truncate = preg_replace('@\[caption[^\]]*?\].*?\[\/caption]@si', '', $truncate);
		
		if ( strlen($truncate) <= $amount ) $echo_out = ''; else $echo_out = '...';
		$truncate = apply_filters('the_content', $truncate);
		$truncate = preg_replace('@<script[^>]*?>.*?</script>@si', '', $truncate);
		$truncate = preg_replace('@<style[^>]*?>.*?</style>@si', '', $truncate);
		
		$truncate = strip_tags($truncate); 
		
		if ($echo_out == '...') $truncate = substr($truncate, 0, strrpos(substr($truncate, 0, $amount), ' '));
		else $truncate = substr($truncate, 0, $amount);

		if ($echo) echo $truncate,$echo_out;
		else return ($truncate . $echo_out);
	};
}


/*this function truncates titles to create preview excerpts*/
function truncate_title($amount,$echo=true,$post='') {
	if ( $post == '' ) $truncate = get_the_title(); 
	else $truncate = $post->post_title; 
	if ( strlen($truncate) <= $amount ) $echo_out = ''; else $echo_out = '...';
	$truncate = mb_substr( $truncate, 0, $amount, 'UTF-8' );
	if ($echo) {
		echo $truncate;
		echo $echo_out;
	}
	else { return ($truncate . $echo_out); }
}


/*this function allows users to use the first image in their post as their thumbnail*/
function et_first_image() {
	global $post;
	$img = '';
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	if ( isset($matches[1][0]) ) $img = $matches[1][0];

	return trim($img);
} 


/* this function gets thumbnail from Post Thumbnail or Custom field or First post image */
function get_thumbnail($width=100, $height=100, $class='', $alttext='', $titletext='', $fullpath=false, $custom_field='', $post='')
{
	if ( $post == '' ) global $post;
	global $shortname;
	
	$thumb_array['thumb'] = '';
	$thumb_array['use_timthumb'] = true;
	if ($fullpath) $thumb_array['fullpath'] = ''; //full image url for lightbox
	
	$new_method = true;
	
	if ( function_exists('has_post_thumbnail') ) {
		if ( has_post_thumbnail( $post->ID ) ) {
			$thumb_array['use_timthumb'] = false;
			
			$et_fullpath =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			$thumb_array['fullpath'] =  $et_fullpath[0];
			
			$args='';
			if ($class <> '') $args['class'] = $class;
			if ($alttext <> '') $args['alt'] = $alttext;
			if ($titletext <> '') $args['title'] = $titletext;
			
			if ( $new_method ) {
				$et_crop = get_post_meta( $post->ID, 'et_nocrop', true ) == '' ? true : false;
				$new_method_thumb = et_resize_image( $thumb_array['fullpath'], $width, $height, $et_crop );
				
				if ( !is_wp_error($new_method_thumb) ) {
					$attributes = '';
					if ( !empty($args) ) {
						foreach ( $args as $key=>$attribute ){
							$attributes .= ' ' . $key . '="' . $attribute . '"';
						}
					}
					
					$thumb_array['thumb'] = '<img src="' . $new_method_thumb . '" ' . $attributes . ' />';
				}
			}
			
			if ( !$new_method || $thumb_array['thumb'] == '' )
				$thumb_array['thumb'] = get_the_post_thumbnail( $post->ID, array($width,$height), $args );
			
		}
	}
	
	if ($thumb_array['thumb'] == '') {
		if ($custom_field == '') $thumb_array['thumb'] = esc_attr( get_post_meta($post->ID, 'Thumbnail', $single = true) );
		else {
			$thumb_array['thumb'] = esc_attr( get_post_meta($post->ID, $custom_field, $single = true) );
			if ($thumb_array['thumb'] == '') esc_attr( $thumb_array['thumb'] = get_post_meta($post->ID, 'Thumbnail', $single = true) );
		}
		
		if (($thumb_array['thumb'] == '') && ((get_option($shortname.'_grab_image')) == 'on')) { 
			$thumb_array['thumb'] = esc_attr( et_first_image() );
			if ( $fullpath ) $thumb_array['fullpath'] = $thumb_array['thumb'];
		}
		
		#if custom field used for small pre-cropped image, open Thumbnail custom field image in lightbox
		if ($fullpath) {
			if ($custom_field == '') $thumb_array['fullpath'] = apply_filters('et_fullpath', et_path_reltoabs(esc_attr($thumb_array['thumb'])));
			elseif ( $custom_field <> '' && get_post_meta($post->ID, 'Thumbnail', $single = true) ) $thumb_array['fullpath'] = apply_filters( 'et_fullpath', et_path_reltoabs(esc_attr(get_post_meta($post->ID, 'Thumbnail', $single = true))) );
		}
	}
	
	return $thumb_array;
}


/* this function prints thumbnail from Post Thumbnail or Custom field or First post image */
function print_thumbnail($thumbnail = '', $use_timthumb = true, $alttext = '', $width = 100, $height = 100, $class = '', $echoout = true, $forstyle = false, $resize = true, $post='') {
	global $shortname;
	if ( $post == '' ) global $post;
	
	$output = '';
	$thumbnail_orig = $thumbnail;
	
	$thumbnail = et_multisite_thumbnail( $thumbnail );
	
	$cropPosition = '';
	
	$allow_new_thumb_method = false;
	
	if ($use_timthumb === true) {
		$new_method = true;
		$new_method_thumb = '';
		$external_source = false;
		
		$parsed_thumb_url = parse_url( $thumbnail_orig ); 
		$parsed_site_url = parse_url( home_url() );
		if ( array_key_exists('host', $parsed_thumb_url) && ( str_replace( 'www.', '', $parsed_thumb_url['host'] ) <> str_replace( 'www.', '', $parsed_site_url['host'] ) ) )
			$external_source = true;
			
		$allow_new_thumb_method = !$external_source && $new_method && $cropPosition == '';
		
		if ( $allow_new_thumb_method && $thumbnail <> '' ){
			$et_crop = get_post_meta( $post->ID, 'et_nocrop', true ) == '' ? true : false; 
			$new_method_thumb =  et_resize_image( et_path_reltoabs($thumbnail), $width, $height, $et_crop );
			if ( is_wp_error( $new_method_thumb ) ) $new_method_thumb = '';
		}
	}
	
	if ($forstyle === false) {
	
		if ($use_timthumb === false) {
			$output = $thumbnail_orig;
		} else {
			$output = '<img src="' . $new_method_thumb . '"';
			
			if ($class <> '') $output .= " class='$class' ";

			$output .= " alt='$alttext' width='$width' height='$height' />";
			
			if (!$resize) $output = $thumbnail;
		}
	
	} else {
		
		$output = $thumbnail;
		
		if ($use_timthumb === false) {
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $output, $matches);
			$output = $matches[1][0];
		} else {
			$output = $new_method_thumb;
		}	
	}
	
	if ($echoout) echo $output;
	else return $output;
}

function et_new_thumb_resize( $thumbnail, $width, $height, $alt='', $forstyle = false ){
	global $shortname;
		
	$new_method = true;
	$new_method_thumb = '';
	$external_source = false;
	
	$parsed_thumb_url = parse_url( $thumbnail );
	$parsed_site_url = parse_url( home_url() );
	if ( array_key_exists('host', $parsed_thumb_url) && ( str_replace( 'www.', '', $parsed_thumb_url['host'] ) <> str_replace( 'www.', '', $parsed_site_url['host'] ) ) )
		$external_source = true; 
		
	$allow_new_thumb_method = !$external_source && $new_method;
	
	if ( $allow_new_thumb_method && $thumbnail <> '' ){
		$et_crop = true;
		$new_method_thumb = et_resize_image( $thumbnail, $width, $height, $et_crop );
		if ( is_wp_error( $new_method_thumb ) ) $new_method_thumb = '';
	}
	
	$thumb = esc_attr( $new_method_thumb );
	
	$output = '<img src="' . $thumb . '" alt="' . $alt . '" width =' . $width . ' height=' . $height . ' />';
	
	return ( !$forstyle ) ? $output : $thumb;
}

function et_multisite_thumbnail($thumbnail='') {
	global $post;
	if ( isset( $post ) && get_post_meta($post->ID, 'blogid', true) ) $blog_id = get_post_meta($post->ID, 'blogid', true);
	else global $blog_id;

	if (isset($blog_id) && $blog_id > 0) {
		$imagePath = explode('/files/', esc_attr($thumbnail));
		if (isset($imagePath[1])) {
			$thumbnail = apply_filters( 'et_multisite_thumbs_absolute_path', get_home_url( 1 ) . '/wp-content/' ); // retrieves wp-content url for a main site ( with blog_id = 1 )
			$thumbnail .= 'blogs.dir/' . $blog_id . '/files/' . $imagePath[1];
		}
	}

	return $thumbnail;
}

function et_is_portrait($imageurl, $post='', $ignore_cfields = false){
	if ( $post == '' ) global $post;
	
	if ( get_post_meta($post->ID,'et_disable_portrait',true) == 1 ) return false;
	
	if ( !$ignore_cfields ) {
		if ( get_post_meta($post->ID,'et_imagetype',true) == 'l' ) return false;
		if ( get_post_meta($post->ID,'et_imagetype',true) == 'p' ) return true;
	}
	
	$imageurl = et_path_reltoabs(et_multisite_thumbnail($imageurl));
	
	$et_thumb_size = @getimagesize($imageurl);
	if ( empty($et_thumb_size) ) {
		$et_thumb_size = @getimagesize( str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $imageurl ) );
		if ( empty($et_thumb_size) ) return false;
	}
	$et_thumb_width = $et_thumb_size[0];
	$et_thumb_height = $et_thumb_size[1];
	
	$result = ($et_thumb_width < $et_thumb_height) ? true : false;
	
	return $result;
}

function et_path_reltoabs( $imageurl ){
	if ( strpos(strtolower($imageurl), 'http://') !== false || strpos(strtolower($imageurl), 'https://') !== false ) return $imageurl;
	
	if ( strpos( strtolower($imageurl), $_SERVER['HTTP_HOST'] ) !== false )
		return $imageurl;
	else {
		$imageurl = home_url() . '/' . $imageurl;
	}
	
	return $imageurl;
}

function in_subcat($blogcat,$current_cat='') {
	$in_subcategory = false;
	
	if (cat_is_ancestor_of($blogcat,$current_cat) || $blogcat == $current_cat) $in_subcategory = true;
		
    return $in_subcategory;
}


function show_page_menu($customClass = 'nav clearfix', $addUlContainer = true, $addHomeLink = true){
	global $shortname, $themename, $exclude_pages, $strdepth, $page_menu, $is_footer;
	
	//excluded pages
	if (get_option($shortname.'_menupages') <> '') $exclude_pages = implode(",", get_option($shortname.'_menupages'));
	
	//dropdown for pages
	$strdepth = '';
	if (get_option($shortname.'_enable_dropdowns') == 'on') $strdepth = "depth=".get_option($shortname.'_tiers_shown_pages');
	if ($strdepth == '') $strdepth = "depth=1";
	
	if ($is_footer) { $strdepth="depth=1"; $strdepth2 = $strdepth; }
	
	$page_menu = wp_list_pages("sort_column=".get_option($shortname.'_sort_pages')."&sort_order=".get_option($shortname.'_order_page')."&".$strdepth."&exclude=".$exclude_pages."&title_li=&echo=0");
	
	if ($addUlContainer) echo('<ul class="'.$customClass.'">');
		if (get_option($shortname . '_home_link') == 'on' && $addHomeLink) { ?> 
			<li <?php if (is_front_page() || is_home()) echo('class="current_page_item"') ?>><a href="<?php echo home_url(); ?>"><?php _e('Home',$themename); ?></a></li>
		<?php };
		
		echo $page_menu;
	if ($addUlContainer) echo('</ul>');
	
};


function show_categories_menu($customClass = 'nav clearfix', $addUlContainer = true){
	global $shortname, $themename, $category_menu, $exclude_cats, $hide, $strdepth2, $projects_cat;
		
	//excluded categories
	if (get_option($shortname.'_menucats') <> '') $exclude_cats = implode(",", get_option($shortname.'_menucats')); 
	
	//hide empty categories
	if (get_option($shortname.'_categories_empty') == 'on') $hide = '1';
	else $hide = '0';
	
	//dropdown for categories
	$strdepth2 = '';
	if (get_option($shortname.'_enable_dropdowns_categories') == 'on') $strdepth2 = "depth=".get_option($shortname.'_tiers_shown_categories'); 
	if ($strdepth2 == '') $strdepth2 = "depth=1";
	
	$args = "orderby=".get_option($shortname.'_sort_cat')."&order=".get_option($shortname.'_order_cat')."&".$strdepth2."&exclude=".$exclude_cats."&hide_empty=".$hide."&title_li=&echo=0";
	
	$categories = get_categories($args);
	
	if (!empty($categories)) {
		$category_menu = wp_list_categories($args);	
		if ($addUlContainer) echo('<ul class="'.$customClass.'">');
			if ($category_menu <> '<li>No categories</li>') echo($category_menu); 
		if ($addUlContainer) echo('</ul>');
	};
	
};


function head_addons(){
	global $shortname, $default_colorscheme;
	
	if ( apply_filters('et_get_additional_color_scheme',get_option($shortname.'_color_scheme')) <> $default_colorscheme ) { ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style-<?php echo(get_option($shortname.'_color_scheme'));?>.css" type="text/css" media="screen" />
	<?php }; 

	if (get_option($shortname.'_child_css') == 'on') { //Enable child stylesheet  ?>
		<link rel="stylesheet" href="<?php echo(get_option($shortname.'_child_cssurl')); ?>" type="text/css" media="screen" />
	<?php };
	
	//prints the theme name, version in meta tag
	$theme_info = get_theme_data(TEMPLATEPATH . '/style.css');	
	echo '<meta content="'.$theme_info['Name'].' v.'.$theme_info['Version'].'" name="generator"/>';

	if (get_option($shortname.'_custom_colors') == 'on') custom_colors_css();
	
};// end function head_addons()
add_action('wp_head','head_addons',7);


function integration_head(){
	global $shortname;
	if (get_option($shortname.'_integration_head') <> '' && get_option($shortname.'_integrate_header_enable') == 'on') echo( get_option($shortname.'_integration_head') ); 
};
add_action('wp_head','integration_head',12);

function integration_body(){
	global $shortname;
	if (get_option($shortname.'_integration_body') <> '' && get_option($shortname.'_integrate_body_enable') == 'on') echo( get_option($shortname.'_integration_body') ); 
};
add_action('wp_footer','integration_body',12);

/*this function gets page name by its id*/
function get_pagename( $page_id )
{
	$page_object = get_page( $page_id );
	
	return apply_filters( 'the_title', $page_object->post_title, $page_id );
}

/*this function gets category name by its id*/
function get_categname( $cat_id )
{
	return get_cat_name( $cat_id );
}


/*this function gets category id by its name*/
function get_catId($cat_name)
{
	$cat_name_id = get_cat_ID( html_entity_decode( $cat_name, ENT_QUOTES ) );
	return $cat_name_id;
}


/*this function gets page id by its name*/
function get_pageId( $page_name )
{
	$page_name = html_entity_decode( $page_name, ENT_QUOTES );
	$page = get_page_by_title( $page_name );
	
	//fix for qtranslate plugin
	#if ( $page_name_id == '' ) $page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title LIKE '%".trim($page_name)."%' AND post_type = 'page'");

	return $page->ID;
}


/*this function controls the meta titles display*/
function elegant_titles() {
	global $shortname;
	
	#if the title is being displayed on the homepage
	if (is_home() || is_front_page()) {
		if (get_option($shortname.'_seo_home_title') == 'on') echo get_option($shortname.'_seo_home_titletext');  
		else { 
			if (get_option($shortname.'_seo_home_type') == 'BlogName | Blog description') echo get_bloginfo('name').get_option($shortname.'_seo_home_separate').get_bloginfo('description'); 
			if ( get_option($shortname.'_seo_home_type') == 'Blog description | BlogName') echo get_bloginfo('description').get_option($shortname.'_seo_home_separate').get_bloginfo('name');
			if ( get_option($shortname.'_seo_home_type') == 'BlogName only') echo get_bloginfo('name');
		}
	}
	#if the title is being displayed on single posts/pages
	if (is_single() || is_page()) { 
		global $wp_query; 
		$postid = $wp_query->post->ID; 
		$key = get_option($shortname.'_seo_single_field_title');
		$exists3 = get_post_meta($postid, ''.$key.'', true);
				if (get_option($shortname.'_seo_single_title') == 'on' && $exists3 !== '' ) echo $exists3; 
				else { 
					if (get_option($shortname.'_seo_single_type') == 'BlogName | Post title') echo get_bloginfo('name').get_option($shortname.'_seo_single_separate').wp_title('',false,''); 
					if ( get_option($shortname.'_seo_single_type') == 'Post title | BlogName') echo wp_title('',false,'').get_option($shortname.'_seo_single_separate').get_bloginfo('name');
					if ( get_option($shortname.'_seo_single_type') == 'Post title only') echo wp_title('',false,'');
			    }
					
	}
	#if the title is being displayed on index pages (categories/archives/search results)
	if (is_category() || is_archive() || is_search()) { 
		if (get_option($shortname.'_seo_index_type') == 'BlogName | Category name') echo get_bloginfo('name').get_option($shortname.'_seo_index_separate').wp_title('',false,''); 
		if ( get_option($shortname.'_seo_index_type') == 'Category name | BlogName') echo wp_title('',false,'').get_option($shortname.'_seo_index_separate').get_bloginfo('name');
		if ( get_option($shortname.'_seo_index_type') == 'Category name only') echo wp_title('',false,'');
		 }	  
} 

/*this function controls the meta description display*/
function elegant_description() {
	global $shortname;
	
	#homepage descriptions
	if (is_home() && get_option($shortname.'_seo_home_description') == 'on') echo '<meta name="description" content="'.get_option($shortname.'_seo_home_descriptiontext').'" />';
	
	#single page descriptions
	global $wp_query; 
	if (isset($wp_query->post->ID)) $postid = $wp_query->post->ID; 
	$key2 = get_option($shortname.'_seo_single_field_description');
	if (isset($postid)) $exists = get_post_meta($postid, ''.$key2.'', true);
	if (get_option($shortname.'_seo_single_description') == 'on' && $exists !== '') {
		if (is_single() || is_page()) echo '<meta name="description" content="'.$exists.'" />';
	}
	
	#index descriptions
	remove_filter('term_description','wpautop');
	$cat = get_query_var('cat'); 
    $exists2 = category_description($cat);
	if ($exists2 !== '' && get_option($shortname.'_seo_index_description') == 'on') {
		if (is_category()) echo '<meta name="description" content="'. $exists2 .'" />';
	}
	if (is_archive() && get_option($shortname.'_seo_index_description') == 'on') echo '<meta name="description" content="Currently viewing archives from'. wp_title('',false,'') .'" />';
	if (is_search() && get_option($shortname.'_seo_index_description') == 'on') echo '<meta name="description" content="'. wp_title('',false,'') .'" />';
}


/*this function controls the meta keywords display*/
function elegant_keywords() {
	global $shortname;
	
	#homepage keywords
	if (is_home() && get_option($shortname.'_seo_home_keywords') == 'on') echo '<meta name="keywords" content="'.get_option($shortname.'_seo_home_keywordstext').'" />';
	
	#single page keywords
	global $wp_query; 
	if (isset($wp_query->post->ID)) $postid = $wp_query->post->ID; 
	$key3 = get_option($shortname.'_seo_single_field_keywords');
	if (isset($postid)) $exists4 = get_post_meta($postid, ''.$key3.'', true);
	if (isset($exists4) && $exists4 !== '' && get_option($shortname.'_seo_single_keywords') == 'on') {
		if (is_single() || is_page()) echo '<meta name="keywords" content="'.$exists4.'" />';	
	}
}


/*this function controls canonical urls*/
function elegant_canonical() {
	global $shortname;
	
	#homepage urls
	if (is_home() && get_option($shortname.'_seo_home_canonical') == 'on') echo '<link rel="canonical" href="'.home_url().'" />';
	
	#single page urls
	global $wp_query; 
	if (isset($wp_query->post->ID)) $postid = $wp_query->post->ID; 
	if (get_option($shortname.'_seo_single_canonical') == 'on') {
		if (is_single() || is_page()) echo '<link rel="canonical" href="'.get_permalink().'" />';	
	}
	
	#index page urls
	if (get_option($shortname.'_seo_index_canonical') == 'on') {
		if (is_archive() || is_category() || is_search()) echo '<link rel="canonical" href="'.get_permalink().'" />';	
	}
}

add_action('wp_head','add_favicon');
function add_favicon(){
	global $shortname;
	
	$faviconUrl = get_option($shortname.'_favicon');
	if ($faviconUrl <> '') echo('<link rel="shortcut icon" href="'.$faviconUrl.'" />');
}

function et_resize_image( $thumb, $new_width, $new_height, $crop ){
	$info = pathinfo($thumb);
	$dir = $info['dirname'];
	$ext = $info['extension'];
	$name = wp_basename($thumb, ".$ext");
	$is_jpeg = false;
	$site_uri = site_url();
	$site_dir = ABSPATH;
	if ( 'jpeg' == $ext ) {
		$ext = 'jpg';
		$name = preg_replace( '#.jpeg$#', '', $name );
		$is_jpeg = true;
	}
	
	$suffix = "{$new_width}x{$new_height}"; 
	$destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";
	
	$matches = apply_filters( 'et_resize_image_site_dir', array(), $site_dir );
	if ( !empty($matches) ){
		preg_match( '#'.$matches[1].'$#', $site_uri, $site_uri_matches );
		if ( !empty($site_uri_matches) ){
			$site_uri = str_replace( $matches[1], '', $site_uri );
			$site_uri = preg_replace( '#/$#', '', $site_uri );
			$site_dir = str_replace( $matches[1], '', $site_dir );
			$site_dir = preg_replace( '#\\\/$#', '', $site_dir );
		}
	}
	
	#get local name for use in file_exists() and get_imagesize() functions
	$localfile = str_replace( $site_uri, $site_dir, et_multisite_thumbnail($thumb) );
	
	$checkfilename = str_replace( $name, $name . '-' . $new_width . 'x' . $new_height, $localfile );
	if ( $is_jpeg ) $checkfilename = preg_replace( '#.jpeg$#', '.jpg', $checkfilename );
	
	#check if we have an image with specified width and height
	if ( file_exists( $checkfilename ) ) return $destfilename;

	$size = @getimagesize( $localfile );
	if ( !$size ) return new WP_Error('invalid_image_path', __('Image doesn\'t exist'), $thumb);
	list($orig_width, $orig_height, $orig_type) = $size;
	
	if ( $orig_width > $new_width || $orig_height > $new_height ){
		if ( $orig_width < $new_width ) $new_width = $orig_width;
		if ( $orig_height < $new_height ) $new_height = $orig_height;

		$suffix = "{$new_width}x{$new_height}";
		$destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";
		$checkfilename = str_replace( $site_uri, $site_dir, $destfilename );
		
		#check if we have an image with new calculated width and height parameters
		if ( file_exists($checkfilename) ) return $destfilename; 
		else {
			$result = image_resize( $localfile, $new_width, $new_height, $crop );
			
			#extract the correct filename and replace it in $thumb
			if ( !is_wp_error( $result ) ) { 
				if ( $is_jpeg ) $thumb = preg_replace( '#.jpeg$#', '.jpg', $thumb);
				$result = str_replace( $name, wp_basename($result, ".$ext"), $thumb );
			}
			
			#returns resized image path or WP_Error ( if something went wrong during resizing )
			return $result;
		}
	}
	
	return $thumb;
}

add_action( 'pre_get_posts', 'et_custom_posts_per_page' );
function et_custom_posts_per_page( $query ) {
	global $shortname;
	
	if ( is_admin() ) return $query;
	
	if ( $query->is_category ) {
		$query->set( 'posts_per_page', get_option( $shortname . '_catnum_posts' ) );
	} elseif ( $query->is_tag ) {
		$query->set( 'posts_per_page', get_option( $shortname . '_tagnum_posts' ) );
	} elseif ( $query->is_search ) {
		if ( isset($_GET['et_searchform_submit']) ) {			
			$postTypes = array();
			if ( !isset($_GET['et-inc-posts']) && !isset($_GET['et-inc-pages']) ) $postTypes = array('post');
			if ( isset($_GET['et-inc-pages']) ) $postTypes = array('page');
			if ( isset($_GET['et-inc-posts']) ) $postTypes[] = 'post';
			$query->set( 'post_type', $postTypes );
			
			if ( isset( $_GET['et-month-choice'] ) && $_GET['et-month-choice'] != 'no-choice' ) {
				$et_year = substr($_GET['et-month-choice'],0,4);
				$et_month = substr($_GET['et-month-choice'], 4, strlen($_GET['et-month-choice'])-4);

				$query->set( 'year', absint($et_year) );
				$query->set( 'monthnum', absint($et_month) );
			}
			
			if ( isset( $_GET['et-cat'] ) && $_GET['et-cat'] != 0 )
				$query->set( 'cat', absint($_GET['et-cat']) );
		}
		$query->set( 'posts_per_page', get_option( $shortname . '_searchnum_posts' ) );
	} elseif ( $query->is_archive ) {
		$query->set( 'posts_per_page', get_option( $shortname . '_archivenum_posts' ) );
	}

	return $query;
}

add_filter('pre_set_site_transient_update_themes', 'et_check_themes_updates');
function et_check_themes_updates( $update_transient ){
	global $wp_version;
	
	if ( !isset($update_transient->checked) ) return $update_transient;
	else $themes = $update_transient->checked;
	
	$send_to_api = array(
		'action' => 'check_theme_updates',
		'installed_themes' => $themes
	);
	
	$options = array(
		'timeout' => ( ( defined('DOING_CRON') && DOING_CRON ) ? 30 : 3),
		'body'			=> $send_to_api,
		'user-agent'	=> 'WordPress/' . $wp_version . '; ' . home_url()
	);
	
	$theme_request = wp_remote_post( 'http://www.elegantthemes.com/api/api.php', $options );
	if ( !is_wp_error($theme_request) && wp_remote_retrieve_response_code($theme_request) == 200 ){
		$theme_response = unserialize( wp_remote_retrieve_body( $theme_request ) );
		if ( !empty($theme_response) ) {
			$update_transient->response = array_merge(!empty($update_transient->response) ? $update_transient->response : array(),$theme_response);
			$last_update->checked = $themes;
			$last_update->response = $theme_response;
		}
	}
	
	$last_update->last_checked = time();
	set_site_transient( 'et_update_themes', $last_update );
	
	return $update_transient;
}

add_filter('site_transient_update_themes', 'et_add_themes_to_update_notification');
function et_add_themes_to_update_notification( $update_transient ){
	$et_update_themes = get_site_transient( 'et_update_themes' );
	if ( !is_object($et_update_themes) || !isset($et_update_themes->response) ) return $update_transient;
	$update_transient->response = array_merge(!empty($update_transient->response) ? $update_transient->response : array(), $et_update_themes->response);
	
	return $update_transient;
}


add_filter( 'default_hidden_meta_boxes', 'et_show_hidden_metaboxes', 10, 2 );
function et_show_hidden_metaboxes( $hidden, $screen ){
	# make custom fields and excerpt meta boxes show by default
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden = array('slugdiv', 'trackbacksdiv', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');
		
	return $hidden;
}

add_filter('widget_title','et_widget_force_title');
function et_widget_force_title( $title ){	
	#add an empty title for widgets ( otherwise it might break the sidebar layout )
	if ( $title == '' ) $title = ' ';
	
	return $title;
}

//modify the comment counts to only reflect the number of comments minus pings
if( version_compare( phpversion(), '4.4', '>=' ) ) add_filter('get_comments_number', 'et_comment_count', 0);
function et_comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
		$get_comments = get_comments( array('post_id' => $id, 'status' => 'approve') );
		$comments_by_type = &separate_comments($get_comments);
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}

add_action( 'admin_init', 'et_theme_check_clean_installation' );
function et_theme_check_clean_installation(){
	add_action( 'admin_notices', 'et_theme_epanel_reminder' );
}

function et_theme_epanel_reminder(){
	global $shortname, $current_screen;
	
	if ( false === get_option( $shortname . '_logo' ) && 'appearance_page_core_functions' != $current_screen->id ){
		printf( '<div class="updated"><p>This is a fresh installation of %1$s theme. Don\'t forget to go to <a href="%2$s">ePanel</a> to set it up. This message will disappear once you have clicked the Save button within the <a href="%2$s">theme\'s options page</a>.</p></div>', get_current_theme(), admin_url( 'themes.php?page=core_functions.php' ) );
	}
} ?>