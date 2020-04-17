<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// wordpress Customized section          
// ------------------------------
$options[]   = array(
    'name'     => 'system-wpCustomize_section',
    'title'    => __('WP定制','CS_TEXTDOMAIN'),
    'icon'     => 'fa fa-wordpress',
    'fields'   => array(

        array(
            'type'    => 'subheading',
            'content' => __('更新提示','CS_TEXTDOMAIN'),
        ),

        array(
            'id'      => 'disable-wp-update',
            'type'    => 'checkbox',
            'title'   => __('关闭更新检测','CS_TEXTDOMAIN'),
            // 'desc'    => __('选择要关闭的更新检测项目','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                'update_core'        => __('核心程序','CS_TEXTDOMAIN'),
                'update_plugins'     => __('插件','CS_TEXTDOMAIN'),
                'update_themes'      => __('主题','CS_TEXTDOMAIN'),
                'update_translation' => __('翻译文件','CS_TEXTDOMAIN'),
            ),
            'default' => array( 'update_core', 'update_plugins', 'update_themes', 'update_translation' )
        ),
    
        array(
            'type'    => 'subheading',
            'content' => __('功能开关','CS_TEXTDOMAIN'),
        ),

        array(
            'id'      => 'limit-post-revisions',
            'type'    => 'select',
            'title'   => __('文章修订版本','CS_TEXTDOMAIN'),
            'options' => array(
                'false' => __('关闭文章修订版本','CS_TEXTDOMAIN'),
                '1'     => 1,
                '2'     => 2,
                '3'     => 3,
                '4'     => 4,
                '5'     => 5,
                '10'    => 10,
            ),
            'default_option' => __('请选择','CS_TEXTDOMAIN'),
        ),
    
        array(
            'id'      => 'disable-wp-image-link',
            'type'    => 'switcher',
            'title'   => __('关闭WordPress的图片默认链接功能','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
    
        array(
            'id'      => 'disable-wp-browse-happy',
            'type'    => 'switcher',
            'title'   => __('禁用Browse Happy','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
    
        array(
            'id'       => 'remove-wp-emoji',
            'type'     => 'switcher',
            'title'    => __('禁用Emoji 表情（建议禁用）','CS_TEXTDOMAIN'),
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('Emoji 表情api服务在国内是无法正常访问的，这就导致了网站加载缓慢','CS_TEXTDOMAIN').'</span>',
            'default'  => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
    
        array(
            'id'       => 'disable-wp-xmlrpc',
            'type'     => 'switcher',
            'title'    => __('关闭XML-PRC接口,即XML远程方法调用','CS_TEXTDOMAIN'),
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('如果没有使用离线编辑工具（如：微软Live Writer编辑器），建议禁用','CS_TEXTDOMAIN').'</span>',
            'default'  => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
    
        array(
            'id'       => 'disable-self-pingback',
            'type'     => 'switcher',
            'title'    => __('禁止站内文章互相 Pingback','CS_TEXTDOMAIN'),
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('比如某篇文章引用了另一篇本站的文章，导致会出现无用的 Pingback','CS_TEXTDOMAIN').'</span>',
            'default'  => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
    
        array(
            'id'       => 'disable-trackbacks',
            'type'     => 'switcher',
            'title'    => __('关闭Trackbacks','CS_TEXTDOMAIN'),
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('Trackbacks会带来一些垃圾评论','CS_TEXTDOMAIN').'</span>',
            'default'  => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
      
        array(
            'id'       => 'disable-rest-api',
            'type'     => 'switcher',
            'title'    => __('关闭JSON REST API','CS_TEXTDOMAIN'),
            'help'     => __('JSON REST API 采用 GET 请求方式来获取数据,为 DDOS 攻击提供了一个新的攻击途径，如果有开发APP请开启','CS_TEXTDOMAIN'),
            'default'  => false,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ), 
    
        array(
            'id'       => 'disable-embeds',
            'type'     => 'switcher',
            'title'    => __('禁用embeds嵌入功能','CS_TEXTDOMAIN'),
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('对WP5.0.2以上版本无效，WP5.0.2以上版本禁用embeds会报错','CS_TEXTDOMAIN').'</span>',
            'help'     => __('阻止他人嵌入您网站的内容，阻止自己嵌入其他网站内容（白名单除外），并移除与WordPress嵌入功能相关的JavaScript请求','CS_TEXTDOMAIN'),
            'default'  => false,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'      => 'disable-rss-feeds',
            'type'    => 'switcher',
            'title'   => __('禁用Feed','CS_TEXTDOMAIN'),
            'default' => false,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'      => 'remove-jquery-migrate',
            'type'    => 'checkbox',
            'title'   => __('Remove jQuery migrate','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                'frontend' => __('前台','CS_TEXTDOMAIN'),
                'admin'    => __('后台','CS_TEXTDOMAIN'),
            ),
            'default' => array( 'frontend' )
        ),

        array(
            'id'       => 'remove-media-element',
            'type'     => 'switcher',
            'title'    => __('Remove Media Element','CS_TEXTDOMAIN'),
            'default'  => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'      => 'disable-heartbeat',
            'type'    => 'select',
            'title'   => __('Heartbeat','CS_TEXTDOMAIN'),
            'help'    => __('Disable WordPress Heartbeat everywhere or in certain areas (used for auto saving and revision tracking).','CS_TEXTDOMAIN'),
            'options' => array(
                'disable_everywhere' => __('Disable Everywhere','CS_TEXTDOMAIN'),
                'allow_posts'        => __('Only Allow When Editing Posts/Pages','CS_TEXTDOMAIN'),
            ),
            'default' => 'allow_posts',
            'default_option' => __('请选择','CS_TEXTDOMAIN'),
        ),

        array(
            'id'      => 'heartbeat-frequency',
            'type'    => 'select',
            'title'   => __('Heartbeat Frequency','CS_TEXTDOMAIN'),
            'help'    => __('Controls how often the WordPress Heartbeat API is allowed to run.','CS_TEXTDOMAIN'),
            'options' => array(
                ''   => __('15 Seconds (Default)','CS_TEXTDOMAIN'),
                '30' => __('30 Seconds','CS_TEXTDOMAIN'),
                '45' => __('45 Seconds','CS_TEXTDOMAIN'),
                '60' => __('60 Seconds','CS_TEXTDOMAIN'),
            ),
            'default'        => '60',
            'default_option' => __('请选择','CS_TEXTDOMAIN'),
        ),
  
    )
  );