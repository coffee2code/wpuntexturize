# Developer Documentation

## Hooks

The plugin is further customizable via four hooks. Such code should ideally be put into a mu-plugin or site-specific plugin (which is beyond the scope of this readme to explain).

### `c2c_wpuntexturize` _(filter)_

The `c2c_wpuntexturize` filter allows you to use an alternative approach to safely invoke `c2c_wpuntexturize()` in such a way that if the plugin were deactivated or deleted, then your calls to the function won't cause errors in your site. This only applies if you use the function directly, which is not typical usage for most users.

#### Arguments:

* none

#### Example:

Instead of:

`<?php echo c2c_wpuntexturize( $mytext ); ?>`

Do:

`<?php echo apply_filters( 'c2c_wpuntexturize', $mytext ); ?>`

### `wpuntexturize_filters` _(filter)_

The `wpuntexturize_filters` filter allows you to customize what filters to hook to be filtered with wpuntexturize. See the Description section for a complete list of all filters that are filtered by default.

#### Arguments:

* **$filters** _(array)_: The default array of filters.

#### Example:

```php
/**
 * Add additional filters to get wpuntexturize'd.
 *
 * @param array $filters Filters that will receive the wpuntexturize treatement.
 * @return array
 */
function more_wpuntexturize_filters( $filters ) {
	$filters[] = 'event_description';
	return $filters;
}
add_filter( 'wpuntexturize_filters', 'more_wpuntexturize_filters' );
```

### `c2c_wpuntexturize_replacements` _(filter)_

The `c2c_wpuntexturize_replacements` filter allows you to customize the character replacements handled by the plugin.

#### Arguments:

* **$replacements** _(array)_: Array where the keys are the characters to be replace, and the values are their respective replacements.

#### Example:

```php
/**
 * Add and remove to/from default wpuntexturize replacements.
 *
 * @param array $replacements
 * @return array
 */
function c2c_change_wpuntexturize_replacements( $replacements ) {
	// Remove low 9 quotation mark replacements.
	unset( $replacements['&#8218;'] );
	unset( $replacements['&#8222;'] );

	// Replace copyright.
	$replacements['&copy;'] = '(c)';

	return $replacements;
}
add_filter( 'c2c_wpuntexturize_replacements', 'c2c_change_wpuntexturize_replacements' );
```

### `c2c_wpuntexturize_convert_curly_quotes` _(filter)_

The `c2c_wpuntexturize_convert_curly_quotes` filter allows you to enable conversion of preexisting curly quotes into their non-curly alternatives.

#### Arguments:

* **$convert** _(boolean)_: Convert preexisting curly quotes? Default false.

#### Example:

```php
// Convert preexisting curly quotes into non-curly quotes.
add_filter( 'c2c_wpuntexturize_convert_curly_quotes', '__return_true' );
```
