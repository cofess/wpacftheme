<?php

class Content_List_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_content_list', __('内容列表','BT_TEXTDOMAIN'), [
            'classname' => 'Content_List_Widget',
            'description' => __('指定内容模型文章列表','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $post_types = get_post_types(['public' => true]);
        unset($post_types['page'],$post_types['attachment']);

        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title');
        echo $this->form->select(__('选择内容模型','BT_TEXTDOMAIN'))->setName('post_type')->setOptions($post_types);
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 5);
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
    register_widget( 'Content_List_Widget' );
});
