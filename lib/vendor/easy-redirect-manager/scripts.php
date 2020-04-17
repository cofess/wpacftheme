<?php

class wps_rm_scripts extends wps_rm {
  
  
  static function admin() {
    $current = get_current_screen();

    $assetsPath = get_template_directory_uri() . str_replace(wp_normalize_path(get_template_directory()),'',wp_normalize_path(dirname(__FILE__)));
    
    if (is_admin() && ($current->base == 'tools_page_wps-redirect-manager' || $current->base == 'tools_page_wps-rm-log')) {
      add_thickbox();
      // wp_enqueue_style(WPS_RM . '-css', $assetsPath . '/css/admin.css', '', wps_rm::$version);
      wp_enqueue_script(WPS_RM . '-js', $assetsPath . '/js/admin.js', array('jquery'), wps_rm::$version);
    }
    
  } // menu
  
  
} // wps_rm_scripts