<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Disable Google Fonts
    |--------------------------------------------------------------------------
    |
    | * This function stops loading of Open Sans and other fonts used by WordPress and bundled themes from Google Fonts.
    |
    */

    'disable-all-google-fonts' => true,
    
    /*
    |--------------------------------------------------------------------------
    | Disable Google maps
    |--------------------------------------------------------------------------
    |
    | * Stops loading of Google Maps used by some themes or plugins.
    |
    */

    'disable-google-maps' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts asynchronous
    |--------------------------------------------------------------------------
    |
    | * By default, WordPress loads Google fonts synchronously, that is, your page will not be fully loaded until Google Fonts are loaded. This algorithm slows down the loading of your page and leads to errors when checking the site in Google Page Speed. Using this option, your Google Fonts will be loaded after your page is fully loaded. This method has a negative — you and visitors of your site will see how the font changes while loading a page, from the system to the downloadable one.
    |
    */

    'lazy-load-google-fonts' => true,

    /*
    |--------------------------------------------------------------------------
    | 阻止非法访问
    |--------------------------------------------------------------------------
    |
    */

    'block-bad-queries' => true,

    /*
    |--------------------------------------------------------------------------
    | Attachment Pages Redirect
    |--------------------------------------------------------------------------
    |
    | * Makes attachment pages redirects (301) to post parent if any. If not, redirects (302) to home page.
    */
    
    'attachment-pages-redirect' => true,

);
