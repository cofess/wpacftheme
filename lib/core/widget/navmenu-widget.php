<?php

class Navmenu_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_navmenu', __('折叠菜单','BT_TEXTDOMAIN'), [
            'classname' => 'Navmenu_Widget',
            'description' => __('添加可折叠的自定义菜单','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $menus = get_registered_nav_menus();
        $menus = array_merge( [ __('请选择','BT_TEXTDOMAIN') => '' ], $menus );
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title');
        echo $this->form->select(__('选择菜单','BT_TEXTDOMAIN'))->setName('nav_menu')->setOptions($menus);
    }

    public function frontend($args, $fields) {
        // make frontend code
    }

    public function save($new_fields, $old_fields) {
        // You will want to sanitize your $new_fields data 
        return $new_fields;
    }
}

add_action( 'widgets_init', function(){
    register_widget( 'Navmenu_Widget' );
});
