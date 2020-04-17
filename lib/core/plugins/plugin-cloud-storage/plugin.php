<?php
namespace TypeRocketCloudStorage;
class Plugin
{
    public function __construct()
    {
        if ( ! function_exists( 'add_action' )) {
            echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
            exit;
        }
        $this->setup();
    }

    public function setup()
    {
        add_action( 'admin_menu', [$this, 'menu']);

    }

    public function menu()
    {
        add_submenu_page('options-general.php', 'Cloud Storage Setting', 'Cloud Storage', 'manage_options', 'cloud-storage-setting', [$this, 'page']);
    }

    public function page()
    {
        do_action('tr_theme_options_page', $this);
        echo '<div class="wrap">';
        include( __DIR__ . '/options.php' );
        echo '</div>';
    }
}
