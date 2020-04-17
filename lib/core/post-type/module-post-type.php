<?php

// Register Post Type
$module = tr_post_type(__('产品导航','BT_TEXTDOMAIN'), __('产品导航','BT_TEXTDOMAIN'));
$module->setId('module');
$module->setArgument('supports', ['title','page-attributes'] );

// disable permalink
$module->setArgument( 'public', false );
$module->setArgument( 'show_ui', true );

// parent menu
$module->setArgument('show_in_menu', 'edit.php?post_type=product');

// disable archive page
$module->setArgument( 'has_archive', false );

// Chain Methods with Eloquence
$module->setIcon('location-arrow')
    ->setArchivePostsPerPage(-1)
    ->setEditorForm( function() {
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
$box = tr_meta_box('custom_post_metabox')->apply($module);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $terms = get_terms( array(
        'taxonomy'   => 'product_category',
        'depth'      => 1,
        'show_count' => false,
        'hide_empty' => false,
    ) );
    $taxonomies = array();
    foreach ($terms as $term=>$v){
        $taxonomies[$v->name] = $v->term_id; 
    }

    $position_options = [
        __('内容上方','BT_TEXTDOMAIN') => 'content-top',
        __('内容下方','BT_TEXTDOMAIN') => 'content-bottom'
    ];

    $form = tr_form();
    echo $form->row(
        $form->toggle('PC端显示')->setName('display')->setText(__('Yes')), 
        $form->toggle('移动端显示')->setName('m_display')->setText(__('Yes'))
    );

    echo $form->row(
        $form->radio(__('展示位置','BT_TEXTDOMAIN'))->setName('position')->setOptions($position_options)->setAttribute( 'class', 'horizontal' )->setSetting('default', 'content-bottom'),
        $form->select(__('绑定分类','BT_TEXTDOMAIN'))->setName('bind_taxonomies')->setOptions($taxonomies)
    )->setAttribute( 'class', 'radio-horizontal' );
    //  $form->select(__('选择分类（按住ctrl多选）','BT_TEXTDOMAIN'))->setName('bind_taxonomies')->setOptions($taxonomies)->multiple()
});

// Add Column
$module->addColumn('position', true, __('展示位置','BT_TEXTDOMAIN'), function($value) {
    if($value > 'content-top'){
        echo  __('内容上方','BT_TEXTDOMAIN');
    }else{
        echo __('内容下方','BT_TEXTDOMAIN');
    }
}, 'string');

$module->addColumn('bind_taxonomies', true, __('绑定分类','BT_TEXTDOMAIN'), function($value) {
    echo $value;
    // echo implode(', ', $value);
}, 'string');

// REST API
$module->setRest('module');