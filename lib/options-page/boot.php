<?php
/**
 * Setup Options Page
 */

add_action('after_setup_theme', 'acf_options_init');
function acf_options_init() {
  if (!function_exists('acf_add_options_page')) {
    return;
  } 

  require_once 'theme.options.php';
  require_once 'system.options.php';
} 

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
