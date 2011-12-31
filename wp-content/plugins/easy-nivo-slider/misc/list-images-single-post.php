<?php
// ------------------------
// PRINT A NIVO SLIDER
// ------------------------
function easy_nivo_slider_for_current_post ($parms=NULL) {
	echo get_easy_nivo_slider_for_current_post ($parms);	
}
function easy_nivo_slider_for_single_post ($parms=NULL) {
	echo get_easy_nivo_slider_for_single_post ($parms);	
}
function easy_nivo_slider_for_all_posts ($parms=NULL) {
	echo get_easy_nivo_slider_for_all_posts ($parms);	
}
// ------------------------
// GENERATE A NIVO SLIDER 
// ------------------------
function get_easy_nivo_slider_for_current_post ($parms=NULL) {
	if (!$parms) return;
	$parms['post_parent'] = get_the_ID();
	return get_easy_nivo_slider_for_single_post ($parms);	
}
function get_easy_nivo_slider_for_all_posts ($parms=NULL) {
	if (!$parms) return;	
	$parms['post_parent'] = NULL;
	return get_easy_nivo_slider_for_single_post ($parms);	
}
function get_easy_nivo_slider_for_single_post ($parms=NULL) {

	// Start an output buffer to capture any output
	ob_start();	
	$options = get_option('easy_nivo_slider_options'); 
	
	sns_debug('get_easy_nivo_slider_for_current_post', $parms);
	
	if (!$parms) return ob_get_clean(); ;
		
	$qry = array(
		'post_parent'   	=> ($parms['post_parent'] ? $parms['post_parent'] : NULL),
		'post_type'     	=> 'attachment',
		'posts_per_page'	=> 50, // Using 50 instead of -1 to avoid fetching a gazillian pictures
		'post_mime_type'	=> 'image',
        'orderby'       	=> ($parms['orderby'] ? $parms['orderby'] : 'menu_order'),
        'order'       		=> ($parms['order'] ? $parms['order'] : 'ASC'),
		'nopaging' 			=> true
	);		
	
	// Fetch the posts with the passed query
	sns_debug('WP_Query', $qry);
	$images = get_children($qry);
						
	if ( $images ) {
					
		// Track the number of sliders on a page so each one has a unique ID
		$parms = sns_set_slider_id( $parms );
							
		// Initialize the parms so everything has a value		
		$parms = sns_set_empty_parms_to_defaults( $parms );		

		// Limit the number of images in the slider
		$number_of_images = 0;
	
		// Perform the loop and build the slider
		echo '<div class="easy-nivo-slider easy-nivo-slider-'.$parms['size'].' '.$parms['class'].'" id="slider-'.$parms['ID'].'">';
		
		// Clear the thumbnail for the new slider
		$thumbnail = '';
		
		foreach ( $images as $id => $image ) {
			
			// If images are linked to their posts, add the link code
			if ('true'==$parms['linking']) 
			 	echo '<a href="'.wp_get_attachment_url($id).'" title="'.get_the_title($id).'">';
			
			// Dynamically generate the image if it doesn't exist
			$arr_image = wp_get_attachment_image_src( $id, $parms['width'].'x'.$parms['height'] );

			// For thumbnail navigation, generate a thumnail and build the image code manually
			if ('true' == $parms['controls_thumbs']) {
				$arr_thumb = wp_get_attachment_image_src( $id, '60x60' );
				$thumbnail = ' rel="'.$arr_thumb[0].'"';
			}
			
			// Create the image tag.  The title should be pulled from the post title
			echo '<img src="'.$arr_image[0].'" '.
				(('true' == $parms['caption']) ? ' title="'.get_the_title($id).'"' : '').
				$thumbnail.'/>';
			
			// Close the linking code				
			if ('true'==$parms['linking'])  echo '</a>';           
				
			// Increment out image count and break out of the loop if we're done.
			$number_of_images++;
			if ($number_of_images >= $parms['number']) break; 
			
		}  // foreach

		echo '</div>';
		
		// If the slider has any pictures, add the javascript to start it
	    if ($number_of_images > 0) sns_print_script_for_slider($parms);	
	}
	
	if (0 == $number_of_images) 	
		echo EASY_NIVO_SLIDER_ERROR_NO_IMAGES;
	
	//return the current buffer and clear it
	return ob_get_clean(); 
}	
?>