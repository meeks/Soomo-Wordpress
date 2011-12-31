<?php

//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
function sns_form_post_type($id_base, $name_base, $defaults, $class='', $taxonomies=NULL) { 


	// - - - - - 
	// Taxonomies is our array holding all the post type / taxonomy / term relationships
	// If it isn't already set, go generate it
	// - - - - - 
	if (!$taxonomies) {
		$taxonomies = easy_nivo_slider_post_types();
	}
	
	$default_post_type = $defaults['post_type'];
	$default_taxonomy = $defaults['taxonomy'];
	$default_term = $defaults['term'];	
    
	?>
    
	<tr valign="top"  class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>post_type"><?php _e('Post Type'); ?>:</label></th>
	    <td><select id="<?php echo $id_base; ?>post_type" name="<?php echo $name_base; ?>[post_type]" class="nivo_listbox">
		   	<?php
				foreach ($taxonomies['arr_post_types'] as $post_type => $label ) {
					echo nivo_form_option ($default_post_type, $label, $post_type);
				}
			?>                
			</select>
		</td>
	</tr>

    
	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>taxonomy"><?php _e('Taxonomy'); ?>:</label></th>
	    <td><select id="<?php echo $id_base; ?>taxonomy" name="<?php echo $name_base; ?>[taxonomy]" class="nivo_listbox">
   			<?php						
				foreach ($taxonomies['arr_post_types'] as $post_type => $label ) {
					if ($taxonomies['arr_post_types_taxonomies'][$post_type]) {
						foreach ($taxonomies['arr_post_types_taxonomies'][$post_type] as $taxonomy) {
							echo nivo_form_option ($default_taxonomy,
								$taxonomies['arr_taxonomies'][$taxonomy], $taxonomy,
								'taxonomy post_type_'.$post_type, $default_post_type==$post_type
							);	
						}
					}
				}
			?>                
			</select>
		</td>
	</tr>
    
    
	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>term"><?php _e('Term'); ?>:</label></th>
		<td><select id="<?php echo $id_base; ?>term" name="<?php echo $name_base; ?>[term]" class="nivo_listbox">
			<?php			
				foreach ($taxonomies['arr_taxonomies'] as $taxonomy=>$taxonomy_label ) {
					if ($taxonomies['arr_terms'][$taxonomy]) {
						echo nivo_form_option ($default_term, 'Include all '.$taxonomy_label, 'all', 'all_terms term taxonomy_'.$taxonomy );
						foreach ($taxonomies['arr_terms'][$taxonomy] as $term=>$term_label) {	
			
							echo nivo_form_option ($default_term, $term_label, $term, 'term taxonomy_'.$taxonomy);			
						}
					}
				}
				echo nivo_form_option ($default_term, 'Include all terms', 'all', 'term taxonomy_'.$taxonomy );
			?>                
			</select>
		</td>
	</tr>

    
<?php }

?>