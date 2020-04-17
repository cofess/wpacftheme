<?php

// Register Post Type
$banner = tr_post_type(__('轮播','BT_TEXTDOMAIN'), __('轮播','BT_TEXTDOMAIN'));
$banner->setId('banner');
$banner->setArgument('supports', ['title','page-attributes'] );

// parent menu
$banner->setArgument('show_in_menu', 'themes.php');

// disable permalink
$banner->setArgument('public', false);
$banner->setArgument('show_ui', true);

// disable archive page
$banner->setArgument('has_archive', false);

// Chain Methods with Eloquence
$banner->setIcon('images')
    ->setArchivePostsPerPage(-1)
    ->setEditorForm( function() {
    	$form = tr_form();
        $style_options = [
            __('杂志形式','BT_TEXTDOMAIN') => 0,
            __('图片轮播','BT_TEXTDOMAIN') => 1,
            __('图文轮播','BT_TEXTDOMAIN') => 2
        ];
        echo $form->row(
            $form->radio(__('展示形式','BT_TEXTDOMAIN'))->setName('style')->setOptions($style_options)->setSetting('default', 1)
        )->setAttribute( 'class', 'radio-horizontal' );
    	echo $form->repeater(__('Add'))->setName('sliders')->setFields([
            $form->row(
                $form->column(
                    $form->text(__('Title'))->setName('title'),
                    $form->textarea(__('Content'))->setName('description')->setAttribute('style', "min-height:40px"), 
                    $form->text(__('Link'))->setName('url')
                ),
                $form->column(
                    $form->image(__('Image'))->setName('image')
                )
            ),
            $form->row( 
                $form->color(__('标题字体颜色','BT_TEXTDOMAIN'))->setName('title_color')->setPalette(['#FFFFFF', '#000000']),
                $form->color(__('描述字体颜色','BT_TEXTDOMAIN'))->setName('description_color')->setPalette(['#FFFFFF', '#000000']),
                $form->toggle(__('在新标签页中打开链接','BT_TEXTDOMAIN'))->setName('target')->setText(__('Yes'))
            )
        ]);
    });

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($banner);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $post_types = get_post_types( ['public' => true]);
    unset($post_types['page'],$post_types['attachment']);

    $position_options = [
        __('首页','BT_TEXTDOMAIN') => 0,
        __('内容类型归档页','BT_TEXTDOMAIN') => 1
    ];

    $form = tr_form();
    echo $form->row( 
        $form->text(__('轮播图宽度（px）','BT_TEXTDOMAIN'))->setName('width')->setType('number')->setSetting('default', 1920),  
        $form->text(__('轮播图高度（px）','BT_TEXTDOMAIN'))->setName('height')->setType('number')->setSetting('default', 640)
    );

    echo $form->row( 
        $form->toggle('PC端显示')->setName('display')->setText(__('Yes')), 
        $form->toggle('移动端显示')->setName('m_display')->setText(__('Yes'))
    );

    echo $form->row(
        $form->toggle('自动轮播')->setName('autoplay')->setText(__('Yes')),
        $form->text(__('轮播间隔时长（ms）','BT_TEXTDOMAIN'))->setName('duration')->setType('number')->setSetting('default', 5000)
    );

    echo $form->row(
        $form->radio(__('展示位置','BT_TEXTDOMAIN'))->setName('position')->setOptions($position_options)->setSetting('default', 0),
        $form->select(__('选择内容模型','BT_TEXTDOMAIN'))->setName('bind_post_type')->setOptions($post_types)
    )->setAttribute( 'class', 'radio-horizontal' );
});

// Add Column
$banner->addColumn('position', true, __('展示位置','BT_TEXTDOMAIN'), function($value) {
    if($value > 0){
        echo __('内容类型归档页','BT_TEXTDOMAIN');
    }else{
        echo __('首页','BT_TEXTDOMAIN');
    }
}, 'number');

// REST API
$banner->setRest('banner');
