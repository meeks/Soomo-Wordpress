<?php
/*
Plugin Name: NIVO slider light
Plugin URI: https://www.netaction.de/wordpress-plugin-nivo-slider-light/
Description: This is a wrapper for the jQuery plugin NIVO Image Slider from dev7studios.
Version: 1.10
Author: Thomas Schmidt
Author URI: http://netaction.de
*/


function NivoInit() {
	wp_enqueue_script('nivoSliderScript', WP_PLUGIN_URL.'/nivo-slider-light/jquery.nivo.slider.pack.js', array('jquery'));
	wp_enqueue_style('nivoStyleSheet', WP_PLUGIN_URL . '/nivo-slider-light/nivo-slider.css');
	wp_enqueue_style('nivoCustomStyleSheet', WP_PLUGIN_URL . '/nivo-slider-light/custom-nivo-slider.css');
}


function NivoHeader() {
?>
<script type="text/javascript">
/* <![CDATA[ */
	jQuery(document).ready(function($){
		$(".nivoSlider br").each(function(){ // strip BR elements created by Wordpress
			$(this).remove();
		});
		$('.nivoSlider').nivoSlider({
			effect:'fade', //Specify sets like: 'random,fold,fade,sliceDown'
			// All effects:
			// sliceDown, sliceDownLeft, sliceUp, sliceUpLeft, sliceUpDown
			// sliceUpDownLeft, fold, fade, random, slideInRight,
			// slideInLeft, boxRandom, boxRain, boxRainReverse, boxRainGrow
			// boxRainGrowReverse
			animSpeed:500, //Slide transition speed
			pauseTime:3000,
			startSlide:0, //Set starting Slide (0 index)
			directionNav:true, //Next & Prev
			directionNavHide:true, //Only show on hover
			controlNav:true, //1,2,3...
			controlNavThumbs:false, //Use thumbnails for Control Nav
			controlNavThumbsFromRel:false, //Use image rel for thumbs
			controlNavThumbsSearch: '.jpg', //Replace this with...
			controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
			keyboardNav:true, //Use left & right arrows
			pauseOnHover:true, //Stop animation while hovering
			manualAdvance:false, //Force manual transitions
			captionOpacity:0.8, //Universal caption opacity
			beforeChange: function(){},
			afterChange: function(){},
			slideshowEnd: function(){} //Triggers after all slides have been shown
		});
	});
/* ]]> */
</script>
<?php
}

if (!is_admin()  ) {
	add_action('init', 'NivoInit');
	add_action('wp_head', 'NivoHeader');
}
?>
