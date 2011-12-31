=== Thesis Import/Export ===
Contributors: 3Dog
Donate link: http://www.3dogmedia.com/
Tags: thesis
Requires at least: 2.0
Tested up to: 2.8.5
Stable tag: trunk

Import/Export all Thesis settings and OpenHook content.

== Description ==

We use Thesis for our site. We also use Thesis for a lot of client work.  And while we dig Thesis, one of the things that becomes a pain in the ass when using it, is having to manually add common layout and design settings that we use regularly.  With the release of Thesis 1.6, this has become even a bigger issue due to all the new font and color control features.

As things move forward, more and more skin designs will start incorporating admin panel settings rather than relying on the traditional style sheet approach. And that means skins will become less and less "plug & play" because you will have to spend time inputing dozens of settings to get your skin to look like the original demo. And skin designers will need to spend a bunch of time creating additional instructions that list all the items that need to be changed. (For a great example, check out all the work that went into Ben's post on his latest skin).

With this plugin, you can download individual data files for Thesis Options, Design Options, and all OpenHook content. (located at Appearance > Thesis Import/Export)

So once you have completed a skin design, or custom layout for a client, you can just export the data files and then bundle them with the plugin. Once the skin is installed, the user simply uploads the bundled data files and all the original settings, hooks, etc. will be imported.

The only words of caution you will need with this plugin has to do with the restore functions. If you click on those links before you have saved a backup, all your settings will be lost!

== Installation ==

1. Upload `thesis-export.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Thesis Import/Expot admin page

== Changelog ==

= 1.2 =
* Added javascriptconfirm to restore defaults

= 1.1 =
* Fixed some leftover urls

