<?php

class Popular_Tag_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_popular_tag', __('热门标签','BT_TEXTDOMAIN'), [
            'classname' => 'Popular_Tag_Widget',
            'description' => __('显示文章标签，可实现3D特效','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('热门标签','BT_TEXTDOMAIN'));
        echo $this->form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 20);
        echo $this->form->text(__('热门标签规则（文章超过此数则为热门标签）','BT_TEXTDOMAIN'))->setName('rule')->setType('number')->setSetting('default', 5);
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
    register_widget( 'Popular_Tag_Widget' );
});
