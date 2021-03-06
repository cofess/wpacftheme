<?php

/*
 * Plugin Name: WP System Info
 * Version: 1.2
 * Plugin URI: https://wordpress.org/plugins/wp-system-info
 * Description: See the basic and main system information about yout site and server. 
 * Author: Nurul Amin
 * Author URI: http://nurul.ninja
 * Requires at least: 4.0        
 * Tested up to: 4.9.1
 * License: GPL2
 * Text Domain: bsi
 * Domain Path: /lang/
 *
 */

class Bbtech_SI {

    public $version = '1.2';
    public $db_version = '1.2';
    protected static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct() {

        $this->init_actions();

        $this->define_constants();
        spl_autoload_register(array($this, 'autoload'));
        // Include required files
       
        
        register_activation_hook(__FILE__, array($this, 'install'));
        //Do some thing after load this plugin
        
        do_action('bsi_loaded');
    }

   

    function install() {
        
    }

    function init_actions() {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('after_setup_theme', array($this, 'load_textdomain'));
       
    }

    
 
 

    function autoload($class) {
        $name = explode('_', $class);
        if (isset($name[1])) {
            $class_name = strtolower($name[1]);
            $filename = dirname(__FILE__) . '/class/' . $class_name . '.php';
            if (file_exists($filename)) {
                require_once $filename;
            }
        }
    }

    public function define_constants() {

        $this->define('BSI_VERSION', $this->version);
        $this->define('BSI_DB_VERSION', $this->db_version);
        $this->define( 'BSI_PATH', plugin_dir_path( __FILE__ ) );
        $this->define('BSI_URL', plugins_url('', __FILE__));
    }

    public function define($name, $value) {
        if (!defined($name)) {
            define($name, $value);
        }
    }
    
    
       function load_textdomain() {
        load_plugin_textdomain( 'bsi', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
    }

    
     function admin_menu() {
        $capability = 'read'; //minimum level: subscriber
        
        add_submenu_page('tools.php',
                        __( 'System Info', 'bsi' ), 
                        __( 'System Info', 'bsi' ),
                        $capability, 'system_info', array( $this, 'system_info_view' ) );
         
        do_action( 'bsi_admin_menu', $capability, $this );
    }
    
    function system_info_view() {
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'system_status';
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">System Information </h1>
            <?php settings_errors(); ?>
            <h2 class="nav-tab-wrapper">
                <a href="?page=system_info&tab=system_status" class="nav-tab <?php echo $active_tab == 'system_status' ? 'nav-tab-active' : ''; ?>">System Status</a>
                <a href="?page=system_info&tab=dashicons" class="nav-tab <?php echo $active_tab == 'dashicons' ? 'nav-tab-active' : ''; ?>">Dashicons</a>
            </h2>
            <?php 
                if($active_tab == 'system_status'){
                    require ( BSI_PATH . '/view/status.php' );
                }
                if($active_tab == 'dashicons'){
                    require ( BSI_PATH . '/view/dashicons.php' );
                }
            ?>
        </div>
        <?php
    }  

}


function bsi() {
    return Bbtech_SI::instance();
}
//bsi instance.
$bsi = bsi();