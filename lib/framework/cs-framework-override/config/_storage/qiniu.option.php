<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 七牛云设置            
// ------------------------------
$options[]   = array(
    'name'   => 'storage-qiniu_section',
    'title'  => __('七牛云设置','CS_TEXTDOMAIN'),
    'icon'   => 'fa fa-cloud',
    'fields' => array(

        array(
            'type'    => 'notice',
            'class'   => 'warning',
            'content' => __('以下设置只对云存储服务选择七牛云存储的时候才有效','CS_TEXTDOMAIN'),
        ),

        array(
            'type'    => 'subheading',
            'content' => __('图片设置','CS_TEXTDOMAIN'),
        ), 

        array(
            'id'       => 'interlace',
            'type'     => 'switcher',
            'title'    => __('渐进显示','CS_TEXTDOMAIN'),
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('是否JPEG格式图片渐进显示','CS_TEXTDOMAIN').'</span>',
            'default'  => false,
            'settings' => array(
              'on_text'  => __('是','CS_TEXTDOMAIN'),
              'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'         => 'quality',
            'type'       => 'number',
            'title'      => __('图片质量','CS_TEXTDOMAIN'),
            'default'    => '75',
            'after'      => '<span class="cs-text-muted">'.__('1-100之间图片质量，七牛默认为75','CS_TEXTDOMAIN').'</span>',
            'attributes' => array(
              'style' => 'width: 50px;margin-right: 5px;'
            ), 
        ),

        array(
            'type'    => 'subheading',
            'content' => __('水印设置','CS_TEXTDOMAIN'),
        ), 
  
        array(
            'id'         => 'watermark',
            'type'       => 'upload',
            'title'      => __('水印图片','CS_TEXTDOMAIN'),
            'attributes' => array(
                'placeholder' => 'http://'
            ),
            'settings'      => array(
                'upload_type'  => 'image',
                'button_title' => __('上传','CS_TEXTDOMAIN'),
                'frame_title'  => __('选择图像','CS_TEXTDOMAIN'),
                'insert_title' => __('使用图像','CS_TEXTDOMAIN'),
            ),
        ), 
  
        array(
            'id'         => 'opacity',
            'type'       => 'number',
            'title'      => __('透明度','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted"> '.__('透明度，取值范围1-100，缺省值为100（完全不透明）','CS_TEXTDOMAIN').'</span>',
            'default'    => '100',
            'attributes' => array(
                'style' => 'width: 50px;margin-right: 5px;',
            ) 
        ), 
  
        array(
            'id'      => 'position',
            'type'    => 'select',
            'title'   => __('水印位置','CS_TEXTDOMAIN'),
            'options' => array(
                'SouthEast' => '右下角',
                'SouthWest' => '左下角',
                'NorthEast' => '右上角',
                'NorthWest' => '左上角',
                'Center'    => '正中间',
                'West'      => '左中间',
                'East'      => '右中间',
                'North'     => '上中间',
                'South'     => '下中间',
            ),
            'default' => 'SouthEast',
        ),
  
        array(
            'id'         => 'dx',
            'type'       => 'number',
            'title'      => __('横轴边距','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted"> '.__('横轴边距，单位:像素(px)，缺省值为10','CS_TEXTDOMAIN').'</span>',
            'default'    => '10',
            'attributes' => array(
                'style' => 'width: 50px;margin-right: 5px;',
            ) 
        ), 
  
        array(
            'id'         => 'dy',
            'type'       => 'number',
            'title'      => __('纵轴边距','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted"> '.__('纵轴边距，单位:像素(px)，缺省值为10','CS_TEXTDOMAIN').'</span>',
            'default'    => '10',
            'attributes' => array(
                'style' => 'width: 50px;margin-right: 5px;',
            ) 
        )
  )
);