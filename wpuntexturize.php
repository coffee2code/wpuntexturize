<?php
/**
 * @package wpuntexturize
 * @author Scott Reilly
 * @version 1.3.1
 */
/*
Plugin Name: wpuntexturize
Version: 1.3.1
Plugin URI: http://coffee2code.com/wp-plugins/wpuntexturize
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Prevent WordPress from displaying single and double quotation marks as their curly alternatives.

Compatible with WordPress 1.5+, 2.0+, 2.1+, 2.2+, 2.3+, 2.5+, 2.6+, 2.7+, 2.8+, 2.9+, 3.0+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/wpuntexturize/

*/

/*
Copyright (c) 2004-2010 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

if ( !function_exists( 'wpuntexturize' ) ) :
/**
 * Prevent WordPress from displaying single and double quotation marks as
 * their curly alternatives.
 *
 * Despite the unfortunately misleading name, this plugin is NOT the antithesis
 * of WordPress's wptexturize() function.  This ONLY prevents WordPress from
 * making HTML entity code substitutions of single and double quotation marks
 * with their curly alternatives and does NOT prevent wptexturize() from making
 * any other character and string substitutions.
 *
 * @param string $text The text to have quotation characters reverted from HTML entities to plain-text
 * @return string The converted text
 */
function wpuntexturize( $text ) {
	$char_codes = array( '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8242;', '&#8243;' );
	$replacements = array( "'", "'", '"', '"', "'", '"' );
	return str_replace( $char_codes, $replacements, $text );
}
add_action( 'wpuntexturize', 'wpuntexturize' );
endif;

if ( !function_exists( 'c2c_init_wpuntexturize' ) ) :
/**
 * Initialize wpuntexturize, primarily to register it against filters
 *
 * @return void
 */
function c2c_init_wpuntexturize() {
	$filters = (array) apply_filters( 'wpuntexturize_filters', array(
	 'comment_author', 'term_name', 'link_name', 'link_description', 'link_notes', 'bloginfo', 'wp_title', 'widget_title',
	 'single_post_title', 'single_cat_title', 'single_tag_title', 'single_month_title', 'nav_menu_attr_title', 'nav_menu_description',
	 'term_description', 'the_title', 'the_content', 'the_excerpt', 'comment_text', 'list_cats', 'widget_text' ) );
	foreach( $filters as $filter )
		add_filter( $filter, 'wpuntexturize', 11 );
}
endif;
add_action( 'init', 'c2c_init_wpuntexturize' );

?>