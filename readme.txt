=== wpuntexturize ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: quotes, curly, substitutions, wptexturize, formatting, post, content, coffee2code
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 1.5
Tested up to: 5.7
Stable tag: 2.2

Prevent WordPress from converting single and double quotation marks into their curly alternatives, and optionally also convert existing curly quotation marks into their non-curly alternatives.


== Description ==

By default, WordPress converts single and double quotation marks into their curly alternatives. This plugin prevents that from happening, so you can enjoy your quotation marks in their non-curly glory. If your content happens to already have curly quotation marks in it, then this plugin can optionally also convert them to their non-curly alternatives.

*Note:* Despite the unfortunately misleading name, this plugin is NOT the antithesis of WordPress's `wptexturize()` function. This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent `wptexturize()` from making any other character and string substitutions. See the FAQ for details on the filters processed by the plugin.

Links: [Plugin Homepage](https://coffee2code.com/wp-plugins/wpuntexturize/) | [Plugin Directory Page](https://wordpress.org/plugins/wpuntexturize/) | [GitHub](https://github.com/coffee2code/wpuntexturize/) | [Author Homepage](https://coffee2code.com)


== Installation ==

1. Install via the built-in WordPress plugin installer. Or download and unzip `wpuntexturize.zip` inside the plugins directory for your site (typically `wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' admin menu in WordPress
3. Optional: If you want to also convert existing curly quotation marks within posts to their non-curly alternatives, then on the Settings -> Reading admin page check the checkbox labeled "Convert existing curly quotes in posts to their non-curly alternatives". _(Reminder that the plugin will always prevent WordPress from converting non-curly quotation marks to the curly alternatives.)_


== Screenshots ==

1. A screenshot of the plugin's checkbox on the Settings -> Reading admin page. If checked, the plugin will convert existing curly quotation marks into their non-curly alternatives.


== Frequently Asked Questions ==

= Why are certain characters in my posts still being replaced by their HTML entity encoded version? =

This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with their curly alternatives and does NOT prevent WordPress from making any other character and string substitutions.

= Why do I still see curly quotation marks in my posts? =

Most likely these curly quotes are actually present in your originally post content and are being directly shown to visitors. WordPress isn't converting these to curly quotes since they are already that way. This could happen if you copy-and-pasted text from another source.

If you don't want any curly quotes to appear in your posts at all, then on the Settings -> Reading admin page check the checkbox labeled "Prevent all curly quotes?". (Or if you're a developer, look into use of the `c2c_wpuntexturize_convert_curly_quotes` filter.)

= What text does this plugin modify/filter? =

This plugin potentially modifies the post content, excerpt, title, comment text, widget text, and more.

More specifically, it performs a wpuntexturize on every filter that WordPress applies the wptexturize to by default. This list comprises:

comment_author, term_name, link_name, link_description, link_notes, bloginfo, wp_title, widget_title, single_post_title, single_cat_title, single_tag_title, single_month_title, nav_menu_attr_title, nav_menu_description, term_description, get_the_post_type_description, the_post_thumbnail_caption, the_title, the_content, the_excerpt, the_excerpt_embed, comment_text, list_cats, widget_text, widget_text_content

This complete list can be filtered via wpuntexturize's own filter, `wpuntexturize_filters`.

= Does this plugin include unit tests? =

Yes.


== Developer Documentation ==

Developer documentation can be found in [DEVELOPER-DOCS.md](https://github.com/coffee2code/wpuntexturize/blob/master/DEVELOPER-DOCS.md). That documentation covers the numerous hooks provided by the plugin. Those hooks are listed below to provide an overview of what's available.

* `c2c_wpuntexturize` : An alternative approach to safely invoke `c2c_wpuntexturize()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site. This only applies if you use the function directly, which is not typical usage for most users.
* `wpuntexturize_filters` : customize what filters to hook to be filtered with wpuntexturize. See the Description section for a complete list of all filters that are filtered by default.
* `c2c_wpuntexturize_replacements` : Customize the character replacements handled by the plugin.
* `c2c_wpuntexturize_convert_curly_quotes` : Enable conversion of preexisting curly quotes into their non-curly alternatives.


== Changelog ==

= 2.2 (2021-07-14) =
Highlights:

This minor release refactors some code, extracts developer docs out from readme and into new DEVELOPER-DOCS.md, restructures unit test files, and notes compatibility through WP 5.7.

Details:

* Change: Refactor some code to prevent code duplication
* Change: Check if the plugin's main class exists before defining it
* Change: Note compatibility through WP 5.7+
* Change: Correct documentation regarding the `c2c_wpuntexturize_convert_curly_quotes` filter
* Change: Update copyright date (2021)
* New: Add DEVELOPER-DOCS.md and move hooks documentation into it
* Unit tests:
    * Change: Restructure unit test directories and files into new `tests/` top-level directory
        * Change: Move `phpunit/bin/` into `tests/`
        * Change: Move `phpunit/bootstrap.php` into `tests/`
        * Change: In bootstrap, store path to plugin file constant so its value can be used within that file and in test file
        * Change: Move `phpunit/tests/*.php` into `tests/phpunit/tests/`
        * Change: Remove 'test-' prefix from unit test file
    * Fix: Fix test that expected a deprecation notice that wasn't going to happen
    * New: Add test for `allowed_options()` that expects a deprecation notice if WP < 5.5
* Change: Tweak formatting for older readme.txt changelog entries
* New: Add a few more possible TODO items

= 2.1 (2020-08-23) =
Highlights:

This minor release mirrors and handles some WP 5.5 terminology changes for inclusion, restructures the unit test file structure, adds a TODO.md file, and notes compatibility through WP 5.5+.

Details:

* Change: Escape settings name before being output as HTML attribute (hardening)
* Change: Rename `whitelist_options()` to `allowed_options()`
* Change: Handle renamings that took place in WP 5.5
    * New: Add `is_wp_55_or_later()` for determining if the site is WP 5.5 or later
    * Change: Hook `allowed_options` instead of `whitelist_options` for WP 5.5+
    * Change: Call `add_allowed_options()` instead of `add_option_whitelist()` for WP 5.5+
* Change: Convert storage of setting name from private class variable to a class constant
* New: Add TODO.md for newly added potential TODO items
* Change: Restructure unit test file structure
    * New: Create new subdirectory `phpunit/` to house all files related to unit testing
    * Change: Move `bin/` to `phpunit/bin/`
    * Change: Move `tests/bootstrap.php` to `phpunit/`
    * Change: Move `tests/` to `phpunit/tests/`
    * Change: Rename `phpunit.xml` to `phpunit.xml.dist` per best practices
* Change: Note compatibility through WP 5.5+
* Unit tests:
    * New: Add test for setting name
    * New: Add test for `whitelist_options()`
    * Change: Rearrange, label the group, enhance, and expand tests for `initialize_setting()`

= 2.0 (2020-05-15) =

Highlights:

Recommended update that reverts an ill-advised change in default behavior added in v1.7 that automatically converted existing curly quotation marks into their non-curly alternatives. This behavior is now disabled by default, but can be optionally enabled on the Settings -> Reading admin page via the checkbox labeled "Convert existing curly quotes in posts to their non-curly alternatives".
* Additionally, much of the plugin's code has been reorganized, the long-deprecated `wpuntexturize()` has been removed, a few URLs were updated to be HTTPS, and compatibility through WP 5.4+ has been noted.

Details:

* Change: Revert default uncurling of native curly quotes and make it an optional behavior controlled by new setting
    * New: Add setting to Settings -> Reading page
    * New: Add "Settings" link to plugin's action links in admin listing of plugins
    * New: Add `initialize_setting()`, `whitelist_options()`, `display_option()`, `should_convert_native_quotes()`, `plugin_action_links()`
    * Change: Switch default for converting native curly quotes to false
    * Change: Update plugin description and documentation to reflect new behavior
* New: Add class `c2c_wpuntexturize` to encapsulate new (largely admin-related) and existing functionality
    * New: Add `version()`, `init()`
* Change: Extract logic for determining if native curly quotes should be handled into `should_convert_native_quotes()`
* Change: Extract code for getting the list of replacements into `get_replacements()`
* Change: Remove function `c2c_init_wpuntexturize()` (its functionality added to `init()`)
* Change: Remove function `c2c_wpuntexturize_get_default_filters()` (moved to class function `get_default_filters()`)
* Change: Remove deprecated function `wpuntexturize()` and its associated filter `wpuntexturize`
* Change: Use HTTPS for link to WP SVN repository in bin script for configuring unit tests
* Change: Note compatibility through WP 5.4+
* Change: Update links to coffee2code.com to be HTTPS
* Change: Unit tests: Remove unnecessary unregistering of hooks, and thus `tearDown()`
* New: Add a screenshot

_Full changelog is available in [CHANGELOG.md](https://github.com/coffee2code/wpuntexturize/blob/master/CHANGELOG.md)._


== Upgrade Notice ==

= 2.2 =
Minor update: refactored some code, extracted developer docs out from readme and into new DEVELOPER-DOCS.md, restructured unit test files, noted compatibility through WP 5.7, and updated copyright date (2021).

= 2.1 =
Recommended update: Mirrored and handled some WP 5.5 terminology changes for inclusion, restructured the unit test file structure, added a TODO.md file, and noted compatibility through WP 5.5+.

= 2.0 =
Recommended update: No longer convert native curly quotes to non-curly quotes by default, but added a setting to optionally do so; reorganized much of the plugin's code; removed long-deprecated `wpuntexturize()`, updated some URLs to HTTPS; and noted compatibility through WP 5.4+.

= 1.7.1 =
Trivial update: noted compatibility through WP 5.3+ and updated copyright date (2020)

= 1.7 =
Recommended update: now convert native curly quotes to non-curly quotes, remove curly quotes from more places, noted compatibility through WP 5.2+, added CHANGELOG.md, tweaked unit test initialization

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
Bugfix release. Fixed bugs preventing plugin activation.

= 1.3 =
Minor update: renamed a filter; added a filter; wrapped initialization into a function.

= 1.2 =
Highlights: now applies to all places in WordPress where quotes are made curly; can now programmatically control what filters are affected; verified WP 3.0 compatibility.
