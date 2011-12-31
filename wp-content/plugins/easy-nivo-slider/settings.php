<?php
// --------------------------------------------------------------------------------------------------------
// Set up the admin menu
// --------------------------------------------------------------------------------------------------------
add_action('admin_menu', 'easy_nivo_slider_add_options_page');
function easy_nivo_slider_add_options_page() {
	add_options_page('Easy Nivo Slider Settings','<img class="menu_pto" src="'.plugins_url('/images/menu-icon.png', __FILE__).'" height="12" width="12" alt="" /> Nivo Slider ','manage_options',
		'easy_nivo_slider_settings_page','easy_nivo_slider_settings_page');
	
	//call register settings function
	add_action( 'admin_init', 'easy_nivo_slider_register_settings' );
}

// --------------------------------------------------------------------------------------------------------
// LOAD THE SCRIPTS THAT WE ONLY NEED ON THE SETTINGS PANEL
// --------------------------------------------------------------------------------------------------------
add_action('admin_print_scripts-settings_page_easy_nivo_slider_settings_page', 'easy_nivo_slider_add_scripts');

function easy_nivo_slider_add_scripts() {
	
	if ('true' == get_easy_nivo_slider_option( 'load_nivo' )) {

		wp_enqueue_script('nivo-slider', plugins_url('/3rd-party/jquery.nivo.slider.pack.js', __FILE__),
			array('jquery'),EASY_NIVO_SLIDER_NIVO_VERSION);
	}		

    wp_enqueue_script('easy_nivo_slider_script', plugins_url('/js/settings.js', __FILE__), array('jquery'));

}

// --------------------------------------------------------------------------------------------------------
// Load the styles for just our admin panel
// --------------------------------------------------------------------------------------------------------
add_action('admin_print_styles-settings_page_easy_nivo_slider_settings_page', 'easy_nivo_slider_add_styles');

function easy_nivo_slider_add_styles() {
	if ('true' == get_easy_nivo_slider_option( 'load_nivo' )) {
		wp_register_style( 'nivo-slider',plugins_url('/3rd-party/nivo-slider.css', __FILE__),array(),EASY_NIVO_SLIDER_NIVO_VERSION);
		wp_enqueue_style( 'nivo-slider' );
	}		
	wp_register_style( 'easy-nivo-slider',plugins_url('/css/easy-nivo-slider.css', __FILE__),array(),EASY_NIVO_SLIDER_VERSION);
	wp_register_style( 'easy-nivo-slider-admin',plugins_url('/css/admin.css', __FILE__),array(), EASY_NIVO_SLIDER_VERSION);
	
	wp_enqueue_style( 'easy-nivo-slider' );
	wp_enqueue_style( 'easy-nivo-slider-admin' );	
}

