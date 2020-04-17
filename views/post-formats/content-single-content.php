<?php // Post Format Standard

if ( post_password_required() ) {
	return;
}

// get theme cusomizer data
$bPage_general 		= get_option('royal_bPage_general');
$bPost_overlay 		= get_option('royal_bPost_overlay');
$pPage_general 		= get_option('royal_pPage_general');
$pPost_effects 		= get_option('royal_pPost_effects');
$gallery_lightbox 	= get_option( 'royal_gallery_lightbox' );

// if post format content is loaded on single page
if ( has_post_thumbnail() ) :

	// get featured image object to display image title in lightbox popup // awaiting moderation
	$attachment = get_post( get_post_thumbnail_id() );
	$url 		= wp_get_attachment_url( get_post_thumbnail_id() );
	$attachment_title = '';

	if ( $attachment !== null ) {
		$attachment_title = esc_attr( $attachment->post_title );
	}

	// get data from custom fields
	$rf_exc_featured_img = get_post_meta( get_the_ID(), 'rf_exc_featured_img', true );

	?>

	<?php if ( $rf_exc_featured_img !== 'yes' ) : ?>

		<!-- Single Featured Media -->
		<div class="featured-media">

			<!-- Post Image Overlay -->
			<div class="image-overlay-wrap lightbox-overlay">

				<a href="<?php echo esc_url( $url ); ?>" class="image-overlay" rel="prettyPhoto" data-title="<?php echo esc_attr($attachment_title); ?>">
					<i class="fa fa-<?php echo esc_attr($gallery_lightbox['icon']);?>"></i>
				</a>

				<!-- Post Thumbnail -->
				<?php the_post_thumbnail(); ?>

			</div>

		</div>

	<?php endif; ?>

<?php endif; ?>