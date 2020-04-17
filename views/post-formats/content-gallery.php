<?php // Post Format Gallery

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
$second_featured_img_id = get_post_meta( $post->ID, 'second_featured_img_id', true );

?>

<?php if ( 'royal_portfolio' === get_post_type()  ) : ?>

	<!-- Post Image Overlay -->
	<div class="image-overlay">

		<?php 

		// get image ALT text
		$attachment = get_post( get_post_thumbnail_id() );
		$attachment_title = '';

		if ( $attachment !== null ) {
			$attachment_title = esc_attr( $attachment->post_title );
		}
			
		if ( $pPost_effects['overlay_click'] === 'lightbox' ) {
			$full_size_img 	= wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			$image_id		= ( $pPost_effects['nxt_prev_image'] === true ) ? 'all' : get_the_ID();

			echo '<a href="'. esc_url($full_size_img[0]) .'" rel="prettyPhoto['. $image_id .']" data-title="'. $attachment_title .'">';
				echo '<i class="fa fa-'. $pPost_effects['overlay_icon'] .'"></i>';
			echo '</a>';

		} else {

			echo '<a href="'. esc_url(get_the_permalink()) .'">';
				echo '<i class="fa fa-'. $pPost_effects['overlay_icon'] .'"></i>';
			echo '</a>';
			
		}

		?>

	</div>

	<!-- Post Type Icon -->
	<div class="post-format-icon">
		<i class="fa fa-<?php echo esc_attr($pPost_formats['gallery_icon']); ?>"></i>
	</div>
	
	<?php

	// get current page object
	global $pagename;
	$current_page_obj = get_page_by_path($pagename);

	if ( isset($current_page_obj) ) {
		$current_page_obj = $current_page_obj->post_content;
	} else {
		$current_page_obj = 'empty';
	}

	// Post Thumbnail
	if ( $pPage_general['layout'] === 'fitRows' || strpos( $current_page_obj, 'portfolio_layout_mode="fitRows"' ) !== false ){
		the_post_thumbnail('royal-portfolio-post');
		if ( $second_featured_img_id !== '' ) {
			echo wp_get_attachment_image( $second_featured_img_id, 'royal-portfolio-post' );
		}
	} else {
		the_post_thumbnail();
		if ( $second_featured_img_id !== '' ) {
			echo wp_get_attachment_image( $second_featured_img_id, 'full' );
		}
	}

	?>

<?php else : ?>

	<!-- Post Gallery Slideshow -->
	<div class="gallery-slideshow">

		<div class="cycle-slideshow" data-cycle-slides="> div" data-cycle-timeout="0" data-cycle-prev=".prev-<?php the_ID(); ?>" data-cycle-next=".nxt-<?php the_ID(); ?>" data-cycle-pause-on-hover="true"> 

			<?php foreach ( $rf_gallery_img_ids as $rf_gallery_img_id ) : ?>

				<div class="gallery-slide">
					<?php

					// get current page object
					global $pagename;
					$current_page_obj = get_page_by_path($pagename);

					if ( isset($current_page_obj) ) {
						$current_page_obj = $current_page_obj->post_content;
					} else {
						$current_page_obj = 'empty';
					}

					$thumbnail_size = ( $bPage_general['layout'] === 'fitRows' || strpos( $current_page_obj, 'blog_layout_mode="fitRows"' ) !== false ) ? 'royal-blog-post' : '';

					echo wp_get_attachment_image( $rf_gallery_img_id, $thumbnail_size );

					?>
				</div>

			<?php endforeach; ?>

		</div>

		<!-- Gallery Navigation -->
		<span class="prev-<?php the_ID(); ?> gallery-prev-slide gallery-arrow rf-button">
			<i class="fa fa-<?php echo esc_attr($gallery_arrows['prev_nxt_icon']); ?>-left"></i>
		</span>
		<span class="nxt-<?php the_ID(); ?> gallery-next-slide gallery-arrow rf-button">
			<i class="fa fa-<?php echo esc_attr($gallery_arrows['prev_nxt_icon']); ?>-right"></i>
		</span>

	</div>


<?php endif; ?>