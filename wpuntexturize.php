<?php
/**
 * Plugin Name: wpuntexturize
 * Version:     1.6.2
 * Plugin URI:  http://coffee2code.com/wp-plugins/wpuntexturize/
 * Author:      Scott Reilly
 * Author URI:  http://coffee2code.com/
 * Text Domain: wpuntexturize
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Prevent WordPress from displaying single and double quotation marks as their curly alternatives.
 *
 * Compatible with WordPress 1.5+ through 4.9+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/wpuntexturize/
 *
 * @package wpuntexturize
 * @author  Scott Reilly
 * @version 1.6.2
 */

/*
	Copyright (c) 2004-2018 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

if ( ! function_exists( 'c2c_wpuntexturize' ) ) :
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
	function c2c_wpuntexturize( $text ) {
		$replacements = array(
			'&#8216;' => "'", // left single quotation mark
			'&#8217;' => "'", // right single quotation mark
			'&#8218;' => "'", // single low 9 quotation mark
			'&#8220;' => '"', // left double quotation mark
			'&#8221;' => '"', // right double quotation mark
			'&#8222;' => '"', // double low 9 quotation mark
			'&#8242;' => "'", // prime mark
			'&#8243;' => '"', // double prime mark
		);

		$replacements = (array) apply_filters( 'c2c_wpuntexturize_replacements', $replacements );

		return str_replace( array_keys( $replacements ), array_values( $replacements ), $text );
	}
	add_filter( 'c2c_wpuntexturize', 'c2c_wpuntexturize' );
endif;


if ( ! function_exists( 'c2c_init_wpuntexturize' ) ) :
	/**
	 * Initialize wpuntexturize, primarily to register it against filters
	 */
	function c2c_init_wpuntexturize() {
		foreach( c2c_wpuntexturize_get_default_filters() as $filter ) {
			add_filter( $filter, 'c2c_wpuntexturize', 11 );
		}
	}
	add_action( 'init', 'c2c_init_wpuntexturize' );
endif;

if ( ! function_exists( 'c2c_wpuntexturize_get_default_filters' ) ) :
	/**
	 * Gets the list of filters that wpuntexturize() is applied to by default.
	 *
	 * @return array
	 */
	function c2c_wpuntexturize_get_default_filters() {
		return (array) apply_filters( 'wpuntexturize_filters', array(
		 'comment_author', 'term_name', 'link_name', 'link_description', 'link_notes', 'bloginfo', 'wp_title', 'widget_title',
		 'single_post_title', 'single_cat_title', 'single_tag_title', 'single_month_title', 'nav_menu_attr_title', 'nav_menu_description',
		 'term_description', 'the_title', 'the_content', 'the_excerpt', 'comment_text', 'list_cats', 'widget_text',
		 'the_excerpt_embed',
		) );
	}
endif;

if ( ! function_exists( 'wpuntexturize' ) ) :
	/**
	 * Prevent WordPress from displaying single and double quotation marks as
	 * their curly alternatives.
	 *
	 * @since 1.0
	 * @deprecated 1.4 Use c2c_wpuntexturize() instead
	 */
	function wpuntexturize( $text ) {
		_deprecated_function( 'wpuntexturize', '1.4', 'c2c_wpuntexturize' );
		return c2c_wpuntexturize( $text );
	}
	add_filter( 'wpuntexturize', 'wpuntexturize' ); // Deprecated
endif;
