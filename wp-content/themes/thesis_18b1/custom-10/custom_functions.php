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
  $delimiter = '<li>&raquo;</li>';
    $home = 'Home'; // text for the 'Home' link
    $before = '<li><span class="current">'; // tag before the current crumb
    $after = '</span></li>'; // tag after the current crumb

    if ( !is_home() && !is_front_page() || is_paged() ) {

      echo '<div id="crumbs">';

      global $post;
      $homeLink = get_bloginfo('url');
      echo '<li class="home"><a href="' . $homeLink . '">' . $home . '</a></li> ' . $delimiter . ' ';

      if ( is_category() ) {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        $thisCat = $cat_obj->term_id;
        $thisCat = get_category($thisCat);
        $parentCat = get_category($thisCat->parent);
        if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
        echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;

      } elseif ( is_day() ) {
        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('d') . $after;

      } elseif ( is_month() ) {
        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('F') . $after;

      } elseif ( is_year() ) {
        echo $before . get_the_time('Y') . $after;

      } elseif ( is_single() && !is_attachment() ) {
        if ( get_post_type() != 'post' ) {
          $post_type = get_post_type_object(get_post_type());
          $slug = $post_type->rewrite;
          echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
          echo $before . get_the_title() . $after;
        } else {
          $cat = get_the_category(); $cat = $cat[0];
          echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
          echo $before . get_the_title() . $after;
        }

      } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
        $post_type = get_post_type_object(get_post_type());
        echo $before . $post_type->labels->singular_name . $after;

      } elseif ( is_attachment() ) {
        $parent = get_post($post->post_parent);
        $cat = get_the_category($parent->ID); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;

      } elseif ( is_page() && !$post->post_parent ) {
        echo $before . get_the_title() . $after;

      } elseif ( is_page() && $post->post_parent ) {
        $parent_id  = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
          $parent_id  = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;

      } elseif ( is_search() ) {
        echo $before . 'Search results for "' . get_search_query() . '"' . $after;

      } elseif ( is_tag() ) {
        echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;

      } elseif ( is_author() ) {
         global $author;
        $userdata = get_userdata($author);
        echo $before . 'Articles posted by ' . $userdata->display_name . $after;

      } elseif ( is_404() ) {
        echo $before . 'Error 404' . $after;
      }

      if ( get_query_var('paged') ) {
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
        echo __('Page') . ' ' . get_query_var('paged');
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
      }

      echo '</div>';

    }
    }
function display_breadcrumbs() {
?>
  <a name="top"></a>
  <div class="breadcrumbs">
    <ul class="crumbs"><?php thesis_breadcrumbs(); ?></ul>
    <h1><?php the_title(); ?></h1>
    <ul class="share-links">
      <!-- email link -->
      <li>
        <a href="mailto:?subject=<?php urlencode(the_title()) ?>&body=<?php urlencode(the_permalink()) ?>">
          <img src="/wp-content/themes/thesis_18b1/custom-10/images/link-email.png" alt="email page link"/>
        </a>
      </li>
      <!-- print friendly link -->
      <li>
        <?php if(function_exists('pf_show_link')){echo pf_show_link();} ?>
      </li>
    </ul>
  </div><?php
	}
 

