<?php

// ------------------------
// PRINT A NIVO SLIDER from FEATURED IMAGES for SPECIFIED POSTS
// ------------------------
function easy_nivo_slider_for_featured_images ($parms=NULL) {
	echo get_easy_nivo_slider_for_featured_images ($parms);
}
	
// ------------------------
// GENERATE A NIVO SLIDER from FEATURED IMAGES for SPECIFIED POSTS
// ------------------------
function get_easy_nivo_slider_for_featured_images ($parms=NULL) {
	// Start an output buffer to capture any output
	ob_start();	
	
	sns_debug('get_easy_nivo_slider_for_featured_images', $parms);
	if (!$parms) return ob_get_clean(); ;
		
	$qry = array(
		'nopaging' => true, 
		'posts_per_page' => -1,
		'post_type' => $parms['post_type'], 
		'post_status' => 'publish'
	);		
	if ($parms['orderby']) 	$qry['orderby'] = $parms['orderby'];
	if ($parms['order']) 	$qry['order'] = $parms['order'];

	// Set a default post_type
	if (NULL==$qry['post_type'])  	
		$qry['post_type'] = 'post';
		
	// WP_Query uses category_name		
	if (NULL!=$parms['category']) 		
		$qry['category_name'] = $parms['category'];	
	
	// Set the taxonomy and term for WP_Query
	if (NULL!=$parms['taxonomy'] &&	NULL!=$parms['term']) 			
		$qry[$taxonomy] = $parms['term'];		
	
	// Fetch the posts with the passed query
	sns_debug('WP_Query', $qry);
	$r = new WP_Query($qry);
		
	if ($r->have_posts()) : 
		
		// Track the number of sliders on a page so each one has a unique ID
		$parms = sns_set_slider_id( $parms );
							
		// Initialize the parms so everything has a value		
		$parms = sns_set_empty_parms_to_defaults( $parms );

		// Limit the number of images in slider
		$number_of_images = 0;
	
			
		// Initialize some loop variabls
		$thumbnail = '';
		
			while ($r->have_posts()) : $r->the_post(); 

				if ( has_post_thumbnail() ) { 	
				
					// Start building the slider when we find our first image
					if (0==$number_of_images) 
						echo '<div class="easy-nivo-slider easy-nivo-slider-'.$parms['size'].' '.$parms['class'].'" id="slider-'.$parms['ID'].'">';

					// If images are linked, add the link code for the full size image
					if ('true'==$parms['linking']) 
						echo '<a href="'.get_permalink().'" title="'.get_the_title().'">';	
						
					// Dynamically generate the image if it doesn't exist
					$arr_image = wp_get_attachment_image_src(get_post_thumbnail_id(),$parms['width'].'x'.$parms['height']);

					// For thumbnail navigation, generate a thumnail dynamically
					if ('true' == $parms['controls_thumbs']) {
						$arr_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), '60x60' );
						$thumbnail = ' rel="'.$arr_thumb[0].'"';
					}
			
					// Create the image tag.  Note that post title is used
					echo '<img src="'.$arr_image[0].'" '.
						(('true' == $parms['caption']) ? ' title="'.get_the_title().'"' : '').
						$thumbnail.'/>';
					
					// Close the linking code
					if ('true'==$parms['linking']) 
						echo '</a>';                    		
	
					// Increment out image count and break out of the loop if we're done.
					$number_of_images++;
					if ($number_of_images >= $parms['number']) break;
				} 
				
			endwhile; 
			
		// Close the slider only if images were found
		if (0!=$number_of_images) 
			echo '</div>';
		
		// Reset the global $the_post because we stomped on it 
		wp_reset_postdata(); 
		
		// If the slider has any pictures, add the javascript to start it
	    if ($number_of_images > 0) sns_print_script_for_slider($parms);	
		
	endif; // if ($r->have_posts())
	
	if (0 == $number_of_images) 	
		echo EASY_NIVO_SLIDER_ERROR_NO_IMAGES;
	
	//return the current buffer and clear it
	return ob_get_clean(); 
}

?>