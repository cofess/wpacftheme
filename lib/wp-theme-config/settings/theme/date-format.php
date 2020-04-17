<?php

/**
 * WordPress 修改时间的显示格式为几天前
 * http://www.wpdaxue.com/time-ago.html
 */
return function($value) 
{
    function time_ago_format(){
        global $post ;
        $time = get_post_time( 'G', true, $post );
        $time_diff = time() - $time;
        // 几分钟前，几小时前
        if ( $time_diff > 0 && $time_diff <= DAY_IN_SECONDS ) {
            $time = sprintf( __( '%s前' ), human_time_diff( $time ) );
        }
        // 几天前
        elseif ($time_diff > DAY_IN_SECONDS && $time_diff <= WEEK_IN_SECONDS) {
            $days = round($time_diff / DAY_IN_SECONDS);
            $time = sprintf(_n('%s天', '%s天', $days), $days) . __( '前' , 'Bing' );
        }
        // 几周前
        elseif ($time_diff > WEEK_IN_SECONDS && $time_diff <= MONTH_IN_SECONDS) {
            $weeks = floor($time_diff / WEEK_IN_SECONDS);
            $time = sprintf(_n('%s周', '%s周', $weeks), $weeks) . __( '前' , 'Bing' );
        }
        // 几月前
        elseif ($time_diff > MONTH_IN_SECONDS && ($time_diff <= (3 * MONTH_IN_SECONDS))) {
            $weeks = floor($time_diff / MONTH_IN_SECONDS);
            $time = sprintf(_n('%s个月', '%s个月', $weeks), $weeks) . __( '前' , 'Bing' );
        }
        // 正常显示
        else{
            $time = get_the_time(get_option('date_format')); 
        }
        return $time;
    }
    add_filter('the_time','time_ago_format');
};
