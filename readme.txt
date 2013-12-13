=== wpuntexturize ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: quotes, curly, substitutions, wptexturize, formatting, post, content, coffee2code
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 1.5
Tested up to: 3.8
Stable tag: 1.5

Prevent WordPress from displaying single and double quotation marks as their curly alternatives.


== Description ==

By default, WordPress converts single and double quotation marks into their curly alternatives. This plugin prevents that from happening, so you can enjoy your quotation marks in their non-curly glory.

*Note:* Despite the unfortunately misleading name, this plugin is NOT the antithesis of WordPress's `wptexturize()` function.  This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent `wptexturize()` from making any other character and string substitutions. See the FAQ for details on the filters processed by the plugin.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/wpuntexturize/) | [Plugin Directory Page](http://wordpress.org/plugins/wpuntexturize/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Unzip `wpuntexturize.zip` inside the `/wp-content/plugins/` directory (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress


== Frequently Asked Questions ==

= Why are certain characters in my posts still being replaced by their HTML entity encoded version? =

This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent WordPress from making any other character and string substitutions.

= What text does this plugin modify/filter? =

This plugin potentially modifies the post content, excerpt, title, comment text, widget text, and more.

More specifically, it performs a wpuntexturize on every filter that WordPress applies the wptexturize to by default.  This list comprises:

comment_author, term_name, link_name, link_description, link_notes, bloginfo, wp_title, widget_title, single_post_title, single_cat_title, single_tag_title, single_month_title, nav_menu_attr_title, nav_menu_description, term_description, the_title, the_content, the_excerpt, comment_text, list_cats, widget_text

This complete list can be filtered via wpuntexturize's own filter, `wpuntexturize_filters`.


== Filters ==

The plugin is further customizable via two hooks. Typically, these customizations would be put into your active theme's functions.php file, or used by another plugin.

= c2c_wpuntexturize (action) =

The 'c2c_wpuntexturize' action allows you to use an alternative approach to safely invoke `c2c_wpuntexturize()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.  This only applies if you use the function directly, which is not typical usage for most users.

Arguments:

* none

Example:

Instead of:

`<?php echo c2c_wpuntexturize( $mytext ); ?>`

Do:

`<?php echo do_action( 'c2c_wpuntexturize', $mytext ); ?>`

= wpuntexturize_filters (filter) =

The 'wpuntexturize_filters' filter allows you to customize what filters to hook to be filtered with wpuntexturize.  See the Description section for a complete list of all filters that are filtered by default.

Arguments:

* array $filters : the default array of filters

Example:

`add_filter( 'wpuntexturize_filters', 'more_wpuntexturize_filters' );
function more_wpuntexturize_filters( $filters ) {
	$filters[] = 'event_description';
	return $filters;
}`


== Changelog ==

= 1.5 (2013-12-13) =
* Add `c2c_wpuntexturize_get_default_filters()` and change `c2c_init_wpuntexturize()` to use it
* Add unit tests
* Minor code formatting tweak (add curly braces)
* Note compatibility through WP 3.8+
* Update copyright date (2014)
* Change donate link

= 1.4.4 =
* Note compatibility through WP 3.5+
* Update copyright date (2013)

= 1.4.3 =
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Add banner image for plugin page
* Remove ending PHP close tag
* Minor code reformatting (indentation)
* Miscellaneous readme.txt changes
* Note compatibility through WP 3.4+

= 1.4.2 =
* Note compatibility through WP 3.3+
* Minor code formatting (spacing)
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

= 1.4.1 =
* Note compatibility through WP 3.2+
* Fix plugin homepage and author links in description in readme.txt

= 1.4 =
* Rename `wpuntexturize()` to `c2c_wpuntexturize()` (but maintain a deprecated version for backwards compatibility)
* Add link to plugin homepage in readme.txt description

= 1.3.2 =
* Note compatibility through WP 3.1+
* Update copyright date (2011)

= 1.3.1 =
* Fix two bugs (missing close parenthesis and typo)

= 1.3 =
* Rename 'wpuntexturize' filter to 'wpuntexturize_filters' to more accurately reflect its purpose (and to prevent conflict for new use of the filter name)
* Add filter 'wpuntexturize' so that users can use the do_action('wpuntexturize') notation for invoking the function
* Add c2c_init_wpuntexturize() to handle initialization
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Add Filters section to readme.txt

= 1.2 =
* Allow filtering of the list of filters to be untexturized, via 'wpuntexturize' filter
* Now unfilter everything that wptexturize is applied to by default, which now includes these filters: comment_author, term_name, link_name, link_description, link_notes, bloginfo, wp_title, widget_title, single_cat_title, single_tag_title, single_month_title, nav_menu_attr_title, nav_menu_description, term_description
* Wrap functions in function_exists() check to be safe
* Note compatibility with WP 3.0+
* Add Upgrade Notice section to readme.txt

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


== Upgrade Notice ==

= 1.5 =
Minor update: added unit tests; added helper function; noted compatibility through WP 3.8+ and updated copyright date

= 1.4.4 =
Trivial update: noted compatibility through WP 3.5+ and updated copyright date

= 1.4.3 =
Trivial update: noted compatibility through WP 3.4+; explicitly stated license

= 1.4.2 =
Trivial update: noted compatibility through WP 3.3+

= 1.4.1 =
Trivial update: noted compatibility through WP 3.2+ and fixed link in description in readme.txt

= 1.4 =
Minor update: deprecated 'wpuntexturize()' in favor of 'c2c_wpuntexturize()'; renamed action from 'wpuntexturize' to 'c2c_wpuntexturize'; added link to plugin homepage in readme.txt

= 1.3.2 =
Trivial update: noted compatibility through WP 3.1+ and updated copyright date

= 1.3.1 =
Bugfix release.  Fixed bugs preventing plugin activation.

= 1.3 =
Minor update: renamed a filter; added a filter; wrapped initialization into a function.

= 1.2 =
Highlights: now applies to all places in WordPress where quotes are made curly; can now programmatically control what filters are affected; verified WP 3.0 compatibility.
