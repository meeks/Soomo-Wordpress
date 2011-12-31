<?php

function thesis_content_classes() {	
	if (have_posts()) {
		if (!is_page())
			$classes[] = 'hfeed';

		if (is_array($classes))
			$classes = implode(' ', $classes);

		if ($classes) {
			$classes = apply_filters('thesis_content_classes', $classes);
			return " class=\"$classes\"";
		}
	}
}

function thesis_headline_area($post_count = false, $post_image = false) {
	if (apply_filters('thesis_show_headline_area', true)) {
?>
				<div class="headline_area">
<?php

	thesis_hook_before_headline($post_count);

	if ($post_image['show'] && $post_image['y'] == 'before-headline')
		echo $post_image['output'];

	if (is_404()) {
		echo "\t\t\t\t\t<h1>";
		thesis_hook_404_title();
		echo "</h1>\n";
	}
	elseif (is_page()) {
		if (is_front_page())
			echo "\t\t\t\t\t<h2>" . get_the_title() . "</h2>\n";
		else
			echo "\t\t\t\t\t<h1>" . get_the_title() . "</h1>\n";

		if ($post_image['show'] && $post_image['y'] == 'after-headline')
			echo $post_image['output'];

		thesis_hook_after_headline($post_count);
		thesis_byline();
	}
	else {
		if (is_single()) {
?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
<?php
		}
		else {
?>
					<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<?php
		}
		
		if ($post_image['show'] && $post_image['y'] == 'after-headline')
			echo $post_image['output'];

		thesis_hook_after_headline($post_count);
		thesis_byline($post_count);
		thesis_post_categories();
	}
?>
				</div>
<?php
	}
}

function thesis_show_byline() {
	global $thesis_design;

	if (is_page()) {
		if ($thesis_design->display['byline']['page']['author'] || $thesis_design->display['byline']['page']['date'] || ($thesis_design->display['byline']['num_comments']['show'] && comments_open() && !$thesis_design->comments['disable_pages']))
			return true;
	}
	else {
		if ($thesis_design->display['byline']['author']['show'] || $thesis_design->display['byline']['date']['show'] || ($thesis_design->display['byline']['num_comments']['show'] && (comments_open() || get_comments_number() > 0)))
			return true;
	}
}

function thesis_byline($post_count = false) {
	global $thesis_design;

	if (thesis_show_byline()) {
		if (is_page()) {
			$author = $thesis_design->display['byline']['page']['author'];
			$date = $thesis_design->display['byline']['page']['date'];

			if (!$thesis_design->display['comments']['disable_pages'] && comments_open() && $thesis_design->display['byline']['num_comments']['show'])
				$show_comments = true;
		}
		else {
			$author = $thesis_design->display['byline']['author']['show'];
			$date = $thesis_design->display['byline']['date']['show'];

			if ($thesis_design->display['byline']['num_comments']['show'] && (comments_open() || get_comments_number() > 0))
				$show_comments = true;
		}
	}
	elseif ($thesis_design->display['admin']['edit_post'] && is_user_logged_in())
		$edit_link = true;
	elseif ($_GET['template'])
		$author = $date = true;

	if ($author || $date || $show_comments || $edit_link) {
		echo "\t\t\t\t\t<p class=\"headline_meta\">";

		if ($author)
			thesis_author();

		if ($author && $date)
			echo ' ' . __('on', 'thesis') . ' ';

		if ($date)
			echo '<abbr class="published" title="' . get_the_time('Y-m-d') . '">' . get_the_time(get_option('date_format')) . '</abbr>';
		
		if ($show_comments) {
			if ($author || $date)
				$sep = ' &middot; ';

			echo $sep . '<span><a href="' . get_permalink() . '#comments" rel="nofollow">';
			comments_number(__('0 comments', 'thesis'), __('1 comment', 'thesis'), __('% comments', 'thesis'));
			echo '</a></span>';
		}

		thesis_hook_byline_item($post_count);

		if (($author || $date || $show_comments) && $thesis_design->display['admin']['edit_post'])
			edit_post_link(__('edit', 'thesis'), '<span class="edit_post pad_left">[', ']</span>');
		elseif ($thesis_design->display['admin']['edit_post'])
			edit_post_link(__('edit', 'thesis'), '<span class="edit_post">[', ']</span>');

		echo "</p>\n";
	}
}

