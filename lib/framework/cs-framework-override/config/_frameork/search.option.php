<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 搜索设置               
// ------------------------------
$options[]   = array(
  'name'   => 'theme-search_section',
  'title'  => __('搜索','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-search',
  'fields' => array(

    array(
      'id'      => 'search_mode',
      'type'    => 'radio',
      'title'   => __('搜索方式','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        '1' => __('仅标题','CS_TEXTDOMAIN'),
        '2' => __('标题+内容','CS_TEXTDOMAIN'),
        '3' => __('标题+内容+标签tag','CS_TEXTDOMAIN'),
      ),
      'default' => '1',
    ),    
  
    array(
      'id'      => 'enable_search_all_type',
      'type'    => 'switcher',
      'title'   => __('搜索结果包含自定义文章类型','CS_TEXTDOMAIN'),
      'default' => '1',
      'help'    => __('注：默认搜索结果不包含自定义文章类型的内容，开启则包含关键词的自定义文章类型的内容也将出现在搜索结果中','CS_TEXTDOMAIN'),
    ),

    array(
      'id'         => 'search_in_post_type',
      'type'       => 'checkbox',
      'title'      => __('Include in Search','CS_TEXTDOMAIN'),
      'class'      => 'horizontal',
      'options'    => 'post_type',
      'default'    => array( 'post' )
    ),
  
    array(
      'id'      => 'enable_search_keywords_highlight',
      'type'    => 'switcher',
      'default' => '1',
      'title'   => __('搜索结果关键字高亮显示','CS_TEXTDOMAIN'),
    ),
  
    array(
      'id'      => 'redirect-single-post',
      'type'    => 'switcher',
      'title'   => __('搜索结果只有一条记录时，自动跳转到该页','CS_TEXTDOMAIN'),
      'default' => '1',
      'help'    => __('注：如果返回的结果只有一篇文章，我们可以直接让它跳转到这篇文章，提高用户体验','CS_TEXTDOMAIN'),
    ),  
  
    array(
      'id'      => 'enable_search_result_match',
      'type'    => 'switcher',
      'title'   => __('提高搜索结果的相关性(准确度)','CS_TEXTDOMAIN'),
      'default' => '1',
      'help'    => __('注：默认搜索结果是按照发布时间排序的，这样的搜索结果相关性并不强，应该让搜索结果按照内容相关性排序','CS_TEXTDOMAIN'),
    ),
  
    array(
      'id'    => 'enable_search_exclude_allpage',
      'type'  => 'switcher',
      'title' => __('搜索结果排除所有页面','CS_TEXTDOMAIN'),
    ),  
    
    array(
      'id'    => 'search_exclude_id',
      'type'  => 'text',
      'title' => __('搜索结果中排除指定ID的页面或者文章','CS_TEXTDOMAIN'),
      'desc'  => __('输入页面或文章ID，多个用英文逗号隔开','CS_TEXTDOMAIN'),
    ),  
    
    array(
      'id'    => 'search_filter_cat',
      'type'  => 'text',
      'title' => __('搜索过滤','CS_TEXTDOMAIN'),
      'desc'  => __('输入分类ID，多个用英文逗号隔开','CS_TEXTDOMAIN'),
      'after' => '<span class="cs-text-warning">'.__('分类ID，前面加负号表示排除；如果直接写ID，则表示只在该ID中搜索','CS_TEXTDOMAIN').'</sp> ',
    )
  )
);