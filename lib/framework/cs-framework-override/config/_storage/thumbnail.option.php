<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 缩略图设置               
// ------------------------------
$options[]   = array(
    'name'  => 'storage-thumbnail_section',
    'title' => __('缩略图','CS_TEXTDOMAIN'),
    'icon'  => 'fa fa-crop',
    // begin: fields
    'fields'    => array(

        array(
            'type'    => 'subheading',
            'content' => '<h3>'.__('缩略图设置','CS_TEXTDOMAIN').'</h3>
                        <p>'.__('启动高级缩略图功能之后,文章获取缩略图的顺序为：特色图片 > 标签缩略图 > 第一张图片 > 分类缩略图 > 默认缩略图','CS_TEXTDOMAIN').'</p>',
        ),

        array(
            'id'      => 'enable_thumb_advanced',
            'type'    => 'switcher',
            'title'   => __('高级缩略图','CS_TEXTDOMAIN'),
            'default' => false,
        ),

        array(
            'id'       => 'thumb_default',
            'type'     => 'upload',
            'title'    => __('默认缩略图','CS_TEXTDOMAIN'),
            'help'     => __('如果日志没有特色图片，没有第一张图片，也没用高级缩略图的情况下所用的缩略图。可以填本地或者七牛的地址！','CS_TEXTDOMAIN'),
            'settings' => array(
                'upload_type'  => 'image',
                'button_title' => __('上传','CS_TEXTDOMAIN'),
                'frame_title'  => __('选择图像','CS_TEXTDOMAIN'),
                'insert_title' => __('使用图像','CS_TEXTDOMAIN'),
            ),
            'attributes' => array(
                'placeholder' => get_template_directory_uri().'/lib/images/cover/placeholder.jpg'
            ),
        ), 

        array(
            'id'         => 'thumb_max_width',
            'type'       => 'number',
            'title'      => __('图片最大宽度','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted">'.__('px','CS_TEXTDOMAIN').'</span>',
            'help'       => __('设置博客文章内容中图片的最大宽度，插件会使用将图片缩放到对应宽度，节约流量和加快网站速度加载。','CS_TEXTDOMAIN'),
            'default'    => '600',
            'attributes' => array(
                'style' => 'width: 50px;margin-right: 5px;'
            ),
        ), 
  
        array(
            'type'    => 'subheading',
            'content' => '<h3>'.__('图片缩略图','CS_TEXTDOMAIN').'</h3><p>'.__('该主题使用 <a href="http://www.cmhello.com/timthumb.html" target="_blank" style="outline:none;border:none" onFocus="this.blur()">TimThumb</a> 来生成缩略图，请确保当前主题的根目录可写（755权限）。如果你使用的是外链图库，请在当前主题根目录下的 timthumb-config.php 添加图库的域名。使用timthumb.php程序进行裁剪，不需要通过wordpress自带的缩略图功能来裁剪，所以在后台——设置——多媒休中把图像的大小全部设置为0。','CS_TEXTDOMAIN').'</p>',
        ),  
    
        array(
            'id'      => 'enable_timthumb',
            'type'    => 'switcher',
            'title'   => __('TimThumb 截图','CS_TEXTDOMAIN'),
            'default' => true,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('建议开启','CS_TEXTDOMAIN').'</span>',
        ),

        array(
            'id'    => 'thumb_mode',
            'type'  => 'radio',
            'title' => __('生成方式','CS_TEXTDOMAIN'),
            //'class'   => 'horizontal',
            'options' => array(
                '1' => __('缩放，缩放到固定高度和宽度（不裁剪，会变形）','CS_TEXTDOMAIN'),
                '2' => __('裁剪，等比例缩小（适应最小边，裁剪大边，不变形）','CS_TEXTDOMAIN'),
                '3' => __('留白，等比例缩小（适应最大边，小边补白，不变形）','CS_TEXTDOMAIN'),
            ),
            'default' => '3',
        ),
    
        array(
            'id'         => 'thumb_quality',
            'type'       => 'number',
            'title'      => __('缩略图质量','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted"> '.__('%，会影响图片清晰度','CS_TEXTDOMAIN').'</span>',
            'default'    => '80',
            'attributes' => array(
                'style' => 'width: 50px;margin-right: 5px;',
            ) 
        ),
  
        array(
            'type'    => 'subheading',
            'content' => '<h3>'.__('Lightbox设置','CS_TEXTDOMAIN').'</h3>
                <p>'.__('图片弹窗：编辑文章插入图片时，从URL插入（外链）必须选择链接到：图像URL；本地上传，必须选择链接到：媒体文件，在a标签中需要添加“title=图片名称”，不然在前台图片弹窗中不会显示名称。','CS_TEXTDOMAIN').'</p>
                <p>'.__('视频弹窗：视频地址需要绝对地址（例如http://player.youku.com/player.php/sid/XMzMxNjY5MzI0/v.swf），需要在a标签中手动添加：class="lightbox"','CS_TEXTDOMAIN').'</p>
                <p>'.__('内容（网址）弹窗：可以为文本、图片等添加链接，链接地址为需要显示的网址（例如https://www.baidu.com/），需要在a标签中手动添加：class="lightbox"','CS_TEXTDOMAIN').'</p>',
        ),  
  
        array(
            'id'      => 'enable_media_lightbox',
            'type'    => 'switcher',
            'title'   => __('图片、视频、内容（网址）弹窗Lightbox效果','CS_TEXTDOMAIN'),
            'default' => true,
        ),    
  
        array(
            'type'    => 'subheading',
            'content' => __('图片延迟加载','CS_TEXTDOMAIN'),
        ),  
  
        array(
            'id'      => 'enable_imageLazyload',
            'type'    => 'switcher',
            'title'   => __('图片延迟加载Lazyload','CS_TEXTDOMAIN'),
            'default' => true,
        ),    
    
    ),
);