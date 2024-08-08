=== wpuntexturize ===
Contributors: coffee2code
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ARCFJ9TX3522
Tags: quotes, substitutions, wptexturize, formatting, post
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 1.5
Tested up to: 6.6
Stable tag: 2.2.2

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

Yes. The tests are not packaged in the release .zip file or included in plugins.svn.wordpress.org, but can be found in the [plugin's GitHub repository](https://github.com/coffee2code/wpuntexturize/).


== Developer Documentation ==

Developer documentation can be found in [DEVELOPER-DOCS.md](https://github.com/coffee2code/wpuntexturize/blob/master/DEVELOPER-DOCS.md). That documentation covers the numerous hooks provided by the plugin. Those hooks are listed below to provide an overview of what's available.

* `c2c_wpuntexturize` : An alternative approach to safely invoke `c2c_wpuntexturize()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site. This only applies if you use the function directly, which is not typical usage for most users.
* `wpuntexturize_filters` : customize what filters to hook to be filtered with wpuntexturize. See the Description section for a complete list of all filters that are filtered by default.
* `c2c_wpuntexturize_replacements` : Customize the character replacements handled by the plugin.
* `c2c_wpuntexturize_convert_curly_quotes` : Enable conversion of preexisting curly quotes into their non-curly alternatives.


== Changelog ==

= 2.2.2 (2024-08-08) =
* Change: Note compatibility through WP 6.6+
* Change: Update copyright date (2024)
* Change: Reduce number of 'Tags' in readme.txt
* Change: Remove development and testing related files from release packaging
* Unit tests:
    * Hardening: Prevent direct web access to `bootstrap.php`
    * Change: In bootstrap, store path to plugin file constant
    * Change: In bootstrap, add backcompat for PHPUnit pre-v6.0

= 2.2.1 (2023-04-29) =
* Change: Note compatibility through WP 6.3+
* Change: Update copyright date (2023)
* Change: Add link to DEVELOPER-DOCS.md in README.md
* New: Add `.gitignore` file
* Unit tests:
    * Fix: Allow tests to run against current versions of WordPress
    * New: Add `composer.json` for PHPUnit Polyfill dependency
    * Change: Prevent PHP warnings due to missing core-related generated files

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

_Full changelog is available in [CHANGELOG.md](https://github.com/coffee2code/wpuntexturize/blob/master/CHANGELOG.md)._


== Upgrade Notice ==

= 2.2.2 =
Trivial update: noted compatibility through WP 6.6+, removed unit tests from release packaging, and updated copyright date (2024)

= 2.2.1 =
Trivial update: noted compatibility through WP 6.3+, updated unit tests to run against latest WordPress, and updated copyright date (2023)

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
