=== Q and A - FAQ Plugin ===
Contributors: daltonrooney 
Tags: FAQs, custom posts 
Requires at least: 3.0.1
Donate link: http://madebyraygun.com/donate
Tested up to: 3.1.2
Stable tag: 0.2.4

Create, categorize, and reorder FAQs and insert them into a page with a shortcode.

== Description ==

Create, categorize, and reorder FAQs and insert them into a page with a shortcode. Questions are shown/hidden with a nice jQuery animation, users without javascript enabled will click through to the single question page. Based on the new Custom Post Type in WordPress 3.0.

The plugin also includes functionality from the <a href="http://geekyweekly.com/mypageorder">My Page Order</a> plugin by Andrew Charlton.

== Installation ==

Extract the zip file and upload the contents to the wp-content/plugins/ directory of your WordPress installation and then activate the plugin from plugins page. 

The plugin registers a new custom post type, so you'll want to update your permalinks. No need to change your permalink structure, just go to "Settings->Permalinks" and click "Save Changes" without making any modifications.

Use the shortcode [qa] to insert your FAQs into a page.

If you want to sort your FAQs into categories, you can optionally use the cat attribute with the category slug. Example: [qa cat="cheese"] will return only FAQs in the "Cheese" category. You can find the category slug on the FAQ Categories page.

You can also insert a single FAQ with the format [aq id="1234"] where 1234 is the post ID.

* Note: the cat & the id attributes are mutually exclusive. Don't use both in the same shortcode.

Use the shortcode [search-qa] to insert a search form that will search only the FAQs.
		

== Frequently Asked Questions ==


= With Javascript disabled, clicking on FAQ titles causes a 404 error.

Did you update your permalinks? (See installation).

= Can it do this, this, or that? =

Not yet. Maybe someday. You might want to drop a link in the [forum](http://madebyraygun.com/forum).

== Screenshots ==


1. Example of FAQs on page.

2. FAQ entry page

3. FAQ reorder page (includes code from My Page Order by Andrew Charlton)

== Changelog ==

0.2.4

* Added support for Qtranslate plugin.

0.2.3

* Changed method of shortcode content filtering for more compatibility.

0.2.2

* Plugin now filters the FAQ content for other shortcodes (such as captions & audio players)

0.2.1 

* Fixed small bug in search shortcode that resulted in no results under some configurations.

0.2.0

* Including WordPress version of jQuery instead of Google CDN version to limit SSL errors.


* Changed categories to hierarchical for clarity.

* Added shortcode for search form that can be added anywhere on your site.


= 0.1.3 = 

* You can now grab single FAQs by ID and insert them into a page.

= 0.1.2 =

* Changed permalinks to FAQs to a more compatible format in case javascript is disabled.

= 0.1.1 =

* Added category titles to displayed FAQs

= 0.1 =

* First version