<?php

/* Cannot access pages directly  */ 
if ( ! defined( 'ABSPATH' ) ) { die; }

/**
 * 访问计数
 * http://rubelmiah.com/display-wordpress-post-view-count-without-plugin/
 */
function record_visitors() {
	if (is_singular()) {
		global $post;
		$post_id = $post->ID;
		if ($post_id) {
			$post_views = (int)get_post_meta($post_id, 'views', true);
			if (!update_post_meta($post_id, 'views', ($post_views + 1))) {
				add_post_meta($post_id, 'views', 1, true);
			} 
		} 
	} 
} 
add_action('wp_head', 'record_visitors');

// 函数作用：取得文章的阅读次数
function post_views($before = '(点击 ', $after = ' 次)', $echo = 1) {
	global $post;
	$post_id = $post->ID;
	$views = (int)get_post_meta($post_id, 'views', true);
	if ($echo) echo $before, number_format($views), $after;
	else return $views;
}

// function to display number of posts.
function getPostViews($post_id){
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);
    if($count==''){
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
 
// function to count views.
function setPostViews($post_id) {
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    }else{
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

// add admin column
// https://stackoverflow.com/questions/48673012/adding-column-to-wordpress-admin-for-posts-only-not-custom-post-types
function posts_column_views($columns){
	// $columns = array_insert_after($columns, 'cb', array('post_views'=>__('Views')));
	$columns['post_views'] = __('Views');
	return $columns;
}
function posts_custom_column_views($column, $post_id){
	if($column === 'post_views'){
		echo getPostViews($post_id);
	}
}
add_filter('manage_post_posts_columns', 'posts_column_views');
add_action('manage_post_posts_custom_column', 'posts_custom_column_views',5,2);


// Register the column as sortable
// https://www.smashingmagazine.com/2017/12/customizing-admin-columns-wordpress/
// http://codeandme.net/how-to-add-sortable-column-in-wordpress-admin-area/
function views_column_register_sortable( $columns ) {
	$columns['post_views'] = __('Views');
	return $columns;
}
function smashing_posts_orderby( $query ) {
  if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }
  if ( 'Views' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'views' );
    $query->set( 'meta_key', 'views' );
    $query->set( 'meta_type', 'numeric' );
  }
}
add_filter('manage_edit-post_sortable_columns', 'views_column_register_sortable');
add_action( 'pre_get_posts', 'smashing_posts_orderby' );


