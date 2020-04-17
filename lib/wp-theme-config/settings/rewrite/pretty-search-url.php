<?php

/*
|--------------------------------------------------------------------------
| Pretty search URLs
|--------------------------------------------------------------------------
|
| * Redirects search results from /?s=query to /search/query
| * Converts %20 to +
|
| http://txfx.net/wordpress-plugins/nice-search/
|
*/

/**
 * 修改搜索结果的链接
 * 参考：http://www.wpdaxue.com/redirect-wordpress-searches.html
 */ 

return function($value)
{
    add_action('template_redirect', function()
    {
        global $wp_rewrite;

        $search_base = 'search';

        if ( ! isset($wp_rewrite) || ! is_object( $wp_rewrite ) | ! $wp_rewrite->using_permalinks())
        {
            return;
        }

        if (is_search() && ! is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false)
        {
            wp_redirect( home_url( "/{$search_base}/" . urlencode( get_query_var( 's' ) ) ) );
            exit();
        }
    });
};
