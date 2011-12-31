<?php


// [dropcap foo="foo-value"]
function dropcap_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'text' => 'something',
		'style' => 1
	), $atts));
	
	//get first char
	$first_char = substr($text, 0, 1);
	$text_len = strlen($text);
	$rest_text = substr($text, 1, $text_len);

	$return_html = '<span class="dropcap'.$style.'">'.$first_char.'</span>';
	$return_html.= $rest_text;
	
	return $return_html;
}
add_shortcode('dropcap', 'dropcap_func');




// [quote foo="foo-value"]
function quote_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'text' => 'something'
	), $atts));
	
	$return_html = '<blockquote>'.$text.'</blockquote>';
	
	return $return_html;
}
add_shortcode('quote', 'quote_func');



function quote_left_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'text' => 'something'
	), $atts));
	
	$return_html = '<blockquote class="left">'.$text.'</blockquote>';
	
	return $return_html;
}
add_shortcode('quote_left', 'quote_left_func');




function quote_right_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'text' => 'something'
	), $atts));
	
	$return_html = '<blockquote class="right">'.$text.'</blockquote>';
	
	return $return_html;
}
add_shortcode('quote_right', 'quote_right_func');




// [button foo="foo-value"]
function button_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'text' => 'something',
		'link' => '',
	), $atts));
	
	$return_html = '<a class="button" href="'.$link.'">';
	$return_html.= '<span>'.$text.'</span>';
	$return_html.= '</a>';
	
	return $return_html;
}
add_shortcode('button', 'button_func');




// [highlight foo="foo-value"]
function highlight_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'text' => 'something',
		'style' => '1',
	), $atts));
	
	$return_html = '<span class="highlight'.$style.'">'.$text.'</span>';
	
	return $return_html;
}
add_shortcode('highlight', 'highlight_func');




// [twitter foo="foo-value"]
function twitter_func($atts) {

	$return_html = soomo_twitter(FALSE);
	
	return $return_html;
}
add_shortcode('twitter', 'twitter_func');




function image_header_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'link' => '',
	), $atts));
	
	$return_html = '<div class="frame">';
	$return_html.= '<a href="'.$link.'">';
	$return_html.= '<img alt="" src="'.$src.'">';
	$return_html.= '</a>';
	$return_html.= '</div>';
	
	return $return_html;
}
add_shortcode('image_header', 'image_header_func');




function frame_left_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
	), $atts));
	
	$return_html = '<img class="frame_left" src="'.$src.'">';
	
	return $return_html;
}
add_shortcode('frame_left', 'frame_left_func');




function frame_right_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
	), $atts));
	
	$return_html = '<img class="frame_right" src="'.$src.'">';
	
	return $return_html;
}
add_shortcode('frame_right', 'frame_right_func');




