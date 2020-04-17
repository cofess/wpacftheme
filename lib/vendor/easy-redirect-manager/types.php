<?php

class wps_rm_types extends wps_rm {


  static function register() {
    self::register_rm_type();
  } // register


  static function register_rm_type() {
    $labels = array(
      'name'               => __('Redirects', WPS_RM_TEXTDOMAIN),
      'singular_name'      => __('Redirect', WPS_RM_TEXTDOMAIN),
      'menu_name'          => __('Redirects', WPS_RM_TEXTDOMAIN),
      'name_admin_bar'     => __('Redirect', WPS_RM_TEXTDOMAIN),
      'add_new'            => __('Add New', WPS_RM_TEXTDOMAIN),
      'add_new_item'       => __('Add New Redirect', WPS_RM_TEXTDOMAIN),
      'new_item'           => __('New Redirect', WPS_RM_TEXTDOMAIN),
      'edit_item'          => __('Edit Redirect', WPS_RM_TEXTDOMAIN),
      'view_item'          => __('View Redirect', WPS_RM_TEXTDOMAIN),
      'all_items'          => __('All Redirect', WPS_RM_TEXTDOMAIN),
      'search_items'       => __('Search Redirect', WPS_RM_TEXTDOMAIN),
      'parent_item_colon'  => __('Parent Redirect:', WPS_RM_TEXTDOMAIN),
      'not_found'          => __('No backups found.', WPS_RM_TEXTDOMAIN),
      'not_found_in_trash' => __('No backups found in Trash.', WPS_RM_TEXTDOMAIN)
   );

    $args = array(
      'labels'             => $labels,
      'description'        => __('All Redirect.', WPS_RM_TEXTDOMAIN),
      'public'             => false,
      'publicly_queryable' => false,
      'show_ui'            => false,
      'show_in_menu'       => false,
      'query_var'          => false,
      'rewrite'            => array('slug' => 'wps-redirects'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array('title', 'editor')
   );

    register_post_type('wps-redirects', $args);
  } // register_rm_type
  


} // wps_rm_types