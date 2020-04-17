<?php

// Register Post Type
$block = tr_post_type(__('区块','BT_TEXTDOMAIN'), __('区块','BT_TEXTDOMAIN'));
$block->setId('block');
$block->setArgument('supports', ['title','page-attributes','thumbnail'] );

// disable permalink
$block->setArgument('public', false);
$block->setArgument('show_ui', true);

// disable archive page
$block->setArgument('has_archive', false);

// Chain Methods with Eloquence
$block->setIcon('stack')
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

// Add Taxonomy
tr_taxonomy(__('Block Category','BT_TEXTDOMAIN'), __('Block Categories','BT_TEXTDOMAIN'))
->setId('block_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($block); 

// side metabox
$sideBox = tr_meta_box('custom_extra_box')->apply($block);
$sideBox->setLabel(__('额外设置','BT_TEXTDOMAIN'));
$sideBox->setContext('side');
$sideBox->setPriority('default');
$sideBox->setCallback(function(){
    $form = tr_form();
    echo $form->textarea(__('Content Block Information','BT_TEXTDOMAIN'))->setName('info')->setHelp(__('You can use this field to describe this content block','BT_TEXTDOMAIN'));
});

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($block);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $form = tr_form();
    $device_active = [
        __('所有设备','BT_TEXTDOMAIN') => 0,
        __('PC端','BT_TEXTDOMAIN') => 1,
        __('移动端','BT_TEXTDOMAIN') => 2
    ];
    echo $form->row(
        $form->toggle('Block wrap')->setName('wrap_enable')->setText(__('Yes')),
        $form->radio(__('在哪些设备上显示','BT_TEXTDOMAIN'))->setName('device_active')->setOptions($device_active)->setSetting('default', 0) 
    )->setAttribute( 'class', 'radio-horizontal' );
    echo $form->row(
        $form->text(__('Wrap classes','BT_TEXTDOMAIN'))->setName('wrap_class')
    );
});

// Add Column
$block->addColumn('info', false, __('Content Block Information','BT_TEXTDOMAIN'));

// REST API
$block->setRest('block');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('block', 'block_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('block', 'block_category') );
