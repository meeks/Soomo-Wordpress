<?php
/*
Plugin Name: WP Require Auth
Version: 1.0.2
Plugin URI: http://johnny.chadda.se/projects/wp-require-auth/
Description: This plugin makes it mandatory to be logged in before viewing any content.
Author: Johnny Chadda
Author URI: http://johnny.chadda.se/
*/

class wprequireauth
{
	/*
	Make sure that the user is logged in if the page is not one of the following:
		* wp-login.php
		* wp-register.php
	*/
	
	function wprequireauth_check_auth()
	{
		if ((strpos($_SERVER["PHP_SELF"], "wp-login.php") === false) 
			&& (strpos($_SERVER['PHP_SELF'], 'wp-register.php') === false)
			&& (strpos($_SERVER['PHP_SELF'], 'async-upload.php') === false))
		{
			if (!is_user_logged_in())
			{
				auth_redirect();
			}
		}
	}
}

// Add the filter to Wordpress
add_filter('init', array('wprequireauth','wprequireauth_check_auth'));
?>