<?php
/*
Plugin name: Easy Redirect Manager
Author: Premium WP Suite
Author URI: http://www.premiumwpsuite.com
Version: 2.18.18
Description: Manage your redirection links with an ease! View detailed redirection logs including default 404 WordPress Errors.
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

include_once 'menus.php';
include_once 'pages.php';
include_once 'types.php';
include_once 'scripts.php';
include_once 'redirect-rules.php';


define('WPS_RM_TEXTDOMAIN', 'wps-rm');
define('WPS_RM', 'wps-redirect-manager');
define('WPS_RM_URL', plugins_url('/', __FILE__));

class wps_rm {

  static $version = '2.18.18';


  static function init() {

    if (is_admin()) {
      // Actions
      self::save_redirect_rule();

      // Hooks
      add_action('admin_menu', array('wps_rm_menus', 'menu'));
      add_action('admin_enqueue_scripts', array('wps_rm_scripts', 'admin'));

      // Ajax
      add_action('wp_ajax_wps_remove_rule', array(__CLASS__, 'remove_rule'));
      add_action('wp_ajax_wps_clear_logs', array(__CLASS__, 'clear_logs'));
    } else {
      // Hook it up
      add_action('send_headers', array('wps_rm_rules', 'register'));
      add_action('template_redirect', array('wps_rm_rules', 'is_404'));
    }

    wps_rm_types::register();

  } // init


  public static function clear_logs() {
    global $wpdb;
    $redirects = $wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . "rm_log");
    wp_send_json_success();
  } // clear_logs


  static function remove_rule() {
    $rule_ID = trim($_POST['rule_id']);

    if (!empty($rule_ID)) {
      wp_delete_post($rule_ID, true);
      wp_send_json_success();
    } else {
      wp_send_json_error();
    }

    die();
  } // remove_rule


  static function save_redirect_rule() {
    if (!empty($_POST['wps-rm']) && empty($_POST['wps-rm']['edit-id'])) {

      if (empty($_POST['wps-rm'])) {
        set_transient('wps-rule-exists', 'Your entered source URL needs to start with "/".', '5');
        return false;
      }
      
      $post_data = $_POST['wps-rm'];
      $post_data['source-url'] = rtrim($post_data['source-url'], '/');

      if ($post_data['source-url'][0] != '/') {
        set_transient('wps-rule-exists', 'Your entered source URL needs to start with "/".', '5');
        return false;
      }

      $redirect_rule_exists = get_page_by_title($post_data['source-url'], OBJECT, 'wps-redirects');
      if (!$redirect_rule_exists) {

        $redirect = wp_insert_post(array('post_type' => 'wps-redirects', 'post_title' => $post_data['source-url'], 'post_status' => 'publish'));

        if ($redirect) {
          update_post_meta($redirect, 'wps-source', $post_data['source-url']);
          update_post_meta($redirect, 'wps-target', $post_data['target-url']);
          update_post_meta($redirect, 'wps-redirect_code', $post_data['redirect-code']);
          update_post_meta($redirect, 'wps-unique_runs', '0');
          update_post_meta($redirect, 'wps-total_runs', '0');
          update_post_meta($redirect, 'wps-last_run', '0');
        } 
      } else {
        set_transient('wps-rule-exists', 'Selected source URL already exists in database.', '5');
      }

    } else if (!empty($_POST['wps-rm']) && !empty($_POST['wps-rm']['edit-id'])) {

      $redirect = $_POST['wps-rm']['edit-id'];
      $post_data = $_POST['wps-rm'];
      $post_data['source-url'] = rtrim($post_data['source-url'], '/');

      update_post_meta($redirect, 'wps-source', $post_data['source-url']);
      update_post_meta($redirect, 'wps-target', $post_data['target-url']);
      update_post_meta($redirect, 'wps-redirect_code', $post_data['redirect-code']);

    }
  } // save_redirect_rule


  static function write_log($data) {
    global $wpdb;
    $table = $wpdb->prefix . "rm_log";

    // User data
    if (!empty($_SERVER['HTTP_REFERER'])) {
      $referral = $_SERVER['HTTP_REFERER'];
    } else {
      $referral = '';
    }
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $sql = $wpdb->prepare("INSERT INTO " . $table . " (source, target, code, timestamp, user_referral, user_agent, user_ip) 
                           VALUES (%s, %s, %s, %s, %s, %s, %s)", $data['source'], $data['target'], $data['code'], current_time('mysql'), $referral, $agent, $ip);
                           
    $wpdb->query($sql);

  } // write_log


  static function install() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $log_table = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "rm_log` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `source` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
    `target` text COLLATE utf8_unicode_ci NOT NULL,
    `code` text COLLATE utf8_unicode_ci NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_referral` text COLLATE utf8_unicode_ci NOT NULL,
    `user_agent` text COLLATE utf8_unicode_ci NOT NULL,
    `user_ip` text COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`ID`)
    ) " . $charset_collate . ";";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($log_table);
  } // install


} // wps_rm

add_action('init', array('wps_rm', 'init'));
add_action('after_switch_theme', array('wps_rm', 'install'));
// register_activation_hook(__FILE__, array('wps_rm', 'install'));