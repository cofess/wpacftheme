<?php // Post Format Standard

// get theme cusomizer data
$bPage_general 		= get_option('royal_bPage_general');
$bPost_overlay 		= get_option('royal_bPost_overlay');
$pPage_general 		= get_option('royal_pPage_general');
$pPost_effects 		= get_option('royal_pPost_effects');
$gallery_lightbox 	= get_option( 'royal_gallery_lightbox' );

// get post meta data
$second_featured_img_id = get_post_meta( $post->ID, 'second_featured_img_id', true );

// if post format content is loaded on single page
if ( has_post_thumbnail() ) : ?>

	<?php

	// lightbox
	if ( 'royal_portfolio' === get_post_type()  ) {

		$overlay_link 	= $pPost_effects['overlay_click'];
		$overlay_icon 	= $pPost_effects['overlay_icon'];
		$image_size		= 'royal-portfolio-post';
		$layout_mode	= $pPage_general['layout'];
		$image_id		= ( $pPost_effects['nxt_prev_image'] === true ) ? 'all' : get_the_ID();

	} else {

		$overlay_link 	= $bPost_overlay['click'];
		$overlay_icon 	= $bPost_overlay['icon'];
		$image_size		= 'royal-blog-post';
		$layout_mode	= $bPage_general['layout'];
		$image_id		= get_the_ID();

	}

	?>

	<!-- Post Image Overlay -->
	<div class="image-overlay">
		<?php

		// get image ALT text
		$attachment = get_post( get_post_thumbnail_id() );
		$attachment_title = '';

		if ( $attachment !== null ) {
			$attachment_title = esc_attr( $attachment->post_title );
		}
		
		if ( $overlay_link === 'lightbox' ) {
			$full_size_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			echo '<a href="'. esc_url($full_size_img[0]) .'" rel="prettyPhoto['. $image_id .']" data-title="'. $attachment_title .'">';
				echo '<i class="fa fa-'. $overlay_icon .'"></i>';
			echo '</a>';
		} else {
			echo '<a href="'. esc_url(get_the_permalink()) .'">';
				echo '<i class="fa fa-'. $overlay_icon .'"></i>';
			echo '</a>';
		}

		?>
	</div>


	<!-- Post Thumbnail -->
	<?php

	// get current page object
	global $pagename;
	$current_page_obj = get_page_by_path($pagename);
	
	if ( isset($current_page_obj) ) {
		$current_page_obj = $current_page_obj->post_content;
	} else {
		$current_page_obj = 'empty';
	}

	if ( 'royal_portfolio' === get_post_type() ) {

		if ( $layout_mode === 'fitRows' || strpos( $current_page_obj, 'portfolio_layout_mode="fitRows"' ) !== false ) {
			the_post_thumbnail( $image_size );
			if ( $second_featured_img_id !== '' ) {
				echo wp_get_attachment_image( $second_featured_img_id, $image_size );
			}
		} else {
			the_post_thumbnail();
			if ( $second_featured_img_id !== '' ) {
				echo wp_get_attachment_image( $second_featured_img_id, 'full' );
			}
		}

	} else {

		if ( $layout_mode === 'fitRows' || strpos( $current_page_obj, 'blog_layout_mode="fitRows"' ) !== false ) {
			the_post_thumbnail( $image_size );
		} else {
			the_post_thumbnail();
		}

	}

	?>

<?php endif; ?>