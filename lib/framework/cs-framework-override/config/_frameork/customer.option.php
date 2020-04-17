<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 在线客服                      
// ------------------------------
$options[]   = array(
  'name'   => 'theme-customer_section',
  'title'  => '客服',
  'icon'   => 'fa fa-users',
  'fields' => array(

    array(
      'id'    => 'enable_onlineService',
      'type'  => 'switcher',
      'title' => '是否启用在线客服',
    ), 

    array(
      'id'      => 'enable_onlineService_mobile',
      'type'    => 'switcher',
      'title'   => '移动端是否显示客服',
      'default' => false,
    ),  

    array(
      'id'      => 'enable_onlineService_ec',
      'type'    => 'switcher',
      'title'   => '腾讯EC营客通 <a href="http://ec.qq.com/" target="_blank" style="outline:none;border:none" onFocus="this.blur()" title="打开营客通官网"><i class="cs-icon fa fa-external-link"></i></a>',
      'default' => false,
      'label'   => '<span class="cs-text-warning">需要额外引入JS</span>',
    ),      
    
    array(
      'id'         => 'onlineService_ec_js',
      'type'       => 'textarea',
      'title'      => '腾讯EC营客通JS代码',
      'sanitize'   => false,
      'dependency' => array( 'enable_onlineService_ec', '==', 'true' ),
    ), 
    
    array(
      'id'         => 'onlineService_ec_css',
      'type'       => 'textarea',
      'title'      => '腾讯EC营客通自定义样式',
      'sanitize'   => false,
      'dependency' => array( 'enable_onlineService_ec', '==', 'true' ),
    ),      

    array(
      'id'         => 'enable_onlineService_ec_skin',
      'type'       => 'switcher',
      'title'      => '隐藏腾讯EC营客通默认样式',
      'default'    => false,
      'dependency' => array( 'enable_onlineService_ec', '==', 'true' ),
    ),      

    array(
      'id'      => 'enable_onlineService_name',
      'type'    => 'switcher',
      'title'   => '是否显示客服名称',
      'default' => true,
    ),
    
    array(
      'id'    => 'onlineService_otherInfo',
      'type'  => 'wysiwyg',
      'title' => '其他信息',
      'after' => '<p class="cs-text-warning">支持HTML语言，可加入第三方代码</p>',
    ),

    array(
      'id'              => 'onlineService',
      'type'            => 'group',
      'title'           => '在线客服',
      'button_title'    => '添加客服',
      'accordion_title' => '客服',
      'fields'          => array(

        array(
          'id'    => 'onlineService_name',
          'type'  => 'text',
          'title' => '客服名称',
        ),

        array(
          'id'    => 'onlineService_description',
          'type'  => 'textarea',
          'title' => '客服简介',
        ),

        array(
          'id'      => 'onlineService_type',
          'type'    => 'radio',
          'title'   => '客服类型',
          'class'   => 'horizontal',
          'options' => array(
            '1' => '售前客服',
            '2' => '售后客服',
            '3' => '技术支持',
          ),
          'default' => '1',
        ),  

        array(
          'id'      => 'enable_onlineService_show',
          'type'    => 'switcher',
          'title'   => '是否在前端显示',
          'default' => true
        ),      
      
        array(
          'id'         => 'onlineService_thumb',
          'type'       => 'upload',
          'title'      => '客服大头贴（正方形图片）',
          'attributes' => array(
            'placeholder' => 'http://'
          ),
          'settings'      => array(
            'upload_type'  => 'image',
            'button_title' => '上传',
            'frame_title'  => '选择图像',
            'insert_title' => '使用图像',
          ),        
          'default' => get_template_directory_uri()."/assets/images/avatar/avatar.png",
        ),

        array(
          'id'    => 'onlineService_mobileNum',
          'type'  => 'text',
          'title' => '手机号',
        ),

        array(
          'id'    => 'onlineService_telNum',
          'type'  => 'text',
          'title' => '座机号',
        ),
      
        array(
          'id'    => 'onlineService_qq',
          'type'  => 'text',
          'title' => 'QQ账号',
        ),  

        array(
          'id'    => 'onlineService_skype',
          'type'  => 'text',
          'title' => 'Skype账号',
        ),

        array(
          'id'    => 'onlineService_ec',
          'type'  => 'text',
          'title' => '腾讯EC营客通账号',
        ),      

      ),
    ),    

  )
);