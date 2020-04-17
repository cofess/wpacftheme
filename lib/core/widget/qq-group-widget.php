<?php

class qqGroup_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_qq_group', __('QQ交流群','BT_TEXTDOMAIN'), [
            'classname' => 'qqGroup_Widget',
            'description' => __('QQ交流群小工具','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        $all_post_types = get_post_types();
        // post type has no taxonomy
        $exclude_post_types = get_post_types(['taxonomies' => false]);
        unset($exclude_post_types['post']);

        $post_types = array_diff($all_post_types,$exclude_post_types);
        // unset($post_types['page'],$post_types['attachment']);

        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('QQ交流群','BT_TEXTDOMAIN'));
        echo $this->form->textarea(__('content','BT_TEXTDOMAIN'))->setName('content');
        echo $this->form->text(__('QQ群ID','BT_TEXTDOMAIN'))->setName('qq_group_id');
        echo $this->form->text(__('QQ群名称','BT_TEXTDOMAIN'))->setName('qq_group_title');
        echo $this->form->text(__('QQ号码','BT_TEXTDOMAIN'))->setName('qq_id');
        echo $this->form->text(__('QQ名称','BT_TEXTDOMAIN'))->setName('qq_title')->setSetting('default', __('即刻QQ联系我们','BT_TEXTDOMAIN'));
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
    register_widget( 'qqGroup_Widget' );
});
