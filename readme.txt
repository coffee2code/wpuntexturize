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

Links: [Plugin Homepage](http://coffee2code.com/wp-plugins/wpuntexturize/) | [Plugin Directory Page](https://wordpress.org/plugins/wpuntexturize/) | [GitHub](https://github.com/coffee2code/wpuntexturize/) | [Author Homepage](http://coffee2code.com)


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

= Full changelog is available in [CHANGELOG.md](CHANGELOG.md). =


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