function thesis_author() {
	global $thesis_design;

	if ($thesis_design->display['byline']['author']['link']) {
		if ($thesis_design->display['byline']['author']['nofollow'])
			$nofollow = ' rel="nofollow"';

		$author = '<a href="' . get_author_posts_url(get_the_author_ID()) . '" class="url fn"' . $nofollow .'>' . get_the_author() . '</a>';
	}
	else {
		$author = get_the_author();
		$fn = ' fn';
	}

	echo __('by', 'thesis') . " <span class=\"author vcard$fn\">$author</span>";
}

function thesis_post_categories() {
	global $thesis_design;

	if ($thesis_design->display['byline']['categories']['show'])
		echo "\t\t\t\t\t<p class=\"headline_meta\">" . __('in', 'thesis') . ' <span>' . get_the_category_list(',') . "</span></p>\n";
}

function thesis_post_tags() {
	global $thesis_design;

	if ((is_single() && $thesis_design->display['tags']['single']) || (!is_single() && $thesis_design->display['tags']['index'])) {
		$post_tags = get_the_tags();

		if ($post_tags) {
			echo "\t\t\t\t\t<p class=\"post_tags\">" . __('Tagged as:', 'thesis') . "\n";
			$num_tags = count($post_tags);
			$tag_count = 1;

			if ($thesis_design->display['tags']['nofollow'])
				$nofollow = ' nofollow';

			foreach ($post_tags as $tag) {			
				$html_before = "\t\t\t\t\t\t<a href=\"" . get_tag_link($tag->term_id) . "\" rel=\"tag$nofollow\">";
				$html_after = '</a>';
				
				if ($tag_count < $num_tags)
					$sep = ", \n";
				elseif ($tag_count == $num_tags)
					$sep = "\n";
				
				echo $html_before . $tag->name . $html_after . $sep;
				$tag_count++;
			}
			
			echo "\t\t\t\t\t</p>\n";
		}
	}
}

function thesis_archive_intro($depth = 3) {
	global $thesis_terms, $wp_query; #wp
	$tab = str_repeat("\t", $depth);
	$output = "$tab<div id=\"archive_intro\">\n";

	if ($wp_query->is_category) { #wp
		$output .= "$tab\t<h1>" . apply_filters('thesis_archive_intro_headline', (($thesis_terms->categories[$wp_query->query_vars['cat']]['headline']) ? trim(wptexturize(stripslashes($thesis_terms->categories[$wp_query->query_vars['cat']]['headline']))) : single_cat_title('', false))) . "</h1>\n"; #wp
		if ($thesis_terms->categories[$wp_query->query_vars['cat']]['content'])
			$output .= "$tab\t<div class=\"format_text\">\n" . apply_filters('thesis_archive_intro_content', $thesis_terms->categories[$wp_query->query_vars['cat']]['content']) . "$tab\t</div>\n"; #filter
	}
	elseif ($wp_query->is_tag) { #wp
		$output .= "$tab\t<h1>" . apply_filters('thesis_archive_intro_headline', (($thesis_terms->tags[$wp_query->query_vars['tag_id']]['headline']) ? trim(wptexturize(stripslashes($thesis_terms->tags[$wp_query->query_vars['tag_id']]['headline']))) : single_tag_title('', false))) . "</h1>\n"; #wp
		if ($thesis_terms->tags[$wp_query->query_vars['tag_id']]['content'])
			$output .= "<div class=\"format_text\">\n" . apply_filters('thesis_archive_intro_content', $thesis_terms->tags[$wp_query->query_vars['tag_id']]['content']) . "</div>\n"; #filter
	}
	elseif ($wp_query->is_author) #wp
		$output .= "$tab\t<h1>" . apply_filters('thesis_archive_intro_headline', get_author_name(get_query_var('author'))) . "</h1>\n"; #wp
	elseif ($wp_query->is_day) #wp
		$output .= "$tab\t<h1>" . apply_filters('thesis_archive_intro_headline', get_the_time('l, F j, Y')) . "</h1>\n"; #wp
	elseif ($wp_query->is_month) #wp
		$output .= "$tab\t<h1>" . apply_filters('thesis_archive_intro_headline', get_the_time('F Y')) . "</h1>\n"; #wp
	elseif ($wp_query->is_year) #wp
		$output .= "$tab\t<h1>" . apply_filters('thesis_archive_intro_headline', get_the_time('Y')) . "</h1>\n"; #wp
	elseif ($wp_query->is_search) #wp
		$output .= "$tab\t<h1>" . apply_filters('thesis_archive_intro_headline', attribute_escape(get_search_query())) . "</h1>\n"; #wp

	$output .= "$tab</div>\n";
	echo apply_filters('thesis_archive_intro', $output);
}

