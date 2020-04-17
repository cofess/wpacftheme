<?php // Post Format Quote

// background image
$quote_bg = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

// get data from custom fields
$rf_quote_content = get_post_meta( $post->ID, 'rf_quote_content', true );
$rf_quote_title	  = get_post_meta( $post->ID, 'rf_quote_title', true );

?>

<!-- Post Quote -->
<div class="link-and-quote quote-wrap" style="background-image: url(<?php echo esc_url( $quote_bg ); ?>);">
	<p><?php echo esc_html($rf_quote_content); ?></p>
	<small><?php echo esc_html($rf_quote_title); ?></small>
</div>