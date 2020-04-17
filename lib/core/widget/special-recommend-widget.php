<?php

class Special_Recommend_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_special_recommend', __('特别推荐','BT_TEXTDOMAIN'), [
            'classname' => 'Special_Recommend_Widget',
            'description' => __('特别推荐小工具','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $daterange_options = [
            __('红色','BT_TEXTDOMAIN')  => 'red',
            __('橙色','BT_TEXTDOMAIN')  => 'orange',
            __('蓝色','BT_TEXTDOMAIN')  => 'blue',
            __('绿色','BT_TEXTDOMAIN')  => 'green',
            __('紫色','BT_TEXTDOMAIN')  => 'purple',
        ];
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title');
        echo $this->form->textarea(__('Content','BT_TEXTDOMAIN'))->setName('content');
        echo $this->form->text(__('Tag','BT_TEXTDOMAIN'))->setName('label');
        echo $this->form->text(__('Link','BT_TEXTDOMAIN'))->setName('url');
        echo $this->form->select(__('Style','BT_TEXTDOMAIN'))->setName('style')->setOptions($daterange_options);
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
    register_widget( 'Special_Recommend_Widget' );
});
