<?php
/**
 * class thesis_comments
 *
 * @package Thesis
 * @since 1.7
 */
class thesis_comments {
	function output_comments($comments, $user_data, $depth = 3) {
		global $thesis_design;
		$tab = str_repeat("\t", $depth);
		echo "$tab<div id=\"comments\">\n";

		foreach ($comments as $comment) { #wp
			if ($comment->comment_type == 'trackback' || $comment->comment_type == 'pingback')
				$this->linkbacks[] = $comment;
			else
				$this->comments[] = $comment;
		}

		if (is_array($thesis_design->comments)) {
			foreach ($thesis_design->comments as $element_name => $element)
				if ($element['show']) call_user_func(array($this, $element_name), $user_data, $depth + 1);
		}

		echo "$tab</div>\n";
	}

	function comments($user_data, $depth = 4) {
		if ($this->comments) {
			$tab = str_repeat("\t", $depth);
			thesis_comments_intro(count($this->comments), comments_open()); #wp
			thesis_comments_navigation();

			echo "$tab<dl id=\"comment_list\">\n";
			thesis_list_comments();
			echo "$tab</dl>\n";

			thesis_comments_navigation(2);
		}

		thesis_hook_after_comments();
	}

	function trackbacks($user_data, $depth = 4) {
		if ($this->linkbacks) {
			$tab = str_repeat("\t", $depth);
			thesis_comments_intro(count($this->linkbacks), pings_open(), 'trackbacks'); #wp

			echo "$tab<ul id=\"trackback_list\">\n";
			foreach ($this->linkbacks as $comment)
				echo "$tab\t<li>" . thesis_trackback_link($comment) . thesis_trackback_date($comment) . "</li>\n"; #filter
			echo "$tab</ul>\n";
		}
	}

	function form($user_data, $depth = 4) {
		global $thesis_design, $post;

		if (comments_open()) { #wp
			$tab = str_repeat("\t", $depth);
			if (get_option('comment_registration') && !$user_data['user_ID']) { #wp
				echo "$tab<div class=\"login_alert\">\n";
				echo "$tab\t<p>" . sprintf(__('You must <a href="%s" rel="nofollow">log in</a> to post a comment.', 'thesis'), wp_login_url(get_permalink())) . "</p>\n"; #wp
				echo "$tab</div>\n";
			}
			else {
				echo "$tab<div id=\"respond\">\n";
				echo "$tab\t<div id=\"respond_intro\">\n";

				if (get_option('thread_comments')) cancel_comment_reply_link(__('Cancel reply', 'thesis')); #wp

				echo "$tab\t\t<p>" . apply_filters('thesis_comment_form_title', __('Leave a Comment', 'thesis')) . "</p>\n"; #filter
				echo "$tab\t</div>\n";
				echo "$tab\t<form action=\"" . get_option('siteurl') . "/wp-comments-post.php\" method=\"post\" id=\"commentform\">\n"; #wp
				thesis_hook_comment_form_top(); #hook

				if ($user_data['user_ID']) // #wp
					echo "$tab\t\t<p>" . sprintf(__('Logged in as <a href="%1$s" rel="nofollow">%2$s</a>.', 'thesis'), get_option('siteurl') . '/wp-admin/profile.php', $user_data['user_identity']) . ' ' . sprintf(__('<a href="%s" title="Log out of this account" rel="nofollow">Logout &rarr;</a>', 'thesis'), wp_logout_url(get_permalink())) . "</p>\n"; #wp
				else {
?>
						<p><input class="text_input" type="text" name="author" id="author" value="<?php echo $user_data['comment_author']; ?>" tabindex="1"<?php if ($user_data['req']) echo ' aria-required="true"'; ?> /><label for="author"><?php _e('Name', 'thesis'); if ($user_data['req']) _e(' <span class="required" title="Required">*</span>', 'thesis'); ?></label></p>
						<p><input class="text_input" type="text" name="email" id="email" value="<?php echo $user_data['comment_author_email']; ?>" tabindex="2"<?php if ($user_data['req']) echo ' aria-required="true"'; ?> /><label for="email"><?php _e('E-mail', 'thesis'); if ($user_data['req']) _e(' <span class="required" title="Required">*</span>', 'thesis'); ?></label></p>
						<p><input class="text_input" type="text" name="url" id="url" value="<?php echo $user_data['comment_author_url']; ?>" tabindex="3" /><label for="url"><?php _e('Website', 'thesis'); ?></label></p>
<?php 
				}

				thesis_hook_comment_field(); #hook
				echo "$tab\t\t<p class=\"comment_box\">\n";
				echo "$tab\t\t\t<textarea name=\"comment\" id=\"comment\" tabindex=\"4\" cols=\"40\" rows=\"8\"></textarea>\n";
				echo "$tab\t\t</p>\n";

				thesis_hook_after_comment_box(); #hook

				echo "$tab\t\t<p class=\"remove_bottom_margin\">\n";
				echo "$tab\t\t\t<input name=\"submit\" class=\"form_submit\" type=\"submit\" id=\"submit\" tabindex=\"5\" value=\"" . __('Submit', 'thesis') . "\" />\n";
				comment_id_fields(); #wp
				echo "$tab\t\t</p>\n";

				thesis_hook_comment_form_bottom(); #hook
				do_action('comment_form', $post->ID); #wp

				echo "$tab\t</form>\n";
				echo "$tab</div>\n";
			}
		}
		elseif ($thesis_design->display['comments']['show_closed']) {
			echo "$tab<div class=\"comments_closed\">\n";
			echo "$tab\t<p>" . apply_filters('thesis_comments_closed', __('Comments on this entry are closed.', 'thesis')) . "</p>\n"; #filter
			echo "$tab</div>\n";
		}
	}
}

