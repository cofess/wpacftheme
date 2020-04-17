<?php

$box = tr_meta_box('custom_page_metabox');
$box->setLabel(__('Settings'));
$box->addScreen('page');
$box->setPriority('high');
$box->setCallback(function(){
    $form = tr_form();
    echo $form->image(__('image','BT_TEXTDOMAIN'))->setName('cover_image');
    echo $form->row(
        $form->text(__('Custom Body Class','BT_TEXTDOMAIN'))->setName('custom_body_class'),
        $form->text(__('Custom Post Class','BT_TEXTDOMAIN'))->setName('custom_post_class')
    );
});
