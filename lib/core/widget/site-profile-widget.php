<?php

class Site_Profile_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_site_profile', __('网站概况','BT_TEXTDOMAIN'), [
            'classname' => 'Site_Profile_Widget',
            'description' => __('网站概况','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('网站概况','BT_TEXTDOMAIN'));
        echo $this->form->text(__('建站日期','BT_TEXTDOMAIN'))->setName('date')->setType('date');
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
    register_widget( 'Site_Profile_Widget' );
});
