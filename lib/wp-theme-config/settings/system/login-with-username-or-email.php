<?php

/**
 * 让WordPress支持用户名或邮箱登录
 * http://www.wpdaxue.com/login-with-username-or-email-address.html
 */
return function($value) 
{
    function dr_email_login_authenticate( $user, $username, $password ) {
        if ( is_a( $user, 'WP_User' ) )
            return $user;
    
        if ( !empty( $username ) ) {
            $username = str_replace( '&', '&', stripslashes( $username ) );
            $user = get_user_by( 'email', $username );
            if ( isset( $user, $user->user_login, $user->user_status ) && 0 == (int) $user->user_status )
                $username = $user->user_login;
        }
    
        return wp_authenticate_username_password( null, $username, $password );
    }
    
    //替换“用户名”为“用户名 / 邮箱”
    function username_or_email_login() {
        if ( 'wp-login.php' != basename( $_SERVER['SCRIPT_NAME'] ) )
            return;
    
        ?><script type="text/javascript">
        // Form Label
        if ( document.getElementById('loginform') )
            document.getElementById('loginform').childNodes[1].childNodes[1].childNodes[0].nodeValue = '<?php echo esc_js( __( '用户名/邮箱', 'email-login' ) ); ?>';
    
        // Error Messages
        if ( document.getElementById('login_error') )
            document.getElementById('login_error').innerHTML = document.getElementById('login_error').innerHTML.replace( '<?php echo esc_js( __( '用户名' ) ); ?>', '<?php echo esc_js( __( '用户名/邮箱' , 'email-login' ) ); ?>' );
        </script><?php
    }

	remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
	add_filter( 'authenticate', 'dr_email_login_authenticate', 20, 3 );
	add_action( 'login_form', 'username_or_email_login' ); 
};