function thesis_get_author_data($author_id, $field = false) {
	if ($author_id) {
		$author = get_userdata($author_id);
		return ($field && !empty($author->$field)) ? $author->$field : $author;
	}
}

function thesis_read_more_text() {
	global $thesis_design;
	$read_more = trim(wptexturize(strip_tags(stripslashes(get_post_meta(get_the_ID(), 'thesis_readmore', true)))));
	
	if ($read_more != '')
		return $read_more;
	elseif ($thesis_design->display['posts']['read_more_text'])
		return urldecode($thesis_design->display['posts']['read_more_text']);
	else
		return __('[click to continue&hellip;]', 'thesis');
}

function thesis_post_navigation() {
	global $wp_query;

	if ($wp_query->is_home || $wp_query->is_archive || $wp_query->is_search) {
		$total_pages = $wp_query->max_num_pages;
		$current_page = $wp_query->query_vars['paged'];

		if ($total_pages > 1) {
			echo "\t\t\t<div class=\"prev_next\">\n";

			if ($current_page <= 1) {
				echo "\t\t\t\t<p class=\"previous\">";
				if (is_search())
					next_posts_link('&larr; ' . __('Previous Results', 'thesis'));
				else
					next_posts_link('&larr; ' . __('Previous Entries', 'thesis'));
				echo "</p>\n";
			}
			elseif ($current_page < $total_pages) {
				echo "\t\t\t\t<p class=\"previous floated\">";
				if (is_search())
					next_posts_link('&larr; ' . __('Previous Results', 'thesis'));
				else
					next_posts_link('&larr; ' . __('Previous Entries', 'thesis'));
				echo "</p>\n";
			
				echo "\t\t\t\t<p class=\"next\">";
				if (is_search())
					previous_posts_link(__('Next Results', 'thesis') . ' &rarr;');
				else
					previous_posts_link(__('Next Entries', 'thesis') . ' &rarr;');
				echo "</p>\n";
			}
			elseif ($current_page >= $total_pages) {
				echo "\t\t\t\t<p class=\"next\">";
				if (is_search())
					previous_posts_link(__('Next Results', 'thesis') . ' &rarr;');
				else
					previous_posts_link(__('Next Entries', 'thesis') . ' &rarr;');
				echo "</p>\n";
			}
		
			echo "\t\t\t</div>\n\n";
		}
	}
}

function thesis_prev_next_posts() {
	global $thesis_design;

	if (is_single() && $thesis_design->display['posts']['nav']) {
		$previous = get_previous_post();
		$next = get_next_post();

		if ($previous || $next) {
			echo "\t\t\t\t\t<div class=\"prev_next post_nav\">\n";

			if ($previous) {
				if ($previous && $next)
					$add_class = ' class="previous"';

				echo "\t\t\t\t\t\t<p$add_class>" . __('Previous post:', 'thesis') . ' ';
				previous_post_link('%link', '%title');
				echo "</p>\n";
			}

			if ($next) {
				echo "\t\t\t\t\t\t<p>" . __('Next post:', 'thesis') . ' ';
				next_post_link('%link', '%title');
				echo "</p>\n";
			}

			echo "\t\t\t\t\t</div>\n";
		}
	}
}

/**
 * Handle [caption] and [wp_caption] shortcodes.
 *
 * This function is mostly copy pasta from WP (wp-includes/media.php),
 * but with minor alteration to play more nicely with our styling.
 *
 * The supported attributes for the shortcode are 'id', 'align', 'width', and
 * 'caption'. These are unchanged from WP's default.
 *
 * @since 2.5
 *
 * @param array $attr Attributes attributed to the shortcode.
 * @param string $content Optional. Shortcode content.
 * @return string
 */
function thesis_img_caption_shortcode($attr, $content = null) {
	// Allow this to be overriden.
	$output = apply_filters('thesis_img_caption_shortcode', '', $attr, $content);

	if ($output != '')
		return $output;

	// Get necessary attributes or use the default.
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	// Not enough information to form a caption, so just dump the image.
	if (1 > (int) $width || empty($caption))
		return $content;

	// For unique styling, create an ID.
	if ($id)
		$id = ' id="' . $id . '"';

	// Format our captioned image.
	$output = "<div$id class=\"wp-caption $align\" style=\"width: " . (int) $width . "px\">
	$content
	<p class=\"wp-caption-text\">$caption</p>\n</div>";

	// Return our result.
	return $output;
}