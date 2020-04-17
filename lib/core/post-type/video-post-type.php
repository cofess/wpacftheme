<?php

// Register Post Type
$video = tr_post_type(__('视频','BT_TEXTDOMAIN'), __('视频','BT_TEXTDOMAIN'));
$video->setId('video');
$video->setArgument('supports', ['title','thumbnail'] );
// add tags
$video->addTaxonomy('post_tag');

// disable permalink
$video->setArgument('public', false);
$video->setArgument('show_ui', true);

// enable archive page
$video->setArgument( 'has_archive', true );
$video->setArgument( 'show_in_nav_menus', true );

// Chain Methods with Eloquence
$video->setIcon('camera')
    ->setTitlePlaceholder( __('请输入视频标题','BT_TEXTDOMAIN') )
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
tr_taxonomy(__('Video Category','BT_TEXTDOMAIN'), __('Video Categories','BT_TEXTDOMAIN'))
->setId('video_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($video);

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($video);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $form = tr_form();

    $source = [
        __('优酷','BT_TEXTDOMAIN') => 0,
        __('爱奇艺','BT_TEXTDOMAIN') => 1,
        __('土豆网','BT_TEXTDOMAIN') => 2,
        __('搜狐视频','BT_TEXTDOMAIN') => 3,
        __('乐视视频','BT_TEXTDOMAIN') => 4,
        __('腾讯视频','BT_TEXTDOMAIN') => 5,
        __('Youtube','BT_TEXTDOMAIN') => 6,
        __('其他','BT_TEXTDOMAIN') => 7
    ];
    echo $form->row(
        $form->text(__('Width','BT_TEXTDOMAIN'))->setName('width')->setSetting('default', '100%'),
        $form->text(__('Height','BT_TEXTDOMAIN'))->setName('height')->setSetting('default', '640px')
    )->setTitle(__('视频尺寸','BT_TEXTDOMAIN'));
    echo $form->row(
        $form->radio(__('视频来源','BT_TEXTDOMAIN'))->setName('source')->setOptions($source)->setSetting('default', 0)
    )->setAttribute( 'class', 'radio-horizontal' );
    echo $form->text(__('视频链接','BT_TEXTDOMAIN'))->setName('url');
    echo $form->image(__('Cover'))->setName('image');
});

// Add Column
$video->addColumn('source', true, __('视频来源','BT_TEXTDOMAIN'), function($value) {
    switch ($value){
        case 0:
            echo  __('优酷','BT_TEXTDOMAIN');
            break;
        case 1:
            echo __('爱奇艺','BT_TEXTDOMAIN');
            break;
        case 2:
            echo __('土豆网','BT_TEXTDOMAIN');
            break;
        case 3:
            echo  __('搜狐视频','BT_TEXTDOMAIN');
            break;
        case 4:
            echo __('乐视视频','BT_TEXTDOMAIN');
            break;
        case 5:
            echo __('腾讯视频','BT_TEXTDOMAIN');
            break;
        case 6:
            echo  __('Youtube','BT_TEXTDOMAIN');
            break;
        case 7:
            echo __('其他','BT_TEXTDOMAIN');
            break;
        default:
            echo __('其他','BT_TEXTDOMAIN');
    }
}, 'number'); 

// $video->addColumn('image', false, __('Cover'), function($value) {
//     echo wp_get_attachment_image($value, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
// }, 'number'); 
$video->addColumn('thumbnail', false, __('Image'), function($id) {
	$post_thumbnail_id = get_post_thumbnail_id( $id );
    echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$video->setRest('video');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('video', 'video_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('video', 'video_category') );