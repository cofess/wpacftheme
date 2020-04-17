<?php

class wps_rm_pages extends wps_rm {
  
  
  static function init_admin() {
    require_once 'templates/admin/init.php';
  } // menu  
  
  
  static function redirects_table() {
    require_once 'templates/admin/redirects-table.php';
  } // redirects_table  
  
  
  static function redirect_log() {
    require_once 'templates/admin/redirect-log.php';
  } // redirect_log
  
  

  
} // wps_rm_pages