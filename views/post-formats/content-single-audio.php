<?php // Post Format Audio

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
$rf_audio_type  	= get_post_meta( $post->ID, 'rf_audio_type', true );
$rf_audio_embed 	= get_post_meta( $post->ID, 'rf_audio_embed', true );
$rf_audio_self_mp3  = get_post_meta( $post->ID, 'rf_audio_self_mp3', true );
$rf_audio_self_ogg  = get_post_meta( $post->ID, 'rf_audio_self_ogg', true );


// allowed html for ifame embed
$allowed_html = array(
	'iframe' => array(
		'src'			=> array(),
		'width'			=> array(),
		'height'		=> array(),
		'frameborder' 	=> array(),
		'scrolling'		=> array()
	)
);


if ( has_post_thumbnail() ) : ?>

	<?php if ( is_single() ) : ?>

		<!-- Single Featured Media -->
		<div class="featured-media">
				
			<?php if ( $rf_audio_type === 'embed' ) : ?>

				<!-- Post Audio Media -->
				<div class="audio-media">
					<?php echo wp_kses($rf_audio_embed, $allowed_html); ?>
				</div>

			<?php elseif ( $rf_audio_type === 'self-hosted' ) : ?>

				<!-- Post Audio Media -->
				<div class="audio-media">
					<audio controls>
					  <source src="<?php echo esc_url( $rf_audio_self_ogg ); ?>" type="audio/ogg">
					  <source src="<?php echo esc_url( $rf_audio_self_mp3 ); ?>" type="audio/mpeg">
					</audio>
				</div>
				
			<?php endif; ?>
			
			<!-- Post Thumbnail -->
			<?php the_post_thumbnail(); ?>

		</div>

	<?php endif; ?>

<?php endif; ?>