function arrow_list_func($atts, $content) {
	
	$return_html = '<ul class="arrow_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('arrow_list', 'arrow_list_func');




function check_list_func($atts, $content) {
	
	$return_html = '<ul class="check_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('check_list', 'check_list_func');




function star_list_func($atts, $content) {
	
	$return_html = '<ul class="star_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('star_list', 'star_list_func');




function testimonial_func($atts, $content) {
	
	/**
	*	Get testimonials category ID
	**/
	$mx_testimonial_cat = get_option('mx_testimonial_cat');
	$testimonial_posts = get_posts('numberposts=-1&category='.$mx_testimonial_cat.'&orderby=date&order=ASC');
	$return_html = '';
	
	 	
	if(!empty($testimonial_posts))
	{
	 	$return_html.= '<div class="testimonials">';
	 	$all_posts = count($testimonial_posts);
	 	
	 	//loop for display testimonial content
	 	foreach($testimonial_posts as $key => $testimonial_post)
	 	{
			$return_html.= '<p id="testimonial'.$key.'" ';
			
			if($key > 0) { 
				$return_html.= 'style="display:none" '; 
			} 
			elseif($key == 0 && $all_posts == 1)
			{
				$return_html.= 'style="display:block" ';
			}
			else { 
				$return_html.= 'style="display:block" ';
			}
			
			$return_html.= '>';
			$return_html.= '<strong>'.$testimonial_post->post_title.'</strong><br/>'.strip_tags($testimonial_post->post_content).'</p>';
	 	}
	 	
	 	$return_html.= '</div><br class="clear"/><div id="testimonials_triangle" class="testimonials_triangle"></div><div class="testimonials_owner"><ul>';
	 	
	 	//loop for display icon
	 	foreach($testimonial_posts as $key => $testimonial_post)
	 	{
	 		$testimonial_icon = get_post_meta($testimonial_post->ID, 'testimonial_thumb_image_url', true);
	 		
	 		$return_html.= '<li><a href="#testimonial'.$key.'"><img src="'.$testimonial_icon.'" alt=""/></a></li>';
	 	}
	 	
	 	$return_html.= '</ul></div><br class="clear"/>';
	 	
	}
	
	
	return $return_html;
}
add_shortcode('testimonial', 'testimonial_func');



function two_column_left_func($atts, $content) {
	
	$return_html = '<div class="two_column_left">'. do_shortcode($content) .'</div>';
	
	return $return_html;
}
add_shortcode('two_column_left', 'two_column_left_func');




function two_column_right_func($atts, $content) {
	
	$return_html = '<div class="two_column_right">'. do_shortcode($content) .'</div>';
	
	return $return_html;
}
add_shortcode('two_column_right', 'two_column_right_func');



function three_column_func($atts, $content) {
	
	$return_html = '<div class="three_column2">'.$content.'</div>';
	
	return $return_html;
}
add_shortcode('three_column', 'three_column_func');




function three_column_last_func($atts, $content) {
	
	$return_html = '<div class="three_column2 last">'.$content.'</div>';
	
	return $return_html;
}
add_shortcode('three_column_last', 'three_column_last_func');



function slideshow_func($atts, $content) {
	
	$return_html = '<div class="nivoSlider" style="height: 300px; width: 600px;">'. do_shortcode($content,'<img><a>') .'</div>';
	
	return $return_html;
}
add_shortcode('slideshow', 'slideshow_func');



function soomo_gallery_func($atts, $content) {

	//extract short code attr
	/*extract(shortcode_atts(array(
		'src' => '',
	), $atts));*/
	
	$return_html = '<div class="soomo_gallery">'.html_entity_decode(strip_tags($content,'<img><a>')).'</div>';
	
	return $return_html;
}
add_shortcode('soomo_gallery', 'soomo_gallery_func');



function accordion_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));
	
	$return_html = '<div class="accordion"><h3><a href="#">'.$title.'</a></h3>';
	$return_html.= '<div><p>';
	$return_html.= $content;
	$return_html.= '</p></div></div>';
	
	return $return_html;
}
add_shortcode('accordion', 'accordion_func');



function tabs_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'tab1' => '',
		'tab2' => '',
		'tab3' => '',
		'tab4' => '',
		'tab5' => '',
		'tab6' => '',
		'tab7' => '',
		'tab8' => '',
		'tab9' => '',
		'tab10' => '',
	), $atts));
	
	$tab_arr = array(
		$tab1,
		$tab2,
		$tab3,
		$tab4,
		$tab5,
		$tab6,
		$tab7,
		$tab8,
		$tab9,
		$tab10,
	);
	
	$return_html = '<div class="tabs"><ul>';
	
	foreach($tab_arr as $key=>$tab)
	{
		//display title1
		if(!empty($tab))
		{
			$return_html.= '<li><a href="#tabs-'.($key+1).'">'.$tab.'</a></li>';
		}
	}
	
	$return_html.= '</ul>';
	$return_html.= do_shortcode(strip_tags($content,'<img><a><p>'));
	$return_html.= '</div>';
	
	return $return_html;
}
add_shortcode('tabs', 'tabs_func');


function tab_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'id' => '',
	), $atts));
	
	$return_html.= '<div id="tabs-'.$id.'"><p>'.html_entity_decode(do_shortcode($content)).'</p></div>';
	
	return $return_html;
}
add_shortcode('tab', 'tab_func');



function recent_posts_func($atts) {

	$return_html = soomo_posts('recent', FALSE);
	
	return $return_html;
}
add_shortcode('recent_posts', 'recent_posts_func');



function popular_posts_func($atts) {

	$return_html = soomo_posts('poopular', FALSE);
	
	return $return_html;
}
add_shortcode('popular_posts', 'popular_posts_func');


?>