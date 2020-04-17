<?php

// Register Post Type
$faq = tr_post_type(__('FAQ','BT_TEXTDOMAIN'), __('FAQ','BT_TEXTDOMAIN'));
$faq->setId('faq');
$faq->setArgument('supports', ['title','excerpt','page-attributes']);

// Chain Methods with Eloquence
$faq->setIcon('pencil')
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
tr_taxonomy(__('FAQ Category','BT_TEXTDOMAIN'), __('FAQ Categories','BT_TEXTDOMAIN'))
->setId('faq_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($faq);   

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($faq);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $form = tr_form();
    echo $form->file('File')->setName('file')->setSetting('type', 'pdf')->setHelp(__('可上传PDF文件供用户下载','BT_TEXTDOMAIN'));
    // echo $form->row(
    //     $form->text(__('觉得内容有用','BT_TEXTDOMAIN'))->setName('helpful')->setSetting('default', 0),  
    //     $form->text(__('觉得内容无用','BT_TEXTDOMAIN'))->setName('unhelpful')->setSetting('default', 0) 
    // );
});

// REST API
$faq->setRest('faq');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('faq', 'faq_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('faq', 'faq_category') );

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('faq','faq_category')]);
}
