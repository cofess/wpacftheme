<?php

/**
 * WP前台顶部清理,删除 wp_head 中无关紧要的代码
 * 来自 http://www.wpdaxue.com/speed-up-wordpress.html
 * http://www.chnpanda.com/1032.html
 */
return function($links) 
{
    function remove_xfn_link(){
		return false;
    }
    
    if (!is_admin()) {      
        foreach( $links as $link ){
            if( $link == 'feed_links' ){
                remove_action( 'wp_head', 'feed_links', 2 );
            } elseif( $link == 'feed_links_extra' ){
                remove_action( 'wp_head', 'feed_links_extra', 3 );
            } elseif( $link == 'rsd_link' ){
                remove_action( 'wp_head', 'rsd_link' );
            } elseif( $link == 'wlwmanifest_link' ){
                remove_action( 'wp_head', 'wlwmanifest_link');
            } elseif( $link == 'index_rel_link' ){
                remove_action( 'wp_head', 'index_rel_link' );
            } elseif( $link == 'wp_shortlink_wp_head' ){
                remove_action( 'wp_head', 'wp_shortlink_wp_head' );
            } elseif( $link == 'wp_resource_hints' ){
                // remove dns-prefetch //s.w.org
                remove_action( 'wp_head', 'wp_resource_hints', 2 );
            } elseif( $link == 'xfn_link' ){
                add_filter('avf_profile_head_tag', 'remove_xfn_link');
            } else {
                remove_action( 'wp_head', $link, 10, 0 );
            } 
        }

        foreach(array('single_post_title','bloginfo','wp_title','category_description','list_cats','comment_author','comment_text','the_title','the_content','the_excerpt') as $where){
            remove_filter ($where, 'wptexturize');
        }
        /*remove_filter( 'the_content', 'wpautop' );
        remove_filter( 'the_excerpt', 'wpautop' );*/
        add_action('wp_enqueue_scripts', function(){
            wp_deregister_script( 'l10n' );
        });
        
    }
};