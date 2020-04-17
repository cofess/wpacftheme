<?php
/**
 * 子分类和父分类使用同一模版
 * http://werdswords.com/force-sub-categories-use-the-parent-category-template/
 * http://wpcodesnippet.com/force-sub-categories-use-parent-category-templates/
 * https://wordpress.stackexchange.com/questions/113075/make-custom-taxonomy-category-use-parent-template
 */
add_filter('template_include', 'research_term_template');
function research_term_template( $template ) {
	if ( is_tax('product_category') ) {
		$category = get_queried_object();
		$parent_id = $category->parent;
		$parent = get_term_by('id', $category->parent, 'product_category');
		$templatename = get_template_directory().'/taxonomy-product_category-'.$parent->slug.'.php';
		if ($parent->slug && file_exists($templatename)){
			return $templatename;
		}
	}
	return $template;
}

/**
 * force sub categories to use parent category templates
 * http://wpcodesnippet.com/force-sub-categories-use-parent-category-templates/
 */
function wcs_force_use_parent_category_template() {

    $category = get_queried_object();
    $templates = array();

    // Add default category template files
    $templates[] = "category-{$category->slug}.php";
    $templates[] = "category-{$category->term_id}.php";

    if ( $category->category_parent != 0 ) {
        $parent = get_category( $category->category_parent );

        if ( !empty($parent) ) {
            $templates[] = "category-{$parent->slug}.php";
            $templates[] = "category-{$parent->term_id}.php";
        }
    }

    $templates[] = 'category.php';
    return locate_template( $templates );
}
add_filter( 'category_template', 'wcs_force_use_parent_category_template' );

/**
 * add inline style on post
 * https://github.com/pickplugins/wp_add_inline_style-on-post
 */
function my_styles_method() {
    if(is_singular()):
        $post_id = get_the_id();
        $color = get_post_meta($post_id, 'color' , true); //E.g. #FF0000
        $custom_css = "
            .page-title{
                background: {$color};
            }";
        wp_register_style( 'custom-style', false );
		wp_enqueue_style( 'custom-style' );
        wp_add_inline_style( 'custom-style', $custom_css );
    endif;
}
add_action( 'wp_enqueue_scripts', 'my_styles_method' );
 
/**
 * automatically spam comments with a long url
 * http://wpcodesnippet.com/automatically-spam-comments-long-url/
 */
function wcs_long_url_comment_spam( $approved , $commentdata ) {
    return ( strlen( $commentdata[ 'comment_author_url' ] ) > 50 ) ? 'spam' : $approved;
}
add_filter( 'pre_comment_approved', 'wcs_long_url_comment_spam', 99, 2 );

/**
 * add all custom post types to rss feed
 * http://wpcodesnippet.com/add-custom-post-types-to-your-rss-feed/
 */
function wcs_all_cpt_in_feed( $vars ) {
    if ( isset( $vars['feed'] ) ) {
        $vars['post_type'] = get_post_types();
    }
    return $vars;
}
add_filter('request', 'wcs_all_cpt_in_feed');