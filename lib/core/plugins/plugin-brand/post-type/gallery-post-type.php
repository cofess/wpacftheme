<?php

// Register Post Type
$gallery = tr_post_type(__('图集','BT_TEXTDOMAIN'), __('图集','BT_TEXTDOMAIN'));
$gallery->setId('gallery');
$gallery->setArgument('supports', ['title','excerpt','comments','page-attributes'] );

// parent menu
$gallery->setArgument('show_in_menu', 'brand');

// Chain Methods with Eloquence
$gallery->setIcon('images')
    ->setTitlePlaceholder( __('请输入图集名称','BT_TEXTDOMAIN') )
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
tr_taxonomy(__('Gallery Category','BT_TEXTDOMAIN'), __('Gallery Categories','BT_TEXTDOMAIN'))
->setId('gallery_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($gallery);

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($gallery);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $form = tr_form();

    $layout = [
        __('平铺','BT_TEXTDOMAIN') => 0,
        __('幻灯片','BT_TEXTDOMAIN') => 7
    ];
    echo $form->row(
            $form->radio(__('布局方式','BT_TEXTDOMAIN'))->setName('layout')->setOptions($layout)->setSetting('default', 1)
    )->setAttribute('class', 'radio-horizontal');
    echo $form->row(
        $form->toggle('PC端首页显示')->setName('module_display')->setText(__('Yes')), 
        $form->toggle('移动端首页显示')->setName('m_module_display')->setText(__('Yes'))
    );
    echo $form->row(
        $form->text(__('Width','BT_TEXTDOMAIN'))->setName('width')->setSetting('default', '100%'),
        $form->text(__('Height','BT_TEXTDOMAIN'))->setName('height')->setSetting('default', '640px')
    )->setTitle(__('视频尺寸','BT_TEXTDOMAIN'));
});

// Add Custom Side MetaBox
$sideBox = tr_meta_box('custom_extra_box')->apply($gallery);
$sideBox->setLabel(__('images'));
$sideBox->setContext('side');
$sideBox->setPriority('default');
$sideBox->setCallback(function(){
    $form = tr_form();
    echo $form->gallery(__('images','BT_TEXTDOMAIN'))->setName('images')->setLabel('');
});

// Add Column
$gallery->addColumn('images', false, __('Cover'), function($value) {
    echo wp_get_attachment_image($value[0], 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$gallery->setRest('gallery');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('gallery', 'gallery_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('gallery', 'gallery_category') );

// Custom Post Type Set Comments Open
function galleryType_comments_on( $data ) {
    if( $data['post_type'] == 'gallery' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'galleryType_comments_on');
