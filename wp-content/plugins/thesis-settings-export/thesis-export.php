<?php
/*
Plugin Name: Thesis Import/Export
Plugin URI: http://www.3dogmedia.com/thesis-settings-export-plugin/
Description: Import/Export all Thesis settings and OpenHook.
Version: 1.2
Author: 3DogMedia
Author URI: http://www.3dogmedia.com/
*/

/*
License: GPL v3

UPDATES
1.2
Added javascriptconfirm to restore defaults
1.1
Fixed some leftover urls
*/
if (!class_exists('thesis_export')) {

class thesis_export {
    function thesis_export() {
      add_action('admin_menu', array(&$this,'options_menu'));
      add_action('init', array(&$this,'init'));
    }

    function options_menu(){
        add_theme_page('Thesis Import/Export', 'Thesis Import/Export', 'edit_themes', __FILE__,array(&$this, 'options_page'));
    }
    
    function init(){
      if(isset($_GET['dld'])){
        if($_GET['dld'] == 'downloadopenhook'){
          //export the settings
          global $current_blog, $wpdb;
          header("Cache-Control: public, must-revalidate");
          header("Pragma: hack"); // WTF? oh well, it works...
          header("Content-Type: text/plain");
          header('Content-Disposition: attachment; filename="openhook-content-'.date("Ymd").'.dat"');
          $qry = "SELECT * FROM {$wpdb->options} WHERE option_name like 'openhook_%'";
          $results = $wpdb->get_results($qry); 
          echo serialize($results);
          exit();
        }
        elseif($_GET['dld'] == 'downloadlayout'){
          header("Cache-Control: public, must-revalidate");
          header("Pragma: hack"); // WTF? oh well, it works...
          header("Content-Type: text/plain");
          header('Content-Disposition: attachment; filename="thesis-layout-options-'.date("Ymd").'.dat"');
          $design_options = new Design;
          $design_options->get_design_options();
          echo serialize($design_options);

          exit();        
        }
        elseif($_GET['dld'] == 'downloadoptions'){
          header("Cache-Control: public, must-revalidate");
          header("Pragma: hack"); // WTF? oh well, it works...
          header("Content-Type: text/plain");
          header('Content-Disposition: attachment; filename="thesis-options-'.date("Ymd").'.dat"');
          $thesis_options = new Options;
          $thesis_options->get_options();
          echo serialize($thesis_options);

          exit();        
        }
        elseif($_GET['dld'] == 'restoredefaultlayout'){
          $design_options = new Design;
          $design_options->default_design_options();
          update_option('thesis_design_options', $design_options);
        
          thesis_generate_css();
          if(function_exists('wp_cache_clean_cache')){
            global $file_prefix;
            wp_cache_clean_cache($file_prefix);
          }
          wp_redirect($_SERVER['PHP_SELF'].'?msg=Design&page='.plugin_basename(__FILE__));

        }
        elseif($_GET['dld'] == 'restoredefaultoptions'){
          $default_options = new Options;
          $default_options->default_options();

          update_option('thesis_options', $default_options);
          thesis_generate_css();
        
          if(function_exists('wp_cache_clean_cache')){
            global $file_prefix;
            wp_cache_clean_cache($file_prefix);
          }
          wp_redirect($_SERVER['PHP_SELF'].'?msg=Options&page='.plugin_basename(__FILE__));
        }
      }
      elseif(isset($_POST['action'])){
        if($_POST['action'] == 'upload-options'){
          if ($_FILES["file"]["error"] > 0){
            echo "Error: " . $_FILES["file"]["error"] . "<br />";
          }
          else{
            $rawdata = file_get_contents($_FILES["file"]["tmp_name"]);
            //file_put_contents(THESIS_LAYOUT_CSS, $rawdata);
            $thesis_options = new Options;
            $thesis_options = unserialize($rawdata);
            
            update_option('thesis_options', $thesis_options);
            thesis_generate_css();
            if(function_exists('wp_cache_clean_cache')){
              global $file_prefix;
              wp_cache_clean_cache($file_prefix);
            }
            
            wp_redirect($_SERVER['PHP_SELF'].'?msg=Options&page='.plugin_basename(__FILE__));
            exit();
          }
        }
        elseif($_POST['action'] == 'upload-layout'){
          if ($_FILES["file"]["error"] > 0){
            echo "Error: " . $_FILES["file"]["error"] . "<br />";
          }
          else{
            $rawdata = file_get_contents($_FILES["file"]["tmp_name"]);
            //file_put_contents(THESIS_LAYOUT_CSS, $rawdata);
            $design_options = new Design;
            $design_options = unserialize($rawdata);
            
            update_option('thesis_design_options', $design_options);
        
            thesis_generate_css();
            if(function_exists('wp_cache_clean_cache')){
              global $file_prefix;
              wp_cache_clean_cache($file_prefix);
            }
            
            wp_redirect($_SERVER['PHP_SELF'].'?msg=Design&page='.plugin_basename(__FILE__));
            exit();
            
          }   
        }
        elseif($_POST['action'] == 'upload-openhook'){
          if ($_FILES["file"]["error"] > 0){
            echo "Error: " . $_FILES["file"]["error"] . "<br />";
          }else{
            error_reporting(E_ALL); 
            $rawdata = file_get_contents($_FILES["file"]["tmp_name"]);
            $import = unserialize($rawdata);
            foreach($import as $item){
              update_option($item->option_name, $item->option_value);
            }
            if(function_exists('wp_cache_clean_cache')){
              global $file_prefix;
              wp_cache_clean_cache($file_prefix);
            }
            wp_redirect($_SERVER['PHP_SELF'].'?msg=OpenHook&page='.plugin_basename(__FILE__));
            exit();
          }
        }
      }

    }

    function options_page(){

        ?>
<script LANGUAGE="JavaScript">
<!--
function confirmDefault(whats){
  var agree=confirm("Are you sure you want to restore the DEFAULT "+whats+"?");
  if(agree) return true;
  else return false;
}
// -->
</script>
        <div class="wrap">
        <h2>Thesis Settings Import/Export</h2>
        <?php
      if($_GET['msg'] != ''){
?><div id="updated" class="updated fade below-h2" style="background-color: rgb(255, 251, 204);">
<p><?php echo $_GET['msg']; ?> updated!  <a href="<?php bloginfo('siteurl'); ?>">Check out your site</a></p>
</div><?php
      }
        ?>
        <p>From here, you can export your Thesis settngs, layout, and OpenHook content for backup or use on another Thesis powered blog.</p>
        <h2>Thesis Options</h2>
        <table class="optiontable">

        <tr valign="top">
        <td>
<a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>&amp;dld=restoredefaultoptions' onclick="return confirmDefault('OPTIONS');">Restore Default Options</a><br>
<a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>&amp;dld=downloadoptions'>Download Current Layout</a>
<form method="post" enctype="multipart/form-data">
<input type=hidden name='action' value='upload-options'>
<label for="file">Upload Layout </label> <input type="file" name="file" id="file" /> <input type="submit" name="Upload" value="Import Options" /> (the uploaded file will overwrite your layout).
</form>
        </td>
        </tr>
        </table>
        
        <h2>Design Options</h2>
        <table class="optiontable">

        <tr valign="top">
        <td>
<a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>&amp;dld=restoredefaultlayout' onclick="return confirmDefault('LAYOUT');">Restore Default Layout</a><br>
<a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>&amp;dld=downloadlayout'>Download Current Layout</a>
<form method="post" enctype="multipart/form-data">
<input type=hidden name='action' value='upload-layout'>
<label for="file">Upload Layout </label> <input type="file" name="file" id="file" /> <input type="submit" name="Upload" value="Import Layout" /> (the uploaded file will overwrite your layout).
</form>
        </td>
        </tr>
        </table>
        
        <h2>Thesis OpenHook Content</h2>
        <table class="optiontable">

        <tr valign="top">
        <td>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>&amp;dld=downloadopenhook">Download OpenHook</a>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
Upload OpenHook Content: <input name="file" type="file" />
<input type=hidden name=action value=upload-openhook>
<input type="submit" value="Import OpenHook" /><br />
</form>
        </td>
        </tr>
        </table>



        </div>
        <?php
    }

}//class ends here

} // if class_exists...

$thesis_export = new thesis_export();

?>