// --------------------------------------------------------------------------------------------------------
// THE AWESOME ADMIN PANEL
// --------------------------------------------------------------------------------------------------------
function easy_nivo_slider_settings_page() { ?>


	<div class="wrap"> 
		<?php screen_icon('tools'); ?>
		<h2>Easy Nivo Slider Settings</h2>  
        
		<div id="poststuff" class="metabox-holder has-right-sidebar">
			
        
   		<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
		<?php // ABOUT THE PLUGIN												?>
   		<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?> 
        
        <div id="side-info-column" class="inner-sidebar">
			<div class="meta-box-sortables"> 
				<div id="about" class="postbox ">  
			
					<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br/></div>
					<h3 class="hndle" id="about-sidebar"><?php _e('About the plugin') ?></h3>
					<div class="inside">
                       	<p>Easy Nivo Slider<br />Version: <?php echo EASY_NIVO_SLIDER_VERSION; ?></p>
						<p>Visit the <a href="http://www.theemeraldcurtain.com/wordpress-plugin/easy-nivo-slider/">
                       	plugin homepage</a> for further information or to get the latest version.</p>

						<p>Feedback and <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QG7JF2QUHGF6A" target="_blank">donations</a> are welcome.</p>
                        <p><strong>Acknowledgements:</strong></p>
							
                        <p>This plugin would not be possible without 
                        <a href="http://nivo.dev7studios.com/" target="_blank">Nivo Slider</a>, 
                        the world's most awesome jQuery slider.  </p>
                            
                        <p>And it's vastly improved by the Filosofo 
                        <a href="http://austinmatzko.com/wordpress-plugins/filosofo-custom-image-sizes/"
                        target="_blank">Custom Image Sizes</a> plugin, which is also completely awesome.</p>
                        
						<p><span style="float: right;">
						&copy; Copyright 2011 - <?php echo date('Y'); ?> 
                        <a href="http://theemeraldcurtain.com">Phillip Bryan</a></p>
					</div> <!-- inside -->
				</div> <!-- about -->
			</div> <!-- meta-box-sortables -->
		</div> <!-- side-info-column -->
                       
		<!-- Start the settings form and set up the plugin options-->   
		<form method="post" action="options.php">
		<?php settings_fields( 'easy_nivo_slider_group' ); ?>
		<?php $options = get_option('easy_nivo_slider_options'); ?>
     
   		<input id="nivo_settings_current_tab" name="easy_nivo_slider_options[nivo_settings_current_tab]" type="hidden" 
    	value="<?php echo $options['nivo_settings_current_tab']; ?>" />
		<!-- Start the settings form -->    
        
   		<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
		<?php // NAVIGATION TABS												?>
   		<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?> 
        <div id="post-body" class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">
				<div id="normal-sortables" class="meta-box-sortables">
                   	
        	        <ul id="nivo_settings_tab">
						<li class="tab_first"><a name="tab_first" href="#">First Slider</a></li>
						<li class="tab_second"><a name="tab_second" href="#">Second Slider</a></li>
						<li class="tab_widget"><a name="tab_widget" href="#">Widget Slider</a></li>


                        
                        <?php if ('true' == get_easy_nivo_slider_option( 'activate_nextgen' )) { ?>
							<li class="tab_nextgen"><a name="tab_nextgen" href="#">NextGen Slider</a></li>
							<li class="tab_nextgenwidget"><a name="tab_nextgenwidget" href="#">NextGen Widget</a></li>
                            
                        <?php } ?>
                        
						<li class="tab_settings"><a name="tab_settings" href="#">Plugin Settings</a></li>
					</ul>           
            
					<div class="postbox">
						<div class="inside"> 
							<div id="nivo_settings_content">
              

   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - FIRST SLIDER												?>
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<div class="tab tab_first">      
		<p>Add a Nivo Slider to a post or page by using the <span class="easy-nivo-slider-icon"></span> 
        button in the Visual editor.  The plugin will generate the <code>[nivo]</code> shortcode for 
        your choice of image selection, slider speed, and type of animation.</p>
        
        <p>There are different configurations for slider size and behaviour.  This panel
        contains the settings for the <strong>First</strong> configuration.</p>
                
    	<?php easy_nivo_slider_options_for_size('first'); ?>
	</div> 

   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - SECOND SLIDER											?>
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>	
	<div class="tab tab_second">     
        <p>This panel contains the settings for the <strong>Second</strong> slider configuration.</p></p>
    	<?php easy_nivo_slider_options_for_size('second'); ?>
    </div>

   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - WIDGET SLIDER											?>
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>    
    <div class="tab tab_widget">       
        <p>This panel contains the settings for slider widgets.</p>
    	<?php easy_nivo_slider_options_for_size('widget'); ?>
	</div>
    
    
       
	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - NEXTGEN 													?>
	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
    <?php if ('true' == get_easy_nivo_slider_option( 'activate_nextgen' )) { ?>	
    	<div class="tab tab_nextgen">       
			
            <p>A Nivo Slider made from a NextGen gallery use the images as maintained by NextGen - 
            they are not resized for the slider.  </p>
            
            <p>The NextGen plugin keeps track of its own image sizes,  
            and these settings are controlled from the the NextGen->Options panels.</p>
            
            <p>If the images have different sizes, then the slider is going to look strange.  
            You can setting a maximum slider size below, which will crop the NextGen images
            (without harming them) to fit the slider.</p>
        
			<?php // The "false" parameter in the next line disables the thumbnail navigation option ?>
			<?php easy_nivo_slider_options_for_size('nextgen', false); ?>

		</div>
	<?php } ?> 
    
 	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - NEXTGEN WIDGET											?>
 	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
    <?php if ('true' == get_easy_nivo_slider_option( 'activate_nextgen' )) { ?>	
	    <div class="tab tab_nextgenwidget">      
        
            <p>A Nivo Widget Slider made from a NextGen gallery use the thumbnails as created by NextGen. </p>
            
            <p>The NextGen plugin can generate thumbnails for its images, 
            and these settings are controlled from the the NextGen->Options panels.</p>
            
            <p>If the thumbnails have different sizes, then the slider is going to look strange.  
            You can setting a maximum slider size below, which will crop the NextGen thumbnails
            (without harming them) to fit the slider.</p>
        		
			<?php // The "false" parameter in the next line disables the thumbnail navigation option ?>
			<?php easy_nivo_slider_options_for_size('nextgenwidget', false); ?>
		</div>  
	<?php } ?> 
    
    
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - PLUGIN SETTINGS											?>
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
    
	<div class="tab tab_settings"> 
                     
        <fieldset class="nivo-slider-fieldset">
        	<legend>Plugin Settings</legend>     
                            
			<p><input name="easy_nivo_slider_options[activate_nextgen]" type="checkbox" value="true" 
			<?php checked('true', $options['activate_nextgen']); ?>  /> Activate NextGen sliders. </p>
            <p>NextGen is a popular image/gallery plugin for WordPress.  It is not required, but if you
            use it, check this box to active Nivo sliders and widgets for your NextGen galleries.
            Tested with version <?php echo EASY_NIVO_SLIDER_NEXTGEN_VERSION; ?> of NextGen.</p>
			<p>&nbsp;</p>
			<p><input name="easy_nivo_slider_options[debug]" type="checkbox" value="true" 
			<?php checked('true', $options['debug']); ?>  /> Activate Debug mode.</p>                        
			<p>&nbsp;</p>                                                   
   			<p><input name="easy_nivo_slider_options[load_nivo]" type="checkbox" value="true" 
			<?php checked('true', $options['load_nivo']); ?>  /> Load Nivo Slider. By default, this plugin loads
            version <?php echo EASY_NIVO_SLIDER_NIVO_VERSION; ?> of Nivo Slider.  
            Leave this checked unless Nivo is installed separately.</p>
                         
			<p>&nbsp;</p>   
			<p><input name="easy_nivo_slider_options[load_cis]" type="checkbox" value="true" 
			<?php checked('true', $options['load_cis']); ?>  /> Load Custom Image Sizes plugin.  By default, this plugin
            loads version <?php echo EASY_NIVO_SLIDER_CUSTOM_IMAGE_SIZES_VERSION; ?> of Custom Image Sizes. 
            Live this checked unless the plugin is installed separately.</p>                         
			<p>&nbsp;</p>                            
			<p><input name="easy_nivo_slider_options[uninstall]" type="checkbox" value="true" 
			<?php checked('true', $options['uninstall']); ?>  /> Uninstall the plugin when deactivated.  
            This will delete the options set by the plugin.</p>
                         
			<p>&nbsp;</p>   
			<p><input type="submit" class="button-primary" value="Save Settings" /></p>
        
        </fieldset> 	                                    
	</div>	    
    

   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - SETTINGS TO PREVIEW SLIDERS								?>
	<?php // This will be a multiple part build - each component will be tagged with the tabs that use it ?>
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
    
	<?php // Start the preview settings for all sliders ?>        
	<div class="tab tab_first tab_second tab_widget tab_nextgen tab_nextgenwidget"> 
		<hr />
		<h4>Preview Slider</h4>   

   		<?php
			
			// - - - - -
			// IMAGE SELECTION 
			// - - - - -
			$id_base = 'nivo_';
			$name_base = 'easy_nivo_slider_options';
			
			sns_form_fieldset_start ( 'Image Selection', 'width400' );	
			
			sns_form_post_id ($id_base, $name_base, $options, 'tab tab_first tab_second tab_widget ');
			
			// sns_form_post_type($id_base, $name_base, $options, 'tab tab_featured', $nivo_tax);
			
			if ('true' == get_easy_nivo_slider_option( 'activate_nextgen' )) { 
				$nivo_nextgen = sns_get_nextgen_galleries();
				if (is_array($nivo_nextgen)) { 
					sns_form_nextgen_gallery ($id_base, $name_base, $options, 'tab tab_nextgen tab_nextgenwidget', $nivo_nextgen);	
				}
			}
			
			sns_form_number_of_images ($id_base, $name_base, $options, 'tab  tab_first tab_second tab_widget tab_nextgen tab_nextgenwidget');
			
			sns_form_orderby ($id_base, $name_base, $options, 'tab tab_first tab_second tab_widget ');
			
			if (is_array($nivo_nextgen)) { 
				sns_form_nextgenorderby ($id_base, $name_base, $options, 'tab tab_nextgen tab_nextgenwidget');
			}
			
			sns_form_order ($id_base, $name_base, $options, 'tab tab_first tab_second tab_widget tab_nextgen tab_nextgenwidget');	
			sns_form_fieldset_end ();   
			
			// - - - - -
			// SLIDER SETTINGS
			// - - - - -
			sns_form_fieldset_start ( 'Slider Settings', 'width400' );
			
			sns_form_animation ($id_base, $name_base, $options, 'tab tab_first tab_second tab_widget tab_nextgen tab_nextgenwidget');
			
			sns_form_fieldset_end ();      
			
    	?>
        
		<div class="tab tab_first tab_second tab_widget tab_nextgen tab_nextgenwidget"> 
    	   	<input type="submit" class="button-primary" value="Preview Slider" />
   	 	</div>	
        
	   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
		<?php // TAB - PREVIEW FIRST SLIDER										?>
	   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>    
		<div class="tab tab_first">         
	        <fieldset class="nivo-slider-fieldset">  
				<?php $options ['size'] = 'first'; ?>
		        <?php easy_nivo_slider_for_single_post($options); ?>
	        </fieldset>	                                
		</div>	

	   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
		<?php // TAB - PREVIEW SECOND SLIDER									?>
	   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
		<div class="tab tab_second">         
	        <fieldset class="nivo-slider-fieldset">  
				<?php $options ['size'] = 'second'; ?>
		        <?php easy_nivo_slider_for_single_post($options); ?>
	        </fieldset>	                                
		</div>	   
    </div>	

   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - PREVIEW WIDGET SLIDER									?>
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>    
	<div class="tab tab_widget">        
        <fieldset class="nivo-slider-fieldset">  
			<?php $options ['size'] = 'widget'; ?>
	        <?php easy_nivo_slider_for_single_post($options); ?>
        </fieldset>	                                
	</div>	   
    
			
 	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - PREVIEW NEXTGEN SLIDER 									?>
 	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
    <?php if ('true' == get_easy_nivo_slider_option( 'activate_nextgen' )) { ?>	
		<div class="tab tab_nextgen">         
    	    <fieldset class="nivo-slider-fieldset">  
				<?php $options['size'] = 'nextgen'; ?>
	        	<?php easy_nivo_slider_for_nextgen($options); ?>
	        </fieldset>	                                
		</div>	
	<?php } ?> 

  	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // TAB - PREVIEW NEXTGEN WIDGET 									?>
 	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
    <?php if ('true' == get_easy_nivo_slider_option( 'activate_nextgen' )) { ?>	

		<div class="tab tab_nextgenwidget">         
    	    <fieldset class="nivo-slider-fieldset">  
				<?php $options['size'] = 'nextgenwidget'; ?>
	        	<?php easy_nivo_slider_for_nextgen($options); ?>
	        </fieldset>	                                
		</div>	
	<?php } ?> 
    
    
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
	<?php // END OF THE TABS												?>
   	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
    
							</div> <!-- nivo_settings_content -->
						</div> <!-- inside -->
					</div> <!-- about -->
                    
				</div> <!-- normalx-sortables -->
			</div> <!-- post-body-content -->
		</div> <!-- post-body -->
                           
        
   		<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
		<?php // CLOSE EVERYTHING DOWN, WHEW									?>
 	  	<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
		<!-- Close the settings form -->          
		</form>       

		</div> <!-- poststuff -->
	</div> <!-- wrap -->   

<?php 
} 

