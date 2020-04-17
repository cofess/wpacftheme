<?php // Post Format Gallery

if ( post_password_required() ) {
	return;
}

// get theme cusomizer data
$bPage_general 		= get_option( 'royal_bPage_general' );
$bPost_overlay 		= get_option( 'royal_bPost_overlay' );
$pPost_formats 		= get_option( 'royal_pPost_formats' );
$pPage_general 		= get_option( 'royal_pPage_general' );
$pPost_effects 		= get_option( 'royal_pPost_effects' );

$gallery_general 	= get_option( 'royal_gallery' );
$stacked_caption 	= get_option( 'royal_stacked_caption' );
$gallery_arrows 	= get_option( 'royal_gallery_arrows' );
$gallery_lightbox 	= get_option( 'royal_gallery_lightbox' );


// get post meta data
$rf_gallery_type 	= get_post_meta( $post->ID, 'rf_gallery_type', true );
$rf_gallery_img_ids = get_post_meta( $post->ID, 'rf_gallery_img_ids', true );
$rf_gallery_img_ids = explode( ',', $rf_gallery_img_ids );

?>

	<!-- Blog Single Gallery Slideshow -->
	<div class="gallery-slideshow">

		<?php if ( $rf_gallery_type === 'slideshow' ) : ?>

			<div class="cycle-slideshow" data-cycle-slides="> div" data-cycle-prev=".prev-<?php the_ID(); ?>" data-cycle-next=".nxt-<?php the_ID(); ?>" data-cycle-pager=".gallery-nav" data-cycle-pause-on-hover="true" data-cycle-fx="<?php echo esc_attr($gallery_general['effect']); ?>" data-cycle-speed="<?php echo esc_attr($gallery_general['transition']); ?>" data-cycle-timeout="<?php echo esc_attr($gallery_general['delay']); ?>" data-cycle-easing="swing">

				<?php

				foreach ( $rf_gallery_img_ids as $rf_gallery_img_id ) {

					// gallery slide caption
					$gallery_img 		 = get_post( $rf_gallery_img_id );
					$gallery_img_caption = '';
					$gallery_img_title 	 = '';

					if ( $gallery_img !== null ) {
						$gallery_img_caption = esc_html( $gallery_img->post_excerpt );
						$gallery_img_title	 = esc_attr( $gallery_img->post_title );
					}


					$html  = '<div class="gallery-slide">';

						if ( trim($gallery_img_caption) !== '' ) {
							$html .= '<p class="slideshow-caption">'. $gallery_img_caption .'</p>';
						}		

						$html .= '<div class="image-overlay-wrap lightbox-overlay">';

						$html .= '<a href="'. esc_url(wp_get_attachment_url( $rf_gallery_img_id )) .'" class="image-overlay" rel="prettyPhoto[gallery-slide]" data-title="'. $gallery_img_title .'"><i class="fa fa-'. $gallery_lightbox['icon'] .'"></i></a>';
						$html .= '<img src="'. esc_url(wp_get_attachment_url( $rf_gallery_img_id )) .'" alt="'. $gallery_img_title .'" />';
						
						$html .= '</div>';

					$html .= '</div>';

					echo ''. $html;
				}

				?>

			</div>

			<!-- Gallery Navigation -->
			<span class="prev-<?php the_ID(); ?> gallery-prev-slide gallery-arrow rf-button">
				<i class="fa fa-<?php echo esc_attr($gallery_arrows['prev_nxt_icon']); ?>-left"></i>
			</span>
			<span class="nxt-<?php the_ID(); ?> gallery-next-slide gallery-arrow rf-button">
				<i class="fa fa-<?php echo esc_attr($gallery_arrows['prev_nxt_icon']); ?>-right"></i>
			</span>
			<div class="gallery-nav"></div>

		<?php elseif ( $rf_gallery_type === 'stacked' ) : ?>

			<?php

			foreach ( $rf_gallery_img_ids as $rf_gallery_img_id ) {

				// gallery slide caption
				$gallery_img 		 = get_post( $rf_gallery_img_id );
				$gallery_img_caption = '';
				$gallery_img_title 	 = '';

				if ( $gallery_img !== null ) {
					$gallery_img_caption = esc_html( $gallery_img->post_excerpt );
					$gallery_img_title	 = esc_attr( $gallery_img->post_title );
				}

				$html  = '<div class="gallery-slide">';	

					// caption top
					if ( trim($gallery_img_caption) !== '' && $stacked_caption['position'] === 'top' ) {
						$html .= '<p class="stacked-caption"><span>'. $gallery_img_caption .'</span></p>';
					}

					// image overlay
					$html .= '<div class="image-overlay-wrap lightbox-overlay">';

					$html .= '<a href="'. esc_url(wp_get_attachment_url( $rf_gallery_img_id )) .'" class="image-overlay" rel="prettyPhoto[gallery-slide]" data-title="'. $gallery_img_title .'"><i class="fa fa-'. $gallery_lightbox['icon'] .'"></i></a>';
					$html .= '<img src="'. esc_url(wp_get_attachment_url( $rf_gallery_img_id )) .'" alt="'. $gallery_img_title .'" />';
					
					$html .= '</div>';

					// caption bottom
					if ( trim($gallery_img_caption) !== '' && $stacked_caption['position'] === 'bottom' ) {
						$html .= '<p class="stacked-caption"><span>'. $gallery_img_caption .'</span></p>';
					}	

				$html .= '</div>';

				echo ''. $html;
			}

			?>

		<?php endif; ?>

	</div>