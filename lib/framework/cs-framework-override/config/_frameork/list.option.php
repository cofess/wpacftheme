<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 列表                       
// ------------------------------
$options[]   = array(
  'name'   => 'theme-lists_section',
  'title'  => __('列表','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-th-list',
  'fields' => array(

    array(
      'type'    => 'subheading',
      'content' => __('搜索列表','CS_TEXTDOMAIN'),
    ),
    
    array(
      'id'      => 'search_region',
      'type'    => 'radio',
      'title'   => __('搜索列表样式','CS_TEXTDOMAIN'),
      'options' => array(
        'list1' => __('输出小图、标准、特色三种文章形式，瀑布流列表','CS_TEXTDOMAIN'),
        'list2' => __('第1和7篇文章自动为大图模式，其他为特色或标准样式（小图同为标准样式）','CS_TEXTDOMAIN'),
        'list3' => __('同上，增加侧边栏','CS_TEXTDOMAIN'),
        'list4' => __('大图列表（单一样式）','CS_TEXTDOMAIN'),
      ),
      'default' => 'list1',
      'desc'    => __('选择搜索列表样式','CS_TEXTDOMAIN'),
    ),
    
    array(
      'type'    => 'subheading',
      'content' => __('作者列表','CS_TEXTDOMAIN'),
    ),
    
    array(
      'id'      => 'author_region',
      'type'    => 'radio',
      'title'   => __('作者列表样式','CS_TEXTDOMAIN'),
      'options' => array(
        'list1' => __('输出小图、标准、特色三种文章形式，瀑布流列表','CS_TEXTDOMAIN'),
        'list2' => __('第1和7篇文章自动为大图模式，其他为特色或标准样式（小图同为标准样式）','CS_TEXTDOMAIN'),
        'list3' => __('同上，增加侧边栏','CS_TEXTDOMAIN'),
        'list4' => __('大图列表（单一样式）','CS_TEXTDOMAIN'),
      ),
      'default' => 'list1',
      'desc'    => __('选择作者列表样式','CS_TEXTDOMAIN'),
    ),
    
    array(
      'type'    => 'subheading',
      'content' => __('标签列表','CS_TEXTDOMAIN'),
    ),
    
    array(
      'id'      => 'tag_region',
      'type'    => 'radio',
      'title'   => __('标签列表样式','CS_TEXTDOMAIN'),
      'options' => array(
        'list1' => __('输出小图、标准、特色三种文章形式，瀑布流列表','CS_TEXTDOMAIN'),
        'list2' => __('第1和7篇文章自动为大图模式，其他为特色或标准样式（小图同为标准样式）','CS_TEXTDOMAIN'),
        'list3' => __('同上，增加侧边栏','CS_TEXTDOMAIN'),
        'list4' => __('大图列表（单一样式）','CS_TEXTDOMAIN'),
      ),
      'default' => 'list1',
      'desc'    => __('选择标签列表样式','CS_TEXTDOMAIN'),
    ),
  
    array(
      'type'    => 'subheading',
      'content' => __('置顶文章','CS_TEXTDOMAIN'),
    ),
  
    array(
      'id'      => 'enable_stickPost',
      'type'    => 'switcher',
      'title'   => __('推荐置顶文章','CS_TEXTDOMAIN'),
      'default' => false,
    ),  
    
    array(
      'id'      => 'stickPost_num',
      'type'    => 'number',
      'title'   => __('置顶文章展示','CS_TEXTDOMAIN'),
      'after'   => '<span class="cs-text-muted">(条)</span>',
      'default' => '4',
      //'validate' => 'numeric',
      'dependency' => array( 'enable_stickPost', '==', 'true' ),
    ),  
  
    array(
      'id'         => 'stickPost_thumb',
      'type'       => 'upload',
      'title'      => __('置顶文章默认缩略图','CS_TEXTDOMAIN'),
      'default'    => get_template_directory_uri()."/assets/images/stickPost_thumb.png",
      'attributes' => array(
        'placeholder' => 'http://'
      ),
      'settings'      => array(
        'upload_type'  => 'image',
        'button_title' => __('上传','CS_TEXTDOMAIN'),
        'frame_title'  => __('选择图像','CS_TEXTDOMAIN'),
        'insert_title' => __('使用图像','CS_TEXTDOMAIN'),
      ),
      'dependency' => array( 'enable_stickPost', '==', 'true' ),
    ),  
  
    array(
      'type'    => 'subheading',
      'content' => __('阅读更多设置','CS_TEXTDOMAIN'),
    ),  
  
    array(
      'id'      => 'enable_post_readMore',
      'type'    => 'switcher',
      'title'   => __('自定义阅读更多','CS_TEXTDOMAIN'),
      'default' => true,
    ), 
  
    array(
      'id'      => 'enable_post_filterHtml',
      'type'    => 'switcher',
      'title'   => __('不过滤html标签','CS_TEXTDOMAIN'),
      'default' => false,
      'help'    => __('支持中英文并且不过滤html标签，但对html标签支持不好，截取时会把标签截断而导致显示不全，所以建议配合文章的more标签一起使用','CS_TEXTDOMAIN'),
    ),  
    
    array(
      'id'         => 'post_excerptLength',
      'type'       => 'number',
      'title'      => __('自定义文章摘要长度','CS_TEXTDOMAIN'),
      'after'      => '<span class="cs-text-muted">'.__('字','CS_TEXTDOMAIN').'</span>',
      'default'    => '80',
      'attributes' => array(
        'style' => 'width: 50px;margin-right: 5px;'
      ), 
    ), 
  
  )
);