<?php

/**
 * 自定义登录页面的LOGO
 * http://www.wpdaxue.com/custom-wordpress-login-page.html
 */
return function($mode) 
{
    $logo = $this->config['system.login-logo-image'];

    // Hide login logo
    function login_logo_hide() {
        echo '<style type="text/css">#login h1 a { display: none !important; }</style>';
    }

    if ( $mode == '1' && $logo != '') {
        add_action( 'login_head', function() use($logo){
            echo '<style type="text/css">
                h1 a { background-image:url('.$logo.') !important; }
            </style>';
        } );
    }

    if ( $mode == '2' ) {
        add_action('login_head', 'login_logo_hide');
    }
};