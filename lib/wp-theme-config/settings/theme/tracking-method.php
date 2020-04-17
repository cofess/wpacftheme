<?php

/**
 * 统计代码
 */
return function($value) 
{
    global $baidu_tracking_id,$ga_tracking_id;

    $tracking_method = WpThemeConfig\Configurator::getInstance()->get('theme.tracking-method');

    if(!empty(WpThemeConfig\Configurator::getInstance()->get('theme.tracking-code-position')) && WpThemeConfig\Configurator::getInstance()->get('theme.tracking-code-position') == 'footer') {
        $tracking_code_position = 'wp_footer';
    }
    else {
        $tracking_code_position = 'wp_head';
    }

    $baidu_tracking_id = WpThemeConfig\Configurator::getInstance()->get('theme.baidu-tracking-id');

    $ga_tracking_id = WpThemeConfig\Configurator::getInstance()->get('theme.ga-tracking-id');
    $enable_local_ga = WpThemeConfig\Configurator::getInstance()->get('theme.enable-local-ga');

    if(!empty($tracking_method) && $tracking_method == 'baidu'){
        add_action($tracking_code_position, 'print_baidu_tracking_code', 0);
    }

    if(!empty($tracking_method) && $tracking_method == 'ga'){
        //enable/disable local analytics scheduled event
        if(!empty($enable_local_ga) && $enable_local_ga) {
            if(!wp_next_scheduled('update_ga_tracking_code')) {
                wp_schedule_event(time(), 'daily', 'update_ga_tracking_code');
            }
            add_action($tracking_code_position, 'print_ga_tracking_code', 0);
        }
        else {
            if(wp_next_scheduled('update_ga_tracking_code')) {
                wp_clear_scheduled_hook('update_ga_tracking_code');
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Baidu tongji id:61187660de33f704ad08099961a307d1
    |--------------------------------------------------------------------------
    |
    | 百度统计
    |
    */
    function print_baidu_tracking_code(){
        global $baidu_tracking_id;
        if(is_admin()){
            return;
        }
        if(!empty($baidu_tracking_id)) {
            ?>
            <script>
            var _hmt = _hmt || [];
            (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?<?php echo $baidu_tracking_id;?>";
                var s = document.getElementsByTagName("script")[0]; 
                s.parentNode.insertBefore(hm, s);
            })();
            </script>
            <?php
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    |
    | 谷歌统计
    |
    */
    //update analytics.js
    function update_ga_tracking_code() {
        //paths
        $local_file = WP_THEME_CONFIG_STATIC_URI . '/js/analytics.js';
        $host = 'www.google-analytics.com';
        $path = '/analytics.js';

        //open connection
        $fp = @fsockopen($host, '80', $errno, $errstr, 10);

        if($fp){	
            //send headers
            $header = "GET $path HTTP/1.0\r\n";
            $header.= "Host: $host\r\n";
            $header.= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6\r\n";
            $header.= "Accept: */*\r\n";
            $header.= "Accept-Language: en-us,en;q=0.5\r\n";
            $header.= "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n";
            $header.= "Keep-Alive: 300\r\n";
            $header.= "Connection: keep-alive\r\n";
            $header.= "Referer: https://$host\r\n\r\n";
            fwrite($fp, $header);
            $response = '';
            
            //get response
            while($line = fread($fp, 4096)) {
                $response.= $line;
            }

            //close connection
            fclose($fp);

            //remove headers
            $position = strpos($response, "\r\n\r\n");
            $response = substr($response, $position + 4);

            //create file if needed
            if(!file_exists($local_file)) {
                fopen($local_file, 'w');
            }

            //write response to file
            if(is_writable($local_file)) {
                if($fp = fopen($local_file, 'w')) {
                    fwrite($fp, $response);
                    fclose($fp);
                }
            }
        }
    }
    add_action('update_ga_tracking_code', 'update_ga_tracking_code');

    //print analytics script
    function print_ga_tracking_code() {
        global $ga_tracking_id;

        //dont print for admin
        if(is_admin()){
            return;
        }

        if(!empty($ga_tracking_id)) {
            echo "<!-- Local Analytics -->";
            echo "<script>";
            echo "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                        })(window,document,'script','" . WP_THEME_CONFIG_STATIC_URI . "/js/analytics.js','ga');";
            echo "ga('create', '" . $ga_tracking_id . "', 'auto');";
            echo "ga('send', 'pageview');";
            echo "</script>";
        }
    }  
};
