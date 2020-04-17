<?php

/**
 * 显示页面查询次数、加载时间和内存占用
 * http://www.wpdaxue.com/wordpress-queries-time-memory.html
*/
return function() 
{
    function performance_overview( $visible = false ) {
        $stat = sprintf(  '%d queries in %.3f seconds, using %.2fMB memory',
            get_num_queries(),
            timer_stop( 0, 3 ),
            memory_get_peak_usage() / 1024 / 1024
        );
        echo $visible ? $stat : "<!-- {$stat} -->" ;
    }
    add_action( 'wp_footer', 'performance_overview', 20 );
};
