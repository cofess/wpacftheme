<?php

// Register Post Type
$testimonial = tr_post_type(__('评价','BT_TEXTDOMAIN'), __('评价','BT_TEXTDOMAIN'));
$testimonial->setId('testimonial');
$testimonial->setArgument('supports', ['title','thumbnail','page-attributes'] );

// disable permalink
$testimonial->setArgument('public', false);
$testimonial->setArgument('show_ui', true);

// disable archive page
$testimonial->setArgument('has_archive', false);

// Chain Methods with Eloquence
$testimonial->setIcon('bubbles')
    // ->setTitlePlaceholder( __('请输入客户名称','BT_TEXTDOMAIN') )
    ->setArchivePostsPerPage(-1)
    ->setTitleForm( function() {
        $form = tr_form();
        $rating_options = [
            __('★☆☆☆☆','BT_TEXTDOMAIN') => 1,
            __('★★☆☆☆','BT_TEXTDOMAIN') => 2,
            __('★★★☆☆','BT_TEXTDOMAIN') => 3,
            __('★★★★☆','BT_TEXTDOMAIN') => 4,
            __('★★★★★','BT_TEXTDOMAIN') => 5
        ];
        $settings = array(
            'teeny' => true,
            'media_buttons' => false,
            'dfw' => true,
            // 'editor_height' => 300,
            // 'tinymce' => true,
            'tinymce' => array(
                'toolbar1' => 'fontsizeselect,bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,alignjustify,link,unlink,spellchecker,removeformat,undo,redo,fullscreen',
            ),
            'quicktags'=> false,
            'textarea_name' => 'content'
        );
        $wpEditor = $form->wpEditor(__('Content','BT_TEXTDOMAIN'))->setName('content');
        $wpEditor->setSetting('options', $settings);
        echo $wpEditor;
        echo $form->row(
            $form->text(__('姓名','BT_TEXTDOMAIN'))->setName('name'),
            $form->text(__('职位','BT_TEXTDOMAIN'))->setName('position'),
            $form->text(__('Email','BT_TEXTDOMAIN'))->setName('email')
        );
        echo $form->row(
            $form->text(__('公司名称','BT_TEXTDOMAIN'))->setName('company'),
            $form->text(__('公司网站','BT_TEXTDOMAIN'))->setName('site')
        );
        // echo $form->image(__('Avatar'))->setName('photo');
        echo $form->row(
            $form->radio(__('评级','BT_TEXTDOMAIN'))->setName('rating')->setOptions($rating_options)->setSetting('default', 5)
        )->setAttribute( 'class', 'radio-horizontal' );
        echo '<p style="color:red">'.__('温馨提示：特色图像推荐尺寸85px*85px','BT_TEXTDOMAIN').'</p>';
    });
    
// Add Column
$testimonial->addColumn('name', true, __('客户名称','BT_TEXTDOMAIN'));
$testimonial->addColumn('company', true, __('公司名称','BT_TEXTDOMAIN'));

// $testimonial->addColumn('photo', false, __('Avatar'), function($value) {
//     echo wp_get_attachment_image($value, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
// }, 'number');

$testimonial->addColumn('thumbnail', false, __('Image'), function($id) {
	$post_thumbnail_id = get_post_thumbnail_id( $id );
    echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$testimonial->setRest('testimonial');

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('testimonial')]);
}