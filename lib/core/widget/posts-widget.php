<?php

class Posts_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_posts', __('文章列表','BT_TEXTDOMAIN'), [
            'classname' => 'Posts_Widget',
            'description' => __('按指定方式筛选文章','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $order_options = [
            __('更新时间','BT_TEXTDOMAIN') => 0,
            __('评论数','BT_TEXTDOMAIN') => 1,
            __('点赞数','BT_TEXTDOMAIN') => 2,
            __('访问量','BT_TEXTDOMAIN') => 3
        ];

        $terms = get_terms( array(
            'taxonomy'   => 'category',
            'depth'      => 1,
            'show_count' => true,
            'hide_empty' => true,
        ) );
        $taxonomies = array();
        foreach ($terms as $term=>$v){
            $taxonomies[$v->name] = $v->term_id; 
        }
        $taxonomies = array_merge( [ __('全部分类','BT_TEXTDOMAIN') => 0 ], $taxonomies );

        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('最新文章','BT_TEXTDOMAIN'));
        echo $this->form->select(__('选择分类','BT_TEXTDOMAIN'))->setName('cat_id')->setOptions($taxonomies);
        echo $this->form->row(
            $this->form->radio(__('文章排序方式','BT_TEXTDOMAIN'))->setName('orderby')->setOptions($order_options)->setSetting('default', 0)
        )->setAttribute( 'class', 'radio-horizontal' );
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 5);
        echo $this->form->text(__('时间限定（天）','BT_TEXTDOMAIN'))->setName('daterange')->setType('number')->setSetting('default', 90);
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
    register_widget( 'Posts_Widget' );
});
