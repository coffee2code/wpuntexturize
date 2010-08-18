=== wpuntexturize ===
Contributors: coffee2code
Donate link: http://coffee2code.com/donate
Tags: quotes, curly, substitutions, wptexturize, post, content, coffee2code
Requires at least: 1.5
Tested up to: 3.0.1
Stable tag: 1.3.1
Version: 1.3.1

Prevent WordPress from displaying single and double quotation marks as their curly alternatives.


== Description ==

Prevent WordPress from displaying single and double quotation marks as their curly alternatives.

Despite the unfortunately misleading name, this plugin is NOT the antithesis of WordPress's `wptexturize()` function.  This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent `wptexturize()` from making any other character and string substitutions.

*Advanced:*  The plugin performs a wpuntexturize on every filter that WordPress applies the wptexturize to by default.  This list comprises:

* comment_author
* term_name
* link_name
* link_description
* link_notes
* bloginfo
* wp_title
* widget_title
* single_post_title
* single_cat_title
* single_tag_title
* single_month_title
* nav_menu_attr_title
* nav_menu_description
* term_description
* the_title
* the_content
* the_excerpt
* comment_text
* list_cats
* widget_text

This complete list can be filtered via wpuntexturize's own filter, `wpuntexturize_filters`.


== Installation ==

1. Unzip `wpuntexturize.zip` inside the `/wp-content/plugins/` directory (or install via the built-in WordPress plugin installer)
1. Activate the plugin through the 'Plugins' admin menu in WordPress


== Filters ==

The plugin is further customizable via two filters. Typically, these customizations would be put into your active theme's functions.php file, or used by another plugin.

= wpuntexturize =

The 'wpuntexturize' filter allows you to use an alternative approach to safely invoke `wpuntexturize()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.  This only applies if you use the function directly, which is not typical usage for most users.

Arguments:

* none

Example:

Instead of:

    `<?php echo wpuntexturize( $mytext ); ?>`

Do:

    `<?php echo do_action( 'wpuntexturize', $mytext ); ?>`

= wpuntexturize_filters =

The 'wpuntexturize_filters' filter allows you to customize what filters to hook to be filtered with wpuntexturize.  See the Description section for a complete list of all filters that are filtered by default.

Arguments:

* array $filters : the default array of filters

Example:

`add_filter( 'wpuntexturize_filters', 'more_wpuntexturize_filters' );
function more_wpuntexturize_filters( $filters ) {
	$filters[] = 'event_description';
	return $filters;
}`


== Frequently Asked Questions ==

= Why are certain characters in my posts still being replaced by their HTML entity encoded version? =

This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent WordPress from making any other character and string substitutions.

= What text does this plugin modify (aka filter)? =

This plugin potentially modifies the post content, excerpt, title, comment text, widget text, and more.  See the description for a complete list of filters that are unfiltered.


== Changelog ==

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

= 1.3.1 =
Bugfix release.  Fixed bugs preventing plugin activation.

= 1.3 =
Minor update: renamed a filter; added a filter; wrapped initialization into a function.

= 1.2 =
Highlights: now applies to all places in WordPress where quotes are made curly; can now programmatically control what filters are affected; verified WP 3.0 compatibility.