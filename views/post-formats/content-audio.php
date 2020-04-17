<?php // Post Format Audio

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
$second_featured_img_id = get_post_meta( $post->ID, 'second_featured_img_id', true );


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

	<?php if ( 'royal_portfolio' === get_post_type() ) : ?>

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

				$image_id = ( $pPost_effects['nxt_prev_image'] === true ) ? 'all' : get_the_ID();
				$src_length = strpos($rf_audio_embed, 'visual=true"') - strpos($rf_audio_embed, 'src="') + 6;
				$src_position = strpos($rf_audio_embed, 'src="') + 5;
				$rf_audio_embed = substr($rf_audio_embed, $src_position, $src_length);

				echo '<a href="'. esc_url($rf_audio_embed) .'" rel="prettyPhoto['. esc_attr($image_id) .']" data-title="'. esc_attr($attachment_title) .'">';
					echo '<i class="fa fa-'. $pPost_effects['overlay_icon'] .'"></i>';
				echo '</a>';

			} else {

				echo '<a href="'. esc_url(get_the_permalink()) .'">';
					echo '<i class="fa fa-'. esc_attr($pPost_effects['overlay_icon']) .'"></i>';
				echo '</a>';
				
			}

			?>
		</div>

		<!-- Post Type Icon -->
		<div class="post-format-icon">
			<i class="fa fa-<?php echo esc_attr($pPost_formats['audio_icon']); ?>"></i>
		</div>

	<?php else : ?>

		<?php if ( $rf_audio_type === 'embed' ) : ?>

			<!-- Post Audio Media -->
			<div class="audio-media">
				<?php echo wp_kses($rf_audio_embed, $allowed_html); ?>
			</div>

		<?php else : ?>

			<!-- Post Audio Media -->
			<div class="audio-media">
				<audio controls>
				  <source src="<?php echo esc_url( $rf_audio_self_ogg ); ?>" type="audio/ogg">
				  <source src="<?php echo esc_url( $rf_audio_self_mp3 ); ?>" type="audio/mpeg">
				</audio>
			</div>

		<?php endif; ?>

	<?php endif; ?>

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
	if ( 'royal_portfolio' === get_post_type() ) {
		if ( $pPage_general['layout'] === 'fitRows' || strpos( $current_page_obj, 'portfolio_layout_mode="fitRows"' ) !== false ) {
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
	} else {
		if ( $bPage_general['layout'] === 'fitRows' || strpos( $current_page_obj, 'blog_layout_mode="fitRows"' ) !== false ) {
			the_post_thumbnail('royal-blog-post');
		} else {
			the_post_thumbnail();
		}
	}

	?>

<?php endif; ?>