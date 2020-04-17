<?php // Post Format Link

// background image
$link_bg = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

// get data from custom fields
$rf_link_description = get_post_meta( $post->ID, 'rf_link_description', true );
$rf_link_title 		 = get_post_meta( $post->ID, 'rf_link_title', true );
$rf_link_url 		 = get_post_meta( $post->ID, 'rf_link_url', true );

?>

<!-- Post Link -->
<div class="link-and-quote link-wrap" style="background-image: url(<?php echo esc_url( $link_bg ); ?>);">
	<p><?php echo esc_html($rf_link_description); ?></p>
	<small><a href="<?php echo esc_url($rf_link_url); ?>" target="_blank"><?php echo esc_html($rf_link_title); ?></a></small>
</div>