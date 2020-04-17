<?php

/**
 * 文章状态
 * 
 * https://github.com/jenwachter/wp-custom-post-status
 * https://codex.wordpress.org/Function_Reference/register_post_status
 * https://phppot.com/wordpress/creating-custom-post-status-in-wordpress/
 * https://rudrastyh.com/wordpress/custom-post-status-quick-edit.html
 * https://www.wpdaxue.com/add-custom-post-status-for-posts-in-wordpress.html
 * 
 */

return function ($option)
{
    global $post_statuses;
    $post_statuses = $option;

    // Register Custom Post Status
    add_action( 'init', function() use($post_statuses){
        foreach ($post_statuses as $post_status) {
            register_post_status( $post_status['status'], $post_status['args'] );
        }
    } );

    // 通过js添加新的状态到文章编辑页面
    function display_custom_post_status_option(){
        global $post,$post_statuses;
        $select_option = '';
        $label = '';
        foreach ($post_statuses as $post_status) {
            if($post->post_type == 'post'){
                $status = $post_status['status'];
                $status_label = $post_status['args']['label'];

                $selected = '';
                if($post->post_status == $status){
                    $selected = 'selected';
                }
                $select_option .= '<option value=\"'.$status.'\" '.$selected.'>'.$status_label.'</option>';
                $label .= '<span id=\"post-status-display\"> '.$status_label.'</span>';
            }
        }
        $html = '$(document).ready(function(){
            $("select#post_status").append("'.$select_option.'");
            $(".misc-pub-section label").append("'.$label.'");
        });';
        echo '<script>'.$html.'</script>';  
    }

    add_action('admin_footer-post.php', 'display_custom_post_status_option');
    add_action('admin_footer-post-new.php', 'display_custom_post_status_option');
     
    // 通过js添加新的状态到文章列表的快速编辑
    add_action('admin_footer-edit.php',function() use($post_statuses){
        $select_option = '';
        foreach ($post_statuses as $post_status) {
            $status = $post_status['status'];
            $status_label = $post_status['args']['label'];

            $select_option .= '<option value=\"'.$status.'\">'.$status_label.'</option>';
        }
        $html = '';
        $html .= 'jQuery(document).ready( function($) {$( "select[name=\'_status\']" ).append( "'.$select_option.'" );})';
        echo '<script>'.$html.'</script>';
    } );
};