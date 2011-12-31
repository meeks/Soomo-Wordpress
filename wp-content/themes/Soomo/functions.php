<?php

/**
*	Setup Theme post custom fields
**/
include (TEMPLATEPATH . "/theme-post-custom-fields.php");

/**
*	Setup Theme page custom fields
**/
    
    
/**
*	Setup Contact side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Contact Sidebar'));
    
    
/**
*	Setup Blog side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Blog Sidebar'));
    

/*	Setup Single post side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Single Sidebar'));
    
    
/*	Setup Footer side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Footer Sidebar'));
    
    

/*
 *  Setup main navigation menu
 */
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
	register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}

    
//Get custom function
include (TEMPLATEPATH . "/lib/custom.lib.php");


//Get custom shortcode
include (TEMPLATEPATH . "/lib/shortcode.lib.php");
    

/*
	Begin creating admin optionss
*/

$themename = "Soomo";
$shortname = "mx";

$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array(
	0		=> "Choose a category"
);
foreach ($categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}

$pages = get_pages(array('parent' => 0));
$wp_pages = array(
	0		=> "Choose a page"
);
foreach ($pages as $page_list ) {
       $wp_pages[$page_list->ID] = $page_list->post_title;
}

$options = array (
 
//Begin admin header
array( 
		"name" => $themename." Options",
		"type" => "title"
),
//End admin header
 

//Begin first tab "General"
array( 
		"name" => "General",
		"type" => "section"
)
,

array( "type" => "open"),


array( "name" => "Your Logo (Image URL)",
	"desc" => "Enter the URL of image that you want to use as the logo",
	"id" => $shortname."_logo",
	"type" => "text",
	"std" => "",
),	
array( "name" => "Google Analytics Domain ID ",
	"desc" => "Get analytics on your site. Simply give us your Google Analytics Domain ID (something like UA-123456-1)",
	"id" => $shortname."_ga_id",
	"type" => "text",
	"std" => ""

),
array( "name" => "Custom Favicon",
	"desc" => "A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image",
	"id" => $shortname."_favicon",
	"type" => "text",
	"std" => "",
),

array( "name" => "Your Twitter username",
	"desc" => "Enter your Twitter account.",
	"id" => $shortname."_twitter_username",
	"type" => "text",
	"std" => "",
),
array( "name" => "Your Twitter password (optional)",
	"desc" => "Enter your Twitter password. Enter only if you want to enable Twitter widget",
	"id" => $shortname."_twitter_password",
	"type" => "password",
	"std" => "",
),
array( "name" => "Your Facebook URL",
	"desc" => "Enter the URL of your Facebook account.",
	"id" => $shortname."_facebook_url",
	"type" => "text",
	"std" => "",
),
array( "name" => "Your Youtube URL",
	"desc" => "Enter the URL of your Youtube account.",
	"id" => $shortname."_youtube_url",
	"type" => "text",
	"std" => "",
),
array( "name" => "Your Linkedin URL",
	"desc" => "Enter the URL of your Linkedin account.",
	"id" => $shortname."_linkedin_url",
	"type" => "text",
	"std" => "",
),
array( "name" => "Your Skype username",
	"desc" => "Enter your Skype account.",
	"id" => $shortname."_skype_username",
	"type" => "text",
	"std" => "",
),
	
array( "type" => "close"),
//End first tab "General"

//Begin second tab "Homepage"
array( "name" => "Homepage",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Choose page for homepage",
	"desc" => "Choose a page from which your homepage content to display",
	"id" => $shortname."_home_page",
	"type" => "select",
	"options" => $wp_pages,
	"std" => "Choose a page"),
array( "name" => "Homepage image slider timer (in second)",
	"desc" => "Enter how long each item gets displayed in seconds (default is 5 seconds)",
	"id" => $shortname."_slider_timer",
	"type" => "text",
	"std" => "5",
	"size" => "40px"	
),
	
array( "name" => "Homepage content slider category",
	"desc" => "Choose a category from which contents in slider are drawn",
	"id" => $shortname."_slider_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"
),
array( "name" => "Homepage image slider items",
	"desc" => "Enter how many images get displayed in homepage slider (default is 5 items)",
	"id" => $shortname."_slider_items",
	"type" => "text",
	"std" => "5",
	"size" => "40px"	
),

array( "name" => "Homepage content boxes category",
	"desc" => "Choose a category from which contents in boxes are drawn",
	"id" => $shortname."_box_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"
),
array( "type" => "close"),
//End second tab "Homepage"
	

//Begin third tab "Titles Gallery"
array( "name" => "Titles Gallery",
	"type" => "section"),
array( "type" => "open"),
array( "name" => "Styles",
	"desc" => "Select the Titles gallery style",
	"id" => $shortname."_portfolio_style",
	"type" => "select",
	"options" => array(
		"normal" => "Normal list", 
		"slider" => "List with image slider", 
		"bigimage" => "Big Image list", 
	),
	"std" => "slider"
),
array( "name" => "Titles Gallery slider category",
	"desc" => "Choose a category from which your Gallery slider contents are drawn (optional only select if you choose 'List with image slider' style)",
	"id" => $shortname."_portfolio_slider_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"),
array( "name" => "Choose page for Title Gallery",
	"desc" => "Choose a page from which your Title Gallery to display",
	"id" => $shortname."_portfolio_page",
	"type" => "select",
	"options" => $wp_pages,
	"std" => "Choose a page"),
array( "name" => "Title Gallery category",
	"desc" => "Choose a category from which your Title Gallery contents are drawn",
	"id" => $shortname."_portfolio_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"),
	
array( "type" => "close"),
//End third tab "Title Gallery"

//Begin second tab "Blog"
array( "name" => "Blog",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Choose page for blog",
	"desc" => "Choose a page from which your blog posts to display",
	"id" => $shortname."_blog_page",
	"type" => "select",
	"options" => $wp_pages,
	"std" => "Choose a page"),

array( "name" => "Blog category",
	"desc" => "Choose a category from which content show as Blog posts",
	"id" => $shortname."_blog_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"
),
array( "type" => "close"),
//End second tab "Blog"

//Begin second tab "Student Testimonial"
array( "name" => "Student Testimonial",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Testimonial category",
	"desc" => "Choose a category from which testimonial contents are drawn",
	"id" => $shortname."_testimonial_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"
),
array( "type" => "close"),
//End second tab "Special Content"


//Begin fourth tab "Contact"
array( "name" => "Contact",
	"type" => "section"),
array( "type" => "open"),
	
array( "name" => "Choose page for contact form",
	"desc" => "Choose a page from which your contact form to display",
	"id" => $shortname."_contact_page",
	"type" => "select",
	"options" => $wp_pages,
	"std" => "Choose a page"),
array( "name" => "Your email address",
	"desc" => "Enter which email address will be sent from contact form",
	"id" => $shortname."_contact_email",
	"type" => "text",
	"std" => ""

),
//End fourth tab "Contact"

//Begin fifth tab "Footer"
array( "type" => "close"),
array( "name" => "Footer",
	"type" => "section"),
array( "type" => "open"),
	
array( "name" => "Footer text",
	"desc" => "Enter footer text ex. copyright description",
	"id" => $shortname."_footer_text",
	"type" => "textarea",
	"std" => ""

),
//End fifth tab "Footer"



 
array( "type" => "close")
 
);


