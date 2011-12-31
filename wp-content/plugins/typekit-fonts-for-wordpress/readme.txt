=== Typekit Fonts for WordPress ===
Contributors: jamescollins, glenn-om4
Donate link: http://om4.com.au/wordpress-plugins/#donate
Tags: typekit, fonts, font, design, wp, multisite, wpmu
Requires at least: 3.1
Tested up to: 3.2
Stable tag: 1.2

Use a range of hundreds of high quality fonts on your WordPress website by integrating the Typekit font service into your WordPress blog.

== Description ==

Allows you to embed and use [Typekit](http://www.typekit.com) fonts in your WordPress website without having to edit your theme.

Typekit offer a service that allows you to select from a range of hundreds of high quality fonts for your WordPress website. The fonts are applied using the font-face standard, so they are standards compliant, fully licensed and accessible.

To use this plugin you need to sign up with Typekit, install this plugin and then either configure some Typekit selectors or define your own CSS rules. Typekit selectors provide a quick and easy way to get fonts enabled on your site.  Using your own CSS rules (as explained in Typekit's Advanced tips) gives you more control and lets you access additional attributes such as font-weight. This plugin allows you to create your own CSS rules that use Typekit fonts without the need to edit/upload CSS style sheets. 

Detailed instructions are available on the plugin's settings page.

Compatible with WordPress Multisite.

This plugin is designed to function securely with both WordPress and WordPress Multisite. When the JavaScript Embed Code is entered on the settings page, the user account id is extracted from the embed code and the correctly formed Typekit Embed Code is included in the site header, so it is not possible to use the Embed Code field to include arbitrary JavaScript. The Custom CSS field is also filtered, and doesn't allow any HTML code to be entered.

If the website is using HTTPS/SSL, the SSL version of the Typekit embed code is automatically used instead.

See the [Typekit Fonts for WordPress Plugin](http://om4.com.au/wordpress-plugins/typekit-fonts-for-wordpress-plugin/) home page for further information.

== Installation ==

Installation of this plugin is simple:

1. Download the plugin files and copy to your Plugins directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Go to the WordPress Dashboard, and use Settings, Typekit Fonts to enter the whole 2 lines of your Typekit embed code.
1. If you want to setup some CSS selectors like the examples shown in the Advanced link, enter your CSS rules in the plugin settings as well.

== Frequently Asked Questions ==

= Where can I get help? =

There are detailed instructions on the plugin's settings page. See screenshot #2 for more information.

= Is this plugin secure? =

Yes, see the plugin's description for more information.

= Which web browser(s) does Typekit support? =

Please see [this page](http://getsatisfaction.com/typekit/topics/typekit_browser_support) for information on [Typekit web browser support](http://getsatisfaction.com/typekit/topics/typekit_browser_support). 

== Screenshots ==
1. Settings/configuration page
2. Detailed inline help

== Changelog ==

= 1.2 =
* Fix invalid HTML on settings page.
* Properly save/display settings.
* WordPress 3.2 compatibility.
* Translation/localization improvements.
* Fix localization deprecated notice (thanks to aradams for reporting).
* Store translation files in a /languages sub directory.

= 1.1 =
* WordPress 3.1 compatibility.

= 1.0.3 =
* Add support for HTTPS/SSL websites.
* WordPress 3.0.1 compatibility.

= 1.0.2 =
* Add instructions on how to use Typekit Kit Editor selectors.
* Add instructions on how to use font weights / styles. 

= 1.0.1 =
* WordPress 2.9 compatibility.
* Improve FAQ.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.2 =
* WordPress 3.2 compatibility, translation/localization improvements, invalid HTML fixes.

= 1.1 =
* WordPress 3.1 compatibility.