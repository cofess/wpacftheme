<!-- begin custom related loop --> 
<?php 
/**
 * https://isabelcastillo.com/related-custom-post-type-taxonomy
 */ 
// get the custom post type's taxonomy terms
$custom_taxterms = wp_get_object_terms( $post->ID, 'product_category', array('fields' => 'ids') );

// arguments
$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 8,                   // you may edit this number
    'orderby'        => 'rand',
    'post__not_in'   => array ($post->ID),
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_category',
            'field'    => 'id',
            'terms'    => $custom_taxterms
        )
    ),  
);
$related_items = new WP_Query( $args );

// loop over query
if ($related_items->have_posts()) :?>
<section class="related-product products">
    <div class="container">
        <h3 class="title with-line fs-2">Related Products</h3>
        <div class="owl-carousel owl-navigation-right owl-navigation-icon owl-navigation-square" data-navigation-text='["", ""]' data-navigation="true" data-dots="false" data-scroll-per-page="true" data-margin="15" data-items-custom="[[0, 2],[576, 2],[768, 3],[992, 4],[1200, 3],[1440, 4]]">
            <?php while ( $related_items->have_posts() ) : $related_items->the_post();?>
            <div class="item item-product wow">
                <?php get_template_part( "templates/item/item-product" ) ?>
            </div>
            <?php endwhile;?>
        </div>
        <a class="btn btn-default btn-simple w-5" href="<?php echo get_post_type_archive_link( 'product' ); ?>">
            <span class="pull-left">All Products</span>
            <span class="pull-right"><i class="fa fa-angle-right fa-fw"></i></span>
        </a>
    </div>
</section>
<?php endif;

// Reset Post Data
wp_reset_postdata();
?>
<!-- end custom related loop -->