<?php

defined( 'ABSPATH' ) or die();

class WPUntexturize_Test extends WP_UnitTestCase {

	//
	//
	// DATA PROVIDERS
	//
	//


	public static function strings_containing_non_curly_quotes() {
		return array(
			array( '"This string is double-quoted."' ),
			array( "'This string is single-quoted.'" ),
			array( "The rope is 9' long." ),
			array( 'The yarn is 9" long.' ),
			array( "I can't stand curly quotes." ),
			array( "It 'twas time the curly quotes got uncurled." ),
		);
	}

	public static function strings_containing_curly_quotes() {
		return array(
			array( array( '"This string is double-quoted."', '&#8220;This string is double-quoted.&#8221;' ) ),
			array( array( "'This string is single-quoted.'", "&#8216;This string is single-quoted.&#8217;" ) ),
			array( array( "The rope is 9' long.", "The rope is 9&#8242; long." ) ),
			array( array( 'The yarn is 9" long.', 'The yarn is 9&#8243; long.' ) ),
			array( array( "I can't stand curly quotes.", "I can&#8217;t stand curly quotes." ) ),
			array( array( "It 'twas time the curly quotes got uncurled.", "It &#8217;twas time the curly quotes got uncurled." ) ),
			array( array( "She said 'free my cat' to me.", 'She said &#8218;free my cat&#8217; to me.' ) ),
			array( array( 'She said "free my cat" to me.', 'She said &#8222;free my cat&#8221; to me.' ) ),
		);
	}

	public static function strings_containing_native_curly_quotes() {
		return array(
			array( array( "'This is single quoted,' I said.", "‘This is single quoted,’ I said." ) ),
			array( array( '"This is double quoted," I said.', '“This is double quoted,” I said.' ) ),
		);
	}

	public static function default_filters() {
		$filters = c2c_wpuntexturize_get_default_filters();
		return array_map( function( $x )  { return array( $x ); }, $filters );
	}

	public static function char_codes() {
		return array(
			array( array( "'", '&#8216;' ) ),
			array( array( "'", '&#8217;' ) ),
			array( array( "'", '&#8218;' ) ),
			array( array( '"', '&#8220;' ) ),
			array( array( '"', '&#8221;' ) ),
			array( array( '"', '&#8222;' ) ),
			array( array( "'", '&#8242;' ) ),
			array( array( '"', '&#8243;' ) ),
		);
	}

	public static function filter_c2c_wpuntexturize_replacements( $replacements ) {
		$replacements['&copy;'] = '(c)';
		return $replacements;
	}

	//
	//
	// TESTS
	//
	//


	public function test_class_is_available() {
		$this->assertTrue( class_exists( 'c2c_wpuntexturize' ) );
	}

	public function test_plugin_version() {
		$this->assertEquals( '1.7.1', c2c_wpuntexturize::version() );
	}

	public function test_hooks_plugins_loaded_for_init() {
		$this->assertEquals( 10, has_action( 'plugins_loaded', array( 'c2c_wpuntexturize', 'init' ) ) );
	}

	public function test_hooks_admin_init_for_initialize_setting() {
		$this->assertEquals( 10, has_action( 'admin_init', array( 'c2c_wpuntexturize', 'initialize_setting' ) ) );
	}

	public function test_setting_is_not_registered_for_unauthorized_user() {
		c2c_wpuntexturize::initialize_setting();

		$this->assertFalse( in_array( 'c2c_wpuntexturize', array_keys( get_registered_settings() ) ) );
	}

