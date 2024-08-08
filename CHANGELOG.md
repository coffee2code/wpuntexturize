# Changelog

## 2.2.2 _(2024-08-08)_
* Change: Note compatibility through WP 6.6+
* Change: Update copyright date (2024)
* Change: Reduce number of 'Tags' in readme.txt
* Change: Remove development and testing related files from release packaging
* Unit tests:
    * Hardening: Prevent direct web access to `bootstrap.php`
    * Change: In bootstrap, store path to plugin file constant
    * Change: In bootstrap, add backcompat for PHPUnit pre-v6.0

## 2.2.1 _(2023-06-06)_
* Change: Note compatibility through WP 6.3+
* Change: Update copyright date (2023)
* Change: Add link to DEVELOPER-DOCS.md in README.md
* New: Add `.gitignore` file
* Unit tests:
    * Fix: Allow tests to run against current versions of WordPress
    * New: Add `composer.json` for PHPUnit Polyfill dependency
    * Change: Prevent PHP warnings due to missing core-related generated files

## 2.2 _(2021-07-14)_

### Highlights:

This minor release refactors some code, extracts developer docs out from readme and into new DEVELOPER-DOCS.md, restructures unit test files, and notes compatibility through WP 5.7.

### Details:

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

## 2.1 _(2020-08-23)_

### Highlights:

This minor release mirrors and handles some WP 5.5 terminology changes for inclusion, restructures the unit test file structure, adds a TODO.md file, and notes compatibility through WP 5.5+.

### Details:

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

## 2.0 _(2020-05-15)_

### Highlights:

Recommended update that reverts an ill-advised change in default behavior added in v1.7 that automatically converted existing curly quotation marks into their non-curly alternatives. This behavior is now disabled by default, but can be optionally enabled on the Settings -> Reading admin page via the checkbox labeled "Convert existing curly quotes in posts to their non-curly alternatives".

Additionally, much of the plugin's code has been reorganized, the long-deprecated `wpuntexturize()` has been removed, a few URLs were updated to be HTTPS, and compatibility through WP 5.4+ has been noted.

### Details:

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

## 1.7.1 _(2019-11-12)_
* Change: Note compatibility through WP 5.3+
* Change: Use full URL for readme.txt link to full changelog
* Change: Update copyright date (2020)

## 1.7 _(2019-05-28)_
* New: Convert native curly quotation marks to their non-curly alternatives
* New: Add filter `c2c_wpuntexturize_convert_curly_quotes` to allow disabling of conversion of native curly quotes
* New: Untexturize three recently introduced core filters: `get_the_post_type_description`, `the_post_thumbnail_caption`, `widget_text_content`
* New: Add CHANGELOG.md and move all but most recent changelog entries into it
* Change: Update unit test install script and bootstrap to use latest WP unit test repo
* Change: Note compatibility through WP 5.2+
* Fix: Correct typo in GitHub URL
* Change: Modify formatting of hook name in readme to prevent being uppercased when shown in the Plugin Directory
* Change: Split paragraph in README.md's "Support" section into two
* Change: Remove extra space character between some sentences

## 1.6.3 _(2019-03-04)_
* New: Add inline documentation for hooks
* Change: Rename readme.txt section from 'Filters' to 'Hooks'
* Change: Note compatibility through WP 5.1+
* Change: Update copyright date (2019)
* Change: Update License URI to be HTTPS

## 1.6.2 _(2017-11-09)_
* New: Add README.md
* Change: Add GitHub link to readme
* Change: Minor readme tweak regarding suggested location for custom code
* Change: Note compatibility through WP 4.9+
* Change: Update copyright date (2018)
* Change: Minor whitespace tweaks in unit test bootstrap

## 1.6.1 _(2017-01-01)_
* New: Add LICENSE file.
* Change: Enable more error ourput for unit tests.
* Change: Default `WP_TESTS_DIR` to `/tmp/wordpress-tests-lib` rather than erroring out if not defined via environment variable.
* Change: Note compatibility through WP 4.7+.
* Change: Update copyright date (2017).

## 1.6 _(2016-07-14)_
* New: Add filter `c2c_wpuntexturize_replacements` for customizing the replacements.
* New: Convert single low 9 quotation mark (`&#8218;`) to single quote `'`.
* New: Convert double low 9 quotation mark (`&#8222;`) to double quote `"`.
* New: Add 'Text Domain' to plugin header.
* Change: Prevent web invocation of unit test bootstrap.php.
* Change: Tweak installation instructions.
* Change: Note compatibility through WP 4.6+.

