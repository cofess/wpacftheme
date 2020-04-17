<?php

/**
 * 在登录框添加额外的信息
 * http://www.wpdaxue.com/custom-wordpress-login-page.html
 */
return function($value) 
{
    if ( ! $value) return;

    add_action('login_form', function() use($value){
        echo '<p>'.$value.'</p><br/>';
    });
};