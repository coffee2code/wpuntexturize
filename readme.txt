=== wpuntexturize ===
Contributors: coffee2code
Donate link: http://coffee2code.com/donate
Tags: quotes, curly, substituions, wptexturize, post, content, coffee2code
Requires at least: 1.5
Tested up to: 2.9.1
Stable tag: 1.1
Version: 1.1

Prevent WordPress from displaying single and double quotation marks as their curly alternatives.

== Description ==

Prevent WordPress from displaying single and double quotation marks as their curly alternatives.

Despite the unfortunately misleading name, this plugin is NOT the antithesis of WordPress's `wptexturize()` function.  This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent `wptexturize()` from making any other character and string substitutions. 

== Installation ==

1. Unzip `wpuntexturize.zip` inside the `/wp-content/plugins/` directory (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress

== Frequently Asked Questions ==

= Why are certain characters in my posts still being replaced by their HTML entity encoded version? =

This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent WordPress from making any other character and string substitutions.

= What text does this plugin modify (aka filter)? =

This plugin potentially modifies the post content, excerpt, title, comment text, and widget text.

== Changelog ==

= 1.1 =
* Convert `&#8242;` and `&#8243;` back to single and double quotes, respectively
* Add PHPDoc documentation
* Update readme.txt changelog with info from earlier releases

= 1.0.1 =
* Now also filter widget_text
* Note compatibility with WP 2.9+
* Update readme.txt (including adding Changelog)

= 1.0 =
* Modify core code to consolidate multiple str_replace() calls into one
* Change description
* Add extended description, installation instructions, and compatibility note
* Change from BSD license to GPL
* Update copyright date and version to 1.0
* Add readme.txt
* Tested compatibility with WP 2.3.3 and 2.5

= 0.91 =
* Add missing untexturization of `&#8221;`

= 0.9 =
* Initial release
