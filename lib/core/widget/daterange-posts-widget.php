<?php

class Daterange_Posts_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_daterange_posts', __('指定时间文章','BT_TEXTDOMAIN'), [
            'classname' => 'Daterange_Posts_Widget',
            'description' => __('调用指定时间内的文章','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $post_types = get_post_types(['public' => true]);
        unset($post_types['page'],$post_types['attachment']);

        $daterange_options = [
            __('一天内','BT_TEXTDOMAIN')  => 1,
            __('一周内','BT_TEXTDOMAIN')  => 7,
            __('一月内','BT_TEXTDOMAIN')  => 30,
            __('一年内','BT_TEXTDOMAIN')  => 365,
        ];

        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title');
        echo $this->form->select(__('选择内容模型','BT_TEXTDOMAIN'))->setName('post_type')->setOptions($post_types);
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 5);
        echo $this->form->select(__('时间范围','BT_TEXTDOMAIN'))->setName('daterange')->setOptions($daterange_options);
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
    register_widget( 'Daterange_Posts_Widget' );
});
