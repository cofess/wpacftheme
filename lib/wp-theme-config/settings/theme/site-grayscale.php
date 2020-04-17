<?php

/**
 * 网站变灰
 */
return function($value) 
{
    function site_grayscale() { 
        $html='<style type="text/css">';
        $html.='html{ filter: grayscale(100%); -webkit-filter: grayscale(100%); -moz-filter: grayscale(100%); -ms-filter: grayscale(100%); -o-filter: grayscale(100%); filter: url("data:image/svg+xml;utf8,#grayscale"); filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); -webkit-filter: grayscale(1);}';
        $html.='</style>'."\n"; 
        echo $html; 
    } 
    add_action('wp_head', function() use($value){
        if( $value == '1'){
            site_grayscale();
        }
        if( $value == '2' && is_home() ){
            site_grayscale();
        }
    } );
};
