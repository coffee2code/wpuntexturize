# Changelog

## _(in-progress)_
* New: Add CHANGELOG.md and move all but most recent changelog entries into it
* Change: Update unit test install script and bootstrap to use latest WP unit test repo
* Fix: Correct typo in GitHub URL
* Change: Split paragraph in README.md's "Support" section into two

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