function mx_add_admin() {
 
global $themename, $shortname, $options;
 
if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__) ) {
 
	if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {
 
		foreach ($options as $value) {
		update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
 
foreach ($options as $value) {
	if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

 
	header("Location: admin.php?page=functions.php&saved=true");
 
} 
else if( isset($_REQUEST['action']) && 'reset' == $_REQUEST['action'] ) {
 
	foreach ($options as $value) {
		delete_option( $value['id'] ); }
 
	header("Location: admin.php?page=functions.php&reset=true");
 
}
}
 
add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mx_admin');
}

function mx_add_init() {

$file_dir=get_bloginfo('template_directory');
wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
wp_enqueue_script("rm_script", $file_dir."/functions/rm_script.js", false, "1.0");

}
function mx_admin() {
 
global $themename, $shortname, $options;
$i=0;
 
if ( isset($_REQUEST['saved']) &&  $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( isset($_REQUEST['reset']) &&  $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
 
?>
	<div class="wrap rm_wrap">
	<h2><?php echo $themename; ?> Settings</h2>

	<div class="rm_opts">
	<form method="post"><?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?> <?php break;
 
case "close":
?>
	
	</div>
	</div>
	<br />


	<?php break;
 
case "title":
?>
	<br />


<?php break;
 
case 'text':
?>

	<div class="rm_input rm_text"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<input name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>"
		value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>"
		<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?> />
	<small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>

	</div>
	<?php
break;

case 'password':
?>

	<div class="rm_input rm_text"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<input name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>"
		value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>"
		<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?> />
	<small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>

	</div>
	<?php
break;
 
case 'textarea':
?>

	<div class="rm_input rm_textarea"><label
		for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<textarea name="<?php echo $value['id']; ?>"
		type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
	<small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>

	</div>

	<?php
break;
 
case 'select':
?>

	<div class="rm_input rm_select"><label
		for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

	<select name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>">
		<?php foreach ($value['options'] as $key => $option) { ?>
		<option
		<?php if (get_settings( $value['id'] ) == $key) { echo 'selected="selected"'; } ?>
			value="<?php echo $key; ?>"><?php echo $option; ?></option>
		<?php } ?>
	</select> <small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>
	</div>
	<?php
break;
 
case "checkbox":
?>

	<div class="rm_input rm_checkbox"><label
		for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

	<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
	<input type="checkbox" name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />


	<small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>
	</div>
	<?php break; 
case "section":

$i++;

?>

	<div class="rm_section">
	<div class="rm_title">
	<h3><img
		src="<?php bloginfo('template_directory')?>/functions/images/trans.png"
		class="inactive" alt="""><?php echo $value['name']; ?></h3>
	<span class="submit"><input name="save<?php echo $i; ?>" type="submit"
		value="Save changes" /> </span>
	<div class="clearfix"></div>
	</div>
<div class="rm_options"><?php break;
 
}
}
?>

<input type="hidden" name="action" value="save" />

</form>

<form method="post"><!-- p class="submit">

<input name="reset" type="submit" value="Reset" />

<input type="hidden" name="action" value="reset" />

</p --></form>

</div>


	<?php
}

add_action('admin_init', 'mx_add_init');
add_action('admin_menu', 'mx_add_admin');

/*
	End creating admin options
*/

//Make widget support shortcode
add_filter('widget_text', 'do_shortcode');
?>