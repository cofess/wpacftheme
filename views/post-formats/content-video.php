<?php // Post Format Video

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
$second_featured_img_id = get_post_meta( $post->ID, 'second_featured_img_id', true );


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
		
			$rf_video_lightbox = '';

			if ( $rf_video_type === 'embed' ) {
				if ( strpos($rf_video_embed, 'www.youtube.com') ) {
					$rf_video_embed = substr($rf_video_embed, strpos($rf_video_embed, 'embed/') + 6, strlen($rf_video_embed));
					$rf_video_embed = substr($rf_video_embed, 0, strpos($rf_video_embed, '"'));
					$rf_video_lightbox = 'https://youtu.be/'. $rf_video_embed;
				} elseif ( strpos($rf_video_embed, 'player.vimeo.com') ) {
					$rf_video_embed = substr($rf_video_embed, strpos($rf_video_embed, 'video/') + 6, strlen($rf_video_embed));
					$rf_video_embed = substr($rf_video_embed, 0, strpos($rf_video_embed, '"'));
					$rf_video_lightbox = 'http://vimeo.com/'. $rf_video_embed;
				}
			} else {
				$full_size_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				$rf_video_lightbox = $full_size_img[0];
			}

			if ( $pPost_effects['overlay_click'] === 'lightbox' ) {

				$image_id = ( $pPost_effects['nxt_prev_image'] === true ) ? 'all' : get_the_ID();

				echo '<a href="'. esc_url($rf_video_lightbox) .'" rel="prettyPhoto['. $image_id .']" data-title="'. $attachment_title .'">';
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
			<i class="fa fa-<?php echo esc_attr($pPost_formats['video_icon']); ?>"></i>
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

		?>

	<?php else : ?>

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

	<?php endif; ?>

<?php endif; ?>