/**
 * class thesis_comment
 *
 * Comment handling.
 *
 * @since 1.5
 */
class thesis_comment extends Walker {
	var $tree_type = 'comment';
	var $db_fields = array('parent' => 'comment_parent', 'id' => 'comment_ID');

	function start_lvl(&$output, $depth, $args) {
		$GLOBALS['comment_depth'] = $depth + 1;
		echo "\t\t\t\t\t<dl class=\"children\">\n";
	}

	function end_lvl(&$output, $depth, $args) {
		$GLOBALS['comment_depth'] = $depth + 1;
		echo "\t\t\t\t\t</dl>\n";
	}

	function start_el(&$output, $comment, $depth, $args) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
		$classes = comment_class(empty($args['has_children']) ? '' : 'parent', $comment, '', false);
		echo "\t\t\t\t\t<dt $classes id=\"comment-" . get_comment_ID() . "\">\n";
		$comment_meta = new thesis_comment_meta;
		$comment_meta->build(array('comment' => $comment, 'args' => $args, 'depth' => $depth));
		echo "\t\t\t\t\t</dt>\n";
		echo "\t\t\t\t\t<dd $classes>\n";
		$comment_body = new thesis_comment_body;
		$comment_body->build(array('comment' => $comment, 'args' => $args, 'depth' => $depth));
		// </dd> excluded as it is added by end_el().
	}

	function end_el(&$output, $comment, $depth, $args) {
		echo "\t\t\t\t\t</dd>\n";
	}
}

/**
 * function thesis_list_comments()
 *
 * List comments — Warning: Here be dragons.
 *
 * @param string|array $args Formatting options
 * @param array $comments Optional array of comment objects.  Defaults to $wp_query->comments
 * @since 1.5
 * @usedby ../../comments.php
 * @uses thesis_comment
 */
function thesis_list_comments() {
	global $wp_query, $comment_alt, $comment_depth, $comment_thread_alt, $overridden_cpage, $in_comment_loop;
	$in_comment_loop = true;
	$comment_alt = $comment_thread_alt = 0;
	$comment_depth = 1;
	$r = array('walker' => null, 'max_depth' => '', 'type' => 'comment', 'page' => '', 'per_page' => '', 'reverse_top_level' => null, 'reverse_children' => '');

	// Get our comments.
	$wp_query->comments_by_type = &separate_comments($wp_query->comments);
	$_comments = $wp_query->comments_by_type['comment'];

	// Are we paginating?
	if (get_option('page_comments'))
		$r['per_page'] = get_query_var('comments_per_page');
	if (empty($r['per_page'])) {
		$r['per_page'] = 0;
		$r['page'] = 0;
	}

	// How deep does our comments hole go?
	$r['max_depth'] = (get_option('thread_comments')) ? get_option('thread_comments_depth') : -1;

	// Determine page number of comments.
	if (empty($overridden_cpage)) {
		$r['page'] = get_query_var('cpage');
	} else {
		$threaded = (-1 == $r['max_depth']) ? false : true;
		$r['page'] = ('newest' == get_option('default_comments_page')) ? get_comment_pages_count($_comments, $r['per_page'], $threaded) : 1;
		set_query_var('cpage', $r['page']);
	}

	// Validate our page number.
	$r['page'] = intval($r['page']);
	if (0 == $r['page'] && 0 != $r['per_page'])
		$r['page'] = 1;

	// Which order should comments be displayed in?
	$r['reverse_top_level'] = ('desc' == get_option('comment_order')) ? TRUE : FALSE;

	// Convert array into handy variables.
	extract($r, EXTR_SKIP);

	// Insantiate comments class.
	if (empty($walker))
		$walker = new thesis_comment;

	if (($r['per_page'] > 0) ? (($r['max_depth'] < 0) ? true : false) : true)
		$GLOBALS['comment_vars'] = array('per_page' => $r['per_page'], 'current' => $r['page']);

	$walker->paged_walk($_comments, $max_depth, $page, $per_page, $r);
	$wp_query->max_num_comment_pages = $walker->max_pages;
	$in_comment_loop = false;
}

