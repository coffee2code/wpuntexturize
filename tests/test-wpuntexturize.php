<?php

defined( 'ABSPATH' ) or die();

class WPUntexturize_Test extends WP_UnitTestCase {

	public function tearDown() {
		parent::tearDown();
		// Ensure the filter gets removed
		remove_filter( 'c2c_wpuntexturize_replacements', array( __CLASS__, 'filter_c2c_wpuntexturize_replacements' ) );
	}

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
	public function test_direct_invocation_uncurlies_curly_quotes( $str ) {
		list( $uncurly, $curly ) = $str;
		$this->assertEquals( $uncurly, c2c_wpuntexturize( $curly ) );
	}

	/**
	 * @dataProvider strings_containing_curly_quotes
	 */
	public function test_indirect_invocation_uncurlies_curly_quotes( $str ) {
		list( $uncurly, $curly ) = $str;
		$this->assertEquals( $uncurly, apply_filters( 'c2c_wpuntexturize', $curly ) );
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

}
