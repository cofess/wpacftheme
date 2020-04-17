<?php
if ( ! defined( 'ABSPATH' ) ) { die; }

$add_taxonomy_as_submenu = function($settings = []) {
    return function() use($settings) {
        add_submenu_page(
            $settings[parent],
            $settings[singular],
            $settings[plural],
            $settings['capabilities'],
            $settings['menu']
        );
    };

};

$set_current_taxonomy_menu_highlight = function($post_type,$taxonomy,$parent_file = null) {
    return function() use($post_type,$taxonomy) {
        
        global $submenu_file, $current_screen, $pagenow;

        // var_dump($submenu_file,$current_screen->post_type,$pagenow);
        // var_dump($post_type,$taxonomy);

        # Set the submenu as active/current while anywhere in your Custom Post Type (nwcm_news)
        if ( $current_screen->post_type == $post_type ) {

            // if ( $pagenow == 'post.php' ) {
            //     $submenu_file = 'edit.php?post_type=' . $current_screen->post_type;
            // }

            if ( $pagenow == 'edit-tags.php' || $pagenow == 'term.php') {
                $submenu_file = 'edit-tags.php?taxonomy='.$taxonomy.'&post_type='.$post_type;
            }

            $parent_file = 'brand';

        }

        return $parent_file;
    };

};

// function add_taxonomy_as_submenu(){
//     add_submenu_page(
//         'brand', 
//         __('Office Category','BT_TEXTDOMAIN'),
//         __('Office Categories','BT_TEXTDOMAIN'),
//         'manage_options',
//         'edit-tags.php?taxonomy=office_category&post_type=office'
//     );
// }
// add_action( 'admin_menu', 'add_taxonomy_as_submenu' );

// function bt_set_current_menu( $parent_file ) {
//     global $submenu_file, $current_screen, $pagenow;

//     // var_dump($submenu_file,$current_screen->post_type,$pagenow);

//     # Set the submenu as active/current while anywhere in your Custom Post Type (nwcm_news)
//     if ( $current_screen->post_type == 'office' ) {

//         // if ( $pagenow == 'post.php' ) {
//         //     $submenu_file = 'edit.php?post_type=' . $current_screen->post_type;
//         // }

//         if ( $pagenow == 'edit-tags.php' || $pagenow == 'term.php') {
//             $submenu_file = 'edit-tags.php?taxonomy=office_category&post_type=office';
//         }

//         $parent_file = 'brand';

//     }

//     return $parent_file;

// }

// add_filter( 'parent_file', 'bt_set_current_menu' );