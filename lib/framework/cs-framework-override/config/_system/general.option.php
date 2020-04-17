<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 常规设置                     
// ------------------------------
$options[]   = array(
    'name'     => 'system-general_section',
    'title'    => __('常规设置','CS_TEXTDOMAIN'),
    'icon'     => 'fa fa-cog',
    'fields'    => array(

        array(
            'type'    => 'subheading',
            'content' => __('优化加速','CS_TEXTDOMAIN'),
        ),  

        // array(
        //     'id'      => 'enable-gzip',
        //     'type'    => 'switcher',
        //     'title'   => __('Gzip压缩','CS_TEXTDOMAIN'),
        //     'label'   => __('网页启用Gzip压缩,提升网页加载速度','CS_TEXTDOMAIN'),
        //     'help'    => __('Gzip开启以后会将输出到用户浏览器的数据进行压缩的处理，这样就会减小通过网络传输的数据量，提高浏览的速度。','CS_TEXTDOMAIN'),
        //     'default' => false,
        //     'settings' => array(
        //         'on_text'  => __('是','CS_TEXTDOMAIN'),
        //         'off_text' => __('否','CS_TEXTDOMAIN'),
        //     ),
        // ),
  
        array(
            'id'       => 'enable-compress-html',
            'type'     => 'switcher',
            'title'    => __('Html压缩','CS_TEXTDOMAIN'),
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('压缩页面源代码,提升网页加载速度','CS_TEXTDOMAIN').'</span>',
            'default'  => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        // array(
        //     'id'       => 'disable-all-google-fonts',
        //     'type'     => 'switcher',
        //     'title'    => __('禁用google fonts','CS_TEXTDOMAIN'),
        //     'default'  => true,
        //     'settings' => array(
        //         'on_text'  => __('是','CS_TEXTDOMAIN'),
        //         'off_text' => __('否','CS_TEXTDOMAIN'),
        //     ),
        // ),
  
        array(
            'id'       => 'enable_replace_google_cdn',
            'type'     => 'switcher',
            'title'    => __('替换Google公共库为360公共库','CS_TEXTDOMAIN'),
            'default'  => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
  
        array(
            'id'      => 'google_fonts_lib',
            'type'    => 'select',
            'title'   => __('Google字体库','CS_TEXTDOMAIN'),
            'options' => array(
                '1' => __('禁用Google Open Sans字体','CS_TEXTDOMAIN'),
                '2' => __('替换为360镜像加载源','CS_TEXTDOMAIN'),
            ),
            'default'        => '1',
            'default_option' => __('请选择','CS_TEXTDOMAIN'),
        ),

        array(
            'id'       => 'disable-gravatar',
            'type'     => 'switcher',
            'title'    => __('禁用Gravatars','CS_TEXTDOMAIN'),
            'default'  => false,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
  
        array(
            'id'      => 'gravatar-server',
            'type'    => 'select',
            'title'   => __('Gravatar全球通用头像服务器','CS_TEXTDOMAIN'),
            'options' => array(
                '1' => __('使用https方式（SSL）调用头像','CS_TEXTDOMAIN'),
                '2' => __('Gravatar中国服务器，cn.gravatar.com','CS_TEXTDOMAIN'),
                '3' => __('自定义第三方Gravatar镜像服务器','CS_TEXTDOMAIN'),
                '4' => __('本地缓存头像（不推荐）','CS_TEXTDOMAIN'),
            ),
            'default'        => '1',
            'default_option' => __('请选择','CS_TEXTDOMAIN'),
        ),
  
        array(
            'id'         => 'custom-gravatar-server',
            'type'       => 'text',
            'title'      => __('自定义第三方Gravatar镜像服务器','CS_TEXTDOMAIN'),
            'dependency' => array( 'gravatar-server', '==', '3' ),
            'attributes' => array(
              'placeholder' => __('输入Gravatar镜像服务器地址','CS_TEXTDOMAIN'),
            )
        ),
  
        array(
            'type'       => 'content',
            'dependency' => array( 'gravatar-server', '==', '3' ),
            'content'    => __('<h3>国内第三方Gravatar镜像服务器列表</h3><ul><li>1、多说镜像服务器，gravatar.duoshuo.com</li><li>2、极客族镜像服务器，sdn.geekzu.org</li><li>3、七牛镜像服务器，gravatar2.u.qiniudn.com</li></ul>','CS_TEXTDOMAIN'),
        ),
  
        array(
            'id'         => 'gravatar-cache-days',
            'type'       => 'number',
            'title'      => __('Gravatar头像缓存天数','CS_TEXTDOMAIN'),
            'after'      => '<span class="cs-text-muted">'.__('天','CS_TEXTDOMAIN').'</span>',
            'default'    => '7',
            'dependency' => array( 'gravatar-server', '==', '4' ),
            'attributes' => array(
                'style' => 'width: 50px;margin-right: 5px;',
            ) 
        ),
  
        // array(
        //     'type'       => 'content',
        //     'content'    => __('<h3>Gravatar头像缓存说明</h3><ul><li>1、确保WordPress安装根目录有“avatar”文件夹（与wp-content等文件夹同一目录下）和default.png默认头像，并设置权限为777</li><li>2、缺点:只能缓存一个尺寸的头像，国内主机无法使用，如有报错等异常，可能你的主机不支持，请选择其他方式</li></ul>','CS_TEXTDOMAIN'),
        //     'dependency' => array( 'gravatar-server', '==', '4' ),
        // ),
  
        // array(
        //     'id'      => 'enable_jquery_cdn',
        //     'type'    => 'switcher',
        //     'title'   => __('自定义前台Jquery库','CS_TEXTDOMAIN'),
        //     'label'   => __('启用后将禁用wordpress自带Jquery库','CS_TEXTDOMAIN'),
        //     'default' => true,
        //     'settings' => array(
        //         'on_text'  => __('是','CS_TEXTDOMAIN'),
        //         'off_text' => __('否','CS_TEXTDOMAIN'),
        //     ),
        // ),
  
        // array(
        //     'id'     => 'jquery_cdn_url',
        //     'type'   => 'text',
        //     'title'  => __('Jquery 引用地址','CS_TEXTDOMAIN'),
        //     'after'  => '<p class="cs-text-muted">'.__('说明：百度、新浪、谷歌提供常用的JS库CDN加速服务，引用这些资源获取更快的访问速度','CS_TEXTDOMAIN').'</p>',
        //     'attributes'    => array(
        //       'placeholder' => __('输入Jquery引用地址','CS_TEXTDOMAIN'),
        //     ),
        //     'default' => get_template_directory_uri()."/lib/base/js/jquery.min.js",
        //     'dependency'    => array( 'enable_jquery_cdn', '==', 'true' ),
        // ),
  
        array(
            'id'       => 'footer-load-js',
            'type'     => 'switcher',
            'title'    => __('所有JS移到页面底部加载','CS_TEXTDOMAIN'),
            'default'  => false,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
          'type'    => 'subheading',
          'content' => __('开发调试','CS_TEXTDOMAIN'),
        ),  

        array(
          'id'      => 'performance-overview',
          'type'    => 'switcher',
          'title'   => __('页面查询次数、加载时间和内存占用','CS_TEXTDOMAIN'),
          'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('前台页面源代码中可查看当请页面查询次数、加载时间和内存占用','CS_TEXTDOMAIN').'</span>',
          'default' => true,
        ),

     ), // end: fields
);