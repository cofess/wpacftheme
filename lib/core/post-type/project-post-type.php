<?php

// Register Post Type
$project = tr_post_type(__('案例','BT_TEXTDOMAIN'), __('案例','BT_TEXTDOMAIN'));
$project->setId('project');
$project->setArgument('supports', ['title','excerpt','comments','page-attributes'] );
// add tags
$project->addTaxonomy('post_tag');

// Chain Methods with Eloquence
$project->setIcon('suitcase')
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
    	// echo $form->text(__('上线地址','BT_TEXTDOMAIN'))->setName('link');
    	echo $form->editor(__('项目背景','BT_TEXTDOMAIN'))->setName('info');
    }); 

// Add Taxonomy
tr_taxonomy(__('Project Category','BT_TEXTDOMAIN'), __('Project Categories','BT_TEXTDOMAIN'))
->setId('project_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($project);

// Add Custom Side MetaBox
$sideBox = tr_meta_box('custom_extra_box')->apply($project);
$sideBox->setLabel(__('images'));
$sideBox->setContext('side');
$sideBox->setPriority('default');
$sideBox->setCallback(function(){
    $form = tr_form();
    echo $form->gallery(__('images','BT_TEXTDOMAIN'))->setName('images')->setLabel('');
});

// Add Column
$project->addColumn('images', false, __('Image'), function($value) {
    echo wp_get_attachment_image($value[0], 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$project->setRest('project');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('project', 'project_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('project', 'project_category') );

// Custom Post Type Set Comments Open
function projectType_comments_on( $data ) {
    if( $data['post_type'] == 'project' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'projectType_comments_on');

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('project','project_category')]);
}