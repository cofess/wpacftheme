<?php

/**
 * 移除 WordPress 菜单输出的多余的CSS选择器id或class
 * 来自 http://www.wpdaxue.com/remove-wordpress-nav-classes.html
 */
return function($value) 
{
	function optimizer_css_attributes_filter($var) {
		return is_array($var) ? array_intersect($var, array('current-menu-item','current-post-ancestor','current-menu-ancestor','current-menu-parent')) : '';
    }
    add_filter('nav_menu_css_class', 'optimizer_css_attributes_filter', 100, 1);
	add_filter('nav_menu_item_id', 'optimizer_css_attributes_filter', 100, 1);
	add_filter('page_css_class', 'optimizer_css_attributes_filter', 100, 1);
};
