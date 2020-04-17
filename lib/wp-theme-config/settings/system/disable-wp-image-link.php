<?php

/**
 * 关闭WordPress的图片默认链接功能
 * http://www.kuqin.com/shuoit/20131118/336381.html
 * http://www.wpdaxue.com/images-auto-link-post.html
 * http://www.wpdaxue.com/image-default-size-align-link-type.html
*/
return function($value) 
{
    add_action( 'after_setup_theme',function(){
        if ($value){
            update_option('image_default_link_type', 'none');
        } else {
            update_option('image_default_link_type', 'file');
        }
    });
};
