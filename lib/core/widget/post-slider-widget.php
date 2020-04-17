<?php

class Post_Slider_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_post_slider', __('幻灯片','BT_TEXTDOMAIN'), [
            'classname' => 'Post_Slider_Widget',
            'description' => __('文章幻灯片小工具','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $post_types = get_post_types(['public' => true]);
        unset($post_types['page'],$post_types['attachment']);

        $daterange_options = [
            __('不限','BT_TEXTDOMAIN')  => 0,
            __('一天内','BT_TEXTDOMAIN')  => 1,
            __('一周内','BT_TEXTDOMAIN')  => 7,
            __('一月内','BT_TEXTDOMAIN')  => 30,
            __('一年内','BT_TEXTDOMAIN')  => 365,
        ];

        $order_options = [
            __('更新时间','BT_TEXTDOMAIN') => 0,
            __('评论数','BT_TEXTDOMAIN') => 1,
            __('点赞数','BT_TEXTDOMAIN') => 2,
            __('访问量','BT_TEXTDOMAIN') => 3
        ];

        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('幻灯片','BT_TEXTDOMAIN'));
        echo $this->form->select(__('选择内容模型','BT_TEXTDOMAIN'))->setName('post_type')->setOptions($post_types);
        echo $this->form->row(
            $this->form->radio(__('文章排序方式','BT_TEXTDOMAIN'))->setName('orderby')->setOptions($order_options)->setSetting('default', 0)
        )->setAttribute( 'class', 'radio-horizontal' );
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 5);
        echo $this->form->select(__('时间范围','BT_TEXTDOMAIN'))->setName('daterange')->setOptions($daterange_options);
        echo $this->form->checkbox(__('缩略图','BT_TEXTDOMAIN'))->setName('show_thumb')->setText(__('显示缩略图','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
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
    register_widget( 'Post_Slider_Widget' );
});
