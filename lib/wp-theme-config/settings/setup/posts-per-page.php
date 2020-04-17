<?php
/*
 |--------------------------------------------------------------------------
 | Archives pagination 自定义每页显示文章数
 |--------------------------------------------------------------------------
 | https://jonchristopher.us/blog/wordpress-posts-per-page-per-custom-post-type/
 |
 */
return function ($options)
{
    global $post_options;
    $post_options = $options;
    function custom_posts_per_page($query){

        /*  If this isn't the main query, we'll avoid altering the results. */
        if ( ! $query->is_main_query() || is_admin() ) {
            return;
        }

        global $post_options;
        // var_dump($post_options);
        if( isset($query->query_vars['post_type']) ) {
            foreach ($post_options as $key => $option) {
                switch ( $query->query_vars['post_type'] ){
                    // Post Type named 'product'
                    case $option['post_type']:
                        $query->query_vars['posts_per_page'] = $option['per_page'];
                        break;     
            
                    default:
                        break;
                }
            }  
        }
        return $query;
    }
    
    add_filter( 'pre_get_posts', 'custom_posts_per_page' );
};