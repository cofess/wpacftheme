<?php

class Author_Profile_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_author_profile', __('关于作者','BT_TEXTDOMAIN'), [
            'classname' => 'Author_Profile_Widget',
            'description' => __('作者个人信息','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title');
        echo $this->form->text(__('User ID','BT_TEXTDOMAIN'))->setName('user_id')->setHelp(__('如果没有指定用户 ID，自动检测文章作者','BT_TEXTDOMAIN'));
        echo $this->form->checkbox(__('Job Info','BT_TEXTDOMAIN'))->setName('show_job_info')->setText(__('显示职位和公司','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->checkbox(__('Social','BT_TEXTDOMAIN'))->setName('show_social')->setText(__('显示社交媒体链接','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
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
    register_widget( 'Author_Profile_Widget' );
});
