<?php

class Recommend_Column_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_recommend_column', __('推荐栏目','BT_TEXTDOMAIN'), [
            'classname' => 'Recommend_Column_Widget',
            'description' => __('自定义推荐栏目','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('推荐栏目','BT_TEXTDOMAIN'));
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 5);
        echo $this->form->repeater(__('Add'))->setName('lists')->setFields([
            $this->form->text(__('Title'))->setName('title'),
            $this->form->text(__('subtitle'))->setName('subtitle'),
            $this->form->text(__('Link'))->setName('url'),
            $this->form->text(__('Icon Font Class','BT_TEXTDOMAIN'))->setName('icon')
        ]);
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
    register_widget( 'Recommend_Column_Widget' );
});
