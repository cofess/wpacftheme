<?php

/**
 * Remove the word "Wordpress" from title
 * 删除后台标题title中“wordpress”文字
 */
return function() 
{
    
    function remove_admin_title_wordpress($admin_title, $title) {
        return $title .' &lsaquo; '. get_bloginfo('name');
    }
    add_filter('admin_title', 'remove_admin_title_wordpress', 10, 2);
};