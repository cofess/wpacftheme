<?php
if ( ! function_exists( 'add_action' )) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

// Setup Form
$form = tr_form()->useJson()->setGroup( $this->getName() );
$config = \TypeRocket\Core\Config::locate('typerocket.plugin-module-options.options');
?>

<h1>Module Setting</h1>
<div class="typerocket-container">
    <?php
    global $current_screen;
    // $current_post_type = $current_screen->post_type;
    $current_post_type = $this->postType;
    $current_taxonomy = $this->taxonomy;
    $support_attributes = get_all_post_type_supports($current_post_type);

    $obj = get_post_type_object( $current_post_type );
    // var_dump($current_post_type,$current_taxonomy);
    // var_dump($current_screen);
    // var_dump($obj);
    // echo $obj->public;
    // echo $obj->show_ui;
    
    echo $form->open();

    // $args = $form->getSettings();
    // $args = array_merge( $args, array( 'redirect' => true, 'block_flash' => true) );
    // $form->setSettings( $args );
    // var_dump($form->getSettings());

    // Home Page Setting
    $moduleSetting = function() use ($form,$current_taxonomy) {
        echo $form->row( 
            $form->toggle('PC端首页显示')->setName('module_display')->setText(__('Yes')), 
            $form->toggle('移动端首页显示')->setName('m_module_display')->setText(__('Yes'))
        );
        if($current_taxonomy){
            $terms = get_terms( array(
                'taxonomy'   => $current_taxonomy,
                'depth'      => 1,
                'show_count' => true,
                'hide_empty' => true,
            ) );
            $taxonomies = array();
            foreach ($terms as $term=>$v){
                $taxonomies[$v->name] = $v->term_id; 
            }
            echo $form->row(
                $form->column(
                    $form->toggle('仅显示指定分类')->setName('filter')->setText(__('Yes'))->setSetting('default', false),
                    $form->toggle('以Tab标签页形式展示')->setName('tab_layout')->setText(__('Yes'))->setSetting('default', false)
                ),
                $form->column(
                    $form->select(__('选择分类（仅一级分类）','BT_TEXTDOMAIN'))->setName('taxonomies')->setOptions($taxonomies)->multiple()
                )
            );
        }
        echo $form->row( 
            $form->text(__('显示数量','BT_TEXTDOMAIN'))->setName('module_limit')->setSetting('default', 4), 
            $form->text(__('Module Prefix Class','BT_TEXTDOMAIN'))->setName('module_prefix_class')
        );
        echo $form->row(
            $form->text(__('模块标题','BT_TEXTDOMAIN'))->setName('module_title'), 
            $form->text(__('模块副标题','BT_TEXTDOMAIN'))->setName('module_subtitle')
        );
        echo $form->editor(__('模块描述','BT_TEXTDOMAIN'))->setName('module_description');
        echo $form->row(
            $form->image('PC端背景图')->setName('module_image')->setSetting('button', 'Insert Image'),
            $form->image('移动端背景图')->setName('m_module_image')->setSetting('button', 'Insert Image')
        );
        echo $form->row(
            $form->toggle('显示ViewMore链接')->setName('show_more')->setText(__('Yes')),
            $form->text(__('ViewMore链接文本','BT_TEXTDOMAIN'))->setName('more_text')->setSetting('default', __('查看更多','BT_TEXTDOMAIN'))
        );
        echo $form->toggle('显示模块下边距')->setName('show_module_margin')->setText(__('Yes'));
    };

    // List Page Setting
    $listPageSetting = function() use ($form) {
        $pagination_type = [
            __('传统页码','BT_TEXTDOMAIN') => 0,
            __('简单分页','BT_TEXTDOMAIN') => 1,
            __('瀑布流','BT_TEXTDOMAIN')  => 2
        ];
        $sort_type = [
            __('默认排序','BT_TEXTDOMAIN')  => 0,
            __('按时间排序','BT_TEXTDOMAIN') => 1,
            __('按ID排序','BT_TEXTDOMAIN') => 2
        ];
        $columns = [
            __('6列布局','BT_TEXTDOMAIN') => 6,
            __('5列布局','BT_TEXTDOMAIN') => 5,
            __('4列布局','BT_TEXTDOMAIN') => 4,
            __('3列布局','BT_TEXTDOMAIN') => 3,
            __('2列布局','BT_TEXTDOMAIN') => 2
        ];
        
        echo $form->row(
            $form->checkbox(__('缩略图','BT_TEXTDOMAIN'))->setName('show_thumb')->setText(__('缩略图','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true),
            $form->checkbox(__('Title'))->setName('show_title')->setText(__('Title'))->setLabel('')->setSetting('default', true),
            $form->checkbox(__('摘要','BT_TEXTDOMAIN'))->setName('show_excerpt')->setText(__('摘要','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true),
            $form->checkbox(__('作者','BT_TEXTDOMAIN'))->setName('show_author')->setText(__('作者','BT_TEXTDOMAIN'))->setLabel(''),
            $form->checkbox(__('日期','BT_TEXTDOMAIN'))->setName('show_date')->setText(__('日期','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true),
            $form->checkbox(__('访问量','BT_TEXTDOMAIN'))->setName('show_pv')->setText(__('访问量','BT_TEXTDOMAIN'))->setLabel('')->setSetting('default', true)
        )->setTitle(__('展示项','BT_TEXTDOMAIN'));
        echo $form->row(
            $form->select(__('列表分页方式','BT_TEXTDOMAIN'))->setName('pagination_type')->setOptions($pagination_type)->setSetting('default', 0),
            $form->select(__('列表排序方式','BT_TEXTDOMAIN'))->setName('sort_type')->setOptions($sort_type)->setSetting('default', 0),
            $form->select(__('列布局','BT_TEXTDOMAIN'))->setName('column')->setOptions($columns)->setSetting('default', 0),
            $form->text(__('每页显示数量','BT_TEXTDOMAIN'))->setName('limit')->setType('number')->setSetting('default', 12)
        );
        echo $form->row(
            $form->text(__('栏目标题','BT_TEXTDOMAIN'))->setName('title'), 
            $form->text(__('栏目副标题','BT_TEXTDOMAIN'))->setName('subtitle')
        );
        echo $form->editor(__('栏目描述','BT_TEXTDOMAIN'))->setName('description');
        echo $form->image('背景图')->setName('image')->setSetting('button', 'Insert Image');
        echo '<hr/>';
        echo '<h3>'.__('缩略图','BT_TEXTDOMAIN').'</h3>';
        echo $form->row(
            $form->column(
                $form->text(__('缩略图宽度','BT_TEXTDOMAIN'))->setName('thumb_width'), 
                $form->text(__('缩略图高度','BT_TEXTDOMAIN'))->setName('thumb_height')
            ),
            $form->column(
                $form->image('默认缩略图')->setName('thumb')->setSetting('button', 'Insert Image')
            )
        );
        echo '<hr/>';
        echo '<h3>'.__('布局','BT_TEXTDOMAIN').'</h3>';
        $layout = [
            'item1' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/cs.gif',
                'value' => 1
            ],
            'item2' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/sc.gif',
                'value' => 2
            ],
            'item3' => [
                'src' => get_template_directory_uri() .'/static/admin/images/layout/c.gif',
                'value' => 3
            ]
        ];
        echo $form->row(
            $form->radio(__('布局方式','BT_TEXTDOMAIN'))->setName('layout')->setOptions($layout)->useImages()->setSetting('default', 1)
        )->setAttribute( 'class', 'radio-horizontal' );
        echo $form->row(
            $form->text(__('Custom Body Class','BT_TEXTDOMAIN'))->setName('custom_body_class'),
            $form->text(__('Custom List Class','BT_TEXTDOMAIN'))->setName('custom_list_class')
        );
    };

    // Single Page Setting
    $singlePageSetting = function() use ($form) {
        $lightbox_options = [
            __('关闭','BT_TEXTDOMAIN') => 0,
            __('单图模式','BT_TEXTDOMAIN') => 1,
            __('相册模式','BT_TEXTDOMAIN')  => 2
        ];
        $related_post_style = [
            __('带缩略图','BT_TEXTDOMAIN') => 0,
            __('简洁标题','BT_TEXTDOMAIN') => 1
        ];
        echo $form->row(
            $form->radio(__('图片灯箱','BT_TEXTDOMAIN'))->setName('lightbox')->setOptions($lightbox_options)->setSetting('default', 1)->setHelp(__('开启后，文章中如带【有图片链接的图片】，点击将弹窗显示。','BT_TEXTDOMAIN'))
        )->setAttribute( 'class', 'radio-horizontal' );
        echo $form->row(
            $form->toggle('显示相关文章')->setName('show_related_post')->setText(__('Yes')),
            $form->radio(__('相关文章展示形式','BT_TEXTDOMAIN'))->setName('related_post_style')->setOptions($related_post_style)->setSetting('default', 0)
        )->setAttribute( 'class', 'radio-horizontal' );
        echo $form->row(
            $form->text(__('相关文章标题','BT_TEXTDOMAIN'))->setName('related_post_title')->setSetting('default', __('相关推荐','BT_TEXTDOMAIN')),
            $form->text(__('相关文章显示数量','BT_TEXTDOMAIN'))->setName('related_post_limit')->setSetting('default', 4)
        );
        echo $form->toggle('显示上下文链接')->setName('show_post_nav')->setText(__('Yes'));
        echo $form->toggle('开启社交分享')->setName('enable_share')->setText(__('Yes'));
        echo $form->toggle('每段文字首行缩进2个字符')->setName('enable_text_indent')->setText(__('Yes'));
    };

    // List Ads Setting
    $listPageAdsSetting = function() use ($form) {
        echo '<h3>'.__('PC端广告','BT_TEXTDOMAIN').'</h3>';
        echo $form->toggle('显示列表广告')->setName('ads_display')->setText(__('Yes')); 
        echo $form->text(__('列表广告展示位置','BT_TEXTDOMAIN'))->setName('ads_position')->setType('number')->setSetting('default', 1)->setHelp(__('自定义显示位置，例如输入7，则此广告出现于列表第7的位置。','BT_TEXTDOMAIN'));
        echo $form->textarea(__('列表广告代码','BT_TEXTDOMAIN'))->setName('ads_code');
        // echo '<hr/>';
        echo '<h3>'.__('移动端广告','BT_TEXTDOMAIN').'</h3>';
        echo $form->toggle('显示列表广告')->setName('m_ads_display')->setText(__('Yes')); 
        echo $form->text(__('列表广告展示位置','BT_TEXTDOMAIN'))->setName('m_ads_position')->setType('number')->setSetting('default', 1)->setHelp(__('自定义显示位置，例如输入7，则此广告出现于列表第7的位置。','BT_TEXTDOMAIN'));
        echo $form->textarea(__('列表广告代码','BT_TEXTDOMAIN'))->setName('m_ads_code');
    };

    // Single Page Ads Setting
    $singlePageAdsSetting = function() use ($form,$support_attributes) {
        echo '<h3>'.__('PC端广告','BT_TEXTDOMAIN').'</h3>';
        echo $form->toggle('正文内容上方显示广告')->setName('content_top_ads_display')->setText(__('Yes')); 
        echo $form->textarea(__('正文内容上方广告代码','BT_TEXTDOMAIN'))->setName('content_top_ads_code');
        echo $form->toggle('正文内容下方显示广告')->setName('content_bottom_ads_display')->setText(__('Yes')); 
        echo $form->textarea(__('正文内容下方广告代码','BT_TEXTDOMAIN'))->setName('content_bottom_ads_code');
        if($support_attributes['comments']){
            echo $form->toggle('评论上方显示广告')->setName('comment_top_ads_display')->setText(__('Yes')); 
            echo $form->textarea(__('评论上方广告代码','BT_TEXTDOMAIN'))->setName('comment_top_ads_code');
        }
        // echo '<hr/>';
        echo '<h3>'.__('移动端广告','BT_TEXTDOMAIN').'</h3>';
        echo $form->toggle('正文内容上方显示广告')->setName('m_content_top_ads_display')->setText(__('Yes')); 
        echo $form->textarea(__('正文内容上方广告代码','BT_TEXTDOMAIN'))->setName('m_content_top_ads_code');
        echo $form->toggle('正文内容下方显示广告')->setName('m_content_bottom_ads_display')->setText(__('Yes')); 
        echo $form->textarea(__('正文内容下方广告代码','BT_TEXTDOMAIN'))->setName('m_content_bottom_ads_code');
        if($support_attributes['comments']){
            echo $form->toggle('评论上方显示广告')->setName('m_comment_top_ads_display')->setText(__('Yes')); 
            echo $form->textarea(__('评论上方广告代码','BT_TEXTDOMAIN'))->setName('m_comment_top_ads_code');
        }
    };

    // Layout
    $tabs = tr_tabs();
    $tabs->addTab([
        'id'       => 'module-setting',
        'title'    => __('模块设置','BT_TEXTDOMAIN'),
        'callback' => $moduleSetting
    ]);
    if( $obj->has_archive || $current_screen->parent_file == 'edit.php' ) {
        $tabs->addTab([
            'id'       => 'list-setting',
            'title'    => __('列表页设置','BT_TEXTDOMAIN'),
            'callback' => $listPageSetting
        ]);
        if(in_array('list-ads',$config)){
            $tabs->addTab([
                'id'       => 'list-ads-setting',
                'title'    => __('列表页广告','BT_TEXTDOMAIN'),
                'callback' => $listPageAdsSetting
            ]);
        }
    }
    if( $obj->public || $current_screen->parent_file == 'edit.php' ) {
        $tabs->addTab([
            'id'       => 'single-setting',
            'title'    => __('详情页设置','BT_TEXTDOMAIN'),
            'callback' => $singlePageSetting
        ]);
        if(in_array('single-ads',$config)){
           $tabs->addTab([
                'id'       => 'single-ads-setting',
                'title'    => __('详情页广告','BT_TEXTDOMAIN'),
                'callback' => $singlePageAdsSetting
            ]); 
        }   
    }
    $tabs->render();
    echo '<br/>';
    echo $form->close('Submit');
    ?>

</div>
