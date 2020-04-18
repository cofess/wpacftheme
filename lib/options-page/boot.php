<?php
/**
 * Setup Options Page
 */

add_action('after_setup_theme', 'acf_options_init');
function acf_options_init() {
  if (!function_exists('acf_add_options_page')) {
    return;
  } 

  acf_add_options_page([
    'page_title' => 'Site Options',
    'menu_title' => 'Site Options',
    'menu_slug' => 'common_site_options',
    'capability' => 'manage_options',
    'update_button'   => __('Update', 'acf'),
    'updated_message' => __("Options Updated", 'acf'),
    // 'redirect' => true
  ]);
  
  acf_add_options_sub_page([
    'page_title' => 'Code Injection',
    'menu_title' => 'Code Injection',
    // 'menu_slug' => 'code_injection',
    'parent_slug' => 'common_site_options',
    'capability' => 'manage_options',
    'update_button'   => __('Update', 'acf'),
    'updated_message' => __("Options Updated", 'acf'),
  ]);
  acf_add_options_sub_page([
    'page_title' => 'Other Services',
    'menu_title' => 'Other Services',
    // 'menu_slug' => 'other_services',
    'parent_slug' => 'common_site_options',
    'capability' => 'manage_options',
    'update_button'   => __('Update', 'acf'),
    'updated_message' => __("Options Updated", 'acf'),
  ]);

  add_filter('acf/settings/save_json', 'my_acf_json_save_point');
  function my_acf_json_save_point($path) {
    // update path
    $path = get_stylesheet_directory() . '/lib/options-page/json'; 
    // return
    return $path;
  } 

  add_filter('acf/settings/load_json', 'my_acf_json_load_point');
  function my_acf_json_load_point($paths) {
    // remove original path (optional)
    unset($paths[0]); 
    // append path
    $paths[] = get_stylesheet_directory() . '/lib/options-page/json'; 
    // return
    return $paths;
  }
  
  require_once 'theme.options.php';
} 
