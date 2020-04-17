<?php

class Recent_Update_Post_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_recent_update_post', __('最近更新过的文章','BT_TEXTDOMAIN'), [
            'classname' => 'Recent_Update_Post_Widget',
            'description' => __('显示最近更新过的文章','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('最近更新过的文章','BT_TEXTDOMAIN'));
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 5);
        echo $this->form->text(__('排除近期文章（天）','BT_TEXTDOMAIN'))->setName('days')->setType('number')->setSetting('default', 15);
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
    register_widget( 'Recent_Update_Post_Widget' );
});
