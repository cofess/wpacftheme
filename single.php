<?php
/**
 * Page Template - This template is used as the default template of the page
 *
 */
get_header(); ?>
	<div class="container">
		<div class="row">
			<div id="content" class="main-content-inner col-sm-12 col-md-9">
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'views/content/content', 'single' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					get_template_part( 'views/post-type/related', 'post' );

				// End the loop.
				endwhile;
				?>
				<?php if( WpThemeConfig\Configurator::getInstance()->get('theme.share_bigger_img') ){ ?>
		            <?php get_template_part( 'views/post-type/post/post', 'bigger' );?>
		        <?php } ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php get_footer(); ?>