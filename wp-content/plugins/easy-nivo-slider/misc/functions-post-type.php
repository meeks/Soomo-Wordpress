<?php
//---------------------------------------------------------------------
// GENERATE TAXONOMY STRUCTURE
//---------------------------------------------------------------------
function easy_nivo_slider_post_types () {	
	
	$post_types = get_post_types(null, 'objects');
	$arr_post_types = array();
	$arr_post_types_taxonomies = array();
	$arr_taxonomies = array();
	$arr_terms = array();
	$nivo_tax = array();
	
		
	foreach( $post_types as $post_type => $obj ) {
		//echo '$post_type='.$post_type.'<br>';
		if(!$obj->_builtin || $post_type=='post' || $post_type=='page') {
			$posttypes_opt[$post_type] = $obj->labels->name;
			$arr_post_types [$post_type] = $obj->labels->name;
			
			
			$taxonomies = get_object_taxonomies($post_type, 'objects' );
			
			foreach ($taxonomies as $taxonomy ) {
				if ($taxonomy->name != 'post_tag' && $taxonomy->name != 'post_format') {
					$arr_taxonomies [$taxonomy->name] = $taxonomy->label;					
					$arr_post_types_taxonomies[$post_type][$i++] = $taxonomy->name;
				}
			}
		}
	}
	foreach ($arr_taxonomies as $taxonomy => $label ) {	
		$terms = get_terms($taxonomy); 
		foreach ($terms as $term) {
			$arr_terms[$taxonomy][$term->slug] = $term->name;
		}
	}
	
	$nivo_tax['arr_post_types'] = $arr_post_types;
	$nivo_tax['arr_post_types_taxonomies'] = $arr_post_types_taxonomies;
	$nivo_tax['arr_taxonomies'] = $arr_taxonomies;
	$nivo_tax['arr_terms'] = $arr_terms;
	
	return $nivo_tax;    
}              
?>