<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'wpdb');

/** MySQL database username */
define('DB_USER', 'soomo');

/** MySQL database password */
define('DB_PASSWORD', '28801');

/** MySQL hostname */
define('DB_HOST', 'wordpress.cr5indqqfd8o.us-east-1.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}+:-pi_`i2_HBXqkik~Lis{/Bn0pRv,!M(Lo]_J+]WU@Y=:(|DOXGuhY|_^e+)W)');
define('SECURE_AUTH_KEY',  ',NRQ{I$?gDoZjSzFoQU-O8{63q5]_kqnxQv-~x1GN3O.O<0#|yE;]%=S-9ngPeMI');
define('LOGGED_IN_KEY',    '*g@KfrI]*MXf}}4#VYeB&<5T>k)+WDa]6[?:qi6-zpl%G:s!*jFeAp<B<50F*P5(');
define('NONCE_KEY',        '_qF%EoT#@6%SWH<MyY-8[J-c5u8&h+(Z|I~|cz|<x=HA<HR8dWkl^w[)li+vUMQ5');
define('AUTH_SALT',        'jW-OS1Rs/oqX]n/5eu4VIPU}Gys&tA| zhX~yf#E)B+rUrZJ?5|2e`p XR+Vi{r5');
define('SECURE_AUTH_SALT', 'a|-7&SWz=%IF6,7~O G$,mhK8|dg*9_C6_|AS^l]HICU|/aegM#f&<!4KE!PM}Ki');
define('LOGGED_IN_SALT',   'j#pKMJ&T:Yt|b^?ltQj=har,)hniN|s^:#%>?IWE.J.t_6a@VA0 M1@2%rak:{!x');
define('NONCE_SALT',       '=b#j{ z;.%zU+3>tZ$M{K/D~Vt!BxqFd_yvQQIla<i3M{&CV>-ER3.UPWIODVNws');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define('WP_ALLOW_MULTISITE', true);
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'soomopublishing.com' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
define( 'SUNRISE', 'on' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
