<?php
namespace TypeRocketModuleOptions;
class Plugin
{

    private $postType;
    private $taxonomy;
    private $name = 'tr_module_options';

    public function __construct($postType, $taxonomy = '')
    {
        if ( ! function_exists( 'add_action' )) {
            echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
            exit;
        }
        if($postType) {
            $this->postType = $postType;
            $this->name = 'module_'.$postType.'_options';
        }
        if($taxonomy) {
            $this->taxonomy = $taxonomy;
        }

        $this->setup();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setup()
    {
        $this->name = apply_filters( 'tr_theme_options_name', $this->name );
        add_action( 'admin_menu', [$this, 'menu']);
        add_filter( 'tr_model', [$this, 'fillable'], 9999999999 );

    }

    public function fillable( $model )
    {

        if ($model instanceof \TypeRocket\Models\WPOption) {
            $fillable = $model->getFillableFields();

            if ( ! empty( $fillable )) {
                $model->appendFillableField( $this->name );
            }
        }

    }

    public function menu()
    {
        if($this->postType == 'post'){
            add_submenu_page('edit.php', 'Module Setting', 'Setting', 'manage_options', 'module_'.$this->postType.'_setting', [$this, 'page']);
        } else {
            add_submenu_page('edit.php?post_type='.$this->postType, 'Module Setting', 'Setting', 'manage_options', 'module_'.$this->postType.'_setting', [$this, 'page']);
        }
    }

    public function page()
    {
        do_action('tr_theme_options_page', $this);
        echo '<div class="wrap">';
        include( __DIR__ . '/options.php' );
        echo '</div>';
    }


}

// example
// add_action( 'typerocket_loaded', [new ModuleOptionsPlugin('download','download_category'), 'setup']);
