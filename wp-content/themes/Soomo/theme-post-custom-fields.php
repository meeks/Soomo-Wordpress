<?php

/**
 * The PHP code for setup Theme post custom fields.
 *
 * @package WordPress
 * @subpackage Soomo
 */


/*
	Begin creating custom fields
*/

$postmetas = 
	array (
		/*
			Begin Homepage custom fields
		*/
		array("section" => "Homepage", "id" => "home_slide_type", "type" => "select", "items" => array("Image")),
		
		array("section" => "Homepage", "id" => "home_slide_image_url", "title" => "Slide content image URL <strong>*Required size is width 960 pixels and height 300 pixels</strong>:"),
		array("section" => "Homepage", "id" => "home_slide_link_url", "title" => "Slide link URL:"),

		/*
			End Homepage custom fields
		*/
	
	
		/*
			Begin Portfolio custom fields
		*/
		array("section" => "Portfolio", "id" => "portfolio_type", "type" => "select","items" => array("Image")),

		
		array("section" => "Portfolio", "id" => "portfolio_slider_image_url", "title" => "Portfolio slider image URL <strong>*Rquired is size width 960 pixels and height 300 pixels</strong>:"),
		array("section" => "Portfolio", "id" => "portfolio_link_url", "title" => "Slide link URL:"),
		/*
			End Portfolio custom fields
		*/
		
		/*
			Begin Blog custom fields
		*/
		array("section" => "Blog", "id" => "blog_thumb_image_url", "title" => "Blog post thumb image URL (show in homepage) <strong>*Recommended size width 75 pixels and height 75 pixels</strong> (image URL):"),
		array("section" => "Blog", "id" => "blog_header_image_url", "title" => "Blog post header image URL <strong>*Maximum width 500 pixels and height 145 pixels</strong> (image URL):"),
		/*
			End Blog custom fields
		*/

		/*
			Begin Testimonial custom fields
		*/
		array("section" => "Testimonial", "id" => "testimonial_thumb_image_url", "title" => "Testimonial owner thumb image URL <strong>*Recommended size width 75 pixels and height 75 pixels</strong> (image URL):"),
		/*
			End Testimonial custom fields
		*/
);
?>
<?php

function create_meta_box() {

	global $postmetas;
	if ( function_exists('add_meta_box') && isset($postmetas) && count($postmetas) > 0 ) {  
		add_meta_box( 'metabox', 'Soomo Post Information', 'new_meta_box', 'post', 'normal', 'high' );  
	}

}  

function new_meta_box() {
	global $post, $postmetas;

	echo '<input type="hidden" name="myplugin_noncename" id="myplugin_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	echo '<br/>';
	
	$meta_section = '';

	foreach ( $postmetas as $postmeta ) {

		$meta_id = $postmeta['id'];
		$meta_title = $postmeta['title'];
		
		$meta_type = '';
		if(isset($postmeta['type']))
		{
			$meta_type = $postmeta['type'];
		}
		
		if(empty($meta_section) OR $meta_section != $postmeta['section'])
		{
			$meta_section = $postmeta['section'];
			
			echo "<h3>".$meta_section."</h3><br/>";
		}
		$meta_section = $postmeta['section'];

		echo "<p><label for='$meta_id'>$meta_title </label>";

		if ($meta_type == 'checkbox') {
			$checked = get_post_meta($post->ID, $meta_id, true) == '1' ? "checked" : "";
			echo "<input type='checkbox' name='$meta_id' id='$meta_id' value='1' $checked /></p>";
		}
		else if ($meta_type == 'select') {
			echo "<p><select name='$meta_id' id='$meta_id'>";
			
			if(!empty($postmeta['items']))
			{
				foreach ($postmeta['items'] as $item)
				{
					echo '<option value="'.$item.'"';
					
					if($item == get_post_meta($post->ID, $meta_id, true))
					{
						echo ' selected ';
					}
					
					echo '>'.$item.'</option>';
				}
			}
			
			echo "</select></p>";
		}
		else {
			echo "<input type='text' name='$meta_id' id='$meta_id' class='code' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
		}
	}
	
	echo '<br/>';

}

function save_postdata( $post_id ) {

	global $postmetas;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( isset($_POST['myplugin_noncename']) && !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) )) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

	// Check permissions

	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	// OK, we're authenticated

	if ( $parent_id = wp_is_post_revision($post_id) )
	{
		$post_id = $parent_id;
	}

	foreach ( $postmetas as $postmeta ) {
	
		if ($_POST[$postmeta['id']]) {
			update_custom_meta($post_id, $_POST[$postmeta['id']], $postmeta['id']);
		}

		if ($_POST[$postmeta['id']] == "") {
			delete_post_meta($post_id, $postmeta['id']);
		}
	}

}

function update_custom_meta($postID, $newvalue, $field_name) {

	if (!get_post_meta($postID, $field_name)) {
		add_post_meta($postID, $field_name, $newvalue);
	} else {
		update_post_meta($postID, $field_name, $newvalue);
	}

}

//init

add_action('admin_menu', 'create_meta_box'); 
add_action('save_post', 'save_postdata'); 

/*
	End creating custom fields
*/

?>
