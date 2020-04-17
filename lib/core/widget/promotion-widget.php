<?php

class Promotion_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_promotion', __('广告代码','BT_TEXTDOMAIN'), [
            'classname' => 'Promotion_Widget',
            'description' => __('添加广告代码','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title');
        echo $this->form->textarea(__('Content','BT_TEXTDOMAIN'))->setName('content');
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
    register_widget( 'Promotion_Widget' );
});
