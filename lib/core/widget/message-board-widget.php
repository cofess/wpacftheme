<?php

class Message_Board_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_message_board', __('留言板','BT_TEXTDOMAIN'), [
            'classname' => 'Message_Board_Widget',
            'description' => __('调用“留言板”页面留言','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $pages = get_pages();
        $page_options = array();
        foreach ($pages as $page=>$v){
            $page_options[$v->post_title] = $v->ID; 
        }
        $page_options = array_merge( [ __('请选择','BT_TEXTDOMAIN') => '' ], $page_options );
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('留言板','BT_TEXTDOMAIN'));
        echo $this->form->select(__('选择页面','BT_TEXTDOMAIN'))->setName('page_id')->setOptions($page_options);
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
    register_widget( 'Message_Board_Widget' );
});
