<?php

class Post_Tab_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_post_tab', __('Tab组合小工具','BT_TEXTDOMAIN'), [
            'classname' => 'Post_Tab_Widget',
            'description' => __('最新文章、热评文章、热门文章、近期评论','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
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

        $daterange = [
            __('全部','BT_TEXTDOMAIN') => 0,
            __('一年内','BT_TEXTDOMAIN') => 365,
            __('一月内','BT_TEXTDOMAIN')  => 30,
            __('一周内','BT_TEXTDOMAIN')  => 7,
            __('一天内','BT_TEXTDOMAIN')  => 1
        ];

        echo '<h3 class="title">'.__('最新文章','BT_TEXTDOMAIN').'</h3>';
        echo $this->form->checkbox(__('最新文章','BT_TEXTDOMAIN'))->setName('enable_recent')->setText(__('显示最新文章','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->checkbox(__('缩略图','BT_TEXTDOMAIN'))->setName('show_recent_thumb')->setText(__('显示缩略图','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('recent_limit')->setType('number')->setSetting('default', 5);
        echo $this->form->select(__('选择分类','BT_TEXTDOMAIN'))->setName('recent_cat_id')->setOptions($taxonomies);
        echo '<hr/>';

        echo '<h3 class="title">'.__('热评文章','BT_TEXTDOMAIN').'</h3>';
        echo $this->form->checkbox(__('热评文章','BT_TEXTDOMAIN'))->setName('enable_popular')->setText(__('显示热评文章','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->checkbox(__('缩略图','BT_TEXTDOMAIN'))->setName('show_popular_thumb')->setText(__('显示缩略图','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('popular_limit')->setType('number')->setSetting('default', 5);
        echo $this->form->select(__('选择分类','BT_TEXTDOMAIN'))->setName('popular_cat_id')->setOptions($taxonomies);
        echo $this->form->select(__('选择时间段','BT_TEXTDOMAIN'))->setName('popular_daterange')->setOptions($daterange);
        echo '<hr/>';

        echo '<h3 class="title">'.__('热门文章','BT_TEXTDOMAIN').'</h3>';
        echo $this->form->checkbox(__('热门文章','BT_TEXTDOMAIN'))->setName('enable_hot')->setText(__('显示热门文章','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->checkbox(__('缩略图','BT_TEXTDOMAIN'))->setName('show_hot_thumb')->setText(__('显示缩略图','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('hot_limit')->setType('number')->setSetting('default', 5);
        echo $this->form->text(__('时间限定（天）','BT_TEXTDOMAIN'))->setName('hot_daterange')->setType('number')->setSetting('default', 90);
        echo '<hr/>';

        echo '<h3 class="title">'.__('近期评论','BT_TEXTDOMAIN').'</h3>';
        echo $this->form->checkbox(__('近期评论','BT_TEXTDOMAIN'))->setName('enable_comments')->setText(__('显示近期评论','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->checkbox(__('Avatar'))->setName('show_comments_thumb')->setText(__('显示头像','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('comments_limit')->setType('number')->setSetting('default', 5);
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
    register_widget( 'Post_Tab_Widget' );
});
