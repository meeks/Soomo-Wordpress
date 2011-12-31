<?php 
session_start(); 
include_once('../misc/form-functions.php');
include_once('../misc/form-functions-post-type.php');
include_once('../misc/functions-post-type.php');

$nivo_tax = unserialize($_SESSION['nivo_tax']);
$nivo_options = unserialize($_SESSION['nivo_options']);

if (isset($_SESSION['nivo_nextgen'])) {
	$nivo_nextgen = unserialize($_SESSION['nivo_nextgen']);
	include_once('../misc/functions-nextgen.php');
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Create a Nivo Slider using images from...</title>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/popup_window.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/admin.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
    <style type="text/css" media="screen">
	#nivo_settings_tab {  border-bottom:2px solid #aaa; } 
    
	#nivo_settings_tab a, #nivo_settings_tab a:active, #nivo_settings_tab a:visited {
	 	background-color: #e0e0e0; color:#999; border-color:#aaa;
	}
	#nivo_settings_tab .current a { border-bottom:#f1f1f1 2px solid; background:#f1f1f1; color:#333; }
    
    </style>
</head>
<body>	
	<form action="#" method="get" accept-charset="utf-8">
   	
		<ul id="nivo_settings_tab">
			<li class="current tab_current"><a name="tab_current" href="#">This Post</a></li>
			<li class="tab_single"><a name="tab_single" href="#">Another Post</a></li>            
			<li class="tab_featured"><a name="tab_featured" href="#">Multiple Posts</a></li>
			<li class="tab_all"><a name="tab_all" href="#">All Posts</a></li>         
            
            <?php if ('true'==$nivo_options['activate_nextgen'] && is_array($nivo_nextgen)) { ?>
				<li class="tab_nextgen"><a name="tab_nextgen" href="#">A NextGen Gallery</a></li>
			<?php } ?>
		</ul>        
                        
    <input id="nivo_settings_current_tab" name="easy_nivo_slider_options[nivo_settings_current_tab]"
    	type="hidden" value="tab_current" />     

    <div id="nivo_settings_content">
    
		<p class="tab current tab_current">
        	Display a slider with images from <strong>the current</strong> post or page.
        </p>   
            
		<p class="tab current tab_single">
        	Display a slider with images from a <strong>specific</strong> post or page.
        </p>   
            
        <p class="tab tab_featured">
        	Display a slider with the <strong>featured images</strong> from multiple posts.
        </p>   
            
        <p class="tab tab_all">
        	Display a slider using <strong>every image</strong> on your site.
        </p>   
 
	    <?php if (is_array($nivo_nextgen)) { ?>	
    		<p class="tab tab_nextgen">Display a slider with images from a <strong>NextGen</strong> gallery</p> 
	    <?php } ?>

        <?php 
			// Set our form base fields
			$id_base = 'nivo_';
			$name_base = 'easy_nivo_slider_options';
			
			// - - - - -
			// IMAGE SELECTION 
			// - - - - -
			sns_form_fieldset_start ( 'Image Selection', 'width400' );	
			
			sns_form_post_id ($id_base, $name_base, $options, 'tab tab_single');
			
			sns_form_post_type($id_base, $name_base, $options, 'tab tab_featured', $nivo_tax);
			
			if (is_array($nivo_nextgen)) { 
				sns_form_nextgen_gallery ($id_base, $name_base, $options, 'tab tab_nextgen', $nivo_nextgen);
			}
		
			
			echo '<tr class="tab tab_featured"><td>&nbsp;</td></tr>';
			         
			sns_form_number_of_images ($id_base, $name_base, $options, 'tab tab_current tab_single tab_featured tab_all tab_nextgen');
			
            $options['orderby'] = 'menu_order'; 
			sns_form_orderby ($id_base, $name_base, $options, 'tab tab_current tab_single tab_featured tab_all');
			
            $options['nextgenorderby'] = 'date';
			if (is_array($nivo_nextgen)) { 
				sns_form_nextgenorderby ($id_base, $name_base, $options, 'tab tab_nextgen ');
			}
			
			sns_form_order ($id_base, $name_base, $options, 'tab tab_current tab_single tab_featured tab_nextgen tab_all');	
			sns_form_fieldset_end ();              
			
			// - - - - -
			// SLIDER SETTINGS
			// - - - - -
			sns_form_fieldset_start ( 'Slider Settings', 'width400' );
			
			// NextGen doesn't have size setting	
			sns_form_size($id_base, $name_base, $options, 'tab tab_current tab_single tab_featured tab_all');	
			
			sns_form_animation ($id_base, $name_base, $options, 'tab tab_current tab_single tab_featured tab_all tab_nextgen');
			
			sns_form_fieldset_end ();                        
            
		?>
     
    </div>   <!-- nivo_settings_content -->	
    
               
	<div align="center">	   
		<input type="submit" id="insert" name="insert" value="Insert" onclick="submit_mce_form();" />
		<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
        </div>
             
	</form>
</body>
</html>
<?php
// -----------------------
// EASY ECHO FUNCTION, BECAUSE THIS POPUP WINDOW DOESN'T RUN IN THE WORDPRESS SPACE
// -----------------------
function _e($txt) { echo $txt; }
?>