// --------------------------------------------------------------------------------------------------------
// DISPLAY THE SLIDER CONFIGURATION OPTIONS FOR A PARTICULAR SIZE
// --------------------------------------------------------------------------------------------------------
function easy_nivo_slider_options_for_size($size='first', $support_thumbnails=true) { 

	$options = get_option('easy_nivo_slider_options'); ?>
	<table class="form-table">

     	<tr valign="top">
			<th scope="row"><?php echo ucwords(str_replace('_',' ',$size)); ?>  Slider Size:</th>
        	<td><input name="easy_nivo_slider_options[<?php echo $size; ?>_width]" 
            	value="<?php echo $options[$size.'_width']; ?>" type="text" class="nivo_numeric_field" size="3" /> width 
                        
                <input name="easy_nivo_slider_options[<?php echo $size; ?>_height]" 
            	value="<?php echo $options[$size.'_height']; ?>" type="text" class="nivo_numeric_field" size="3" /> height

               
    		</td>
		</tr>
 
 		<tr valign="top">
			<th scope="row">Number of slices:</th>
        	<td><input name="easy_nivo_slider_options[<?php echo $size; ?>_slices]" type="text" 
          		value="<?php echo $options[$size.'_slices']; ?>" class="nivo_numeric_field" size="3" /> 
             	      Suggested value is slider width divided by 40.
			</td>
		</tr>
 
 		<tr valign="top">
			<th scope="row">Linking:</th>
        	<td><input name="easy_nivo_slider_options[<?php echo $size; ?>_linking]" type="checkbox" value="true" 
				<?php checked('true', $options[$size.'_linking']); ?>  /> 
                Link each image to the post, page, or image, depending on the type of slider. 
			</td>
		</tr>
 
 		<tr valign="top">
			<th scope="row">Caption:</th>
        	<td><input name="easy_nivo_slider_options[<?php echo $size; ?>_caption]" type="checkbox" value="true" 
			<?php checked('true', $options[$size.'_caption']); ?>  /> Display a caption using the post/page/image title.
			</td>
		</tr>
 
 		<tr valign="top">
			<th scope="row">Caption opacity:</th>
        	<td><input id="nivo_caption_opacity" name="easy_nivo_slider_options[<?php echo $size; ?>_caption_opacity]" 
                type="text" value="<?php echo $options[$size.'_caption_opacity']; ?>"
                class="nivo_numeric_field nivo_opacity_field" size="3" /> a number between 0 and 1.
			</td>
		</tr>
 		
        <tr valign="top">                               
			<th scope="row">Navigation:</th>
        	<td>
                <!-- pause_on_hover checkbox and hidden text field -->
                <input name="easy_nivo_slider_options[<?php echo $size; ?>_pause_on_hover]" type="hidden" 
                id="<?php echo $size; ?>_nivo_pause_on_hover" value="<?php echo $options[$size.'_pause_on_hover']; ?>"/> 
                	
                <input name="<?php echo $size; ?>_nivo_pause_on_hover" 
                type="checkbox" value="true"  class="nivo_checkbox"
				<?php checked('true', $options[$size.'_pause_on_hover']); ?> /> 
                Pause the slider when the mouse is over it.<br />
                
               	<!-- arrows checkbox and hidden text field -->
                <input name="easy_nivo_slider_options[<?php echo $size; ?>_arrows]" type="hidden" 
                id="<?php echo $size; ?>_nivo_arrows" value="<?php echo $options[$size.'_arrows']; ?>"/> 
                
                <input name="<?php echo $size; ?>_nivo_arrows" 
                type="checkbox" value="true" class="nivo_checkbox"
				<?php checked('true', $options[$size.'_arrows']); ?> /> Add Previous/Next navigation.<br />
                    
               	<!-- hide_arrows checkbox and hidden text field -->
                <input name="easy_nivo_slider_options[<?php echo $size; ?>_hide_arrows]" type="hidden" 
                id="<?php echo $size; ?>_nivo_hide_arrows" 
                value="<?php echo $options[$size.'_hide_arrows']; ?>" id="nivo_hide_arrows"/> 
                
                <input name="<?php echo $size; ?>_nivo_hide_arrows" 
                type="checkbox" value="true" class="nivo_checkbox" 
				<?php checked('true', $options[$size.'_hide_arrows']); ?>  /> 
                Hide the Previous/Next navigation when the mouse is not over the slider.<br />
			</td>
		</tr>
        
        
 		<tr valign="top">
			<th scope="row">&quot;Jump to slide&quot; navigation:</th>
        	<td>
                <!-- controls checkbox and hidden text field -->
                <input name="easy_nivo_slider_options[<?php echo $size; ?>_controls_buttons]"  
                id="<?php echo $size; ?>_nivo_controls_buttons" 
                class="nivo_checkbox_controls_field"
                type="hidden" value="<?php echo $options[$size.'_controls_buttons']; ?>"/>  
                
                <input name="<?php echo $size; ?>_nivo_controls_buttons" 
                type="checkbox" value="true" class="nivo_checkbox nivo_checkbox_controls" 
				<?php checked('true', $options[$size.'_controls_buttons']); ?> /> 
                Button navigation.<br /> 
                    
                <!-- controls checkbox and hidden text field -->
                <input name="easy_nivo_slider_options[<?php echo $size; ?>_controls_numbers]"
                id="<?php echo $size; ?>_nivo_controls_numbers"
                class="nivo_checkbox_controls_field"
                type="hidden" value="<?php echo $options[$size.'_controls_numbers']; ?>"/> 
                
                <input name="<?php echo $size; ?>_nivo_controls_numbers" 
                type="checkbox" value="true" class="nivo_checkbox nivo_checkbox_controls" 
				<?php checked('true', $options[$size.'_controls_numbers']); ?> /> 
                Number navigation.<br />
                
   			<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
            <?php // Thumbnail option is not available for all slider types 		?>
   			<?php // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  ?>
			<?php if ($support_thumbnails) { ?>
            
                <!-- controls checkbox and hidden text field -->
                <input name="easy_nivo_slider_options[<?php echo $size; ?>_controls_thumbs]"
                id="<?php echo $size; ?>_nivo_controls_thumbs"
                class="nivo_checkbox_controls_field"
                type="hidden" value="<?php echo $options[$size.'_controls_thumbs']; ?>"/> 
                
                <div><input name="<?php echo $size; ?>_nivo_controls_thumbs" 
                type="checkbox" value="true" class="nivo_checkbox nivo_checkbox_controls" 
				<?php checked('true', $options[$size.'_controls_thumbs']); ?> /> 
                Thumbnail navigation
                 <a class="sns-hover-help" href="#">?
				<span><h4>Thumbnail navigation</h4>
                <p>A row of 60x60 thumbnails will be addded below the slider.</p>
                <p><strong>Note: </strong>Set the number of images when you add a slider, so that the thumbnails 
                will fit on one line.  </p></span></a>
                
           	<?php } ?>
            <?php // ------------------------------------------------------ ?>

                <!--<input id="nivo_controls_offset" name="easy_nivo_slider_options[<?php echo $size; ?>_controls_offset]" 
				type="text" value="<?php echo $options[$size.'_controls_offset']; ?>"
                class="nivo_numeric_field" size="3" /> Space between controls and bottom of slider:  0=slider bottom,  24&asymp;just above caption, <?php echo ($options[$size.'_height']-24); ?>&asymp;slider top. -->

			</td>
		</tr>
        
 
 		<tr valign="top">
			<th scope="row">Custom CSS:</th>
        	<td><input name="easy_nivo_slider_options[<?php echo $size; ?>_css]" type="text" 
          		value="<?php echo $options[$size.'_css']; ?>" size="60" /> <a class="sns-hover-help" href="#">?
				<span><h4>Custom CSS</h4><p>CSS styling that will be applied to the slider. Examples:</p>
         		<p>Add a gray border: <code>border:4px solid #aaa;</code></p>
                <p>Center the slider: <code>margin:0 auto;</code></p></span></a>
			</td>
		</tr>
        
     	<tr valign="top">
			<th scope="row"></th>
        	<td><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td>
		</tr>
	</table>
<?php } ?>