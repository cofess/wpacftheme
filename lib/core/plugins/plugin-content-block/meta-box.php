<?php

// Meta boxes on block edit page
function cpw_add_meta_boxes() {
	add_meta_box( 'cpw_shortcode', __( 'Content Block Shortcodes', 'custom-post-widget' ), 'cpw_shortcode_meta_box', 'block', 'advanced' );
}
add_action( 'add_meta_boxes_block', 'cpw_add_meta_boxes' );

// Shortcode meta box
function cpw_shortcode_meta_box( $post ) { ?>
	<p><?php _e( 'You can place this content block into your posts, pages, custom post types or widgets using the shortcode below:','custom-post-widget' ); ?></p>
	<code class="cpw-code" id="cpw-shortcode-1"><?php echo '[content_block id=' . $post -> ID . ']'; ?></code>
	<!-- <span class="cpw-clipboard" data-clipboard-target="#cpw-shortcode-1"><?php _e( 'Copy to clipboard', 'custom-post-widget' ); ?></span> -->

	<p><?php _e( 'Shortcode to use if you prefer using the slug instead of the post ID:','custom-post-widget' ); ?></p>
	<code class="cpw-code" id="cpw-shortcode-2"><?php echo '[content_block slug=' . $post -> post_name . ']'; ?></code>
	<!-- <span class="cpw-clipboard" data-clipboard-target="#cpw-shortcode-2"><?php _e( 'Copy to clipboard', 'custom-post-widget' ); ?></span> -->

	<p><?php _e( 'Use this shortcode to include the content block title:','custom-post-widget' ); ?></p>
	<code class="cpw-code" id="cpw-shortcode-3"><?php echo '[content_block id=' . $post -> ID . ' title=yes title_tag=h3]'; ?></code>
	<!-- <span class="cpw-clipboard" data-clipboard-target="#cpw-shortcode-3"><?php _e( 'Copy to clipboard', 'custom-post-widget' ); ?></span> -->
<?php
}
