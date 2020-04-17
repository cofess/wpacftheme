<?php

/**
 * WordPress 禁止多个人同时登录一个账号
 * http://www.wpdaxue.com/prevent-concurrent-logins.html
 */
return function($value) 
{
    function pcl_user_has_concurrent_sessions() {
        return ( is_user_logged_in() && count( wp_get_all_sessions() ) > 1 );
    }
    
    /**
     * Get the user's current session array
     *
     * @return array
     */
    function pcl_get_current_session() {
        $sessions = WP_Session_Tokens::get_instance( get_current_user_id() );
    
        return $sessions->get( wp_get_session_token() );
    }
    
    /**
     * Only allow one session per user
     * @action init
     *
     * @return void
     */
    function pcl_disallow_account_sharing() {
        if ( ! pcl_user_has_concurrent_sessions() ) {
            return;
        }
    
        $newest  = max( wp_list_pluck( wp_get_all_sessions(), 'login' ) );
        $session = pcl_get_current_session();
    
        if ( $session['login'] === $newest ) {
            wp_destroy_other_sessions();
        } else {
            wp_destroy_current_session();
        }
    }
	add_action( 'init', 'pcl_disallow_account_sharing' );
};