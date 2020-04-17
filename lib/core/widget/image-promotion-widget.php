<?php

class Image_Promotion_Widget extends \TypeRocket\Register\BaseWidget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'tr_image_promotion', __('图片广告','BT_TEXTDOMAIN'), [
            'classname' => 'Image_Promotion_Widget',
            'description' => __('添加图片广告','BT_TEXTDOMAIN')
        ] );
    }

    public function backend($fields) {
        echo $this->form->text(__('Title','BT_TEXTDOMAIN'))->setName('title');
        echo $this->form->image(__('Image','BT_TEXTDOMAIN'))->setName('image');
        echo $this->form->text(__('Link','BT_TEXTDOMAIN'))->setName('link');
        echo $this->form->text(__('图片宽度（输入数字例如：250px或者100%）','BT_TEXTDOMAIN'))->setName('img_width')->setSetting('default', '100%');
        echo $this->form->text(__('图片高度（默认，或者输入数字例如：250px或者100%）','BT_TEXTDOMAIN'))->setName('img_height')->setSetting('default', 'auto');
        echo $this->form->checkbox(__('Link Target','BT_TEXTDOMAIN'))->setName('link_target')->setText(__('在新标签页中打开链接','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true);
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
    register_widget( 'Image_Promotion_Widget' );
});
