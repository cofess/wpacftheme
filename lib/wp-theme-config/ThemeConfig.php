<?php namespace WpThemeConfig;

class ThemeConfig {

    /**
     * Instance of this class
     */
    protected static $instance = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        add_action('after_setup_theme', array($this, 'init'));
    }

    /**
     * Initialize ThemeConfig
     */
    public function init()
    {
        if ( !defined( 'WP_THEME_CONFIG_DIR' ) ) {
            define( 'WP_THEME_CONFIG_DIR', dirname(__FILE__) );
        }

        if ( !defined( 'WP_THEME_CONFIG_TEMPLATE_DIR' ) ) {
            define( 'WP_THEME_CONFIG_TEMPLATE_DIR', dirname(__FILE__) . '/template');
        }

        if ( !defined( 'WP_THEME_CONFIG_INCLUDE_DIR' ) ) {
            define( 'WP_THEME_CONFIG_INCLUDE_DIR', dirname(__FILE__) . '/includes');
        }

        if ( !defined( 'WP_THEME_CONFIG_STATIC_URI' ) ) {
            define( 'WP_THEME_CONFIG_STATIC_URI', get_template_directory_uri() . str_replace(wp_normalize_path(get_template_directory()),'',wp_normalize_path(dirname(__FILE__))) . '/assets');
        }

        // Initialize configurator
        $configurator = Configurator::getInstance();

        // Initialize settings
        new Settings($configurator->all());

        do_action('wp_theme_config_loaded');
    }

    /**
     * Return an instance of this class
     */
    public static function getInstance()
    {
        // If the single instance hasn't been set, set it now.
        if (self::$instance == null)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }

}
