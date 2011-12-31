<?php
// ------------------------
// PRINT A NIVO SLIDER using the IMAGES in a NEXTGEN GALLERY
// ------------------------
function easy_nivo_slider_for_nextgen ($parms=NULL) {
	echo get_easy_nivo_slider_for_nextgen ($parms);	
}

// ------------------------
// GENERATE A NIVO SLIDER using the IMAGES in a NEXTGEN GALLERY
// ------------------------
function get_easy_nivo_slider_for_nextgen ($parms=NULL) {
    global $wpdb;
	
	// Start an output buffer to capture any output
	ob_start();	
	
	sns_debug('get_easy_nivo_slider_for_nextgen', $parms);
	
	if (!$parms) return ob_get_clean(); ;
	
    $sql_where = ' WHERE exclude = 0';
    if ('' != $parms['gallery']) {
    	$sql_where .= ' AND galleryid='.$parms['gallery'];
    }
	
	
	$parms['size'] = ('nextgenwidget'==$parms['size'] ? 'nextgenwidget' : 'nextgen');
	
	if ('' != $parms['nextgenorderby']) {
		$sql_order = ' ORDER BY '.$parms['nextgenorderby'].' '.$parms['order'];
	}
	
	sns_debug('SQL', "SELECT * FROM $wpdb->nggpictures" . $sql_where . $sql_order);
	
    $results = $wpdb->get_results("SELECT * FROM $wpdb->nggpictures" . $sql_where . $sql_order);    
	$num_results = 0;
    if (is_array($results)) $num_results = count($results);
	
	$output = '';                
    if ($num_results > 0) {                                   
		     
      	$image_alt = null;
      	$image_description = null;
		
		// Track the number of sliders on a page so each one has a unique ID
		$parms = sns_set_slider_id( $parms );
		
		// Initialize the parms so everything has a value		
		$parms = sns_set_empty_parms_to_defaults( $parms );		
		
		// Limit the number of images in slider
		$number_of_images = 0;
				
		// Start the slider DIV
		echo '<div class="easy-nivo-slider easy-nivo-slider-'.$parms['size'].' '.$parms['class'].'" id="slider-'.$parms['ID'].'">';
			
      	// Loop for each image in the gallery
		foreach ($results as $result) {
		
			// Fetch gallery information for each image
        	$gallery = $wpdb->get_row("SELECT * FROM $wpdb->nggallery WHERE gid = '" . $result->galleryid . "'");
			
			// Copy gallery fields into the image array
        	foreach ($gallery as $key => $value) {
            	$result->$key = $value;
        	}       
			 
			// Instantiate a nextGen image from the image array
        	$image = new nggImage($result);    
        	$image_alt = trim($image->alttext);   
        	$image_description = trim($image->description);                   
                
        	// check that alt is url with a easy validation
        	$use_url = false;        
        	if ('' != $image_alt && 
				(substr($image_alt,0,1)=='/' || substr($image_alt,0,4)=='http' || substr($image_alt,0,3)=='ftp')) {
	        	$use_url = true;
				
    	    // if alt isn't a url make it the alt text to backwards support nextgen galleries
        	} elseif( '' != $image_alt ) {
    			$image_description = $image_alt;
	        }    
        
        	/* Retrieve the image description
				if ('' != $image_description) {
        		$image_description = "alt=\"" . esc_attr($image_description) . "\" ";} else {
        		$image_description = '';
        	} */
			
			// Add test for caption, and don't set title if it's false
			
			// Add test for size, and display thumb URL if requested
                  
			// Start the link
			if ('true'==$parms['linking']  &&  '' != $use_url) 			    	        
       			echo "<a href=\"" . esc_attr($image_alt) . "\">";
				
			// Output the image
			// Note that this outputs the original nextgen image, not the resized one.  need to figure out how
			// to get that one, if it exists
			
			
			// Create the image tag.  
			echo '<img '.
				// Use the NextGen image URL if this is a normal slider, and the NextGen thumb URL if this is a widget
				'src="'.('nextgenwidget'==$parms['size'] ? $image->thumbURL : $image->imageURL).'" '.
				
				// If captions are own, add the imagealt for the title
				(('true' == $parms['caption']) ? ' title="'.$image_alt.'"' : '').
				
				// Close the image tag
				'/>';
			
			// Finish the link
			if ('true'==$parms['linking']  &&  '' != $use_url) 
				echo '</a>';
				
			// Check to see if we've reached our maxiumum image count
			$number_of_images++;
			if ($number_of_images >= $parms['number']) break;     			
			
		}
		echo '</div>';
		
		// If the slider has any pictures, add the javascript to start it
	    if ($number_of_images > 0) sns_print_script_for_slider($parms);	
		
		
    }    
	
	if (0 == $number_of_images) 	
		echo EASY_NIVO_SLIDER_ERROR_NO_IMAGES;
	//echo '<h4>Size = '.$parms['size'].'</h4>';		
	
	//return the current buffer and clear it
	return ob_get_clean(); 
}	
?>