<?php

/**
 * Plugin Name: JolekPress Get Template Part With Variables
 * Plugin URI: https://github.com/JolekPress/Get-Template-Part-With-Variables
 * Description: Adds a new function that works the same as get_template_part, but allows passing of variables using
 * and associative array.
 * Version: 0.1.0
 * Author: John Oleksowicz
 * Author URI: http://jolekpress.com
 */
function find_template_part($slug, $name = null, $variablesArray = []) {
	Lib\Theme\TemplateHelp :: getTemplatePartWithNamedVariables($slug, $name, $variablesArray);
} 

/**
 * 获取用户首字头像
 */
function make_letter_avatar($username, $width = 32) {
	$cache_dir = WP_CONTENT_DIR . '/cache/avatar/'; 
	// 判断是否有缓存目录，创建头像缓存目录
	if (!is_dir($cache_dir)) {
		mkdir($cache_dir, 0755, true);
	} 

	$avatarName = md5($username) . '-' . $width . '.jpg';
	$avatar = WP_CONTENT_URL . '/cache/avatar/' . $avatarName;
	if (file_exists($cache_dir . $avatarName)) {
		// 已缓存用户头像，直接返回用户头像 src
		return $avatar;
	} 

	$letter_avatar = new Lib\Image\Avatar($username, $width); 
	// if(preg_match('/^([\x81-\xfe][\x40-\xfe])+/' , $username)){
	// echo '首字是中文';
	// }else{
	// echo '首字不是中文';
	// }
	$letter_avatar -> Save($cache_dir . $avatarName, $width);
	$letter_avatar -> Free();
	return $avatar;
}

/**
 * Insert a value or key/value pair after a specific key in an array.  If key doesn't exist, value is appended
 * to the end of the array.
 * https://gist.github.com/wpscholar/0deadce1bbfa4adb4e4c
 *
 * @param array $array
 * @param string $key
 * @param array $new_key
 *
 * @return array
 */
function array_insert_after( array $array, $key, array $new_key ) {
	$keys = array_keys( $array );
	$index = array_search( $key, $keys );
	$pos = false === $index ? count( $array ) : $index + 1;
	return array_merge( array_slice( $array, 0, $pos ), $new_key, array_slice( $array, $pos ) );
}

/**
 * Get Current Post Type in the WordPress Admin Area
 * link:https://wp-mix.com/get-current-post-type-wordpress/
 */
function get_current_post_type() {
	global $post, $typenow, $current_screen;

	if ($post && $post -> post_type) {
		return $post -> post_type;
	} elseif ($typenow) {
		return $typenow;
	} elseif ($current_screen && $current_screen -> post_type) {
		return $current_screen -> post_type;
	} elseif (isset($_REQUEST['post_type'])) {
		return sanitize_key($_REQUEST['post_type']);
	} else {
		return null;
	} 
}

function bt_get_thumbnail($img_url, $width=100, $height=200){
	$post_timthumb = get_bloginfo("template_url").'/timthumb.php?src='.$img_url.'&h='.$height.'&w='.$width.'&zc=1'; 
	return $post_timthumb;
}

/**
 * Get related posts of post
 * https://codeless.co/wordpress-related-posts-without-plugin/
 * https://developer.wordpress.org/reference/functions/wp_get_object_terms/
 * // var_dump(bt_get_related_posts( 1, 4, array('post_type'=>'post','taxonomy'=>array('category','post_tag')) ));
 * // var_dump($product_terms = wp_get_object_terms( 1,  array('category','post_tag') ));
 */
function bt_get_related_posts( $post_id, $related_count, $args = array() ) {
	$args = wp_parse_args( $args );
	$post_type = $args['post_type'] ? $args['post_type'] : 'post';
	$taxonomies = $args['taxonomies'];
	if(empty( $taxonomies ) && $post_type == 'post'){
		$taxonomies = array('category','post_tag');
	}
	if ( ! is_array( $taxonomies ) ) {
        $taxonomies = array( $taxonomies );
    }
    $terms = wp_get_object_terms( $post_id,  $taxonomies );
    // var_dump($terms);
    $tax_query = array();
    if ( count( $terms ) > 1 ) {
    	$tax_query['relation'] = 'OR';
        
    }
    foreach ( $terms as $index => $term ) {
        $tax_query[] = array(
	    	'taxonomy' => $term->taxonomy,
	        'field' => 'slug',
	        'terms' => $term->slug
	    );
    }

    // var_dump($tax_query);

    $related_args = array(
		'post_type' => $post_type,
	    'posts_per_page' => $related_count,
	    'post_status' => 'publish',
	    'post__not_in' => array( $post_id ),
	    'orderby' => 'post_date',
	    'tax_query' => $tax_query
	);
  	return new WP_Query( $related_args );
}


/**
 * 隐藏某个分类或者标签下所有文章
 * https://wordpress.stackexchange.com/questions/231258/using-get-terms-with-meta-query-parameters
 * https://wordpress.stackexchange.com/questions/162232/exclude-categories-from-search-query
 * https://wordpress.stackexchange.com/questions/30911/excluding-categories-from-manage-categories-using-a-get-terms-filter/30963
 */
function bt_exclude_taxonomy_posts( $query ) {
  	if ( is_admin() || ! $query->is_main_query() ){
    	return;
  	}

  	$taxonomies = get_taxonomies();
  	$exclude_term_ids = array();
  	$terms = get_terms( array(
		// 'taxonomy' => $taxonomy,
		'hide_empty' => false,
		'meta_query' => array(
		    array(
		       	'key'       => 'is_exclude',
		        'value'     => '1',
		        'compare'   => '='
		    )
		)
	) );
	foreach ($terms as $term=>$v){
    	$exclude_term_ids[] = $v->term_id;
    }
	// foreach ( $taxonomies as $taxonomy ) {
	// 	$terms = get_terms( array(
	// 	    'taxonomy' => $taxonomy,
	// 	    'hide_empty' => false,
	// 	    'meta_query' => array(
	// 	        array(
	// 	        	'key'       => 'is_exclude',
	// 	            'value'     => '1',
	// 	            'compare'   => '='
	// 	        )
	// 	    )
	// 	) );
	// 	foreach ($terms as $term=>$v){
 //           	$exclude_term_ids[] = $v->term_id;
 //        }
	// }

  	$query->set( 'tag__not_in', $exclude_term_ids );
  	$query->set( 'category__not_in', $exclude_term_ids );  	
}
add_action( 'pre_get_posts', 'bt_exclude_taxonomy_posts', 1 );
