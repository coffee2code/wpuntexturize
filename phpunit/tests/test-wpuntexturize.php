<?php

defined( 'ABSPATH' ) or die();

class WPUntexturize_Test extends WP_UnitTestCase {

	public function tearDown() {
		parent::tearDown();

		unset( $GLOBALS['wp_settings_fields'] );
		unset( $GLOBALS['wp_registered_settings'] );
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
		);
	}

	public static function strings_containing_native_curly_quotes() {
		return array(
			array( array( "'This is single quoted,' I said.", "‘This is single quoted,’ I said." ) ),
			array( array( '"This is double quoted," I said.', '“This is double quoted,” I said.' ) ),
		);
	}

	public static function default_filters() {
		$filters = c2c_wpuntexturize::get_default_filters();
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
		$this->assertEquals( '2.0', c2c_wpuntexturize::version() );
	}

	public function test_hooks_plugins_loaded_for_init() {
		$this->assertEquals( 10, has_action( 'plugins_loaded', array( 'c2c_wpuntexturize', 'init' ) ) );
	}

	public function test_hooks_admin_init_for_initialize_setting() {
		$this->assertEquals( 10, has_action( 'admin_init', array( 'c2c_wpuntexturize', 'initialize_setting' ) ) );
	}

	public function test_setting_name() {
		$this->assertEquals( 'c2c_wpuntexturize', c2c_wpuntexturize::SETTING_NAME );
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
	 * get_default_filters()
	 */

	public function test_get_default_filters() {
		$expected = array(
			'comment_author', 'term_name', 'link_name', 'link_description', 'link_notes', 'bloginfo', 'wp_title', 'widget_title',
			'single_post_title', 'single_cat_title', 'single_tag_title', 'single_month_title', 'nav_menu_attr_title', 'nav_menu_description',
			'term_description', 'get_the_post_type_description',
			'the_title', 'the_content', 'the_excerpt', 'the_post_thumbnail_caption', 'comment_text', 'list_cats',
			'widget_text_content', 'widget_text', 'the_excerpt_embed',
		);

		$this->assertEquals( $expected, c2c_wpuntexturize::get_default_filters() );
	}

	/*
	 * filter: wpuntexturize_filters
	 */

	public function test_filter_wpuntexturize_filters() {
		add_filter( 'wpuntexturize_filters', function( $filters ) {
			// Add something.
			$filters[] = 'c2c_test';
			// Remove something.
			array_shift( $filters );
			return $filters;
		} );

		$default_filters = c2c_wpuntexturize::get_default_filters();

		$this->assertContains( 'c2c_test', $default_filters );
		$this->assertContains( 'term_name', $default_filters );
		$this->assertNotContains( 'comment_author', $default_filters );
	}

	public function test_filter_wpuntexturize_filters_returns_array() {
		add_filter( 'wpuntexturize_filters', function( $filters ) { return 'c2c_test'; } );

		$this->assertIsArray( c2c_wpuntexturize::get_default_filters() );
	}

	/*
	 * plugin_action_links()
	 */

	public function test_plugin_action_links() {
		$existing_item = "this is existing";
		$action_links = c2c_wpuntexturize::plugin_action_links( array( $existing_item ) );

		$this->assertEquals(
			'<a href="http://example.org/wp-admin/options-reading.php#wpuntexturize">Settings</a>',
			$action_links[0]
		);
		$this->assertEquals( $existing_item, $action_links[1] );
	}

	public function test_hooks_plugin_action_links() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		$action = 'plugin_action_links_wpuntexturize/wpuntexturize.php';

		$this->assertFalse( has_action( $action, array ( 'c2c_wpuntexturize', 'plugin_action_links' ) ) );

		c2c_wpuntexturize::initialize_setting();

		$this->assertEquals( 10, has_action( $action, array ( 'c2c_wpuntexturize', 'plugin_action_links' ) ) );
	}

	/*
	 * initialize_setting()
	 */

	public function test_setting_is_registered_for_authorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertArrayHasKey( 'c2c_wpuntexturize', get_registered_settings() );
	}

	public function test_setting_is_not_registered_for_unauthorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'subscriber' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertArrayNotHasKey( 'c2c_wpuntexturize', get_registered_settings() );
	}

	public function test_does_not_hook_whitelist_options_for_unauthorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'subscriber' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertFalse( has_filter( 'whitelist_options', array( 'c2c_wpuntexturize', 'whitelist_options' ) ) );
	}

	public function test_hooks_whitelist_options_for_authorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertEquals( 10, has_filter( 'whitelist_options', array( 'c2c_wpuntexturize', 'whitelist_options' ) ) );
	}

	public function test_does_not_hook_plugin_action_links_for_unauthorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'subscriber' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertFalse( has_filter( 'plugin_action_links_wpuntexturize/wpuntexturize.php', array( 'c2c_wpuntexturize', 'plugin_action_links' ) ) );
	}

	public function test_hooks_plugin_action_links_for_authorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertEquals( 10, has_filter( 'plugin_action_links_wpuntexturize/wpuntexturize.php', array( 'c2c_wpuntexturize', 'plugin_action_links' ) ) );
	}

	public function test_does_not_add_setting_field_for_unauthorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'subscriber' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$this->assertFalse( isset( $GLOBALS['wp_settings_fields'] ) );
	}

	public function test_adds_setting_field_for_authorized_user() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		c2c_wpuntexturize::initialize_setting();

		$expected = array( 'reading' => array(
			'default' => array(
				'c2c_wpuntexturize' => array(
					'id'       => 'c2c_wpuntexturize',
					'title'    => 'Prevent all curly quotes?',
					'callback' => array( 'c2c_wpuntexturize', 'display_option' ),
					'args'     => array(),
				),
			),
		) );

		$this->assertSame( $expected, $GLOBALS['wp_settings_fields'] );
	}

	/*
	 * whitelist_options()
	 */

	/**
	 * @expectedDeprecated add_option_whitelist
	 */
	public function test_whitelist_options() {
		$this->assertSame(
			array( 'example' => array( 'sample' ), 'c2c_wpuntexturize' => array( 'c2c_wpuntexturize' ) ),
			c2c_wpuntexturize::whitelist_options( array( 'example' => array( 'sample' ) ) )
		);
	}

	/*
	 * display_option()
	 */

	public function test_display_option_when_unchecked() {
		update_option( 'c2c_wpuntexturize', '0' );
		c2c_wpuntexturize::display_option();

		$expected = '<fieldset id="wpuntexturize"><label for="c2c_wpuntexturize"><input type="checkbox" name="c2c_wpuntexturize" value="1" /> ';
		$expected .= 'Convert existing curly quotes in posts to their non-curly alternatives';
		$expected .= '</label><p class="description">';
		$expected .= 'The <b>wpuntexturize</b> plugin already prevents non-curly quotes from being converted to curly quotes.';
		$expected .= '</p></fieldset>';

		$this->expectOutputRegex( '~' . preg_quote( $expected ) . '~' );
	}

	public function test_display_option_when_checked() {
		update_option( 'c2c_wpuntexturize', '1' );
		c2c_wpuntexturize::display_option();

		$expected = '<fieldset id="wpuntexturize"><label for="c2c_wpuntexturize"><input type="checkbox" name="c2c_wpuntexturize" value="1" checked=\'checked\' /> ';
		$expected .= 'Convert existing curly quotes in posts to their non-curly alternatives';
		$expected .= '</label><p class="description">';
		$expected .= 'The <b>wpuntexturize</b> plugin already prevents non-curly quotes from being converted to curly quotes.';
		$expected .= '</p></fieldset>';

		$this->expectOutputRegex( '~' . preg_quote( $expected ) . '~' );
	}

	/*
	 * get_replacements()
	 */

	public function test_get_replacements() {
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_false' );
		$expected = array(
			'&#8216;' => "'",
			'&#8217;' => "'",
			'&#8218;' => "'",
			'&#8220;' => '"',
			'&#8221;' => '"',
			'&#8222;' => '"',
			'&#8242;' => "'",
			'&#8243;' => '"',
		);

		$this->assertEquals( $expected, c2c_wpuntexturize::get_replacements() );
	}

	public function test_get_replacements_when_converting_native_curly_quotes() {
		add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_true' );
		$expected = array(
			'&#8216;' => "'",
			'&#8217;' => "'",
			'&#8218;' => "'",
			'&#8220;' => '"',
			'&#8221;' => '"',
			'&#8222;' => '"',
			'&#8242;' => "'",
			'&#8243;' => '"',
			'“'       => '"',
			'”'       => '"',
			'‘'       => "'",
			'’'       => "'",
		);

		$this->assertEquals( $expected, c2c_wpuntexturize::get_replacements() );
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
