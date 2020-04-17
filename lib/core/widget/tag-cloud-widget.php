<?php

class Tag_Cloud_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_tag_cloud', __('标签云','BT_TEXTDOMAIN'), [
            'classname' => 'Tag_Cloud_Widget',
            'description' => __('显示指定内容类型的标签，可实现3D特效','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $all_post_types = get_post_types();
        // post type has no taxonomy
        $exclude_post_types = get_post_types(['taxonomies' => false]);
        unset($exclude_post_types['post']);

        $post_types = array_diff($all_post_types,$exclude_post_types);
        // unset($post_types['page'],$post_types['attachment']);

        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('标签云','BT_TEXTDOMAIN'));
        echo $this->form->select(__('选择内容模型','BT_TEXTDOMAIN'))->setName('post_type')->setOptions($post_types);
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 20);
        echo $this->form->checkbox(__('3D特效','BT_TEXTDOMAIN'))->setName('show_3d')->setText(__('显示3D特效','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
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
    register_widget( 'Tag_Cloud_Widget' );
});
