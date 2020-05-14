<?php
/**
 * Plugin Name: wpuntexturize
 * Version:     1.7.1
 * Plugin URI:  https://coffee2code.com/wp-plugins/wpuntexturize/
 * Author:      Scott Reilly
 * Author URI:  https//coffee2code.com/
 * Text Domain: wpuntexturize
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Prevent WordPress from displaying single and double quotation marks as their curly alternatives.
 *
 * Compatible with WordPress 1.5+ through 5.4+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/wpuntexturize/
 *
 * @package wpuntexturize
 * @author  Scott Reilly
 * @version 1.7.1
 */

/*
	Copyright (c) 2004-2020 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

class c2c_wpuntexturize {

	/**
	 * The name used for the plugin's setting.
	 *
	 * @ccess private
	 * @since 2.0
	 * @var string
	 */
	private static $setting_name = 'c2c_wpuntexturize';

	/**
	 * Returns version of the plugin.
	 *
	 * @since 1.0
	 */
	public static function version() {
		return '1.7.1';
	}

	/**
	 * Initializer.
	 *
	 * Loads plugin textdomain and registers actions/filters.
	 *
	 * @since 2.0
	 */
	public static function init() {
		// Load textdomain.
		load_plugin_textdomain( 'wpuntexturize' );

		// Register hooks.
		add_action( 'admin_init', array( __CLASS__, 'initialize_setting' ) );
	}

	/**
	 * Initializes setting.
	 *
	 * @since 2.0
	 */
	public static function initialize_setting() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		register_setting( 'reading', self::$setting_name );

		add_filter( 'whitelist_options', array( __CLASS__, 'whitelist_options' ) );

		add_settings_field(
			self::$setting_name,
			__( 'Prevent all curly quotes?', 'wpuntexturize' ),
			array( __CLASS__, 'display_option' ),
			'reading'
		);
	}

	/**
	 * Whitelists the plugin's option(s)
	 *
	 * @since 2.0
	 *
	 * @param array $options Array of options.
	 * @return array The whitelist-amended $options array.
	 */
	public static function whitelist_options( $options ) {
		return add_option_whitelist(
			array( self::$setting_name => array( self::$setting_name ) ),
			$options
		);
	}

	/**
	 * Outputs markup for the plugin setting on the Reading Settings page.
	 *
	 * @since 2.0
	 *
	 * @param array $args Arguments.
	 */
	public static function display_option( $args = array() ) {
		printf(
			'<fieldset><label for="%s"><input type="checkbox" name="%s" value="1"%s /> %s</label><p class="description">%s</p></fieldset>' . "\n",
			self::$setting_name,
			self::$setting_name,
			checked( true, self::should_convert_native_quotes(), false ),
			__( 'Convert existing curly quotes in posts to their non-curly alternatives', 'wpuntexturize' ),
			__( 'The <b>wpuntexturize</b> plugin already prevents non-curly quotes from being converted to curly quotes.', 'wpuntexturize' )
		);
	}

	/**
	 * Returns the replacements.
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	public static function get_replacements() {
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

		if ( self::should_convert_native_quotes() ) {
			$replacements = array_merge(
				$replacements,
				array(
					'“'       => '"', // left double curly quotation mark
					'”'       => '"', // right double curly quotation mark
					'‘'       => "'", // left double curly quotation mark
					'’'       => "'", // right double curly quotation mark
				)
			);
		}

		/**
		 * Filters the character replacements.
		 *
		 * @since 1.6.0
		 *
		 * @param array $replacements Array of replacements; keys are text to replace
		 *                            and values are the text for the replacements.
		 */
		return (array) apply_filters( 'c2c_wpuntexturize_replacements', $replacements );
	}

	/**
	 * Determines if native curly quotes should be converted to their non-curly
	 * alternatives.
	 *
	 * @since 2.0
	 *
	 * @return bool True if quotes should be converted, else false.
	 */
	public static function should_convert_native_quotes() {
		/**
		 * Filters if preexisting curly quotes should be converted to their non-curly
		 * alternatives.
		 *
		 * @since 1.7
		 *
		 * @param bool $convert Convert preexistingmcurly quotes? Default true.
		 */
		return (bool) apply_filters( 'c2c_wpuntexturize_convert_curly_quotes', (bool) get_option( self::$setting_name, false ) );
	}

}

add_action( 'plugins_loaded', array( 'c2c_wpuntexturize', 'init' ) );

if ( ! function_exists( 'c2c_wpuntexturize' ) ) :
	/**
	 * Prevent WordPress from displaying single and double quotation marks as
	 * their curly alternatives.
	 *
	 * Despite the unfortunately misleading name, this plugin is NOT the antithesis
	 * of WordPress's wptexturize() function. This ONLY prevents WordPress from
	 * making HTML entity code substitutions of single and double quotation marks
	 * with their curly alternatives and does NOT prevent wptexturize() from making
	 * any other character and string substitutions.
	 *
	 * @param string $text The text to have quotation characters reverted from HTML entities to plain-text
	 * @return string The converted text
	 */
	function c2c_wpuntexturize( $text ) {
		$replacements = c2c_wpuntexturize::get_replacements();

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
		/**
		 * Filters the hooks to be filtered with wpuntexturize.
		 *
		 * @since 1.2.0
		 *
		 * @param array $filters Array of filter names.
		 */
		return (array) apply_filters( 'wpuntexturize_filters', array(
		 'comment_author', 'term_name', 'link_name', 'link_description', 'link_notes', 'bloginfo', 'wp_title', 'widget_title',
		 'single_post_title', 'single_cat_title', 'single_tag_title', 'single_month_title', 'nav_menu_attr_title', 'nav_menu_description',
		 'term_description', 'get_the_post_type_description',
		 'the_title', 'the_content', 'the_excerpt', 'the_post_thumbnail_caption', 'comment_text', 'list_cats',
		 'widget_text_content', 'widget_text', 'the_excerpt_embed',
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
