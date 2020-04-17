<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Hide update information (WP core, plugins, themes)
    |--------------------------------------------------------------------------
    |
    | * The affected user role won't be confronted with update information. This will also speed up certain page load times.
    |
    */

    'hide-updates' => false,
    
    /*
    |--------------------------------------------------------------------------
    | Head cleanup
    |--------------------------------------------------------------------------
    |
    | * Remove extra features from <head>.
    |
    | http://wpengineer.com/1438/wordpress-header/
    |
    */

    'clean-head' => false,

    /*
    |--------------------------------------------------------------------------
    | Wordpress version cleanup
    |--------------------------------------------------------------------------
    |
    | * Remove WP version from head,RSS feeds and dashboard.
    |
    */

    'remove-wp-version' => true,

   /*
    |--------------------------------------------------------------------------
    | Body class cleanup
    |--------------------------------------------------------------------------
    |
    | * Remove extra body_class() classes
    |
    */

   'clean-body-class' => false,

   /*
    |--------------------------------------------------------------------------
    | Menu class cleanup
    |--------------------------------------------------------------------------
    |
    | * Remove extra menu classes and id
    |
    */

    'clean-menu-class' => true,

   /*
    |--------------------------------------------------------------------------
    | Remove unnecessary dashboard widgets
    |--------------------------------------------------------------------------
    |
    | http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
    |
    */

   'remove-dashboard-widgets' => true,

   /*
    |--------------------------------------------------------------------------
    | Remove unnecessary self-closing tags
    |--------------------------------------------------------------------------
    */

   'remove-self-closing-tags' => true,

   /*
    |--------------------------------------------------------------------------
    | Remove dns-prefetch //s.w.org
    |--------------------------------------------------------------------------
    */

    'remove-wp-resource-hints' => false,

);
