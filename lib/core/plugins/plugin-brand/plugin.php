<?php
namespace TypeRocketBrand;
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
        $settings = [
            'capability' => 'edit_posts',
            'position' => 2,
            'menu' => 'Brand',
            'slug' => 'brand'
        ];
        $parent = (new \TypeRocket\Register\Page('TypeRocket', __('Brand'), __('Brand Module'), $settings))
            ->addToRegistry()->setIcon('color-wheel');

        $subMenuSettings = [
            'view_file' => __DIR__ . '/options.php',
            'menu' => 'Settings',
            'slug' => 'brand_settings'
        ];
        (new \TypeRocket\Register\Page('TypeRocket', __('Settings'), __('Settings'), $subMenuSettings))
            ->addToRegistry()->setIcon('color-wheel')->setParent($parent);
    }

}

add_action( 'typerocket_loaded', [new \TypeRocketBrand\Plugin()]);