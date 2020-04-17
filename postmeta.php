<p class="post-meta">
	  <span class="author vcard"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
	  <span class="published"><i class="fa fa-clock-o"></i> <?php the_time( get_option( 'date_format' ) ); ?> </span>

	<?php if( has_category() ) : ?>
		<span class="category"><i class="fa fa-file" aria-hidden="true"></i> <?php _e( 'Posted In', 'wp-bootstrap-starter' ); ?>: <?php the_category( __( ', ', 'wp-bootstrap-starter' ) ); ?></span>
	<?php endif; ?>

	<?php if( has_tag() ) : ?>
	  <span class="tags"><i class="fa fa-tags"></i> <?php the_tags(); ?></span>
	<?php endif; ?>

	<?php if( current_user_can( 'edit_others_posts' ) ) : ?>
	  <span class="edit"><i class="fa fa-pencil-square-o"></i> <?php edit_post_link( __( 'Edit', 'wp-bootstrap-starter' ) ); ?></span>
	<?php endif; ?>
</p>
