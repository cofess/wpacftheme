<?php
if ( ! defined( 'ABSPATH' ) ) { die; } 

// add_action('admin_menu', $add_taxonomy_as_submenu([
//     'parent'       => 'brand',
//     'singular'     => __('Gallery Category','BT_TEXTDOMAIN'),
//     'plural'       => __('Gallery Categories','BT_TEXTDOMAIN'),
//     'capabilities' => 'manage_options',
//     'menu'         => 'edit-tags.php?taxonomy=gallery_category&post_type=gallery'
// ]));

// add_filter( 'parent_file', $set_current_taxonomy_menu_highlight('gallery','gallery_category') );


function add_gallery_category_menu(){
    add_submenu_page(
        'brand',
        __('Gallery Category','BT_TEXTDOMAIN'), 
        __('Gallery Categories','BT_TEXTDOMAIN'), 
        'edit_posts', 
        'edit-tags.php?taxonomy=gallery_category&post_type=gallery'
    );
}
add_action( 'admin_menu', 'add_gallery_category_menu' );

function gallery_category_current_menu_highlight( $parent_file ) {
    global $submenu_file, $current_screen, $pagenow;

    // var_dump($submenu_file,$current_screen->post_type,$pagenow);

    # Set the submenu as active/current while anywhere in your Custom Post Type (nwcm_news)
    if ( $current_screen->post_type == 'gallery' ) {

        // if ( $pagenow == 'post.php' ) {
        //     $submenu_file = 'edit.php?post_type=' . $current_screen->post_type;
        // }

        if ( $pagenow == 'edit-tags.php' || $pagenow == 'term.php') {
            $submenu_file = 'edit-tags.php?taxonomy=gallery_category&post_type=gallery';
        }

        $parent_file = 'brand';

    }

    return $parent_file;

}

add_filter( 'parent_file', 'gallery_category_current_menu_highlight' );