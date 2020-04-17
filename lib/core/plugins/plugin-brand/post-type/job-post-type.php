<?php

// Register Post Type
$job = tr_post_type(__('职位','BT_TEXTDOMAIN'), __('职位','BT_TEXTDOMAIN'));
$job->setId('job');
$job->setArgument('supports', ['title','excerpt','comments','page-attributes'] );

// parent menu
$job->setArgument('show_in_menu', 'brand');

// Chain Methods with Eloquence
$job->setIcon('users')
    ->setTitlePlaceholder( __('请输入职位名称','BT_TEXTDOMAIN') )
    ->setArchivePostsPerPage(-1)
    ->setTitleForm( function() {
        $form = tr_form();
        $settings = array(
            'teeny' => false,
            'media_buttons' => true,
            'dfw' => true,
            // 'editor_height' => 300,
            // 'tinymce' => true,
            'tinymce' => array(
                'toolbar1' => 'formatselect,styleselect,bold,italic,blockquote,bullist,numlist,alignleft,aligncenter,alignright,alignjustify,link,unlink,media,spellchecker,undo,redo,wp_more,wp_page,wp_adv,fullscreen',
                'toolbar2' => 'fontselect,fontsizeselect,strikethrough,hr,underline,outdent,indent,forecolor,backcolor,cleanup,sub,sup,copy,paste,cut,pastetext,removeformat,charmap,wp_help',
            ),
            // 'quicktags'=> false,
            'textarea_name' => 'content'
        );
        $wpEditor = $form->wpEditor(__('Content','BT_TEXTDOMAIN'))->setName('content');
        $wpEditor->setSetting('options', $settings);
        echo $wpEditor;
    });

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($job);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $job_types = [
        __('全职','BT_TEXTDOMAIN') => 0,
        __('兼职','BT_TEXTDOMAIN') => 1,
        __('实习','BT_TEXTDOMAIN') => 2
    ];
    $degree_options = [
        __('不限','BT_TEXTDOMAIN') => 0,
        __('高中','BT_TEXTDOMAIN') => 1,
        __('中专','BT_TEXTDOMAIN') => 2,
        __('大专','BT_TEXTDOMAIN') => 3,
        __('本科','BT_TEXTDOMAIN') => 4,
        __('本科以上','BT_TEXTDOMAIN') => 5,
    ];
    $form = tr_form();
    echo $form->row(
        $form->radio(__('工作类型','BT_TEXTDOMAIN'))->setName('job_type')->setOptions($job_types)->setSetting('default', 0),
        $form->radio(__('学历','BT_TEXTDOMAIN'))->setName('degree')->setOptions($degree_options)->setSetting('default', 0)
    )->setAttribute( 'class', 'radio-horizontal' );
    echo $form->row(
        $form->date(__('有效日期','BT_TEXTDOMAIN'))->setName('valid_date')->setFormat('yy-mm-dd'),
        $form->text(__('招聘人数','BT_TEXTDOMAIN'))->setName('number')->setType('number')->setSetting('default', 1)
    );
    echo $form->row(
        $form->text(__('工作地点','BT_TEXTDOMAIN'))->setName('address'), 
        $form->text(__('简历投递邮箱','BT_TEXTDOMAIN'))->setName('apply_email')
    );
    echo $form->row(
        $form->text(__('薪资待遇','BT_TEXTDOMAIN'))->setName('salary')->setSetting('default', __('面议','BT_TEXTDOMAIN')), 
        $form->text(__('工作经验要求','BT_TEXTDOMAIN'))->setName('experience')->setSetting('default', __('不限','BT_TEXTDOMAIN'))
    );
    //  $form->text(__('招聘人数','BT_TEXTDOMAIN'))->setName('number')->setType('number')->setSetting('default', 1) );
    //  $form->text(__('招聘人数','BT_TEXTDOMAIN'))->setName('number')->setAttributes( [ 'type' => 'number','min' => 1 ] )->setSetting('default', 1) );
});

// Add Sortable Columns to Admin Index View
$job->addColumn('number', true, __('招聘人数','BT_TEXTDOMAIN'));
$job->addColumn('valid_date', true, __('有效日期','BT_TEXTDOMAIN'));

$job->addColumn('job_type', true, __('职位类型','BT_TEXTDOMAIN'), function($value) {
    switch ($value){
        case 0:
            echo __('全职','BT_TEXTDOMAIN');
            break;
        case 1:
            echo __('兼职','BT_TEXTDOMAIN');
            break;
        case 2:
            echo __('实习','BT_TEXTDOMAIN');
            break;
        default:
            echo __('全职','BT_TEXTDOMAIN');
    }
}, 'number');    

// REST API
$job->setRest('job');
