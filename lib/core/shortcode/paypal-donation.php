<?php
if ( ! defined( 'ABSPATH' ) ) { die; } 

/**
 * add shortcode for paypal donation button in wordpress
 * http://wpcodesnippet.com/add-shortcode-paypal-donation-button-wordpress/
 * @example [paypal account="new-paypal-account" text="Buy me a coffee!"]
 */
function wcs_paypal_donate_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'text' => 'Make a donation',
        'account' => 'paypal-account',
        'for' => '',
    ), $atts ) );
    global $post;
    if ( !$for ) $for = str_replace( " ", "+", $post->post_title );
    return '<a class="paypal_donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' . $account . '&item_name=Donation+for+' . $for . '">' . $text . '</a>';
}
add_shortcode( 'paypal', 'wcs_paypal_donate_shortcode' );
