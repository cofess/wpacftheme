<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 本地设置               
// ------------------------------
$options[]   = array(
    'name'   => 'storage-local_section',
    'title'  => __('本地设置','CS_TEXTDOMAIN'),
    'icon'   => 'fa fa-gratipay',
    'fields' => array(

        array(
            'id'         => 'exts',
            'type'       => 'text',
            'title'      => __('扩展名','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted">'.__('说明：设置要缓存静态文件的扩展名，请使用 | 分隔开，|前后都不要留空格','CS_TEXTDOMAIN').'</span>',
            'default'    => 'js|css|png|jpg|jpeg|gif|ico',
            'attributes' => array(
                'style' => 'width: 100%;'
            ),
        ),

        array(
            'id'         => 'dirs',
            'type'       => 'text',
            'title'      => __('目录','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted">'.__('说明：设置要缓存静态文件所在的目录，请使用 | 分隔开，|前后都不要留空格','CS_TEXTDOMAIN').'</span>',
            'default'    => 'wp-content|wp-includes',
            'attributes' => array(
                'style' => 'width: 100%;'
            ),
        ),

        array(
            'id'         => 'local-host',
            'type'       => 'text',
            'title'      => __('本地域名','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted">'.__('将该域名也填入CDN的镜像源中','CS_TEXTDOMAIN').'</span>',
            'default'    => home_url(),
            // 'attributes' => array(
            //     'type' => 'url',
            //     'style' => 'width: 100%;'
            // ),
        ),

        array(
            'id'         => 'other-host',
            'type'       => 'text',
            'title'      => __('其他域名','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted">'.__('在编辑内容添加的图片，或者其他操作的图片，它们的地址都是CDN的地址，如果切换了服务，或者 CDN地址换了，那么这些图片就GG了，这个时候，我就提供了第四个选项，你把所有旧的CDN地址都放到这里，系统会自动把这些所有地址都切换到最新的CDN地址','CS_TEXTDOMAIN').'</span>',
            // 'default'    => home_url(),
            // 'attributes' => array(
            //     'type' => 'url',
            //     'style' => 'width: 100%;'
            // ),
        ),

  ),
);