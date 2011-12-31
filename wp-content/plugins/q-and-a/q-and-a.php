<?php
/*
Plugin Name: Q and A
Plugin URI: http://madebyraygun.com/lab/q-and-a
Description: Add FAQs using custom posts & a shortcode 
Author: Dalton Rooney
Version: 0.2.3
Author URI: http://madebyraygun.com
*/ 

require_once(dirname(__FILE__).'/reorder.php');

$qa_version = "0.2.3";
// add our default options if they're not already there:
if (get_option('qa_version')  != $qa_version) {
    update_option('qa_version', $qa_version);}
add_option("qa_show_support", 'false'); 
   
// now let's grab the options table data
$qa_version = get_option('qa_version');
$qa_show_support = get_option('qa_show_support');

add_action( 'init', 'create_qa_post_types' );
function create_qa_post_types() {
	 $labels = array(
		'name' => _x( 'FAQ Categories', 'taxonomy general name' ),
		'singular_name' => _x( 'FAQ Category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search FAQ Categories' ),
		'all_items' => __( 'All FAQ Categories' ),
		'parent_item' => __( 'Parent FAQ Category' ),
		'parent_item_colon' => __( 'Parent FAQ Category:' ),
		'edit_item' => __( 'Edit FAQ Category' ), 
		'update_item' => __( 'Update FAQ Category' ),
		'add_new_item' => __( 'Add New FAQ Category' ),
		'new_item_name' => __( 'New FAQ Category Name' ),
  ); 	
  	register_taxonomy('faq_category',array('qa_faqs'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'faq-category' ),
  ));
	register_post_type( 'qa_faqs',
		array(
			'labels' => array(
				'name' => __( 'FAQs' ),
				'singular_name' => __( 'FAQ' ),
				'edit_item'	=>	__( 'Edit FAQ'),
				'add_new_item'	=>	__( 'Add FAQ')
			),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => 'faq', 'with_front' => false ),
			'taxonomies' => array( 'FAQs '),
			'supports' => array('title','editor')	
		)
	);
}	

add_shortcode('qa', 'qa_shortcode');
// define the shortcode function
function qa_shortcode($atts) {
	extract(shortcode_atts(array(
		'cat'	=> '', 
		'id'	=> ''
	), $atts));
		
	// stuff that loads when the shortcode is called goes here
		
		if (!empty($id)) { 
			$qa_faqs = get_posts( array(
			'order'          => 'ASC',
			'orderby' 		 => 'menu_order ID',
			'p'	 			=> $id,
			'post_type'      => 'qa_faqs',
			'post_status'    => null,
			'numberposts'    => -1) );
		} else {		
			$qa_faqs = get_posts( array(
			'order'          => 'ASC',
			'orderby' 		 => 'menu_order ID',
			'faq_category'	 => $cat,
			'post_type'      => 'qa_faqs',
			'post_status'    => null,
			'numberposts'    => -1) );
		} 
		
		global $wpdb; $catname = $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE slug = '$cat'");
		
		if (!empty($cat)) {$qa_shortcode .= '<p class="faq-catname">'.$catname.'</p>';}	
		
		if ($qa_faqs) {
		foreach ($qa_faqs as $qa_faq) {
		
		$postslug = $qa_faq->post_name;
		$title = $qa_faq->post_title;
		$answer = wpautop($qa_faq->post_content);
					
		$qa_shortcode .= '<div class="faq-title"><a href="'.get_bloginfo('wpurl').'?qa_faqs='.$postslug.'">'.$title.'</a></div>';
		$qa_shortcode .= '<div class="faq-answer">'.$answer.'</div>';

		}}  // end slideshow loop
	
	$qa_shortcode = do_shortcode( $qa_shortcode );
	return (__($qa_shortcode));
}//ends the qa_shortcode function

