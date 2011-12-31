<?php
//---------------------------------------------------------------------
// RETRIEVE A LIST OF NEXTGEN GALLERIES
//---------------------------------------------------------------------
function sns_get_nextgen_galleries() {

	global $wpdb;
	$galleries = $wpdb->get_results("SELECT * FROM $wpdb->nggallery ORDER BY name ASC");
	
	if (is_array($galleries) && count($galleries) > 0) { 
		$nextgen = array();
		$nextgen[''] = 'All images';
		foreach ($galleries as $gallery) { 
			$nextgen[$gallery->gid] = $gallery->title;
			
			//echo 'gid='.$gallery->gid.', name='.$gallery->title.'<br>';
		}		    
		return $nextgen;
	}
	
	return NULL;	
}


?>