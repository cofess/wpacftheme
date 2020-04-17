<?php

/*
 * Plugin Name: Sort Users by Post Count
 * WordPress 让后台用户列表可以根据文章数进行排序
 * Description: Add a column to the Users page in the admin to sort users by post counts.https://github.com/ksemel/sort-users-by-post-count
 * http://www.wpdaxue.com/wordpress-sort-users-by-post-count.html
 * Author: Katherine Semel
*/
return function() 
{
    /* Add sorting by post count to user page */
    function add_custom_user_sorts( $columns ) {
        $columns['posts'] = 'post_count';
        return $columns;
	}
	// Make user table sortable by post count
	add_filter( 'manage_users_sortable_columns', 'add_custom_user_sorts' );
};