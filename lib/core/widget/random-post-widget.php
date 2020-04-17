<?php

class Random_Post_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_random_post', __('随机文章','BT_TEXTDOMAIN'), [
            'classname' => 'Random_Post_Widget',
            'description' => __('显示随机文章','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('随机文章','BT_TEXTDOMAIN'));
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 5);
        echo $this->form->checkbox(__('缩略图','BT_TEXTDOMAIN'))->setName('show_thumb')->setText(__('显示缩略图','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
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
    register_widget( 'Random_Post_Widget' );
});
