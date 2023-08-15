<?php
/**
 * PHPUnit bootstrap file
 *
 * @package wpuntexturize
 */

$polyfill_path = dirname( __FILE__, 3 ) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';
if ( file_exists( $polyfill_path ) ) {
	require $polyfill_path;
} else {
	echo "Error: PHPUnit Polyfills dependency not found.\n";
	echo "Run: composer require --dev yoast/phpunit-polyfills:\"^2.0\"\n";
	exit;
}

define( 'WPUNTEXTURIZE_PLUGIN_FILE', dirname( __FILE__, 3 ) . '/wpuntexturize.php' );

! defined( 'WP_RUN_CORE_TESTS' ) && define( 'WP_RUN_CORE_TESTS', false );

ini_set( 'display_errors', 'on' );
error_reporting( E_ALL );

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/tests/phpunit/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require WPUNTEXTURIZE_PLUGIN_FILE;
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/tests/phpunit/includes/bootstrap.php';
