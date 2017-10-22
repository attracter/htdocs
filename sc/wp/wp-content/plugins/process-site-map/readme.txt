=== Process Site Map ===
Contributors: MikeNGarrett
Tags: site map, processing, pages, new site, admin, posts, plugin
Requires at least: 3.3.1
Tested up to: 3.3.1
Stable tag: 0.3

One time use plugin for processing visually ordered site map into nested pages. 

== Description ==
My intention with this plugin was to create a site that could hold notes about the site map in a snap.

Takes the following format: 

	Home
		About Us
			Mission Statement
			The Team
			Location
		Projects
			Client 1
			Client 2
			Client 3
				Design
				Development
				Conclusion
				Contact Us

…and turns it into nested pages. 

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= This isn't working! =

The developer was temporarily possessed and was forced into providing a plugin structure that was not compatible with WordPress's default format for plugins. I apologize for speaking in the third person. The possession… well that just happens sometimes. Regardless, it should work now.

== Changelog ==

= 0.1 =
* LAUNCH

= 0.2 =
* Fixes plugin structure to be compatible with WordPress. Nested directories are a bad idea.
* Adds some JS to prevent the browser defaults for tabbing inside a text area.
* Quick fix to some logic when returning to the topmost parent element.

= 0.3 =
* I said TAB.