	public function test_setting_is_registered_for_authorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertTrue( in_array( 'c2c_wpuntexturize', array_keys( get_registered_settings() ) ) );
	}

	public function test_does_not_hook_whitelist_options_for_unauthorized_user() {
		c2c_wpuntexturize::initialize_setting();

		$this->assertFalse( has_filter( 'whitelist_options', array( 'c2c_wpuntexturize', 'whitelist_options' ) ) );
	}

	public function test_hooks_whitelist_options_for_authorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertEquals( 10, has_filter( 'whitelist_options', array( 'c2c_wpuntexturize', 'whitelist_options' ) ) );
	}

	/**
	 * @dataProvider strings_containing_non_curly_quotes
	 */
	public function test_direct_invocation_retains_non_curly_quotes( $str ) {
		$this->assertEquals( $str, c2c_wpuntexturize( $str ) );
	}

	/**
	 * @dataProvider strings_containing_non_curly_quotes
	 */
	public function test_indirect_invocation_retains_non_curly_quotes( $str ) {
		$this->assertEquals( $str, apply_filters( 'c2c_wpuntexturize', $str ) );
	}

	/**
	 * @dataProvider strings_containing_curly_quotes
	 */
	public function test_direct_invocation_uncurlies_curly_quotes( $str, $uncurly_single_characters = true ) {
		list( $uncurly, $curly ) = $str;

		if ( ! $uncurly_single_characters && false === strpos( $curly, '&#8' ) ) {
			$this->assertEquals( $curly, c2c_wpuntexturize( $curly ) );
		} else {
			$this->assertEquals( $uncurly, c2c_wpuntexturize( $curly ) );
		}
	}

	/**
	 * @dataProvider strings_containing_native_curly_quotes
	 */
	public function test_direct_invocation_uncurlies_native_curly_quotes( $str ) {
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_true' );
		list( $uncurly, $curly ) = $str;

		$this->assertEquals( $uncurly, c2c_wpuntexturize( $curly ) );
	}

	/**
	 * @dataProvider strings_containing_native_curly_quotes
	 */
	public function test_direct_invocation_does_not_uncurly_native_curly_quotes_if_disabled( $str ) {
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_false' );
		list( $uncurly, $curly ) = $str;

		$this->assertEquals( $curly, c2c_wpuntexturize( $curly ) );
	}

	/**
	 * @dataProvider strings_containing_curly_quotes
	 */
	public function test_indirect_invocation_uncurlies_curly_quotes( $str ) {
		list( $uncurly, $curly ) = $str;
		$this->assertEquals( $uncurly, apply_filters( 'c2c_wpuntexturize', $curly ) );
	}

	/**
	 * @dataProvider strings_containing_native_curly_quotes
	 */
	public function test_indirect_invocation_uncurlies_native_curly_quotes( $str ) {
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_true' );
		list( $uncurly, $curly ) = $str;

		$this->assertEquals( $uncurly, apply_filters( 'c2c_wpuntexturize', $curly ) );
	}

	/**
	 * @dataProvider strings_containing_native_curly_quotes
	 */
	public function test_indirect_invocation_does_not_uncurly_native_curly_quotes_if_disabled( $str ) {
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_false' );
		list( $uncurly, $curly ) = $str;

		$this->assertEquals( $curly, apply_filters( 'c2c_wpuntexturize', $curly ) );
	}

	/**
	 * @dataProvider char_codes
	 */
	public function test_direct_invocation_replace_quote_html_entities( $str ) {
		list( $uncurly, $curly ) = $str;
		$this->assertEquals( $uncurly, c2c_wpuntexturize( $curly ) );
	}

	/**
	 * Test deprecated function, at least while it's still present.
	 *
	 * @dataProvider strings_containing_non_curly_quotes
	 *
	 * @expectedDeprecated wpuntexturize
	 */
	public function test_deprecated_function_retains_non_curly_quotes( $str ) {
		$this->assertEquals( $str, wpuntexturize( $str ) );
	}

	/**
	 * Test deprecated function, at least while it's still present.
	 *
	 * @dataProvider strings_containing_curly_quotes
	 *
	 * @expectedDeprecated wpuntexturize
	 */
	public function test_deprecated_function_uncurlies_curly_quotes( $str ) {
		list( $uncurly, $curly ) = $str;
		$this->assertEquals( $uncurly, wpuntexturize( $curly ) );
	}

	/**
	 * Test deprecated function, at least while it's still present.
	 *
	 * @dataProvider strings_containing_curly_quotes
	 *
	 * @expectedDeprecated wpuntexturize
	 */
	public function test_deprecated_filter_invocation_uncurlies_curly_quotes( $str ) {
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_true' );
		list( $uncurly, $curly ) = $str;
		$this->assertEquals( $uncurly, apply_filters( 'wpuntexturize', $curly ) );
	}

	/**
	 * @dataProvider default_filters
	 */
	public function test_wpuntexturize_is_hooked_to_all_default_filters( $filter ) {
		$default_hook_priority = 11;
		$this->assertEquals( $default_hook_priority, has_filter( $filter, 'c2c_wpuntexturize' ) );
	}

	public function test_filter_c2c_wpuntexturize_replacements() {
		add_filter( 'c2c_wpuntexturize_replacements', array( __CLASS__, 'filter_c2c_wpuntexturize_replacements' ) );

		$this->assertEquals( '(c) 2017', c2c_wpuntexturize( '&copy; 2017' ) );
	}

	/*
	 * display_option()
	 */

	public function test_display_option_when_unchecked() {
		update_option( 'c2c_wpuntexturize', '0' );
		c2c_wpuntexturize::display_option();

		$expected = '<fieldset><label for="c2c_wpuntexturize"><input type="checkbox" name="c2c_wpuntexturize" value="1" /> ';
		$expected .= 'Convert existing curly quotes in posts to their non-curly alternatives';
		$expected .= '</label><p class="description">';
		$expected .= 'The <b>wpuntexturize</b> plugin already prevents non-curly quotes from being converted to curly quotes.';
		$expected .= '</p></fieldset>';

		$this->expectOutputRegex( '~' . preg_quote( $expected ) . '~' );
	}

	public function test_display_option_when_checked() {
		update_option( 'c2c_wpuntexturize', '1' );
		c2c_wpuntexturize::display_option();

		$expected = '<fieldset><label for="c2c_wpuntexturize"><input type="checkbox" name="c2c_wpuntexturize" value="1" checked=\'checked\' /> ';
		$expected .= 'Convert existing curly quotes in posts to their non-curly alternatives';
		$expected .= '</label><p class="description">';
		$expected .= 'The <b>wpuntexturize</b> plugin already prevents non-curly quotes from being converted to curly quotes.';
		$expected .= '</p></fieldset>';

		$this->expectOutputRegex( '~' . preg_quote( $expected ) . '~' );
	}

	/*
	 * should_convert_native_quotes()
	 */

	public function test_should_convert_native_quotes_when_setting_is_true() {
		update_option( 'c2c_wpuntexturize', '1' );

		$this->assertTrue( c2c_wpuntexturize::should_convert_native_quotes() );
	}

	public function test_should_convert_native_quotes_when_setting_is_false() {
		update_option( 'c2c_wpuntexturize', '0' );

		$this->assertFalse( c2c_wpuntexturize::should_convert_native_quotes() );
	}

	/*
	 * filter: c2c_wpuntexturize_convert_curly_quotes
	 */

	public function test_filter_c2c_wpuntexturize_convert_curly_quotes_when_false() {
		update_option( 'c2c_wpuntexturize', '0' );
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_true' );

		$this->assertTrue( c2c_wpuntexturize::should_convert_native_quotes() );
	}

	public function test_filter_c2c_wpuntexturize_convert_curly_quotes() {
		update_option( 'c2c_wpuntexturize', '1' );
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_false' );

		$this->assertFalse( c2c_wpuntexturize::should_convert_native_quotes() );
	}

}
