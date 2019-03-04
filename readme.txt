=== wpuntexturize ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: quotes, curly, substitutions, wptexturize, formatting, post, content, coffee2code
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 1.5
Tested up to: 5.1
Stable tag: 1.6.3

Prevent WordPress from displaying single and double quotation marks as their curly alternatives.


== Description ==

By default, WordPress converts single and double quotation marks into their curly alternatives. This plugin prevents that from happening, so you can enjoy your quotation marks in their non-curly glory.

*Note:* Despite the unfortunately misleading name, this plugin is NOT the antithesis of WordPress's `wptexturize()` function.  This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent `wptexturize()` from making any other character and string substitutions. See the FAQ for details on the filters processed by the plugin.

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/wpuntexturize/) | [Plugin Directory Page](https://wordpress.org/plugins/wpuntexturize/) | [GitHub](https://github.com/coffe2code/wpuntexturize/) | [Author Homepage](http://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or download and unzip `wpuntexturize.zip` inside the plugins directory for your site (typically `wp-content/plugins/`)
1. Activate the plugin through the 'Plugins' admin menu in WordPress


== Frequently Asked Questions ==

= Why are certain characters in my posts still being replaced by their HTML entity encoded version? =

This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent WordPress from making any other character and string substitutions.

= What text does this plugin modify/filter? =

This plugin potentially modifies the post content, excerpt, title, comment text, widget text, and more.

More specifically, it performs a wpuntexturize on every filter that WordPress applies the wptexturize to by default.  This list comprises:

comment_author, term_name, link_name, link_description, link_notes, bloginfo, wp_title, widget_title, single_post_title, single_cat_title, single_tag_title, single_month_title, nav_menu_attr_title, nav_menu_description, term_description, the_title, the_content, the_excerpt, comment_text, list_cats, widget_text

This complete list can be filtered via wpuntexturize's own filter, `wpuntexturize_filters`.

= Does this plugin include unit tests? =

Yes.


== Hooks ==

The plugin is further customizable via three hooks. Such code should ideally be put into a mu-plugin or site-specific plugin (which is beyond the scope of this readme to explain).

= c2c_wpuntexturize (filter) =

The 'c2c_wpuntexturize' filter allows you to use an alternative approach to safely invoke `c2c_wpuntexturize()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site.  This only applies if you use the function directly, which is not typical usage for most users.

Arguments:

* none

Example:

Instead of:

`<?php echo c2c_wpuntexturize( $mytext ); ?>`

Do:

`<?php echo apply_filters( 'c2c_wpuntexturize', $mytext ); ?>`

= wpuntexturize_filters (filter) =

The 'wpuntexturize_filters' filter allows you to customize what filters to hook to be filtered with wpuntexturize.  See the Description section for a complete list of all filters that are filtered by default.

Arguments:

* array $filters : the default array of filters

Example:

`
/**
 * Add additional filters to get wpuntexturize'd.
 *
 * @param array $filters Filters that will receive the wpuntexturize treatement.
 * @return array
 */
function more_wpuntexturize_filters( $filters ) {
	$filters[] = 'event_description';
	return $filters;
}
add_filter( 'wpuntexturize_filters', 'more_wpuntexturize_filters' );
`

= c2c_wpuntexturize_replacements (filter) =

The 'c2c_wpuntexturize_replacements' filter allows you to customize the character replacements handled by the plugin.

Arguments:

* array $replacements : Array where the keys are the characters to be replace, and the values are their respective replacements.

Example:

`
/**
 * Add and remove to/from default wpuntexturize replacements.
 *
 * @param array $replacements
 * @return array
 */
function c2c_change_wpuntexturize_replacements( $replacements ) {
	// Remove low 9 quotation mark replacements.
	unset( $replacements['&#8218;'] );
	unset( $replacements['&#8222;'] );

	// Replace copyright.
	$replacements['&copy;'] = '(c)';

	return $replacements;
}
add_filter( 'c2c_wpuntexturize_replacements', 'c2c_change_wpuntexturize_replacements' );
`


== Changelog ==

= 1.6.3 (2019-03-04) =
* New: Add inline documentation for hooks
* Change: Rename readme.txt section from 'Filters' to 'Hooks'
* Change: Note compatibility through WP 5.1+
* Change: Update copyright date (2019)
* Change: Update License URI to be HTTPS

= 1.6.2 (2017-11-09) =
* New: Add README.md
* Change: Add GitHub link to readme
* Change: Minor readme tweak regarding suggested location for custom code
* Change: Note compatibility through WP 4.9+
* Change: Update copyright date (2018)
* Change: Minor whitespace tweaks in unit test bootstrap

= 1.6.1 (2017-01-01) =
* New: Add LICENSE file.
* Change: Enable more error ourput for unit tests.
* Change: Default `WP_TESTS_DIR` to `/tmp/wordpress-tests-lib` rather than erroring out if not defined via environment variable.
* Change: Note compatibility through WP 4.7+.
* Change: Update copyright date (2017).

= 1.6 (2016-07-14) =
* New: Add filter 'c2c_wpuntexturize_replacements' for customizing the replacements.
* New: Convert single low 9 quotation mark (`&#8218;`) to single quote `'`.
* New: Convert double low 9 quotation mark (`&#8222;`) to double quote `"`.
* New: Add 'Text Domain' to plugin header.
* Change: Prevent web invocation of unit test bootstrap.php.
* Change: Tweak installation instructions.
* Change: Note compatibility through WP 4.6+.

= 1.5.4 (2015-12-14) =
* Add: Untexturize newly introduced core filter 'the_excerpt_embed'.
* Change: Note compatibility through WP 4.4+.
* Change: Explicitly declare methods in unit tests as public.
* Change: Update copyright date (2016).
* Add: Create empty index.php to prevent files from being listed if web server has enabled directory listings.

= 1.5.3 (2015-08-26) =
* Bugfix: 'c2c_wpuntexturize' hook should be a filter and not an action
* Update: Correct documentation regarding 'c2c_wpuntexturize' hook
* Update: Add more unit tests for indirect hook invocation method
* Update: Add inline documentation to readme code example
* Update: Note compatibility through WP 4.3+

= 1.5.2 (2015-02-10) =
* Note compatibility through WP 4.1+
* Update copyright date (2015)

= 1.5.1 (2014-08-25) =
* Die early if script is directly invoked
* Remove unnecessary function from unit tests
* Minor plugin header reformatting
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

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

= 1.6.3 =
Trivial update: aded inline documentation for hooks, noted compatibility through WP 5.1+, updated copyright date (2019)

= 1.6.2 =
Trivial update: noted compatibility through WP 4.9+; added README.md; added GitHub link to readme; updated copyright date (2018)

= 1.6.1 =
Trivial update: updated unit test bootstrap file, noted compatibility through WP 4.7+, and updated copyright date

= 1.6 =
Minor update: convert single and double low 9 quotation marks; noted compatibility through WP 4.6+

= 1.5.4 =
Trivial update: minor unit test tweaks, noted compatibility through WP 4.4+, and updated copyright date

= 1.5.3 =
Trivial update: bugfix for very rare usage technique; noted compatibility through WP 4.3+

= 1.5.2 =
Trivial update: noted compatibility through WP 4.1+ and updated copyright date

= 1.5.1 =
Trivial update: noted compatibility through WP 4.0+; added plugin icon.

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
