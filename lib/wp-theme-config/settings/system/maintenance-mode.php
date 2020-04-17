<?php

/**
 * 网站维护模式
 */
return function() 
{
    global $complete_date,$maintenance_autoend,$ip_whitelist;
    // 获取配置参数
    $maintenance_mode = $this->config['system.maintenance-mode'];
    $maintenance_notice = $this->config['system.enable-maintenance-notice'];
    $complete_date = $this->config['system.maintenance-complete-date'];
    $maintenance_autoend = $this->config['system.enable-maintenance-autoend'];
    $ip_whitelist = $this->config['system.maintenance-ip-whitelist'];

    // 激活维护模式 Activate maintenance mode?
    // 维护模式仅对首页有效，其他页面可正常访问
    // if( is_home() ){
        add_action('template_redirect', 'load_maintenance_mode');
    // }

    // Show maintenance mode notice
    if( $maintenance_notice ) {
        add_action('admin_notices', 'maintenance_mode_notice');
    }
    // Show maintenance mode notice
    function maintenance_mode_notice() {
        ?>
        <div class="error awpm">
            <p><?php echo __('温馨提示：网站已开启维护模式，无法正常访问，维护完成后别忘记关闭维护模式！', 'CS_TEXTDOMAIN'); ?></p>
        </div>
        <?php
    }

    // Do maintenance mode
    function load_maintenance_mode() {
        global $complete_date,$maintenance_autoend;
        
        // 维护模式仅对首页有效，其他页面可正常访问
        if ( !is_home() ) return;

        // 未设置主题或者IP白名单用户关闭维护模式 Do some checks
        if( check_ip_exclude() ) {
            return false;
        }

        // 开启“到达指定的维护完成时间自动结束维护模式”并且服务器当前时间大于维护完成时间时关闭维护模式
        if( $maintenance_autoend && date('Y/m/d',current_time('timestamp')) > $complete_date ){
            return false;
        }	
        
        // Start output
        nocache_headers();
        ob_start();
        
        // Set 503? 设置 503 HTTP状态码
        status_header(503);
        
        // Set actions
        add_action('maintenance_header', 'maintenance_mode_header');
        add_action('maintenance_footer', 'maintenance_mode_footer');

        // Load template
        include_once(WP_THEME_CONFIG_TEMPLATE_DIR . '/maintenance.php');
        ob_flush();
        exit();
    }

    // Check if this IP is to be excluded
    function check_ip_exclude() {

        global $ip_whitelist;
        
        $is_excluded = false;
        $addresses = $ip_whitelist;
        
        if($addresses != '') {
            $addresses = preg_split("/\n/", $addresses);
            
            // Loop
            foreach($addresses as $address) {
                $address = trim($address);
                if((!empty($_SERVER['REMOTE_ADDR']) AND strstr($_SERVER['REMOTE_ADDR'], $address)) OR (!empty($_SERVER['REQUEST_URI']) AND strstr($_SERVER['REQUEST_URI'], $address))) {
                    $is_excluded = true;
                    break;
                }
            }
        }

        return $is_excluded;
    }

    // Header for maintenance mode
    function maintenance_mode_header() {
        
        // Create tags used in tempate
        // $theme = cs_get_manager_option('maintenance_theme');
        $robots = (get_option('blog_public') == 0) ? 'noindex, nofollow' : 'index, follow';
        $robots = apply_filters('meta_robots', $robots);
        echo '<meta name="robots" content="'. esc_attr($robots) .'" />' . "\r\n";
        
        // Load styles and scripts
        global $wp_styles;
        wp_register_style('font-awesome',  WP_THEME_CONFIG_STATIC_URI .'/css/font-awesome.min.css');
        wp_register_style('maintenance',  WP_THEME_CONFIG_STATIC_URI .'/css/maintenance.css');
            
        if ( !is_admin() ) { /** Load Scripts and Style on Website Only */  
            // Output styles and scripts
            $wp_styles->do_items('font-awesome');
            $wp_styles->do_items('maintenance');
            // $background=cs_get_manager_option('maintenance_background');
            $html= '';
            // $html='<style type="text/css">';
            // if(cs_get_manager_option('maintenance_body_background')) $html.='body{background-color:'.cs_get_manager_option('maintenance_body_background').'!important;}';
            // if(cs_get_manager_option('maintenance_subject_color')) $html.='.subject{color:'.cs_get_manager_option('maintenance_subject_color').'!important;}';
            // if(cs_get_manager_option('maintenance_content_color')) $html.='.content{color:'.cs_get_manager_option('maintenance_content_color').'!important;}';
            // if(cs_get_manager_option('maintenance_footer_color')) $html.='.copyright{color:'.cs_get_manager_option('maintenance_footer_color').'!important;}';
            // if(cs_get_manager_option('maintenance_date_color')) $html.='.counter ul{color:'.cs_get_manager_option('maintenance_date_color').'!important;}';
            // if($background['image']) {
            //     $html.='.parallax {
            //     background-color:'.$background['color'].';
            //     background-image: url('.$background['image'].'); 
            //     background-attachment:'.$background['attachment'].';
            //     background-position:'.$background['position'].'; 
            //     background-repeat:'.$background['repeat'].';
            //     }';
            // }
            // //custom style
            // if(cs_get_manager_option('maintenance_custom_style')){
            //     $html.=cs_get_manager_option('maintenance_custom_style');
            // }
            // $html.='</style>'."\n";
            echo $html;		
        }
    }

    // Footer for maintenance mode
    function maintenance_mode_footer() {
        # Not used right now
        global $wp_scripts;
        wp_register_script('countdown', WP_THEME_CONFIG_STATIC_URI .'/js/jquery.countdown.min.js', 'jquery');
        wp_register_script('maintenance', WP_THEME_CONFIG_STATIC_URI .'/js/maintenance.js', 'jquery');
        if ( !is_admin() ) {
            $wp_scripts->do_items('jquery');
            $wp_scripts->do_items('countdown');
            $wp_scripts->do_items('maintenance');
        }
    }
};
