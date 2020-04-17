<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 功能拓展               
// ------------------------------
$options[]   = array(
    'name'   => 'system-extend_section',
    'title'  => __('功能拓展','CS_TEXTDOMAIN'),
    'icon'   => 'fa fa-cog',
    'fields' => array(
        array(
            'id'      => 'dashboard-layout',
            'type'    => 'radio',
            'title'   => __('仪表盘布局','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                '1' => __('1列','CS_TEXTDOMAIN'),
                '2' => __('2列','CS_TEXTDOMAIN'),
                '3' => __('3列','CS_TEXTDOMAIN'),
            ),
            'default' => '2',
        ),

        array(
            'id'      => 'list-show-ids',
            'type'    => 'switcher',
            'title'   => __('在管理列表中显示 ID','CS_TEXTDOMAIN'),
            'default' => false,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('后台文章、分类、页面、标签、评论、用户等管理列表显示 ID','CS_TEXTDOMAIN').'</span>',
        ),

        array(
            'id'      => 'editor-button-extend',
            'type'    => 'switcher',
            'title'   => __('默认编辑器增强','CS_TEXTDOMAIN'),
            'default' => true,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('WP5.0.2以上版本已启用Gutenberg编辑器，该设置对WP5.0.2以上版本无效','CS_TEXTDOMAIN').'</span>',
            'help'   => __('默认编辑器没有把所有的功能菜单都显示出来，启用可以找回这些功能菜单','CS_TEXTDOMAIN'),
        ),

        array(
            'type'    => 'subheading',
            'content' => __('文件重命名','CS_TEXTDOMAIN'),
        ),

        array(
            'id'      => 'upload-file-rename',
            'type'    => 'radio',
            'title'   => __('上传文件重命名','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                '0'   => __('禁用','CS_TEXTDOMAIN'),
                '1'   => __('所有文件','CS_TEXTDOMAIN'),
                '2'   => __('仅中文名称文件','CS_TEXTDOMAIN'),
            ),
            'default' => '1',
        ),

        array(
            'id'      => 'file-rename-mode',
            'type'    => 'radio',
            'title'   => __('文件重命名方式','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                '1'   => __('命名方式：时间戳+随机数字（MD5加密文件名）','CS_TEXTDOMAIN'),
                '2'   => __('命名方式：随机数字（MD5加密文件名）','CS_TEXTDOMAIN'),
            ),
            'default' => '1',
            'dependency' => array( 'upload-file-rename_0', '==', 'false' ),
        ),

        array(
            'type'    => 'subheading',
            'content' => __('用户相关','CS_TEXTDOMAIN'),
        ),

        array(
            'id'      => 'enhance-user-query',
            'type'    => 'switcher',
            'title'   => __('增强后台用户搜索','CS_TEXTDOMAIN'),
            'default' => true,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('支持通过 display_name, nickname, user_email 进行检索','CS_TEXTDOMAIN').'</span>',
        ),

        array(
            'id'      => 'enable_custom_gravatar',
            'type'    => 'switcher',
            'title'   => __('用户自定义头像','CS_TEXTDOMAIN'),
            'default' => false,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('上传本地图片作为注册用户个人资料头像','CS_TEXTDOMAIN').'</span>',
        ),

        array(
            'id'      => 'show-user-register-date',
            'type'    => 'switcher',
            'title'   => __('显示用户注册时间','CS_TEXTDOMAIN'),
            'default' => true,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('后台用户列表显示用户注册时间','CS_TEXTDOMAIN').'</span>',
        ),

        array(
            'id'      => 'show-user-nickname',
            'type'    => 'switcher',
            'title'   => __('显示用户昵称','CS_TEXTDOMAIN'),
            'default' => false,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('后台用户列表显示用户昵称','CS_TEXTDOMAIN').'</span>',
        ),

        array(
            'id'      => 'sort-user-by-post-count',
            'type'    => 'switcher',
            'title'   => __('用户根据文章数进行排序','CS_TEXTDOMAIN'),
            'default' => false,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('后台用户列表可以根据文章数进行排序','CS_TEXTDOMAIN').'</span>',
        ),

    ), // end: fields

);