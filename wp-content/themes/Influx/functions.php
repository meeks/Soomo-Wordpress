<?php 

function the_title2($before = '', $after = '', $echo = true, $length = false) {
         $title = get_the_title();

      if ( $length && is_numeric($length) ) {

             $title = substr( $title, 0, $length );

          }

        if ( strlen($title)> 0 ) {

             $title = apply_filters('the_title2', $before . $title . $after, $before, $after);

             if ( $echo )

                echo $title;

             else

                return $title;

          }

      }

?>
<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div class="sidebar-box">',
    'after_widget' => '</div>',
 'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
?>
<?php
$themename = "Influx Theme";
$shortname = "artsee";
$options = array (

    array(    "name" => "Layout Settings",
            "type" => "titles",),

    array(    "name" => "<span style='float: left;'>Child Theme</span>",
            "id" => $shortname."_theme",
            "type" => "select",
            "std" => "Default",
            "options" => array("Default", "Grunge", "Oceanic", "Subtlety")),

	array(    "name" => "<span style='float: left;'>Post Format</span>",
            "id" => $shortname."_format",
            "type" => "select",
            "std" => "Default",
            "options" => array("Default", "Blog Style")),

	array(    "name" => "Hid/Display Sidebar Tabbed Content",
            "id" => $shortname."_posttabs",
            "type" => "select",
            "std" => "Display",
            "options" => array("Display", "Hide")),

    array(    "name" => "About Us Text",
            "id" => $shortname."_about",
            "std" => "Consectetuer rutrum urna in, a molestie aliquam gravida, quam vestibulum ac. Consequat ut lacus tempus a ipsum, sociis urna sed, vel tellus maecenas nec, lorem maecenas tortor. At odio platea etiam. Euismod libero pretium accumsan pellentesque ac. Quam semper in vitae dictum eget, ipsum magna orci odio lectus vitae, luctus magnam, porta integer, ac purus. Vestibulum sit ligula vestibulum, vestibulum fames ac mauris venenatis. Ut vel ligula fermentum enim fermentum dignissim. Morbi lacus nulla, condimentum ac, suscipit auctor, aliquam sit amet, odio. Nunc scelerisque facilisis ante. Vestibulum dui lectus, egestas at, tempus vitae, vehicula et, lectus.",
            "type" => "text2"),
	
	
	array(    "name" => "Number of Recent Entries displayed in the sidebar tab",
            "id" => $shortname."_tab_entries",
            "std" => "8",
            "type" => "text"),
			
	array(    "name" => "Number of Recent Comments displayed in the sidebar tab",
            "id" => $shortname."_tab_comments",
            "std" => "4",
            "type" => "text"),
							
    array(    "name" => "Homepage Options",
            "type" => "titles"),

	array(    "name" => "Hide/Display Right/Center Column",
            "id" => $shortname."_featured2",
            "type" => "select",
            "std" => "Display",
            "options" => array("Display", "Hide")),
	
	array(    "name" => "<span style='float: left;'>Number of Featured Articles <br> displayed in the homepage</span><div style='clear:both'></div><span style='font-size: 10px; color: #2583AD; display: block; width: 200px; padding: 10px; border: 1px solid #A6C3DA; background-color: #F4FAFF; margin-bottom: 15px;'>The featured articles are within a container with a fixed height. Increasing this number may result in hidden content. Use in conjuction with increasing/lessening the number of random posts displayed.</span>",
            "id" => $shortname."_featured",
            "std" => "4",
            "type" => "text"),
			
			
	array(    "name" => "<span style='float: left;'>Number of Random Articles <br> displayed in the homepage</span><div style='clear:both'></div><span style='font-size: 10px; color: #2583AD; display: block; width: 200px; padding: 10px; border: 1px solid #A6C3DA; background-color: #F4FAFF; margin-bottom: 15px;'>The random articles are within a container with a fixed height. Increasing this number may result in hidden content. Use in conjuction with increasing/lessening the number of featured posts displayed.</span>",
            "id" => $shortname."_random",
            "std" => "8",
            "type" => "text"),
					
    array(    "name" => "Post-Page Options",
            "type" => "titles"),
			
	array(    "name" => "Hid/Display Thumbnails on Post Pages",
            "id" => $shortname."_thumbnails",
            "type" => "select",
            "std" => "Display",
            "options" => array("Display", "Hide")),
	
    array(    "name" => "Hide/Display Share Button",
            "id" => $shortname."_share",
            "type" => "select",
            "std" => "visible",
            "options" => array("visible", "hidden")),
	
					
    array(    "name" => "Navigation Options",
            "type" => "titles"),
			
    array(    "name" => "Exclude Pages From Navigation by ID (separate by ',')",
            "id" => $shortname."_exclude_page",
            "std" => "",
            "type" => "text"),
				
	array(    "name" => "Order Pages Links by Ascending/Descending",
            "id" => $shortname."_order_page",
            "type" => "select",
            "std" => "asc",
            "options" => array("asc", "desc")),
			
    array(    "name" => "Advertisement Options",
            "type" => "titles"),
			
	array(    "name" => "Enable/Disable 125x125 Sidebar Ads",
            "id" => $shortname."_ads",
            "type" => "select",
            "std" => "Enable",
            "options" => array("Enable", "Disable")),
			
	array(    "name" => "Enable/Disable 250x250 Sidebar Ad",
            "id" => $shortname."_twofifty",
            "type" => "select",
            "std" => "Disable",
            "options" => array("Disable", "Enable")),

	array(    "name" => "Enable/Disable 468x60 Advertisement (on post pages)",
            "id" => $shortname."_foursixeight",
            "type" => "select",
            "std" => "Disable",
            "options" => array("Disable", "Enable")),

		
    array(    "name" => "Banner Management",
            "type" => "titles"),
			
	array(    "name" => "468x60 Banner Image",
            "id" => $shortname."_banner_468",
            "std" => "http://www.elegantthemes.com/images/StudioBlue/468x60.gif",
            "type" => "text"),
						
	array(    "name" => "468x60 Banner URL",
            "id" => $shortname."_banner_468_url",
            "std" => "#",
            "type" => "text"),
			
	array(    "name" => "125x125 Banner #1 Image",
            "id" => $shortname."_banner_image_one",
            "std" => "http://www.elegantwordpressthemes.com/preview/InterPhase/wp-content/themes/InterPhase/images/125x125.gif",
            "type" => "text"),
			
	array(    "name" => "125x125 Banner #1 URL",
            "id" => $shortname."_banner_url_one",
            "std" => "#",
            "type" => "text"),
			
	array(    "name" => "125x125 Banner #2 Image",
            "id" => $shortname."_banner_image_two",
            "std" => "http://www.elegantwordpressthemes.com/preview/InterPhase/wp-content/themes/InterPhase/images/125x125.gif",
            "type" => "text"),
			
	array(    "name" => "125x125 Banner #2 URL",
            "id" => $shortname."_banner_url_two",
            "std" => "#",
            "type" => "text"),
			
	array(    "name" => "125x125 Banner #3 Image",
            "id" => $shortname."_banner_image_three",
            "std" => "http://www.elegantwordpressthemes.com/preview/InterPhase/wp-content/themes/InterPhase/images/125x125.gif",
            "type" => "text"),
			
	array(    "name" => "125x125 Banner #3 URL",
            "id" => $shortname."_banner_url_three",
            "std" => "#",
            "type" => "text"),
		
	array(    "name" => "125x125 Banner #4 Image",
            "id" => $shortname."_banner_image_four",
            "std" => "http://www.elegantwordpressthemes.com/preview/InterPhase/wp-content/themes/InterPhase/images/125x125.gif",
            "type" => "text"),
			
	array(    "name" => "125x125 Banner #4 URL",
            "id" => $shortname."_banner_url_four",
            "std" => "#",
            "type" => "text"),
			
	array(    "name" => "250x250 Banner Image",
            "id" => $shortname."_banner_twofifty_image",
            "std" => "http://www.elegantwordpressthemes.com/images/StudioBlue/250x250.gif",
            "type" => "text"),
			
	array(    "name" => "250x250 Banner URL",
            "id" => $shortname."_banner_twofifty_url",
            "std" => "#",
            "type" => "text"),
			
	array(    "name" => "728x90 Banner Image",
            "id" => $shortname."_banner_leader_image",
            "std" => "http://www.elegantwordpressthemes.com/images/StudioBlue/728x90.gif",
            "type" => "text"),

);

