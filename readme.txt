=== MP Stacks + EDD ===
Contributors: johnstonphilip
Donate link: http://mintplugins.com/
Tags: page, builder, stacks, bricks
Requires at least: 3.5
Tested up to: 4.0
Stable tag: 1.0.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shortcode which dynamically shows a download "Buy" link using the parent download's post id. This way, the exact same shortcode can be used for every download.

== Description ==

Shortcode which dynamically shows a download "Buy" link using the parent download's post id. This way, the exact same shortcode can be used for every download.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the 'mp-stacks-edd folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Build Bricks under the “Stacks and Bricks” menu. 
4. Publish your bricks into a “Stack”.
5. Put Stacks on pages using the shortcode or the “Add Stack” button.

== Frequently Asked Questions ==

See full instructions at http://mintplugins.com/doc/mp-stacks

== Screenshots ==


== Changelog ==

= 1.0.0.2 = July 24, 2014
* Now we use a straight-up button instead of the EDD form.

= 1.0.0.1 = July 24, 2014
* Use wp_query->queried_object instead of $post_id for downloads. This way we don’t need to use wp_query_reset.

= 1.0.0.0 = June 15, 2014
* Original release
