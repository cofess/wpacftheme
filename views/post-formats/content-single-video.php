<?php // Post Format Video

if ( post_password_required() ) {
	return;
}

// get theme cusomizer data
$bPage_general 	= get_option( 'royal_bPage_general' );
$bPost_overlay 	= get_option( 'royal_bPost_overlay' );
$pPost_formats 	= get_option( 'royal_pPost_formats' );
$pPage_general 	= get_option( 'royal_pPage_general' );
$pPost_effects 	= get_option( 'royal_pPost_effects' );


// get data from custom fields
$rf_video_type  	= get_post_meta( $post->ID, 'rf_video_type', true );
$rf_video_embed 	= get_post_meta( $post->ID, 'rf_video_embed', true );
$rf_video_self_mp4  = get_post_meta( $post->ID, 'rf_video_self_mp4', true );
$rf_video_self_ogv  = get_post_meta( $post->ID, 'rf_video_self_ogv', true );


// allowed html for ifame embed
$allowed_html = array(
    'iframe' => array(
        'src'                   => array(),
        'width'                 => array(),
        'height'                => array(),
        'frameborder'           => array(),
        'allowfullscreen'       => array(),
        'mozallowfullscreen'    => array(),
        'webkitallowfullscreen' => array()
    )
);


if ( has_post_thumbnail() ) : ?>

	<?php if ( is_single() ) : ?>

		<!-- Single Featured Media -->
		<div class="featured-media">

			<?php if ( $rf_video_type === 'embed' ) : ?>

				<!-- Post Video Media -->
				<div class="video-media">
					<?php echo wp_kses($rf_video_embed, $allowed_html); ?>
				</div>

			<?php elseif ( $rf_video_type === 'self-hosted' ) : ?>

				<!-- Post Video Media -->
				<div class="video-media">
					<video controls>
					  <source src="<?php echo esc_url( $rf_video_self_mp4 ); ?>" type="video/mp4">
					  <source src="<?php echo esc_url( $rf_video_self_ogv ); ?>" type="video/ogg">
					</video>
				</div>
				
			<?php endif; ?>

		</div>

	<?php endif; ?>

<?php endif; ?>