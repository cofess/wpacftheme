<?php

class Follow_Us_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_follow_us', __('关注我们','BT_TEXTDOMAIN'), [
            'classname' => 'Follow_Us_Widget',
            'description' => __('RSS、微信等社媒信息','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title')->setSetting('default', __('关注我们','BT_TEXTDOMAIN'));
        echo $this->form->image(__('Image','BT_TEXTDOMAIN'))->setName('image');
        echo $this->form->text(__('Site Title','BT_TEXTDOMAIN'))->setName('site_title')->setSetting('default', get_bloginfo('name'));
        echo $this->form->text(__('Tagline','BT_TEXTDOMAIN'))->setName('site_subtitle')->setSetting('default', get_bloginfo('description'));
        echo $this->form->textarea(__('Content','BT_TEXTDOMAIN'))->setName('content');
        echo $this->form->image(__('微信二维码','BT_TEXTDOMAIN'))->setName('wechat');
        echo $this->form->repeater(__('添加社媒','BT_TEXTDOMAIN'))->setName('socials')->setFields([
            $this->form->text(__('Title'))->setName('title'),
            $this->form->text(__('Link'))->setName('url'),
            $this->form->text(__('Icon Font Class','BT_TEXTDOMAIN'))->setName('icon')
        ]);
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
    register_widget( 'Follow_Us_Widget' );
});
