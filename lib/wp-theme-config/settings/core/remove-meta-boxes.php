<?php

/*
 |--------------------------------------------------------------------------
 | remove meta box
 |--------------------------------------------------------------------------
 | https://codex.wordpress.org/Function_Reference/remove_meta_box
 | https://wordpress.stackexchange.com/questions/131814/if-current-user-is-admin-or-editor
 |
 */

return function ($option)
{
    global $removeboxes;
    $removeboxes = $option;
    // var_dump($removeboxes);
    function remove_meta_boxes() {
        global $removeboxes;
        foreach ($removeboxes as $key => $value) {
            // var_dump(!is_array($value['role']));
            if(isset($value['role'])){
                $user = wp_get_current_user();
                $allowed_roles = array();
                if(!is_array($value['role'])){
                    $allowed_roles[] = $value['role'];
                } else {
                    $allowed_roles = $value['role'];
                }
                if( array_intersect($allowed_roles, $user->roles) ) {
                    foreach ($value['page'] as $key => $page) {
                        remove_meta_box( $value['id'], $page, 'normal' );
                    }                 
                }
            } else {
                foreach ($value['page'] as $key => $page) {
                    remove_meta_box( $value['id'], $page, 'normal' );
                }
            }
        }
    }
    add_action( 'admin_menu', 'remove_meta_boxes' );
};