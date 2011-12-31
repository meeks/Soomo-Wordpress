<?php	
//---------------------------------------------------------------------
// WIDGET FIELD - TITLE
//---------------------------------------------------------------------
function sns_form_widget_title ($id_base, $name_base, $defaults) { ?>
    	<tr valign="top">	
			<th scope="row">	
				<label for="<?php echo $id_base; ?>title"><?php _e('Title'); ?>:</label></th>
        	<td>
        	    <input id="<?php echo $id_base; ?>title" type="text" 
   	    		name="<?php echo $name_base; ?>[title]" value="<?php echo $defaults['title']; ?>" />
			</td>
		</tr>
<?php }

//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
function sns_form_fieldset_start($legend, $class='') { ?>
    <fieldset class="nivo-slider-fieldset <?php echo $class; ?>">
       	<legend><?php _e($legend); ?>:</legend>
        	<table class="nivo-slider-widget-table">
<?php }

//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
function sns_form_table_start() { ?> 
	<table class="nivo-slider-widget-table">
<?php }

function sns_form_table_end() { ?>
	</table>
<?php }

//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
function sns_form_fieldset_end() { ?>
			</table>
    </fieldset>
<?php }

//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
function sns_form_size_hidden($id_base, $name_base, $defaults, $size='first') { 
	$defaults['size'] = $size;
	?>
		<input type="hidden" value="<?php echo $size; ?>" 
    		id="<?php echo $id_base; ?>size" name="<?php echo $name_base; ?>[size]">
	<?php 
	return $defaults;
}

//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
function sns_form_size($id_base, $name_base, $defaults, $class='') { 
	?>
	<tr valign="top"  class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>size"><?php _e('Slider Size'); ?>:</label></th>
		<td><select id="<?php echo $id_base; ?>size" name="<?php echo $name_base; ?>[size]">
			<?php
				$default = $defaults['size'];
				echo nivo_form_option ($default, 'First Slider',  'first');
				echo nivo_form_option ($default, 'Second Slider', 'second');
		    	echo nivo_form_option ($default, 'Widget Slider', 'widget');
			?>                
			</select>
	    </td>
	</tr>
<?php }


//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
function sns_form_animation($id_base, $name_base, $defaults, $class='') { 
	$defaults['size'] = $size;
	?>
	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>effect"><?php _e('Transition'); ?>:</label></th>
	    <td><select id="<?php echo $id_base; ?>effect" name="<?php echo $name_base; ?>[effect]">
	    	<?php
				$default = $defaults['effect'];
		        echo nivo_form_option ($default, 'random');
		        echo nivo_form_option ($default, 'sliceDown');
			    echo nivo_form_option ($default, 'sliceDownLeft');
				echo nivo_form_option ($default, 'sliceUp');
	           	echo nivo_form_option ($default, 'sliceUpLeft');
		        echo nivo_form_option ($default, 'sliceUpDown');
		        echo nivo_form_option ($default, 'sliceUpDownLeft');
		        echo nivo_form_option ($default, 'fold');
			    echo nivo_form_option ($default, 'fade');
	       		echo nivo_form_option ($default, 'slideInRight');
	           	echo nivo_form_option ($default, 'slideInLeft');
	           	echo nivo_form_option ($default, 'boxRandom');
	           	echo nivo_form_option ($default, 'boxRain');
	           	echo nivo_form_option ($default, 'boxRainReverse');
	           	echo nivo_form_option ($default, 'boxRainGrow ');
	           	echo nivo_form_option ($default, 'boxRainGrowReverse');
			?>                
			</select>
		</td>
	</tr>

    <tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>speed"><?php _e('Speed'); ?>:</label></th>
		<td><input id="<?php echo $id_base; ?>speed" name="<?php echo $name_base; ?>[speed]" 
			value="<?php echo $defaults['speed']; ?>" 
			type="text" class="nivo_numeric_field" size="7" /> 
            <a class="sns-hover-help" href="#">?
			<span><h4>Speed</h4><p>How fast should the slider change from one image to another?</p>
         	<p>Default value is 500 (half a second).</p></span></a>
		</td>
	</tr>

	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>pause"><?php _e('Pause'); ?>:</label></th>
		<td><input id="<?php echo $id_base; ?>pause" name="<?php echo $name_base; ?>[pause]" 
			value="<?php echo $defaults['pause']; ?>" 
			type="text" class="nivo_numeric_field" size="7" /> 
            <a class="sns-hover-help" href="#">?
			<span><h4>Pause</h4><p>How long should the slider pause on each image?</p>
          <p>Default value is 3000 (3 seconds)</p></span></a>
		</td>
	</tr>
<?php }

//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
function sns_form_number_of_images($id_base, $name_base, $defaults, $class='') { 
?>
	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>number"><?php _e('Number of images'); ?>:</label></th>
		<td><input id="<?php echo $id_base; ?>number" name="<?php echo $name_base; ?>[number]" 
			value="<?php echo $defaults['number']; ?>" 
			type="text" class="nivo_numeric_field" size="4" />
            <a class="sns-hover-help" href="#">?
			<span><h4>Number of images</h4><p>Maxiumum of 50</p></span></a>
   		</td>
	</tr>
<?php }

 

