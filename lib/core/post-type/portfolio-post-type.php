<?php

// Register Post Type
$portfolio = tr_post_type(__('作品','BT_TEXTDOMAIN'), __('作品','BT_TEXTDOMAIN'));
$portfolio->setId('portfolio');
$portfolio->setArgument('supports', ['title','excerpt','comments','page-attributes'] );
// add tags
$portfolio->addTaxonomy('post_tag');

// Chain Methods with Eloquence
$portfolio->setIcon('fire')
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
tr_taxonomy(__('Portfolio Category','BT_TEXTDOMAIN'), __('Portfolio Categories','BT_TEXTDOMAIN'))
->setId('portfolio_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($portfolio);

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($portfolio);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $copyright_options = [
        __('禁止匿名转载；禁止商业使用；禁止个人使用。','BT_TEXTDOMAIN') => 0,
        __('禁止匿名转载；禁止商业使用。','BT_TEXTDOMAIN') => 1,
        __('不限制作品用途。','BT_TEXTDOMAIN') => 1
    ];

    $form = tr_form();
    echo $form->row(
        $form->text(__('Link','BT_TEXTDOMAIN'))->setName('url'),
        $form->select(__('版权','BT_TEXTDOMAIN'))->setName('copyright')->setOptions($copyright_options)->setSetting('default', 0)     
    )->setAttribute( 'class', 'radio-horizontal' );
    echo $form->row(
        $form->text(__('创作时间','BT_TEXTDOMAIN'))->setName('daterange'),
        $form->text(__('使用工具','BT_TEXTDOMAIN'))->setName('tools')  
    );
});

// Add Custom Side MetaBox
$sideBox = tr_meta_box('custom_extra_box')->apply($portfolio);
$sideBox->setLabel(__('images'));
$sideBox->setContext('side');
$sideBox->setPriority('default');
$sideBox->setCallback(function(){
    $form = tr_form();
    echo $form->gallery(__('images','BT_TEXTDOMAIN'))->setName('images')->setLabel('');
});

// Add Column
$portfolio->addColumn('images', false, __('Cover'), function($value) {
    echo wp_get_attachment_image($value[0], 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$portfolio->setRest('portfolio');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('portfolio', 'portfolio_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('portfolio', 'portfolio_category') );

// Custom Post Type Set Comments Open
function portfolioType_comments_on( $data ) {
    if( $data['post_type'] == 'portfolio' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'portfolioType_comments_on');

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('portfolio','portfolio_category')]);
}