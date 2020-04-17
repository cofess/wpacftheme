<?php

/**
 * 作者存档链接中的用户名改为昵称或ID
 * 参考：https://boke112.com/3624.html
 */ 
return function($value)
{
    if($value == 'nickname'){
        /**
         * 将 WordPress 作者存档链接中的用户名改为用户昵称（完美版） - 龙笑天下
         * http://www.ilxtx.com/use-user-nickname-or-id-for-author-slug.html
         * 20170527：修复原 wordpress 大学版本的中文昵称 404 问题
        */
        //使用昵称替换用户名，通过用户 ID 进行查询
        add_filter( 'request', 'author_link_request_by_nickname' );
        function author_link_request_by_nickname( $query_vars )
        {
            if ( array_key_exists( 'author_name', $query_vars ) ) {
                global $wpdb;
                $author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='nickname' AND meta_value = %s", urldecode( $query_vars['author_name'] ) ) );
                if ( $author_id ) {
                    $query_vars['author'] = $author_id;
                    unset( $query_vars['author_name'] );
                }
            }
            return $query_vars;
        }
        //使用昵称替换链接中的用户名
        add_filter( 'author_link', 'use_nickname_replace_author', 10, 3 );
        function use_nickname_replace_author( $link, $author_id, $author_nicename )
        {
            $author_nickname = get_user_meta( $author_id, 'nickname', true );
            if ( $author_nickname ) {
                $link = str_replace( $author_nicename, $author_nickname, $link );
            }
            return $link;
        }
    }

    if($value == 'id'){
        /**
         * 替换作者的存档页的用户名，防止被其他用途
         * 作者存档页链接有 2 个查询变量，
         * 一个是 author（作者用户 id），用于未 url 重写
         * 另一个是 author_name（作者用户名），用于 url 重写
         * 此处做的是，在 url 重写之后，把 author_name 替换为 author
         * @version 1.0
         * @since yundanran-3 beta 2
         * 2013 年 10 月 8 日 23:19:13
         * @link http://www.wpdaxue.com/use-nickname-for-author-slug.html
         */
        add_filter( 'request', 'author_link_request_by_id' );
        function author_link_request_by_id( $query_vars ) {
            if ( array_key_exists( 'author_name', $query_vars ) ) {
                global $wpdb;
                $author_id=$query_vars['author_name'];
                if ( $author_id ) {
                    $query_vars['author'] = $author_id;
                    unset( $query_vars['author_name'] );
                }
            }
            return $query_vars;
        }

        /**
         * 将 WordPress 作者存档链接中的用户名改为用户 ID - 龙笑天下
         * http://www.ilxtx.com/use-user-nickname-or-id-for-author-slug.html
         * 修改 url 重写后的作者存档页的链接变量
         * @since yundanran-3 beta 2
         * 2013 年 10 月 8 日 23:23:49
         */
        add_filter( 'author_link', 'use_id_replace_author', 10, 2 );
        function use_id_replace_author( $link, $author_id) {
            global $wp_rewrite;
            $author_id = (int) $author_id;
            $link = $wp_rewrite->get_author_permastruct();
            if ( empty($link) ) {
                $file = home_url( '/' );
                $link = $file . '?author=' . $author_id;
            } else {
                $link = str_replace('%author%', $author_id, $link);
                $link = home_url( user_trailingslashit( $link ) );
            }
            return $link;
        }
    } 
};
