<?php

/**
 * 禁止鼠标右键
 */
return function() 
{
    function disable_oncontext_menu() { 
        echo "\n".'<script type="text/javascript">document.oncontextmenu=function(){ return false }</script>'."\n"; 
    } 
    add_action( 'wp_head', 'disable_oncontext_menu', 99, 3 );
};
