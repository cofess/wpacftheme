<?php

namespace Lib\Core;

class Page {
  /**
   * 创建页面方法，用于插件或主题创建自定义页面
   * 
   * @author cofess | cofess@foxmail.com 
   * @param string $title 页面标题
   * @param string $slug 页面url
   * @param string $page_template 页面模版
   * @example create_page('取回密码','resetpass','user-resetpass.php');
   */
  public static function create_page($title, $slug, $page_template = '') {
    $allPages = get_pages();
    $exists = false;
    foreach($allPages as $page) {
      if (strtolower($page -> post_name) == strtolower($slug)) {
        $exists = true;
      } 
    } 
    if ($exists == false) {
      $new_page_id = wp_insert_post(
        array('post_title' => $title,
          'post_type' => 'page',
          'post_name' => $slug,
          'comment_status' => 'closed',
          'ping_status' => 'closed',
          'post_content' => '',
          'post_status' => 'publish',
          'post_author' => 1,
          'menu_order' => 0
          )
        );
      if ($new_page_id && $page_template != '') {
        update_post_meta($new_page_id, '_wp_page_template', $page_template);
      } 
    } 
  } 
} 
