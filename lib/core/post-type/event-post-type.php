<?php

// Register Post Type
$event = tr_post_type(__('活动','BT_TEXTDOMAIN'), __('活动','BT_TEXTDOMAIN'));
$event->setId('event');
$event->setArgument('supports', ['title','thumbnail','excerpt','comments','page-attributes']);
// add tags
$event->addTaxonomy('post_tag');

// Chain Methods with Eloquence
$event->setIcon('brightness-contrast')
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
tr_taxonomy(__('Event Category','BT_TEXTDOMAIN'), __('Event Categories','BT_TEXTDOMAIN'))
->setId('event_category')
->setHierarchical()
->setArgument('public', true)
->setArgument('show_ui', true)
->setArgument('show_admin_column', true)
->setArgument('show_in_rest', true)
->apply($event);   

// Add Custom MetaBox
$box = tr_meta_box('custom_post_metabox')->apply($event);
$box->setLabel(__('Settings'));
$box->setPriority('high');
$box->setCallback(function() {
    $form = tr_form();

    $tabContentOne = function() use ($form){
        echo $form->row(
            $form->date(__('报名开始日期','BT_TEXTDOMAIN'))->setName('apply_start_date')->setFormat('yy-mm-dd'),
            $form->text(__('报名开始时间','BT_TEXTDOMAIN'))->setName('apply_start_time')->setSetting('default', '09:00'),
            $form->date(__('报名截止日期','BT_TEXTDOMAIN'))->setName('apply_end_date')->setFormat('yy-mm-dd'),
            $form->text(__('报名截止时间','BT_TEXTDOMAIN'))->setName('apply_end_time')->setSetting('default', '22:00')
        );
        echo $form->row(
            $form->date(__('活动开始日期','BT_TEXTDOMAIN'))->setName('start_date')->setFormat('yy-mm-dd'),
            $form->text(__('活动开始时间','BT_TEXTDOMAIN'))->setName('start_time')->setSetting('default', '09:00'),
            $form->date(__('活动截止日期','BT_TEXTDOMAIN'))->setName('end_date')->setFormat('yy-mm-dd'),
            $form->text(__('活动截止时间','BT_TEXTDOMAIN'))->setName('end_time')->setSetting('default', '22:00')
        );
        echo $form->row(
            $form->text(__('活动举办地','BT_TEXTDOMAIN'))->setName('place'),
            $form->text(__('活动地址','BT_TEXTDOMAIN'))->setName('address'),
            $form->text(__('活动地址地图','BT_TEXTDOMAIN'))->setName('map')
        );
        echo $form->row(
            $form->text(__('计划人数','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 100),
            $form->text(__('活动费用','BT_TEXTDOMAIN'))->setName('cost'),
            $form->text(__('报名链接','BT_TEXTDOMAIN'))->setName('link')
        );
    };

    $tabContentTwo = function() use ($form){
        echo $form->repeater(__('Add'))->setName('stories')->setFields([
            $form->row(
                $form->column(
                    $form->text(__('Name','BT_TEXTDOMAIN'))->setName('date'),
                    $form->textarea(__('Content','BT_TEXTDOMAIN'))->setName('event')
                ),
                $form->column(
                    $form->image(__('Avatar','BT_TEXTDOMAIN'))->setName('image')
                )   
            )
        ]);
    };
    

    $tabs = tr_tabs();
    $tabs->addTab([
        'id'       => 'tab-one',
        'title'    => __('基本信息','BT_TEXTDOMAIN'),
        'callback' => $tabContentOne
    ]);
    $tabs->addTab([
        'id'       => 'tab-two',
        'title'    => __('活动嘉宾','BT_TEXTDOMAIN'),
        'callback' => $tabContentTwo
    ]);
                
    $tabs->render();
});

// Add Sortable Columns to Admin Index View
$event->addColumn('place', true, __('活动举办地','BT_TEXTDOMAIN'));
$event->addColumn('event_status', false, __('Status'), function($id) {
    $apply_start_time = strtotime(tr_posts_field('apply_start_date').tr_posts_field('apply_start_time'));
    $apply_end_time = strtotime(tr_posts_field('apply_end_date').tr_posts_field('apply_end_time'));
    $start_time = strtotime(tr_posts_field('start_date').tr_posts_field('start_time'));
    $end_time = strtotime(tr_posts_field('end_date').tr_posts_field('end_time'));
    if(time()<$apply_start_time){
        echo '<span style="color:gray">'.__('未开始报名','BT_TEXTDOMAIN').'</span>';
    } elseif(time()>=$apply_start_time && time()<=$apply_end_time){
        echo '<span style="color:blue">'.__('报名中','BT_TEXTDOMAIN').'</span>';
    } elseif(time()>$apply_end_time && time()<$start_time){
        echo '<span style="color:orange">'.__('报名结束','BT_TEXTDOMAIN').'</span>';
    } elseif(time()>=$start_time && time()<=$end_time){
        echo '<span style="color:green">'.__('活动中','BT_TEXTDOMAIN').'</span>';
    } elseif(time()>$end_time){
        echo '<span style="color:red">'.__('活动结束','BT_TEXTDOMAIN').'</span>';
    } else{
        echo '—';
    }
}, 'number');
$event->addColumn('thumbnail', false, __('Image'), function($id) {
    $post_thumbnail_id = get_post_thumbnail_id( $id );
    echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$event->setRest('event');

// Add taxtonomy filters
// Creates select fields for filtering posts by taxonomies on admin edit screen.
add_action('restrict_manage_posts', Lib\Core\Taxonomy::add_taxtonomy_filter('event', 'event_category') );
add_filter('parse_query', Lib\Core\Taxonomy::parse_taxtonomy_filter_query('event', 'event_category') );

// Custom Post Type Set Comments Open
function eventType_comments_on( $data ) {
    if( $data['post_type'] == 'event' ) {
        $data['comment_status'] = 'open';
    }
    return $data;
}
add_filter('wp_insert_post_data', 'eventType_comments_on');

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
    add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('event','event_category')]);
}
