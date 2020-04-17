<?php

// Register Post Type
$knowledge = tr_post_type(__('文档','BT_TEXTDOMAIN'), __('文档','BT_TEXTDOMAIN'));
$knowledge->setId('knowledge');
$knowledge->setArgument('supports', ['title','excerpt','comments','page-attributes']);
// add tags
$knowledge->addTaxonomy('post_tag');

// Chain Methods with Eloquence
$knowledge->setIcon('books')
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
tr_taxonomy(__('Knowledge Category','BT_TEXTDOMAIN'), __('Knowledge Categories','BT_TEXTDOMAIN'))
->setId('knowledge_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($knowledge);   

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($knowledge);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $form = tr_form();
    echo $form->row(
        $form->text(__('觉得有用','BT_TEXTDOMAIN'))->setName('helpful')->setSetting('default', 0),  
        $form->text(__('觉得无用','BT_TEXTDOMAIN'))->setName('unhelpful')->setSetting('default', 0) 
    );
});

// Add Sortable Columns to Admin Index View
$knowledge->addColumn('helpful', true, __('觉得有用','BT_TEXTDOMAIN'), function($value) {
    if($value){
       echo $value.__('人','BT_TEXTDOMAIN'); 
    }  
}, 'number');
$knowledge->addColumn('unhelpful', true, __('觉得无用','BT_TEXTDOMAIN'), function($value) {
    if($value){
        echo $value.__('人','BT_TEXTDOMAIN');
    }
}, 'number');

// REST API
$knowledge->setRest('knowledge');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('knowledge', 'knowledge_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('knowledge', 'knowledge_category') );

// Custom Post Type Set Comments Open
function knowledgeType_comments_on( $data ) {
    if( $data['post_type'] == 'knowledge' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'knowledgeType_comments_on');

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('knowledge','knowledge_category')]);
}
