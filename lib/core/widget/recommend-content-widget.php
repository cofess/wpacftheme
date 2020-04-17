<?php

class Recommend_Content_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_recommend_content', __('推荐内容','BT_TEXTDOMAIN'), [
            'classname' => 'Recommend_Content_Widget',
            'description' => __('手动选择推荐内容','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('推荐内容','BT_TEXTDOMAIN'));
        echo $this->form->repeater(__('Add'))->setName('lists')->setFields([
            $this->form->search('Search')->setName('item')->setPostType('any')
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
    register_widget( 'Recommend_Content_Widget' );
});
