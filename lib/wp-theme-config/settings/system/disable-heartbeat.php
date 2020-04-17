<?php

/**
 * Disable Heartbeat
 */
return function($option) 
{
    add_action( 'init', function() use($option){
        if( $option == 'disable_everywhere' ) {
            wp_deregister_script('heartbeat');
        }
        elseif( $option == 'allow_posts' ) {
            global $pagenow;
            if($pagenow != 'post.php' && $pagenow != 'post-new.php') {
                wp_deregister_script('heartbeat');  
            }
        }
    }, 1 );
};
