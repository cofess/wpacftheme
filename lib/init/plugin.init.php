<?php

if ( ! defined( 'ABSPATH' ) ) { die; } 

/*
 |--------------------------------------------------------------------------
 | woocommerce
 |--------------------------------------------------------------------------
*/
// woocommerce support
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

// woocommerce产品属性列表撑破表格
function fixed_woocommerce_product_attributes_table(){
	$style = '';
	$style .= '<style type="text/css">';
	$style .= '.attributes-table .attribute-terms {display: block;width:60px!important;overflow: hidden !important; text-overflow: ellipsis !important; white-space: nowrap !important; word-wrap: normal !important;}';
	$style .= '</style>';
	echo $style;
}
// add_action('admin_head', 'fixed_woocommerce_product_attributes_table' );

// Display 60 Woocommerce products per page.
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 60;' ), 20 );

add_filter( 'woocommerce_output_related_products_args', 'bbloomer_change_number_related_products', 9999 );

function bbloomer_change_number_related_products( $args ) {
 $args['posts_per_page'] = 10; // # of related products
 $args['columns'] = 5; // # of columns per row
 return $args;
}

/*
 |--------------------------------------------------------------------------
 | yoast seo
 |--------------------------------------------------------------------------
*/
add_filter( 'wpseo_metabox_prio', 'BT_yoast_seo_metabox_priority' );
function BT_yoast_seo_metabox_priority() {
  //* Accepts 'high', 'default', 'low'. Default is 'high'.
  return 'low';
}

/*
 |--------------------------------------------------------------------------
 | Download Monitor
 |--------------------------------------------------------------------------
*/
function remove_all_dlm_css() {
    wp_deregister_style( 'dlm-frontend' );
}
add_action('wp_print_styles', 'remove_all_dlm_css' );

/*
 |--------------------------------------------------------------------------
 | WP Libre Form
 |--------------------------------------------------------------------------
 | 发送邮件
*/
// send thankyou email
// add_action( 'wplf_post_validate_submission', 'my_email_thankyou' );
function my_email_thankyou( $return ) {
  // recipient details from submission
  $name = sanitize_text_field( $_POST['name'] );
  $email = sanitize_email( $_POST['email'] );

  // email subject
  $subject = __( 'Thank You For Submitting A Form' );

  // text body of email
  $body = wp_sprintf( __('Thanks, %s for clicking Submit on this glorious HTML5 Form!'), $name );

  // send the email
  wp_send_mail( $email, $subject, $body );
}

// send email copy
remove_action( 'wplf_post_validate_submission', 'wplf_send_email_copy', 20 );
add_action( 'wplf_post_validate_submission', 'my_send_email_copy', 20 );
function my_send_email_copy( $return, $submission_id = null ) {
  if ( ! $submission_id ) {
    $submission_id = $return->submission_id;
  }

  // _form_id is already validated and we know it exists by this point
  $form_id = intval( ( isset( $submission_id ) ) ?
    get_post_meta( $submission_id, '_form_id', true ) : $_POST['_form_id'] );

  $form = get_post( intval( $form_id ) );

  $form_title = esc_html( get_the_title( $form ) );
  $form_meta = get_post_meta( $form_id );

  $referrer = esc_url_raw( ( isset( $submission_id ) ) ?
    get_post_meta( $submission_id, 'referrer', true ) : $_POST['referrer'] );

  if ( ( isset( $form_meta['_wplf_email_copy_enabled'] ) && $form_meta['_wplf_email_copy_enabled'][0] )
    || isset( $submission_id ) ) {

    $to = isset( $form_meta['_wplf_email_copy_to'] ) ?
      $form_meta['_wplf_email_copy_to'][0] : get_option( 'admin_email' );

    // translators: %1$s is submission ID, %2$s is URL where form was submitted
    $subject = wp_sprintf( __( '[%1$s] New submission to %2$s', 'wp-libre-form' ), $submission_id, $referrer );

    if ( isset( $submission_id ) ) {
      $to = get_post_meta( $submission_id, '_wplf_email_copy_to', true );
      // translators: %1$s is submission ID, %2$s is URL where form was submitted
      $subject = wp_sprintf( __( '[%1$s] Submission from %2$s', 'wp-libre-form' ), $submission_id, $referrer );
    }

    $to = empty( $to ) ? get_option( 'admin_email' ) : $to;
    $content = wp_sprintf(
      // translators: %1$s is form title, %2$d is form ID
      __( 'Form "%1$s" (ID %2$d) was submitted with values below: ', 'wp-libre-form' ), $form_title, $form_id );
    $content = apply_filters( 'wplf_email_copy_content_start', $content, $form_title, $form_id ) . "\n\n";

    $fields = $_POST;
    if ( isset( $submission_id ) ) {
      $fields = get_post_meta( $submission_id );
    }

    foreach ( $fields as $key => $value ) {
      if ( '_' === $key[0] ) {
        continue;
      }
      if ( is_array( $value ) ) { // in case input type="radio" submits an array
        $value = implode( ', ', $value );
      }
      // @codingStandardsIgnoreStart
      // WP coding standards don't like print_r
      // @TODO: come up with a prettier format for default mail output
      $content .= esc_html( $key ) . ': ' . esc_html( print_r( $value, true ) ) . "\n";
      // @codingStandardsIgnoreEnd
    }

    // default pre-filtered values for email headers and attachments
    $headers = '';
    $attachments = array();

    // allow filtering email fields
    $to = apply_filters( 'wplf_email_copy_to', $to );
    $subject = apply_filters( 'wplf_email_copy_subject', $subject );
    $content = apply_filters( 'wplf_email_copy_content', $content );
    $headers = apply_filters( 'wplf_email_copy_headers', $headers );
    $attachments = apply_filters( 'wplf_email_copy_attachments', $attachments );

    // form slug specific filters
    $to = apply_filters( "wplf_{$form->post_name}_email_copy_to", $to );
    $subject = apply_filters( "wplf_{$form->post_name}_email_copy_subject", $subject );
    $content = apply_filters( "wplf_{$form->post_name}_email_copy_content", $content );
    $headers = apply_filters( "wplf_{$form->post_name}_email_copy_headers", $headers );
    $attachments = apply_filters( "wplf_{$form->post_name}_email_copy_attachments", $attachments );

    // form ID specific filters
    $to = apply_filters( "wplf_{$form->ID}_email_copy_to", $to );
    $subject = apply_filters( "wplf_{$form->ID}_email_copy_subject", $subject );
    $content = apply_filters( "wplf_{$form->ID}_email_copy_content", $content );
    $headers = apply_filters( "wplf_{$form->ID}_email_copy_headers", $headers );
    $attachments = apply_filters( "wplf_{$form->ID}_email_copy_attachments", $attachments );

    wp_send_mail( $to, $subject, $content, $headers, $attachments );
  }
}