<?php
if ( ! defined( 'ABSPATH' ) ) { die; }

// add_action( 'admin_menu', $add_taxonomy_as_submenu([
//     'parent'       => 'brand',
//     'singular'     => __('Office Category','BT_TEXTDOMAIN'),
//     'plural'       => __('Office Categories','BT_TEXTDOMAIN'),
//     'capabilities' => 'manage_options',
//     'menu'         => 'edit-tags.php?taxonomy=office_category&post_type=office'
// ]) );

// add_filter( 'parent_file', $set_current_taxonomy_menu_highlight('office','office_category') );

function add_office_category_menu(){
    add_submenu_page(
        'brand', 
        __('Office Category','BT_TEXTDOMAIN'),
        __('Office Categories','BT_TEXTDOMAIN'),
        'edit_posts',
        'edit-tags.php?taxonomy=office_category&post_type=office'
    );
}
add_action( 'admin_menu', 'add_office_category_menu' );

function office_category_current_menu_highlight( $parent_file ) {
    global $submenu_file, $current_screen, $pagenow;

    // var_dump($submenu_file,$current_screen->post_type,$pagenow);

    # Set the submenu as active/current while anywhere in your Custom Post Type (nwcm_news)
    if ( $current_screen->post_type == 'office' ) {

        // if ( $pagenow == 'post.php' ) {
        //     $submenu_file = 'edit.php?post_type=' . $current_screen->post_type;
        // }

        if ( $pagenow == 'edit-tags.php' || $pagenow == 'term.php') {
            $submenu_file = 'edit-tags.php?taxonomy=office_category&post_type=office';
        }

        $parent_file = 'brand';

    }

    return $parent_file;

}

add_filter( 'parent_file', 'office_category_current_menu_highlight' );