//---------------------------------------------------------------------
// SLIDER SETTINGS FORM - ORDERBY
//---------------------------------------------------------------------
function sns_form_orderby($id_base, $name_base, $defaults, $class='') { ?>

	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>orderby"><?php _e('Order By'); ?>:</label></th>
        <td><select id="<?php echo $id_base; ?>orderby" name="<?php echo $name_base; ?>[orderby]">
	    	<?php
				$default = $defaults['orderby'];
	       		echo nivo_form_option ($default, 'Title', 'title');
	        	echo nivo_form_option ($default, 'Date', 'date');
	        	echo nivo_form_option ($default, 'Random Order', 'rand');
	        	echo nivo_form_option ($default, 'Menu Order', 'menu_order');
			?>                
			</select>
		</td>
	</tr>
              
<?php }   

//---------------------------------------------------------------------
// SLIDER SETTINGS FORM - NEXTGEN ORDERBY
//---------------------------------------------------------------------
function sns_form_nextgenorderby($id_base, $name_base, $defaults, $class='') { ?>

	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>nextgenorderby"><?php _e('Order By'); ?>:</label></th>
        <td><select id="<?php echo $id_base; ?>nextgenorderby" name="<?php echo $name_base; ?>[nextgenorderby]">
	    	<?php
				$default = $defaults['nextgenorderby'];
	       		echo nivo_form_option ($default, 'Date', 'imagedate');
	       		echo nivo_form_option ($default, 'Description', 'description');
	       		echo nivo_form_option ($default, 'Filename', 'filename');
	       		echo nivo_form_option ($default, 'Number', 'pid');
	       		echo nivo_form_option ($default, 'Random Order', 'rand()');
	       		echo nivo_form_option ($default, 'Sort Order', 'sortorder');
	       		echo nivo_form_option ($default, 'Title', 'alttext');
			?>                
			</select>
		</td>
	</tr>
<?php }   


//---------------------------------------------------------------------
// SLIDER SETTINGS FORM - ORDERBY
//---------------------------------------------------------------------
function sns_form_order($id_base, $name_base, $defaults, $class='') { ?>
             
	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>order"><?php _e('Order'); ?>:</label></th>
         <td><select id="<?php echo $id_base; ?>order" name="<?php echo $name_base; ?>[order]">
	    	<?php
				$default = $defaults['order'];
		        echo nivo_form_option ($default, '', '');
		        echo nivo_form_option ($default, 'Ascending', 'ASC');
		        echo nivo_form_option ($default, 'Descending', 'DESC');
			?>                
			</select>
		</td>
    </tr>
<?php }   


//---------------------------------------------------------------------
// SLIDER SETTINGS FORM - POST ID
//---------------------------------------------------------------------
function sns_form_post_id ($id_base, $name_base, $defaults, $class='') { ?>
            
	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>post_parent"><?php _e('Use images from which Post?'); ?>:</label></th>
         <td><input id="<?php echo $id_base; ?>post_parent" name="<?php echo $name_base; ?>[post_parent]" 
			value="<?php echo $defaults['post_parent']; ?>" 
            type="text" class="nivo_numeric_field" size="7" />
            <a class="sns-hover-help" href="#">?
			<span><h4>Use images from which Post?</h4><p>Enter the ID of the post or page to use for the slider.</p>
	          <p>If left blank, images from <strong>all</strong> posts and pagess will be used.</p>
    	      <p>To determine the ID of a post/page, just edit it and and look at the web address.   
				It should contain something like: </p>
				<p><big>?post=<strong>##</strong>&amp;action=edit</big></p>
				<p>The <strong>##</strong> is the ID</p></span></a>
		</td>
    </tr>
    <tr class="<?php echo $class; ?>">
    	<td colspan="2">
		    
      	</td>
	</tr>    
<?php }


//---------------------------------------------------------------------
// CREATE A FORM SELECTION BOX FOR NEXTGEN GALLERIES
//---------------------------------------------------------------------
function sns_form_nextgen_gallery ($id_base, $name_base, $defaults, $class='', $nextgen) { ?>

	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row"><label for="<?php echo $id_base; ?>post_type"><?php _e('Gallery'); ?>:</label></th>
        <td> 
			<?php
		    	if ($nextgen && is_array($nextgen)) {
					echo '<select id="'.$id_base.'gallery" name="'.$name_base.'[gallery]">';
					foreach ($nextgen as $key=>$value) {   
				   		echo '<option value="'.$key.'"'.
						($defaults['gallery']==$key ? ' selected="selected"' : '').'>'.
						$value.'</option>';
        			}					
					echo '</select>';	
				} else {
					_e('No galleries found');
				}
			?>
		</td>
	</tr>
<?php
}

//---------------------------------------------------------------------
// ADD AN OPTION TO A FORM SELECTION FIELD
//---------------------------------------------------------------------
function nivo_form_option ($current, $label, $value=false, $class=false, $second_test=true) { 

	if (!$value) $value=$label;

	return '<option value="'.$value.'" '.
		(($current==$value && $second_test) ? 'selected="selected"' : '').
		(($class) ? 'class="'.$class.'"' : '').
		'>'.$label.'</option>';
 
} 

?>