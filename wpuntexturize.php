<?php
/**
 * Plugin Name: wpuntexturize
 * Version:     2.2.2
 * Plugin URI:  https://coffee2code.com/wp-plugins/wpuntexturize/
 * Author:      Scott Reilly
 * Author URI:  https//coffee2code.com/
 * Text Domain: wpuntexturize
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Prevent WordPress from converting single and double quotation marks into their curly alternatives, and optionally also convert existing curly quotation marks into their non-curly alternatives.
 *
 * Compatible with WordPress 1.5+ through 6.6+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/wpuntexturize/
 *
 * @package wpuntexturize
 * @author  Scott Reilly
 * @version 2.2.2
 */

/*
	Copyright (c) 2004-2024 by Scott Reilly (aka coffee2code)

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

if ( ! class_exists( 'c2c_wpuntexturize' ) ) :

class c2c_wpuntexturize {

	/**
	 * Name of plugin's setting.
	 *
	 * @since 2.0
	 * @var string
	 */
	const SETTING_NAME = 'c2c_wpuntexturize';

	/**
	 * Returns version of the plugin.
	 *
	 * @since 2.0
	 */
	public static function version() {
		return '2.2.2';
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

		foreach( self::get_default_filters() as $filter ) {
			add_filter( $filter, 'c2c_wpuntexturize', 11 );
		}
	}

	/**
	 * Determines if the running WordPress is WP 5.5 or later.
	 *
	 * @since 2.1
	 *
	 * @return bool True if WP is 5.5 or later, else false.
	 */
	public static function is_wp_55_or_later() {
		return version_compare( $GLOBALS['wp_version'], '5.5', '>=' );
	}

	/**
	 * Gets the list of filters that wpuntexturize() is applied to by default.
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	public static function get_default_filters() {
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

	/**
	 * Adds a 'Settings' link to the plugin action links.
	 *
	 * @since 2.0
	 *
	 * @param string[] $action_links An array of plugin action links.
	 * @return array
	 */
	public static function plugin_action_links( $action_links ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'options-reading.php' ) . '#wpuntexturize' ),
			__( 'Settings', 'wpuntexturize' )
		);
		array_unshift( $action_links, $settings_link );

		return $action_links;
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

		register_setting( 'reading', self::SETTING_NAME );

		add_filter(
			self::is_wp_55_or_later() ? 'allowed_options' : 'whitelist_options',
			array( __CLASS__, 'allowed_options' )
		);

		add_settings_field(
			self::SETTING_NAME,
			__( 'Prevent all curly quotes?', 'wpuntexturize' ),
			array( __CLASS__, 'display_option' ),
			'reading'
		);

		// Add link to settings page from the plugin's action links on plugin page.
		add_filter( 'plugin_action_links_wpuntexturize/wpuntexturize.php', array( __CLASS__, 'plugin_action_links' ) );
	}

	/**
	 * Allows the plugin's option(s)
	 *
	 * @since 2.0
	 * @since 2.1 Renamed from `whitelist_options()`.
	 *
	 * @param array $options Array of allowed options.
	 * @return array The amended allowed options array.
	 */
	public static function allowed_options( $options ) {
		$added = array( self::SETTING_NAME => array( self::SETTING_NAME ) );

		return self::is_wp_55_or_later()
			? add_allowed_options( $added, $options )
			: add_option_whitelist( $added, $options );
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
			'<fieldset id="wpuntexturize"><label for="%s"><input type="checkbox" name="%s" value="1"%s /> %s</label><p class="description">%s</p></fieldset>' . "\n",
			esc_attr( self::SETTING_NAME ),
			esc_attr( self::SETTING_NAME ),
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
		 * @param bool $convert Convert preexisting curly quotes? Default false.
		 */
		return (bool) apply_filters( 'c2c_wpuntexturize_convert_curly_quotes', (bool) get_option( self::SETTING_NAME, false ) );
	}

}

add_action( 'plugins_loaded', array( 'c2c_wpuntexturize', 'init' ) );

endif; // end if !class_exists()

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
