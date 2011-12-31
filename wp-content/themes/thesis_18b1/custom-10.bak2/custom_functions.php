<?php

// Using hooks is absolutely the smartest, most bulletproof way to implement things like plugins,
// custom design elements, and ads. You can add your hook calls below, and they should take the 
// following form:
// add_action('thesis_hook_name', 'function_name');
// The function you name above will run at the location of the specified hook. The example
// hook below demonstrates how you can insert Thesis' default recent posts widget above
// the content in Sidebar 1:
// add_action('thesis_hook_before_sidebar_1', 'thesis_widget_recent_posts');

// Delete this line, including the dashes to the left, and add your hooks in its place.

// DPL removing the footer attribution
remove_action('thesis_hook_footer', 'thesis_attribution');



/**
 * function custom_bookmark_links() - outputs an HTML list of bookmarking links
 * NOTE: This only works when called from inside the WordPress loop!
 * SECOND NOTE: This is really just a sample function to show you how to use custom functions!
 *
 * @since 1.0
 * @global object $post
*/

// remove navigation from header area and add to the content box
remove_action('thesis_hook_after_header', 'thesis_nav_menu');
add_action('thesis_hook_before_header', 'thesis_nav_menu');

// wrap content and sidebar in a div to give background color
add_action('thesis_hook_content_box_top', 'content_wrapper');
function content_wrapper(){
?>
  <div id="content-wrapper">
<?php  
}

add_action('thesis_hook_content_box_bottom', 'content_wrapper_end');
function content_wrapper_end(){
?>
  </div>
<?php  
}

function custom_bookmark_links() {
	global $post;
?>
<ul class="bookmark_links">
	<li><a rel="nofollow" href="http://delicious.com/save?url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>" onclick="window.open('http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>', 'delicious', 'toolbar=no,width=550,height=550'); return false;" title="Bookmark this post on del.icio.us">Bookmark this article on Delicious</a></li>
</ul>
<?php
}

add_action('thesis_hook_header','display_breadcrumbs');
function thesis_breadcrumbs() {
	echo '<li class="home"><a href="';
	echo get_option('home');
	echo '">';
	bloginfo('name');
	echo "</a></li>";
		if (is_category() || is_single()) {
			echo "<li>&nbsp;&nbsp;&#187;&nbsp;&nbsp;</li>";
			the_category(' &bull; ');
				if (is_single()) {
					echo "<li> &nbsp;&nbsp;&#187;&nbsp;&nbsp; </li><li>";
					the_title();
					echo "</li>";
				}
        } elseif (is_page()) {
            echo "<li>&nbsp;&nbsp;>&nbsp;&nbsp;</li><li>";
            echo the_title();
            echo "</li>";
		} elseif (is_search()) {
            echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
			echo '"<em>';
			echo the_search_query();
			echo '</em>"';
        }
    }
function display_breadcrumbs() {
?>
  <div class="breadcrumbs">
    <ul class="crumbs"><?php thesis_breadcrumbs(); ?></ul>
    <h1><?php the_title(); ?></h1>
  </div><?php
	}
 

