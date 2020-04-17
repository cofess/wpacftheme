<?php

// side metabox
$box = tr_meta_box('custom_post_side_metabox');
$box->setLabel(__('文章内容索引','BT_TEXTDOMAIN'));
$box->addScreen('post');
$box->setContext('side');
$box->setPriority('high');
$box->setCallback(function(){
    $toc_depth = [
        'h2' => 'h2',
        'h3' => 'h3',
        'h4' => 'h4',
        'h5' => 'h5',
        'h6' => 'h6',
    ];
    $form = tr_form();
    echo $form->toggle(__('文章内容索引','BT_TEXTDOMAIN'))->setName('enable_toc')->setText(__('启用文章内容索引','BT_TEXTDOMAIN'))->setLabel('');
    echo $form->select(__('显示到第几级目录','BT_TEXTDOMAIN'))->setName('toc_depth')->setOptions($toc_depth)->setSetting('default', array('h2'));
});