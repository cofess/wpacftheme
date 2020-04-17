<?php

/**
 * 登录页面自定义底部信息
 * http://www.wpdaxue.com/custom-wordpress-login-page.html
 */
return function($value) 
{
    if ( ! $value) return;

    add_action( 'login_footer', function() use( $value ){
        echo '<footer class="footer"><div class="bottom">'.$value.'</div></footer>';
    } );
};