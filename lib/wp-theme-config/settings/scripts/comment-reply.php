<?php

/**
 * 系统自带嵌套评论js
 */
return function()
{
    function load_comment_reply_scripts() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'load_comment_reply_scripts' );
};