add_shortcode('search-qa', 'qasearch_shortcode');
// define the shortcode function
function qasearch_shortcode($atts) {

		$qasearch_shortcode .= '<form role="search" method="get" id="searchform" action="';
		$qasearch_shortcode .= get_bloginfo ( 'siteurl' ); 
		$qasearch_shortcode .='">
    <div><label class="screen-reader-text" for="s">Search FAQs:</label>
        <input type="text" value="" name="s" id="s" />
        <input type="hidden" name="post_type" value="qa_faqs" />
        <input type="submit" id="searchsubmit" value="Search" />
    </div>
</form>';
		
	return $qasearch_shortcode;
}//ends the qa-search_shortcode function

// scripts to go in the header and/or footer
if( !is_admin()){
	wp_enqueue_script('jquery');
}  // load jQuery.

   wp_register_script('qa',  plugins_url('js/qa.js', __FILE__), false, '0.1.4', true); 
   wp_enqueue_script('qa');

function qa_head() {
	echo '
<!-- loaded by Q and A plugin-->
<link rel="stylesheet" type="text/css" href="' .  get_bloginfo('wpurl') . '/wp-content/plugins/q-and-a/q-and-a.css" />
<!-- end Q and A -->
';
} // ends qa_head function
add_action('wp_head', 'qa_head');

// create the admin menu
// hook in the action for the admin options page
add_action('admin_menu', 'add_qa_option_page');

function add_qa_option_page() {
	// hook in the options page function
	add_options_page('Q and A', 'Q and A', 6, __FILE__, 'qa_options_page');
}

function qa_options_page() { 	// Output the options page
	global $qa_version, $qa_show_support; ?>
	<div class="wrap" style="width:500px">
	<h2>Support this plugin</h2>
		
		<div<?php if ($qa_show_support=="true"){echo ' style="display:none"';}?>>
			<p>Donations for this software are welcome:</p> 
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
			<input type="hidden" name="cmd" value="_s-xclick"> 
			<input type="hidden" name="hosted_button_id" value="2ANTEK4HG6XCW"> 
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"> 
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"><br /> 
			</form> 	
			<p>Another way to support our work: we love <a  href="http://daltn.com/x/a2">A2 Hosting</a>! We’ve been using them for years, and they provide the best web host service and support in the industry. If you sign up through the link below, we get a referral fee, which helps us maintain this software. Their one-click WordPress install will have you up and running in just a couple of minutes.</p> 
			<p><a  href="http://daltn.com/x/a2"><img style="margin:10px 0;" src="http://daltonrooney.com/portfolio/wp-content/uploads/2010/01/green_234x60.jpeg" alt="" title="green_234x60" width="234" height="60" class="alignnone size-full wp-image-148" /></a></p> 
		</div><!--//support div-->
		<form method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>
			<input type="checkbox" name="qa_show_support" value="true"<?php if ($qa_show_support=="true"){echo ' checked="checked"';}?>> I have donated to the plugin, don't show this ad.<br />
			<input type="hidden" name="page_options" value="qa_show_support" />
			<input type="hidden" name="action" value="update" />	
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
			</p>
		</form>
		
		<h2>Plugin Reference</h2>
		<p>Use shortcode <code>[qa]</code> to insert your FAQs into a page.</p>
		
		<p>If you want to sort your FAQs into categories, you can optionally use the <code>cat="category-slug"</code> attribute. Example: <code>[qa cat="cheese"]</code> will return only FAQs in the "Cheese" category. You can find the category slug in the <a href="<?php bloginfo('wpurl');?>/wp-admin/edit-tags.php?taxonomy=faq_category&post_type=qa_faqs">FAQ Categories page</a>.
		
		<p>You can also insert a single FAQ with the format <code>[aq id="1234"]</code> where 1234 is the post ID.<br /><br />
		<small>Note: the cat & the id attributes are mutually exclusive. Don't use both in the same shortcode.</small></p>
		
		<p>Use the shortcode [search-qa] to insert a search form that will search only your FAQs.</p>
		
		
		<p>You're using Q and A v. <?php echo $qa_version;?> by <a href="http://madebyraygun.com">Raygun</a>.
	</div><!--//wrap div-->
<?php } ?>