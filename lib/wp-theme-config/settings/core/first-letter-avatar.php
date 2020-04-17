<?php

return function ($value)
{
    // get user name
    function get_user_name($user){
        $user_name = $user->user_firstname;
        if(empty($user_name)){
            $user_name = $user->display_name;
        }
        if(empty($user_name)){
            $user_name = $user->user_login;
        }
        return $user_name;
    }
    /**
     * Description
     * @param type $id_or_email 
     * @since 2.1
     * @return type
     */
    function process_user_identifier($id_or_email){
        if ( is_numeric( $id_or_email ) ) :
            $user = get_user_by( 'id', absint( $id_or_email ) );
            $email = get_userdata($user->ID)->user_email;
            $user_name = get_user_name($user);
        elseif ( is_string( $id_or_email ) ) :
            if ( strpos( $id_or_email, '@md5.gravatar.com' ) ) :
                // md5 hash
                list( $email_hash ) = explode( '@', $id_or_email );
                return false;
            else :
                $email = $id_or_email;
                $user = get_user_by( 'email', $email );
                $user_name = get_user_name($user);
            endif;
        elseif ( $id_or_email instanceof WP_User ) :
            $user = $id_or_email;
            $email = get_userdata($user->ID)->user_email;
            $user_name = get_user_name($user);
        elseif ( $id_or_email instanceof WP_Post ) :
            $user = get_user_by( 'id', (int) $id_or_email->post_author );
            $email = get_userdata($user->ID)->user_email;
            $user_name = get_user_name($user);
        elseif ( $id_or_email instanceof WP_Comment ) :
            if ( ! empty( $id_or_email->user_id ) ) :
                $user = get_user_by( 'id', (int) $id_or_email->user_id );
                $email = get_userdata($user->ID)->user_email;
                $user_name = get_user_name($user);
            else :
                $user = $email = $user_name = false;
            endif;
            if ( ( ! $user || is_wp_error( $user ) ) && ! empty( $id_or_email->comment_author_email ) ) :
                $email = $id_or_email->comment_author_email;
                $user_name = $id_or_email->comment_author;
            endif;
        endif;
        return array('email'=>$email,'name'=>$user_name);
    }

    /**
     * 用户默认头像
     * https://phppot.com/wordpress/how-to-add-avatar-defaults-in-wordpress/
     */
    add_filter( 'avatar_defaults', 'custom_default_avatar' );
    function custom_default_avatar($avatar_defaults) {
        $avatar_defaults['letter'] = __('首字（主题生成）','CS_TEXTDOMAIN');
        return $avatar_defaults;
    }
    
    // add_filter('get_avatar', 'get_first_letter_avatar', 1);
    function get_first_letter_avatar($avatar){
        $avatar_src = Lib\Util\Tool::get_avatar_src($avatar);
        $params = Lib\Util\Tool::get_url_params($avatar_src);
        if($params['d'] == 'letter'){
            // $tmp = strpos($avatar, 'http');
            // $g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
            // $avatar = strtr($avatar, array($g => make_letter_avatar(Lib\Core\User::get_name(), $params['s'])));
            $avatar = preg_replace("/src='([^']*)'/", "src='".make_letter_avatar(Lib\Core\User::get_name(), $params['s'])."'", $avatar);
            $avatar = preg_replace("/srcset='([^']*)'/", "srcset='".make_letter_avatar(Lib\Core\User::get_name(), $params['s'])."'", $avatar);
        }
        return $avatar;
    }

    
    function get_first_letter_avatar_url($url, $id_or_email, $args){
        $params = Lib\Util\Tool::get_url_params($url);
        $custom_avatar = null;
        if($params['d'] == 'letter'){
            $custom_avatar = make_letter_avatar('First Letter Avatar', $args['size']);
            if(get_option('avatar_default') == 'letter'){
                $result = process_user_identifier($id_or_email);
                if($result){
                    $custom_avatar = make_letter_avatar($result['name'], $args['size']);
                }
            }
        }
        if ($custom_avatar) {
            return $custom_avatar;
        }
        return str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cn.gravatar.com", $url);
    }

    add_filter('get_avatar_url', 'get_first_letter_avatar_url', 10, 3);
};