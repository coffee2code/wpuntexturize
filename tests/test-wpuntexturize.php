<?php

class WPUntexturize_Test extends WP_UnitTestCase {

	/**
	 *
	 * DATA PROVIDERS
	 *
	 */


	static function strings_containing_non_curly_quotes() {
		return array(
			array( '"This string is double-quoted."' ),
			array( "'This string is single-quoted.'" ),
			array( "The rope is 9' long." ),
			array( 'The yarn is 9" long.' ),
			array( "I can't stand curly quotes." ),
			array( "It 'twas time the curly quotes got uncurled." ),
		);
	}

	static function strings_containing_curly_quotes() {
		return array(
			array( array( '"This string is double-quoted."', '&#8220;This string is double-quoted.&#8221;' ) ),
			array( array( "'This string is single-quoted.'", "&#8216;This string is single-quoted.&#8217;" ) ),
			array( array( "The rope is 9' long.", "The rope is 9&#8242; long." ) ),
			array( array( 'The yarn is 9" long.', 'The yarn is 9&#8243; long.' ) ),
			array( array( "I can't stand curly quotes.", "I can&#8217;t stand curly quotes." ) ),
			array( array( "It 'twas time the curly quotes got uncurled.", "It &#8217;twas time the curly quotes got uncurled." ) ),
		);
	}

	static function default_filters() {
		$filters = c2c_wpuntexturize_get_default_filters();
		return array_map( function( $x)  { return array( $x ); }, $filters );
	}

	static function char_codes() {
		return array(
			array( array( "'", '&#8216;' ) ),
			array( array( "'", '&#8217;' ) ),
			array( array( '"', '&#8220;' ) ),
			array( array( '"', '&#8221;' ) ),
			array( array( "'", '&#8242;' ) ),
			array( array( '"', '&#8243;' ) ),
		);
	}


	/**
	 *
	 * TESTS
	 *
	 */


	/**
	 * @dataProvider strings_containing_non_curly_quotes
	 */
	function test_direct_invocation_retains_non_curly_quotes( $str ) {
		$this->assertEquals( $str, c2c_wpuntexturize( $str ) );
	}

	/**
	 * @dataProvider strings_containing_curly_quotes
	 */
	function test_direct_invocation_uncurlies_curly_quotes( $str ) {
		list( $uncurly, $curly ) = $str;
		$this->assertEquals( $uncurly, c2c_wpuntexturize( $curly ) );
	}

	/**
	 * @dataProvider char_codes
	 */
	function test_direct_invocation_replace_quote_html_entities( $str ) {
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
	function test_deprecated_function_retains_non_curly_quotes( $str ) {
		$this->assertEquals( $str, wpuntexturize( $str ) );
	}

	/**
	 * Test deprecated function, at least while it's still present.
	 *
	 * @dataProvider strings_containing_curly_quotes
	 *
	 * @expectedDeprecated wpuntexturize
	 */
	function test_deprecated_function_uncurlies_curly_quotes( $str ) {
		list( $uncurly, $curly ) = $str;
		$this->assertEquals( $uncurly, wpuntexturize( $curly ) );
	}

	/**
	 * @dataProvider default_filters
	 */
	function test_wpuntexturize_is_hooked_to_all_default_filters( $filter ) {
		$default_hook_priority = 11;
		$this->assertEquals( $default_hook_priority, has_filter( $filter, 'c2c_wpuntexturize' ) );
	}
}
