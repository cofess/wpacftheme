<?php

// Register Post Type
$download = tr_post_type(__('下载','BT_TEXTDOMAIN'), __('下载','BT_TEXTDOMAIN'));
$download->setId('download');
$download->setArgument('supports', ['title','thumbnail','excerpt','comments','page-attributes'] );
// add tags
$download->addTaxonomy('post_tag');

// Chain Methods with Eloquence
$download->setIcon('cloud-download')
    ->setTitlePlaceholder( __('请输入文件名称','BT_TEXTDOMAIN') )
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
     	// echo $form->image(__('Cover'))->setName('image');
    	// echo $form->editor(__('摘要','BT_TEXTDOMAIN'))->setName('excerpt');
    	echo $form->repeater(__('下载地址','BT_TEXTDOMAIN'))->setName('resources')->setFields([
            $form->row( 
                $form->text(__('网盘名称','BT_TEXTDOMAIN'))->setName('storage'), 
                $form->text(__('提取密码','BT_TEXTDOMAIN'))->setName('password'),
                $form->text(__('文件版本','BT_TEXTDOMAIN'))->setName('version')
            ),
            $form->text(__('下载地址','BT_TEXTDOMAIN'))->setName('url')
	    ]);
    });

// Add Taxonomy
tr_taxonomy(__('Download category','BT_TEXTDOMAIN'), __('Download categories','BT_TEXTDOMAIN'))
->setId('download_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($download); 

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($download);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $form = tr_form();
    echo $form->toggle('广告')->setName('ads_display')->setText(__('显示文件下载页面广告','BT_TEXTDOMAIN'))->setLabel(''); 
    echo $form->textarea(__('文件下载页面广告代码','BT_TEXTDOMAIN'))->setName('ads_code');
});

// Add Column

// $download->addColumn('image', false, __('Cover'), function($value) {
//     echo wp_get_attachment_image($value, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
// }, 'number');

$download->addColumn('thumbnail', false, __('Image'), function($id) {
	$post_thumbnail_id = get_post_thumbnail_id( $id );
    echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$download->setRest('download');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('download', 'download_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('download', 'download_category') );

// Custom Post Type Set Comments Open
function downloadType_comments_on( $data ) {
    if( $data['post_type'] == 'download' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'downloadType_comments_on');

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('download','download_category')]);
}
