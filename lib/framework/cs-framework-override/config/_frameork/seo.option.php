<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// SEO优化                      
// ------------------------------
$options[]   = array(
  'name'   => 'theme-seo_section',
  'title'  => __('SEO','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-flag-checkered',
  'fields' => array(
  
    array(
      'type'    => 'subheading',
      'content' => __('基本设置','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'enable_seo',
      'type'    => 'switcher',
      'title'   => __('主题自带SEO设置','CS_TEXTDOMAIN'),
      'default' => 1,
      'after'   => '<span class="cs-text-warning" style="margin-left:5px;line-height:26px">'.__('关闭后，请自行安装SEO插件，以下设置均无效','CS_TEXTDOMAIN').'</span>',
    ),
    
    array(
      'id'         => 'seo_title_divider',
      'type'       => 'text',
      'title'      => __('标题连接符','CS_TEXTDOMAIN'),
      'default'    => '-',
      'after'      => '<span class="cs-text-warning">'.__('连接符:如果针对的是百度，分隔符可以选择_ |，针对谷歌的话，就选择 - , 及空格。一经选择，切勿更改，对SEO不友好','CS_TEXTDOMAIN').'</span>',
      'attributes' => array(
        'style' => 'width: 50px;margin-right: 5px;'
      ),      
    ),
    
    array(
      'id'      => 'enable_post_auto_description',
      'type'    => 'switcher',
      'title'   => __('自动获取文章内容作为文章description','CS_TEXTDOMAIN'),
      'default' => 1,
    ),

    array(
      'id'         => 'post_auto_description_length',
      'type'       => 'number',
      'title'      => __('自动截取字符长度','CS_TEXTDOMAIN'),
      'default'    => '80',
      'after'      => '<span class="cs-text-muted">'.__('字','CS_TEXTDOMAIN').'</span>',
      'dependency' => array( 'enable_post_auto_description', '==', 1 ),
      'attributes' => array(
        'style' => 'width: 50px;margin-right: 5px;'
      ), 
    ),
  
    array(
      'id'      => 'enable_post_auto_keywords',
      'type'    => 'switcher',
      'title'   => __('自动获取文章标签作为文章keyword','CS_TEXTDOMAIN'),
      'default' => 1,
    ),
  
    array(
      'type'    => 'subheading',
      'content' => __('首页设置','CS_TEXTDOMAIN'),
    ),  

    array(
      'id'      => 'seo_home_title_mode',
      'type'    => 'radio',
      'title'   => __('首页标题（title）','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        '1' => __('网站名称+副标题（默认）','CS_TEXTDOMAIN'),
        '2' => __('网站关键词+网站名称（推荐）','CS_TEXTDOMAIN'),
        '3' => __('自定义','CS_TEXTDOMAIN'),
      ),
      'default' => '1',
    ),    
    
    array(
      'id'         => 'seo_title',
      'type'       => 'text',
      'before'     => '<h4>'.__('标题（title）','CS_TEXTDOMAIN').'</h4>',
      'after'      => '<p class="cs-text-warning">'.__('说明：页面标题，一般不超过80个字符。','CS_TEXTDOMAIN').'</p>',
      'attributes' => array(
        'style'       => 'width: 100%;',
        'maxlength'   => 80,
        'placeholder' => __('网站标题','CS_TEXTDOMAIN'),
      ),
      'dependency' => array( 'seo_home_title_mode_3', '==', 'true' ),
    ),
    
    array(
      'id'         => 'seo_keywords',
      'type'       => 'text',
      'before'     => '<h4>'.__('关键词（KeyWords）','CS_TEXTDOMAIN').'</h4>',
      'after'      => '<span class="cs-text-warning">'.__('说明：页面关键词，一般不超过100个字符。多个关键词请用英文半角逗号","或英文半角竖线"|"隔开','CS_TEXTDOMAIN').'</span>',
      'attributes' => array(
        'style'       => 'width: 100%;',
        'placeholder' => __('网站关键词','CS_TEXTDOMAIN'),
      ),
    ), 
    
    array(
      'id'         => 'seo_description',
      'type'       => 'textarea',
      'before'     => '<h4>'.__('描述（Description）','CS_TEXTDOMAIN').'</h4>',
      'after'      => '<span class="cs-text-warning">'.__('说明：页面简短描述，一般不超过200个字符，可将公司的具体联系方式写入描述中，方便客户直接联系','CS_TEXTDOMAIN').'</sp>',
      'attributes' => array(
        'maxlength'   => 200,
        'placeholder' => __('网站描述','CS_TEXTDOMAIN'),
      ),
    ), 
  
    array(
      'type'    => 'subheading',
      'content' => __('内页设置','CS_TEXTDOMAIN'),
    ), 

    array(
      'id'      => 'seo_page_title_mode',
      'type'    => 'radio',
      'title'   => __('内页标题（title）','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        '1' => __('内容标题','CS_TEXTDOMAIN'),
        '2' => __('内容标题+关键词','CS_TEXTDOMAIN'),
        '3' => __('内容标题+网站名称(推荐)','CS_TEXTDOMAIN'),
        '4' => __('内容标题+关键词+网站名称','CS_TEXTDOMAIN'),
      ),
      'default' => '3',
      'after'   => '<div class="cs-text-warning">'.__('内页的标题(title)构成方式，您也可以在编辑/添加内容时自定义对应页面的SEO标题(title)，如果SEO标题为空则使用上面设置的title构成方式','CS_TEXTDOMAIN').'</div>',
    ),     
  
    array(
      'type'    => 'subheading',
      'content' => __('图片ALT和TITLE属性，SEO Friendly Images <a href="https://wordpress.org/plugins/seo-image/" target="_blank" style="outline:none;border:none" onFocus="this.blur()"><i class="cs-icon fa fa-external-link"></i></a>','CS_TEXTDOMAIN'),
    ),
    
    array(
      'type'    => 'content',
      'content' => '<div>'.__('自动更新图片的 ALT和TITLE属性，图片的ALT和TITLE属性对于搜索引擎优化来说是非常重要的','CS_TEXTDOMAIN').'</div>
            <p class = "cs-text-warning">'.__('您可以使用以下标签或者任何其他的文字：','CS_TEXTDOMAIN').'</p>
            <ul>
            <li>%site - '.__('替换网站名称','CS_TEXTDOMAIN').'</li>
            <li>%title - '.__('替换为文章标题','CS_TEXTDOMAIN').'</li>
            <li>%name - '.__('替换为图像的文件名（不带扩展名）','CS_TEXTDOMAIN').'</li>
            <li>%category - '.__('替换为文章分类目录','CS_TEXTDOMAIN').'</li>
            <li>%tag - '.__('替换为文章标签','CS_TEXTDOMAIN').'</li></ul>',
    ),

    array(
      'id'      => 'seo-friendly-images',
      'type'    => 'switcher',
      'title'   => __('图片SEO优化','CS_TEXTDOMAIN'),
      'default' => 1,
      'after'   => '<span class="cs-text-warning" style="margin-left:5px;line-height:26px">'.__('开启后将自动更新图像的alt和title属性','CS_TEXTDOMAIN').'</span>',
    ),
    
    array(
      'id'      => 'image_alt_text',
      'type'    => 'text',
      'title'   => __('图片alt属性','CS_TEXTDOMAIN'),
      'help'    => __('说明：图像不能正常显示（网速慢、图片链接错误）后显示的替换文本','CS_TEXTDOMAIN'),
      'default' => '%name %title',
    ),    
    
    array(
      'id'      => 'image_title_text',
      'type'    => 'text',
      'title'   => __('图片title属性','CS_TEXTDOMAIN'),
      'help'    => __('说明：鼠标移至图片显示的文字','CS_TEXTDOMAIN'),
      'default' => '%title',
    ),
  
    array(
      'id'    => 'enable_image_alt_override',
      'type'  => 'switcher',
      'title' => __('替换默认的图片alt属性','CS_TEXTDOMAIN'),
    ),  
  
    array(
      'id'    => 'enable_image_title_override',
      'type'  => 'switcher',
      'title' => __('替换默认的图片title属性','CS_TEXTDOMAIN'),
    ),    

    array(
      'id'      => 'enable_seo_image',
      'type'    => 'checkbox',
      'title'   => __('图片alt和title属性覆盖设置','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        'alt'   => __('替换默认的图片alt属性（推荐）','CS_TEXTDOMAIN'),
        'title' => __('替换默认的图片title属性','CS_TEXTDOMAIN'),
      ),
      'default' => array( 'alt'),
    ),  
  
    array(
      'type'    => 'subheading',
      'content' => __('高级设置','CS_TEXTDOMAIN'),
    ),  
  
    array(
      'id'      => 'enable_post_link_nofollow_external',
      'type'    => 'switcher',
      'title'   => __('文章站外链接自动添加nofollow属性和新窗口打开页面','CS_TEXTDOMAIN'),
      'default' => '1',
    ),
  
    array(
      'id'      => 'enable_comment_link_nofollow_external',
      'type'    => 'switcher',
      'title'   => __('评论站外链接自动添加nofollow属性和新窗口打开页面','CS_TEXTDOMAIN'),
      'default' => '1',
    ),    
  
    array(
      'id'    => 'enable_post_tag_link',
      'type'  => 'switcher',
      'title' => __('自动为文章tag添加链接','CS_TEXTDOMAIN'),
    ),  

    array(
      'id'         => 'post_tag_minNum',
      'type'       => 'number',
      'title'      => __('一个标签在文章中出现少于多少次不添加链接','CS_TEXTDOMAIN'),
      'default'    => '1',
      'after'      => ' <span class="cs-text-muted">'.__('次','CS_TEXTDOMAIN').'</span>',
      'dependency' => array( 'enable_post_tag_link', '==', 'true' ),
    ),

    array(
      'id'         => 'post_tag_linkNum',
      'type'       => 'number',
      'title'      => __('一篇文章中同一个标签添加几次链接','CS_TEXTDOMAIN'),
      'default'    => '1',
      'after'      => ' <span class="cs-text-muted">'.__('次','CS_TEXTDOMAIN').'</span>',
      'dependency' => array( 'enable_post_tag_link', '==', 'true' ),
    ),  
    
  )
);