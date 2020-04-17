<?php
/*
Easy Redirect Manager
Copyright © 2016 Premium WP Suite
*/
class wps_rm_rules extends wps_rm {


  static function register() {
    if (!session_id()) {
      session_start();
    }

    $url = rtrim($_SERVER['REQUEST_URI'], '/');

    // Search through all
    $redirects = get_posts(array('post_type' => 'wps-redirects', 'posts_per_page' => '-1'));
    if ($redirects) {

      foreach ($redirects as $redirect) {
        $source = get_post_meta($redirect->ID, 'wps-source', true);
        if (fnmatch($source, $url)) {
          $target = get_post_meta($redirect->ID, 'wps-target', true);
          $status = get_post_meta($redirect->ID, 'wps-redirect_code', true);

          // Count hits
          $unqiue_hits = get_post_meta($redirect->ID, 'wps-unique_runs', true);

          if (!isset($_SESSION[WPS_RM . '-' . $redirect->ID])) {
            $_SESSION[WPS_RM . '-' . $redirect->ID] = time();
            $unqiue_hits++;
          }

          $total_hits = get_post_meta($redirect->ID, 'wps-total_runs', true);
          $total_hits++;

          // Update meta
          update_post_meta($redirect->ID, 'wps-unique_runs', $unqiue_hits);
          update_post_meta($redirect->ID, 'wps-total_runs', $total_hits);
          update_post_meta($redirect->ID, 'wps-last_run', current_time('mysql'));

          // Write Log
          wps_rm::write_log(array('source' => $url, 'target' => $target, 'code' => $status));

          self::redirect($target, $status);
          exit();
        }
      }

    }

    // No wildcard matched
    if ($url != '/' && $url != '') {
      self::find_plain_source($url);
    }

  } // register


  static function redirect($target, $status) {
    if ($status != 'cloak') {
      wp_redirect($target, $status);
      exit();
    } else {
      echo '<!DOCTYPE html>
      <head>
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>' . get_bloginfo('name') . '</title>
      <style type="text/css">
      html, body { padding: 0; margin: 0; border: 0; height: 100%; overflow: hidden; }
      iframe { width: 100%; height: 100%; border: 0; margin: 0; padding: 0; }
      </style>
      </head>
      <body>
      <iframe src="' . $target . '"></iframe>
      </body>
      </html>';
      exit;
    }
  } // redirect


  static function find_plain_source($url) {

    $redirects = get_posts(array('post_type' => 'wps-redirects', 'posts_per_page' => '1', 'meta_key' => 'wps-source', 'meta_value' => $url));
    if ($redirects) {
      // Get redirect target
      $target = get_post_meta($redirects[0]->ID, 'wps-target', true);
      $status = get_post_meta($redirects[0]->ID, 'wps-redirect_code', true);

      // Count hits
      $unqiue_hits = get_post_meta($redirects[0]->ID, 'wps-unique_runs', true);

      if (!isset($_SESSION[WPS_RM . '-' . $redirects[0]->ID])) {
        $_SESSION[WPS_RM . '-' . $redirects[0]->ID] = time();
        $unqiue_hits++;
      }

      $total_hits = get_post_meta($redirects[0]->ID, 'wps-total_runs', true);
      $total_hits++;

      // Update meta
      update_post_meta($redirects[0]->ID, 'wps-unique_runs', $unqiue_hits);
      update_post_meta($redirects[0]->ID, 'wps-total_runs', $total_hits);
      update_post_meta($redirects[0]->ID, 'wps-last_run', current_time('mysql'));

      // Write Log
      wps_rm::write_log(array('source' => $url, 'target' => $target, 'code' => $status));

      self::redirect($target, $status);
    }
  } // find_plain_source


  static function is_404() {
    $url = rtrim($_SERVER['REQUEST_URI'], '/');

    if (is_404()) {
      // Write Log
      wps_rm::write_log(array('source' => $url, 'target' => 'Default WordPress 404 Error', 'code' => '404'));
    }
  } // is_404


} // wps_rm_rules