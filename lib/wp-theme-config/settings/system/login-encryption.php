<?php

/**
 * 修改WordPress后台登录地址，提高安全性
 * http://www.wpdaxue.com/protected-wp-login.html
 */
return function() 
{
    $private_key = $this->config['system.login-private-Key'];
    $redirect_url = ($this->config['system.login-redirect-url'])? $this->config['system.login-redirect-url'] : site_url();
    
    if ( $private_key ) {  
        add_action( 'login_enqueue_scripts', function() use($private_key,$redirect_url){
            if($_GET['q'] != ''.$private_key.'')header('Location: '.$redirect_url.''); 
        } ); 
    } 
};