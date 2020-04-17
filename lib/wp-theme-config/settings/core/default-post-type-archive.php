<?php
/**
 * has_archive for default post type
 * https://wordpress.stackexchange.com/questions/31089/has-archive-for-default-post-type
 */
return function($value) {
	add_action( 'init', 'default_post_type_archive' );
	function default_post_type_archive( ) {
		$post_type = 'post';
	    $post_type_object = get_post_type_object( $post_type);
	    $post_type_object->show_in_nav_menus = 'true';
	    $post_type_object->has_archive = 'true';
	    $post_type_object->rewrite = array(
	        'slug' => 'blog',
	        'with_front' => 0,
	        'pages' => 1,
	    );
	}
	add_rewrite_rule( '^blog$','index.php?post_type=post','top' );
	add_rewrite_rule( '^blog/page/([0-9]{1,})/?$','index.php?post_type=post&paged=$matches[1]','top' );
};