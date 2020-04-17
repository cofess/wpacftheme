<?php

// Register Post Type
$topic = tr_post_type(__('专题','BT_TEXTDOMAIN'), __('专题','BT_TEXTDOMAIN'));
$topic->setId('topic');
$topic->setArgument('supports', ['title','thumbnail','excerpt','comments','page-attributes'] );

// Chain Methods with Eloquence
$topic->setIcon('droplet')
    ->setArchivePostsPerPage(-1)
    ->setEditorForm( function() {
        $post_types = get_post_types( ['public' => true]);
        unset($post_types['page'],$post_types['attachment']);

        $filter_type = [
            __('分类','BT_TEXTDOMAIN') => 0,
            __('标签','BT_TEXTDOMAIN') => 1,
            __('标题包含关键词','BT_TEXTDOMAIN') => 2
        ];

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
    	echo $form->repeater(__('添加版块','BT_TEXTDOMAIN'))->setName('blocks')->setFields([
            $form->row(
                $form->text(__('版块名称','BT_TEXTDOMAIN'))->setName('title'), 
                $form->text(__('更多链接','BT_TEXTDOMAIN'))->setName('url')
            ),
            $form->row(
                $form->select(__('选择内容模型','BT_TEXTDOMAIN'))->setName('post_type')->setOptions($post_types),
                $form->text(__('显示记录条数','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 4)
            ),
            $form->row(
                $form->radio(__('查找方式','BT_TEXTDOMAIN'))->setName('filter_type')->setOptions($filter_type)->setSetting('default', 0)
            )->setAttribute( 'class', 'radio-horizontal' ),
            $form->text(__('关键词','BT_TEXTDOMAIN'))->setName('keyword')
	        // $form->search(__('选择文章','BT_TEXTDOMAIN'))->setName('post-list')->setPostType('any')
        ]);
    });

// Add Taxonomy
tr_taxonomy(__('Topic Category','BT_TEXTDOMAIN'), __('Topic Categories','BT_TEXTDOMAIN'))
->setId('topic_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($topic); 

// Add Column
$topic->addColumn('thumbnail', false, __('Image'), function($id) {
	$post_thumbnail_id = get_post_thumbnail_id( $id );
    echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$topic->setRest('topic');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('topic', 'topic_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('topic', 'topic_category') );

// Custom Post Type Set Comments Open
function topicType_comments_on( $data ) {
    if( $data['post_type'] == 'topic' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'topicType_comments_on');
