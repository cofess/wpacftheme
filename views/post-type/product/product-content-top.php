<?php
/**
 * https://codex.wordpress.org/Class_Reference/WP_Query
 */
// get the custom post type's taxonomy terms
// $custom_taxterms = wp_get_object_terms( $post->ID, 'product_category');
// $custom_taxterm_ids = wp_get_object_terms( $post->ID, 'product_category', array('fields' => 'ids'));
$custom_taxterms = wp_get_object_terms( $post->ID, 'product_category');
$custom_taxterm_ids = array();
foreach ($custom_taxterms as $tax_slug => $taxonomy) {
    $custom_taxterm_ids[] = $taxonomy->term_id;
    if($taxonomy->parent && !in_array($taxonomy->parent,$custom_taxterm_ids)){
        $custom_taxterm_ids[] = $taxonomy->parent;
    }
}
$args = array( 
	'post_type'      => 'module',
	'post_status'    => 'publish',
	// 'posts_per_page' => -1,
	// 'showposts'      => 1,
	'meta_query'     => array(
        'relation'        => 'AND',
        'position_clause' => array(
			'key'     => 'position',
			'value'   => 'content-top',
			'compare' => '=',
        ),
        'type_clause' => array(
            'key'     => 'bind_taxonomies',
            'value'   => $custom_taxterm_ids,
            'compare' => 'IN',
        ),
    ),
    'orderby'     => 'post_date',
	'order'       => 'desc',
);
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();?>
<section>
    <div class="container">
    <?php tr_components_field('builder');?>
    </div>
</section>
<?php endwhile; wp_reset_query(); ?>