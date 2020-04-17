<?php

// tab metabox
$box = tr_meta_box('custom_post_metabox');
$box->setLabel(__('Settings'));
$box->addScreen('post');
$box->setPriority('high');
$box->setCallback(function(){

    $tabs = tr_tabs();

    $form = tr_form();
    // post-label
    $postLabel = function() use ($form){
        $source = [
            '默认' => 0,
            '原创' => 1,
            '投稿' => 2,
            '转载' => 3,
            '翻译' => 4
        ];
        echo $form->row(
            $form->checkbox(__('置顶','BT_TEXTDOMAIN'))->setName('is_sticky')->setText(__('置顶','BT_TEXTDOMAIN'))->setLabel(''),
            $form->checkbox(__('热门','BT_TEXTDOMAIN'))->setName('is_hot')->setText(__('热门','BT_TEXTDOMAIN'))->setLabel(''),
            $form->checkbox(__('推荐','BT_TEXTDOMAIN'))->setName('is_feature')->setText(__('推荐','BT_TEXTDOMAIN'))->setLabel(''),
            $form->checkbox(__('首页推荐','BT_TEXTDOMAIN'))->setName('is_index_feature')->setText(__('首页推荐','BT_TEXTDOMAIN'))->setLabel('')
        )->setTitle(__('文章标识','BT_TEXTDOMAIN'));
        echo $form->row(
            $form->radio(__('文章来源','BT_TEXTDOMAIN'))->setName('source')->setOptions($source)->setSetting('default', 0)
        )->setAttribute('class', 'radio-horizontal');
        echo $form->row(
            $form->text(__('来源网站名称','BT_TEXTDOMAIN'))->setName('source_site'),
            $form->text(__('来源URL','BT_TEXTDOMAIN'))->setName('source_url')
        );
        echo $form->row(
            $form->text(__('投稿者','BT_TEXTDOMAIN'))->setName('contributor'),
            $form->text(__('投稿者邮箱','BT_TEXTDOMAIN'))->setType('email')->setName('contributor_email')->setHelp(__('投稿者邮箱地址，发布后将邮件通知投稿者','BT_TEXTDOMAIN'))
        );
        echo $form->toggle(__('封面文章','BT_TEXTDOMAIN'))->setName('show_cover')->setText(__('Yes'));
        echo $form->image(__('Cover'))->setName('cover_image')->setSetting('button', 'Insert Image');
    };
    
    // post layout
    $postLayout = function() use ($form){
        $layout = [
            'item1' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/cs.gif',
                'value' => 1
            ],
            'item2' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/sc.gif',
                'value' => 2
            ],
            'item3' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/css.gif',
                'value' => 3
            ],
            'item4' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/ssc.gif',
                'value' => 4
            ],
            'item5' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/scs.gif',
                'value' => 5
            ],
            'item6' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/c.gif',
                'value' => 6
            ]
        ];
        echo $form->row(
            $form->radio(__('布局方式','BT_TEXTDOMAIN'))->setName('layout')->setOptions($layout)->useImages()->setSetting('default', 1)
        )->setAttribute('class', 'radio-horizontal');
        echo $form->color(__('选择颜色','BT_TEXTDOMAIN'))->setName('color')->setPalette(['#FFFFFF', '#000000']);
        echo $form->row(
            $form->text(__('Custom Body Class','BT_TEXTDOMAIN'))->setName('custom_body_class'),
            $form->text(__('Custom Post Class','BT_TEXTDOMAIN'))->setName('custom_post_class')
        );
    };

    $tabs->addTab([
        'id'      => 'post-label',
        'title'   => __('基本设置','BT_TEXTDOMAIN'),
        'callback' => $postLabel
    ]);

    $tabs->addTab([
        'id'      => 'post-layout',
        'title'   => __('样式','BT_TEXTDOMAIN'),
        'callback' => $postLayout
    ]);

    $tabs->render();
});
