<?php

/*
 |--------------------------------------------------------------------------
 | Attachment Pages Redirect
 |--------------------------------------------------------------------------
 |
 | * Makes attachment pages redirects (301) to post parent if any. If not, redirects (302) to home page.
 */

return function($value)
{

	if ( ! defined( 'ATTACHMENT_REDIRECT_CODE' ) ) {
		define ( 'ATTACHMENT_REDIRECT_CODE', '301' ); // Default redirect code for attachments with existing parent post
	}

	if ( ! defined( 'ORPHAN_ATTACHMENT_REDIRECT_CODE' ) ) {
		define ( 'ORPHAN_ATTACHMENT_REDIRECT_CODE', '302' ); // Default redirect code for attachments with no parent post
	}


	function attachment_pages_redirect() {

		global $post;

		if ( is_attachment() && isset( $post->post_parent ) && is_numeric( $post->post_parent ) && ( $post->post_parent != 0 ) ) {

			$parent_post_in_trash = get_post_status( $post->post_parent ) === 'trash' ? true : false; 

			if ( $parent_post_in_trash ) { 
				wp_die( 'Page not found.', '404 - Page not found', 404 ); // Prevent endless redirection loop in old WP releases and redirecting to trashed posts if an attachment page is visited when parent post is in trash
			}

			wp_safe_redirect( get_permalink( $post->post_parent ), ATTACHMENT_REDIRECT_CODE ); // Redirect to post/page from where attachment was uploaded
			exit;	

		} elseif ( is_attachment() && isset( $post->post_parent ) && is_numeric( $post->post_parent ) && ( $post->post_parent < 1 ) ) {

			wp_safe_redirect( get_bloginfo( 'wpurl' ), ORPHAN_ATTACHMENT_REDIRECT_CODE ); // Redirect to home for attachments not associated to any post/page
			exit;

		}


	}

	add_action( 'template_redirect', 'attachment_pages_redirect', 1 );
};