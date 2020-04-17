<?php

class wps_rm_menus extends wps_rm {
  
  
  static function menu() {
    // add_menu_page('Easy Redirect', 'Easy Redirect', 'manage_options', 'wps-redirect-manager', array('wps_rm_pages', 'init_admin'), '', 60);
    add_submenu_page('tools.php', 'Redirect Manager', 'Redirect Manager', 'manage_options', 'wps-redirect-manager', array('wps_rm_pages', 'init_admin'));
    add_submenu_page('tools.php', 'Redirect Log', 'Redirect Log', 'manage_options', 'wps-rm-log', array('wps_rm_pages', 'redirect_log'));
  } // menu
  
  
} // wps_rm_menus