class thesis_comment_meta extends thesis_comment {
	function build($comment) {
		global $thesis_design;
		$this->meta = $thesis_design->comments['comments']['options']['meta'];

		if (is_array($this->meta)) {
			foreach ($this->meta as $element_name => $element)
				if ($element['show']) $output .= call_user_func(array($this, $element_name), $comment) . "\n";
		}

		thesis_hook_before_comment_meta();
		if ($output) echo $output;
		thesis_hook_after_comment_meta();
	}

	function author($comment) {
		return "<span class=\"comment_author\">" . get_comment_author_link() . "</span>";
	}

	function avatar($comment) {
		$avatar = get_avatar(get_comment_author_email(), $this->meta['avatar']['options']['size'], '');
		$author_url = get_comment_author_url();
		$avatar_output = (empty($author_url) || $author_url == 'http://') ? $avatar : "<a href=\"$author_url\" rel=\"nofollow\">$avatar</a>";
		return '<span class="avatar">' . apply_filters('thesis_avatar', $avatar_output) . '</span>'; #filter
	}

	function date($comment) {
		$timestamp = ($this->meta['date']['options']['time']) ? sprintf(__('%1$s at %2$s'), get_comment_date($this->meta['date']['options']['date_format']), get_comment_time()) : get_comment_date($this->meta['date']['options']['date_format']);
		$text = ($this->meta['number']['show']) ? $timestamp : '<a href="#comment-' . get_comment_ID() . '" title="Permalink to this comment" rel="nofollow">' . $timestamp . '</a>';
		return '<span class="comment_time">' . apply_filters('thesis_comment_date', $text) . '</span>'; #filter
	}

	function number($comment) {
		if (!$GLOBALS['comment_vars']) return; else $c = $GLOBALS['comment_vars'];
		$number = ($c['current'] - 1) * $c['per_page'] + did_action('thesis_hook_before_comment_meta') + 1;
		return '<span class="comment_num"><a href="#comment-' . get_comment_ID() . "\" title=\"Permalink to this comment\" rel=\"nofollow\">$number</a></span>";
	}

	function edit($comment) {
		if (get_edit_comment_link()) return '<span class="edit_comment">' . apply_filters('thesis_edit_comment_link', '<a href="' . get_edit_comment_link() . '" rel="nofollow">' . __('edit', 'thesis') . '</a>') . '</span>'; #filter
	}
}

class thesis_comment_body extends thesis_comment {
	function build($comment) {
		global $thesis_design;
		$this->body = $thesis_design->comments['comments']['options']['body'];

		if (is_array($this->body)) {
			foreach ($this->body as $element_name => $element)
				if ($element['show']) $output .= call_user_func(array($this, $element_name), $comment);
		}

		echo '<div class="format_text" id="comment-body-' . get_comment_ID() . "\">\n";
		if ($output) echo $output;
		thesis_hook_after_comment();
		echo "</div>\n";
	}
	
	function text($comment) {
		$approved = ($comment['comment']->comment_approved == '0') ? '<p class="comment_moderated">' . __('Your comment is awaiting moderation.', 'thesis') . "</p>\n" : '';
		return $approved . apply_filters('thesis_comment_text', get_comment_text()); #filter
	}
	
	function reply($comment) {
		if (get_option('thread_comments')) return '<p class="reply">' . get_comment_reply_link(array_merge($comment['args'], array('add_below' => 'comment-body', 'depth' => $comment['depth']))) . '</p>' . "\n";
	}
}