<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 系统清理               
// ------------------------------
$options[]   = array(
    'name'     => 'system-clean_section',
    'title'    => __('系统清理','CS_TEXTDOMAIN'),
    'icon'     => 'fa fa-recycle',
    'fields'   => array(

        array(
            'type'    => 'subheading',
            'content' => __('网站前台','CS_TEXTDOMAIN'),
        ),

        array(
            'id'      => 'disable-admin-bar',
            'type'    => 'switcher',
            'title'   => __('禁用顶部管理员工具条','CS_TEXTDOMAIN'),
            'help'    => __('为使页面干净，建议隐藏','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'         => 'clean-wp-header',
            'type'       => 'checkbox',
            'title'      => __('Remove from template header','CS_TEXTDOMAIN'),
            'options'    => array(
                'feed_links'              => __('Feed Links (Links to general feeds)','CS_TEXTDOMAIN'),
                'feed_links_extra'        => __('Feed Links extras (Links to additional feeds)','CS_TEXTDOMAIN'),
                'rsd_link'                => __('RSD Link (Link to the Really Simple Discovery service endpoint)','CS_TEXTDOMAIN'),
                'wlwmanifest_link'        => __('wlwmanifest (Link to Windows Live Writer manifest file)','CS_TEXTDOMAIN'),
                'index_rel_link'          => __('Remove the index link','CS_TEXTDOMAIN'),
                'parent_post_rel_link'    => __('Remove the prev link','CS_TEXTDOMAIN'),
                'start_post_rel_link'     => __('Remove the start link','CS_TEXTDOMAIN'),
                'adjacent_posts_rel_link' => __('Relational links for the posts adjacent to the current post.','CS_TEXTDOMAIN'),
                'wp_resource_hints'       => __('DNS prefetch //s.w.org','CS_TEXTDOMAIN'),
                'wp_shortlink_wp_head'    => __('Remove shortlink','CS_TEXTDOMAIN'),
                'xfn_link'                => __('Removing XFN (XHTML Friends Network) Profile Link','CS_TEXTDOMAIN'),
            ),
            'default'    => array( 'rsd_link', 'wlwmanifest_link', 'wp_resource_hints', 'wp_shortlink_wp_head', 'xfn_link' )
        ),

        array(
            'id'      => 'remove-query-strings',
            'type'    => 'switcher',
            'title'   => __('从静态资源中删除查询字符串','CS_TEXTDOMAIN'),
            'desc'    => __('加载的css或者js后面的?ver=xxx 版本号','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'type'    => 'subheading',
            'content' => __('网站后台','CS_TEXTDOMAIN'),
        ),

        array(
            'id'         => 'clean-dashboard-widgets',
            'type'       => 'checkbox',
            'title'      => __('仪表盘清理','CS_TEXTDOMAIN'),
            'desc'       => __('选择您不希望在仪表盘显示的项目','CS_TEXTDOMAIN'),
            'class'      => 'horizontal',
            'options'    => array(
                'welcome_panel'             => __('Welcome','CS_TEXTDOMAIN'),
                'dashboard_incoming_links'  => __('链入链接','CS_TEXTDOMAIN'),
                'dashboard_right_now'       => __('概览','CS_TEXTDOMAIN'),
                'dashboard_plugins'         => __('插件','CS_TEXTDOMAIN'),
                'dashboard_recent_comments' => __('近期评论','CS_TEXTDOMAIN'),
                'dashboard_primary'         => __('wordpress活动及新闻','CS_TEXTDOMAIN'),
                'dashboard_secondary'       => __('其它WordPress新闻','CS_TEXTDOMAIN'),
                'dashboard_quick_press'     => __('快速草稿','CS_TEXTDOMAIN'),
                'dashboard_recent_drafts'   => __('近期草稿','CS_TEXTDOMAIN'),
                'dashboard_activity'        => __('活动','CS_TEXTDOMAIN'),
            ),
            'default'    => array( 'dashboard_primary', 'dashboard_secondary', 'dashboard_quick_press', 'dashboard_recent_drafts' )
        ),

        array(
            'id'         => 'remove-default-widgets',
            'type'       => 'checkbox',
            'title'      => __('Remove Widgets','CS_TEXTDOMAIN'),
            'class'      => 'horizontal',
            'options'    => array(
                'WP_Widget_Meta'            => __('功能','CS_TEXTDOMAIN'),
                'WP_Widget_Calendar'        => __('日历','CS_TEXTDOMAIN'),
                'WP_Widget_Text'            => __('文本','CS_TEXTDOMAIN'),
                'WP_Widget_Media_Audio'     => __('音频','CS_TEXTDOMAIN'),
                'WP_Widget_Media_Video'     => __('视频','CS_TEXTDOMAIN'),
                'WP_Widget_Media_Gallery'   => __('画廊','CS_TEXTDOMAIN'),
                'WP_Widget_Media_Image'     => __('图像','CS_TEXTDOMAIN'),
                'WP_Widget_Links'           => __('链接','CS_TEXTDOMAIN'),
                'WP_Nav_Menu_Widget'        => __('菜单','CS_TEXTDOMAIN'),
                'WP_Widget_Pages'           => __('页面','CS_TEXTDOMAIN'),
                'WP_Widget_RSS'             => __('RSS','CS_TEXTDOMAIN'),
                'WP_Widget_Search'          => __('搜索','CS_TEXTDOMAIN'),
                'WP_Widget_Tag_Cloud'       => __('标签云','CS_TEXTDOMAIN'),
                'WP_Widget_Archives'        => __('文章归档','CS_TEXTDOMAIN'),
                'WP_Widget_Categories'      => __('分类目录','CS_TEXTDOMAIN'),
                'WP_Widget_Recent_Comments' => __('近期评论','CS_TEXTDOMAIN'),
                'WP_Widget_Recent_Posts'    => __('近期文章','CS_TEXTDOMAIN'),
                
            ),
            'default'    => array( 'WP_Widget_Meta','WP_Widget_Media_Audio','WP_Widget_Media_Video','WP_Widget_Media_Gallery','WP_Widget_Pages' )
        ),

        array(
            'id'         => 'clean-admin-bar',
            'type'       => 'checkbox',
            'title'      => __('Admin Bar清理','CS_TEXTDOMAIN'),
            'desc'       => __('选择您不希望在admin bar显示的项目','CS_TEXTDOMAIN'),
            'class'      => 'horizontal',
            'options'    => array(
                'wp-logo'     => __('Wordpress Logo','CS_TEXTDOMAIN'),
                'updates'     => __('更新','CS_TEXTDOMAIN'),
                'comments'    => __('评论','CS_TEXTDOMAIN'),
                'new-content' => __('新建','CS_TEXTDOMAIN'),
                'site-name'   => __('站点名称','CS_TEXTDOMAIN'),
            ),
            'default'    => array( 'wp-logo' )
        ),
    
        array(
            'id'      => 'remove-wordpress-from-admin-title',
            'type'    => 'switcher',
            'title'   => __('删除标题title中“wordpress”文字','CS_TEXTDOMAIN'),
            'desc'    => __('删除后台标题title中“wordpress”文字','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
    
        array(
            'id'      => 'custom-wp-footer-text',
            'type'    => 'radio',
            'title'   => __('网站后台底部版权信息','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                '0'     => __('默认','CS_TEXTDOMAIN'),
                '1'     => __('不显示','CS_TEXTDOMAIN'),
                '2'     => __('自定义','CS_TEXTDOMAIN'),
            ),
            'default' => '0',
        ),
    
        array(
            'id'         => 'footer-text-left',
            'type'       => 'text',
            'title'      => __('自定义后台底部文字-left','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-warning">( '.__('后台底部左侧文字信息','CS_TEXTDOMAIN').' )</span>',
            'dependency' => array( 'custom-wp-footer-text_2', '==', 'true' ),
        ),
    
        array(
            'id'         => 'footer-text-right',
            'type'       => 'text',
            'title'      => __('自定义后台底部文字-right','CS_TEXTDOMAIN'),
            'after'      => ' <span class="cs-text-warning">( '.__('后台底部右侧文字信息','CS_TEXTDOMAIN').' )</span>',
            'dependency' => array( 'custom-wp-footer-text_2', '==', 'true' ),
        ),
  
    )
);