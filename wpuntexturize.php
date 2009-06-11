<?php
/*
Plugin Name: wpuntexturize
Version: 1.0
Plugin URI: http://coffee2code.com/wp-plugins/wpuntexturize
Author: Scott Reilly
Author URI: http://coffee2code.com
Description: Prevent WordPress from displaying single and double quotation marks as their curly alternatives.

Despite the unfortunately misleading name, this plugin is NOT the antithesis of WordPress's wptexturize() function.
This ONLY prevents WordPress from making HTML entity code substitutions of single and double quotation marks with 
their curly alternatives and does NOT prevent wptexturize() from making any other character and string substitutions. 

Compatible with WordPress 1.5+, 2.0+, 2.1+, 2.2+, 2.3+, 2.5+, 2.6+, 2.7+, 2.8+.

=>> Read the accompanying readme.txt file for more information.  Also, visit the plugin's homepage
=>> for more information and the latest updates

Installation:

1. Download the file http://coffee2code.com/wp-plugins/wpuntexturize.zip and unzip it into your 
/wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' admin menu in WordPress

*/

/*
Copyright (c) 2004-2009 by Scott Reilly (aka coffee2code)

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

function wpuntexturize($text) {
	$char_codes = array('&#8216;', '&#8217;', '&#8220;', '&#8221;');
	$replacements = array("'", "'", '"', '"');
	return str_replace($char_codes, $replacements, $text);
} // end wpuntexturize()

add_filter('comment_text', 'wpuntexturize', 11);
add_filter('single_post_title', 'wpuntexturize', 11);
add_filter('the_title', 'wpuntexturize', 11);
add_filter('the_content', 'wpuntexturize', 11);
add_filter('the_excerpt', 'wpuntexturize', 11);

?>