function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;

        }
    }

    add_theme_page($themename." Options", "Current Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');

}

function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>

<form method="post">



<?php foreach ($options as $value) { 
    
if ($value['type'] == "text") { ?>

<div style="float: left; width: 880px; background-color:#E4F2FD; border-left: 1px solid #C2D6E6; border-right: 1px solid #C2D6E6;  border-bottom: 1px solid #C2D6E6; padding: 10px;">     
<div style="width: 200px; float: left;"><?php echo $value['name']; ?></div>
<div style="width: 680px; float: left;"><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width: 400px;" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></div>
</div>
 
<?php } elseif ($value['type'] == "text2") { ?>
        
<div style="float: left; width: 880px; background-color:#E4F2FD; border-left: 1px solid #C2D6E6; border-right: 1px solid #C2D6E6;  border-bottom: 1px solid #C2D6E6; padding: 10px;">     
<div style="width: 200px; float: left;"><?php echo $value['name']; ?></div>
<div style="width: 680px; float: left;"><textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width: 400px; height: 200px;" type="<?php echo $value['type']; ?>"><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></div>
</div>


<?php } elseif ($value['type'] == "select") { ?>

<div style="float: left; width: 880px; background-color:#E4F2FD; border-left: 1px solid #C2D6E6; border-right: 1px solid #C2D6E6;  border-bottom: 1px solid #C2D6E6; padding: 10px;">   
<div style="width: 200px; float: left;"><?php echo $value['name']; ?></div>
<div style="width: 680px; float: left;"><select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" style="width: 400px;">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select></div>
</div>

<?php } elseif ($value['type'] == "titles") { ?>

<div style="float: left; width: 870px; padding: 15px; background-color:#2583AD; border: 1px solid #2583AD; color: #FFF; font-size: 16px; font-weight: bold; margin-top: 25px;">   
<?php echo $value['name']; ?>
</div>

<?php 
} 
}
?>
<div style="clear: both;"></div>
<p class="submit">
<input name="save" type="submit" value="Save changes" />    
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>

<?php
}

function mytheme_wp_head() { ?>

<?php }

add_action('wp_head', 'mytheme_wp_head');
add_action('admin_menu', 'mytheme_add_admin'); ?>