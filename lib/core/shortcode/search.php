<?php
if ( ! defined( 'ABSPATH' ) ) { die; } 

/**
 * add search form in post content with shortcode
 * http://wpcodesnippet.com/add-search-form-in-post-content-shortcode/
 * @example [search]
 */
function wcs_search_form_shortcode( ) {
    get_search_form( );
}
add_shortcode( 'search', 'wcs_search_form_shortcode' );
