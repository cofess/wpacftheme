<?php

namespace Lib\Core;

class Menu{
  
  public static function renameItem($oldName, $newName) {
    add_action('admin_menu', function() use($oldName, $newName){
      global $menu;
      foreach($menu as &$menuItem){
        if($menuItem[0] === $oldName){
          $menuItem[0] = $newName;
          break;
        }
      }
    });
  }

  public static function removeItem($name){
    add_action( 'admin_menu', function() use($name){
      global $menu;
      $menu = array_filter($menu, function($e) use($name){
        return substr($e[0], 0, strlen($name)) !== $name;
      });
    });
  }
  
  public static function parentFromCurrentMenuItem($menuId, $postId=null) {
    $currentMenuItem = self::currentMenuItem($menuId, $postId);
    if($currentMenuItem === null || !$currentMenuItem->menu_item_parent)
      return null;

    $menuItems = wp_get_nav_menu_items($menuId, [
       'posts_per_page' => -1,
       'page_id' => $currentMenuItem->menu_item_parent
    ]);

    return isset($menuItems[0]) ? $menuItems[0] : null;
  }

  public static function currentMenuItem($menuId, $postId=null) {
    global $post;
    if($postId === null)
      $postId = $post->ID;

    $menuItems = wp_get_nav_menu_items($menuId, [
       'posts_per_page' => -1,
       'meta_key' => '_menu_item_object_id',
       'meta_value' => $postId
    ]);

    if(!isset($menuItems[0]) )
      return null;

    // return child, if parent is also it self
    foreach($menuItems as $menuItem)
      if($menuItem->menu_item_parent)
        return $menuItem;

    return $menuItems[0];
  }
}