## 1.5.4 _(2015-12-14)_
* Add: Untexturize newly introduced core filter `the_excerpt_embed`.
* Change: Note compatibility through WP 4.4+.
* Change: Explicitly declare methods in unit tests as public.
* Change: Update copyright date (2016).
* Add: Create empty index.php to prevent files from being listed if web server has enabled directory listings.

## 1.5.3 _(2015-08-26)_
* Bugfix: `c2c_wpuntexturize` hook should be a filter and not an action
* Update: Correct documentation regarding `c2c_wpuntexturize` hook
* Update: Add more unit tests for indirect hook invocation method
* Update: Add inline documentation to readme code example
* Update: Note compatibility through WP 4.3+

## 1.5.2 _(2015-02-10)_
* Note compatibility through WP 4.1+
* Update copyright date (2015)

## 1.5.1 _(2014-08-25)_
* Die early if script is directly invoked
* Remove unnecessary function from unit tests
* Minor plugin header reformatting
* Change documentation links to wp.org to be https
* Note compatibility through WP 4.0+
* Add plugin icon

## 1.5 _(2013-12-13)_
* Add `c2c_wpuntexturize_get_default_filters()` and change `c2c_init_wpuntexturize()` to use it
* Add unit tests
* Minor code formatting tweak (add curly braces)
* Note compatibility through WP 3.8+
* Update copyright date (2014)
* Change donate link

## 1.4.4
* Note compatibility through WP 3.5+
* Update copyright date (2013)

## 1.4.3
* Re-license as GPLv2 or later (from X11)
* Add 'License' and 'License URI' header tags to readme.txt and plugin file
* Add banner image for plugin page
* Remove ending PHP close tag
* Minor code reformatting (indentation)
* Miscellaneous readme.txt changes
* Note compatibility through WP 3.4+

## 1.4.2
* Note compatibility through WP 3.3+
* Minor code formatting (spacing)
* Add link to plugin directory page to readme.txt
* Update copyright date (2012)

## 1.4.1
* Note compatibility through WP 3.2+
* Fix plugin homepage and author links in description in readme.txt

## 1.4
* Rename `wpuntexturize()` to `c2c_wpuntexturize()` (but maintain a deprecated version for backwards compatibility)
* Add link to plugin homepage in readme.txt description

## 1.3.2
* Note compatibility through WP 3.1+
* Update copyright date (2011)

## 1.3.1
* Fix two bugs (missing close parenthesis and typo)

## 1.3
* Rename `wpuntexturize` filter to `wpuntexturize_filters` to more accurately reflect its purpose (and to prevent conflict for new use of the filter name)
* Add filter `wpuntexturize` so that users can use the `do_action('wpuntexturize')` notation for invoking the function
* Add `c2c_init_wpuntexturize()` to handle initialization
* Remove docs from top of plugin file (all that and more are in readme.txt)
* Add Filters section to readme.txt

## 1.2
* Allow filtering of the list of filters to be untexturized, via `wpuntexturize` filter
* Now unfilter everything that wptexturize is applied to by default, which now includes these filters: `comment_author`, `term_name`, `link_name`, `link_description`, `link_notes`, `bloginfo`, `wp_title`, `widget_title`, `single_cat_title`, `single_tag_title`, `single_month_title`, `nav_menu_attr_title`, `nav_menu_description`, `term_description`
* Wrap functions in `function_exists()` check to be safe
* Note compatibility with WP 3.0+
* Add Upgrade Notice section to readme.txt

## 1.1
* Convert `&#8242;` and `&#8243;` back to single and double quotes, respectively
* Add PHPDoc documentation
* Update readme.txt changelog with info from earlier releases

## 1.0.1
* Now also filter widget_text
* Note compatibility with WP 2.9+
* Update readme.txt (including adding Changelog)

## 1.0
* Modify core code to consolidate multiple `str_replace()` calls into one
* Change description
* Add extended description, installation instructions, and compatibility note
* Change from BSD license to GPL
* Update copyright date and version to 1.0
* Add readme.txt
* Tested compatibility with WP 2.3.3 and 2.5

# 0.91
* Add missing untexturization of `&#8221;`

# 0.9
* Initial release
