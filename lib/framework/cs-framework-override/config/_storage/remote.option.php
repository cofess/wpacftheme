<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 远程图片            
// ------------------------------
$options[]   = array(
    'name'   => 'storage-remote_section',
    'title'  => __('远程图片','CS_TEXTDOMAIN'),
    'icon'   => 'fa fa-ioxhost',
    'fields' => array(
        array(
            'type'    => 'subheading',
            'content' => $remote_html,
        ), 
      
        array(
            'id'      => 'cache-remote-image',
            'type'    => 'switcher',
            'title'   => __('保存远程图片','CS_TEXTDOMAIN'),
            'default' => false,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('自动将远程图片镜像到云存储','CS_TEXTDOMAIN').'</span>',
        ),
      
        array(
            'id'         => 'exceptions',
            'type'       => 'textarea',
            'title'      => __('例外','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted">'.__('如果远程图片的链接中包含以上字符串或者域名，就不会被保存并镜像到云存储','CS_TEXTDOMAIN').'</span>',
            'attributes' => array(
                'style' => 'min-height: 80px;'
            ), 
        ),    
      
    )
);