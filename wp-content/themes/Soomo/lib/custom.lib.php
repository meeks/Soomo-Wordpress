<?php
/**
*	Custom function to get current URL
**/
function curPageURL() {
 	$pageURL = 'http';
 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 	$pageURL .= "://";
 	if ($_SERVER["SERVER_PORT"] != "80") {
 	 $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 	} else {
 	 $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 	}
 	return $pageURL;
}
    
function soomo_debug($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
    
/**
*	Setup blog comment style
**/
function soomo_comment($comment, $args, $depth) 
{
	$GLOBALS['comment'] = $comment; ?>
   
	<div class="comment" id="comment-<?php comment_ID() ?>">
		<div class="left">
         	<?php echo get_avatar($comment,$size='50',$default='<path_to_url>' ); ?>
      	</div>
      

      	<div class="right">
			<?php if ($comment->comment_approved == '0') : ?>
         		<em><?php _e('(Your comment is awaiting moderation.)') ?></em>
         		<br />
      		<?php endif; ?>
			
      		<?php comment_text() ?>
      		<p class="comment-reply-link"><?php comment_reply_link(array_merge( $args, array('depth' => $depth,
'reply_text' => '
Reply', 'login_text' => 'Log in to reply to this', 'max_depth' => $args['max_depth']))) ?></p>

      	</div>
    </div>
<?php
}


function soomo_twitter($echo = TRUE)
{
	include("twitter.lib.php");
	$cache_path = TEMPLATEPATH."/cache/";
	$tweets_cache = $cache_path."twitter.txt";
	
	if(!is_dir($cache_path))
	{
		mkdir($cache_path);
	}
	
	//if read from cache if file more than 60 minutes cache
	if(file_exists($tweets_cache) && (time()-filemtime($tweets_cache) < 3600))
	{
		$timeline = simplexml_load_file($tweets_cache);
	}
	//if get from twitter
	else
	{
		//Get twitter username and password
		$username = get_option('mx_twitter_username');
		$password = get_option('mx_twitter_password');
		
		$twitter = new Twitter($username, $password);
		
		// This array is passed into getMentions, for this example we will pass a blank array
		// Options can include: page, count, since_id, max_id
		$arrOptions = Array('count' => 5);
		
		$timeline = $twitter->getUserTimeline($arrOptions);
	
		if(is_dir(TEMPLATEPATH.'/cache'))
		{
			// Open the file and erase the contents if any
			$fp = fopen($tweets_cache, "w");
				
			// Write the data to the file
			fwrite($fp, $timeline);
				
				
			// Close the file
			fclose($fp);
				
		}
		
		// Convert the xml document into an array
		$timeline = simplexml_load_string($timeline);
	}
	
	$return_html = '';
	
	if(isset($timeline->status) && !empty($timeline->status))
	{
		
		$return_html.= '<h4>From Twitter <img src="'.get_bloginfo( 'stylesheet_directory' ).'/images/icon_twitter.png" alt="" class="mid_align" style="margin-left: 10px" /></h4>';
		
		$return_html.= '<ul class="posts twitter">';
	
	
		foreach($timeline->status as $status)
		{ 
	
			$return_html.= '<li>';
			$return_html.= '<a href="http://twitter.com/'.$username.'/status/'.$status->id.'">'.$status->text.'</a> '.soomo_ago(strtotime($status->created_at));
			$return_html.= '</li>';
	
		}
	
		$return_html.= '</ul>';
	

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}


function soomo_ago($timestamp){
   $difference = time() - $timestamp;
   $periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");
   for($j = 0; $difference >= $lengths[$j]; $j++)
   $difference /= $lengths[$j];
   $difference = round($difference);
   if($difference != 1) $periods[$j].= "s";
   $text = "$difference $periods[$j] ago";
   return $text;
}


// Substring without losing word meaning and
// tiny words (length 3 by default) are included on the result.
// "..." is added if result do not reach original string length

function soomo_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}


/**
*	Setup recent posts widget
**/
function soomo_posts($sort = 'recent', $echo = TRUE) 
{
	$mx_blog_cat = get_option('mx_blog_cat'); 
	$return_html = '';
	
	if($sort == 'recent')
	{
		$posts = get_posts('numberposts=3&order=DESC&orderby=date&category='.$mx_blog_cat);
		$title = 'Recent Posts';
	}
	else
	{
		global $wpdb;
		
		$query = "SELECT ID, post_title, post_content FROM {$wpdb->posts} p ";
		$query.= "LEFT OUTER JOIN wp_term_relationships r ON r.object_id = p.ID ";
		$query.= "LEFT OUTER JOIN wp_terms t ON t.term_id = r.term_taxonomy_id WHERE t.term_id = ".$mx_blog_cat." AND p.post_type = 'post' ";
		$query.= "ORDER BY p.comment_count DESC LIMIT 0,2";
		
		$posts = $wpdb->get_results($query);
		$title = 'Popular Posts';
	}
	
	if(!empty($posts))
	{

		$return_html.= '<h4><?=$title?></h4>';
		$return_html.= '<ul class="posts blog">';

			foreach($posts as $post)
			{
				$image_thumb = get_post_meta($post->ID, 'blog_thumb_image_url', false);

				$return_html.= '<li><a href="'.get_permalink($post->ID).'">';
				$return_html.= $post->post_title.'</a><br />';
				$return_html.= soomo_substr($post->post_content, 50).'</li>';

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}


function theme_queue_js(){
  if (!is_admin()){
    if (!is_page() AND is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}
add_action('get_header', 'theme_queue_js');

?>