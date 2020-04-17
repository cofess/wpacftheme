<?php

/**
 * mail smtp
 */
return function($value) 
{
    global $smtp;
    $smtp = array();
    $smtp['Host'] = WpThemeConfig\Configurator::getInstance()->get('system.smtp-host');
    $smtp['Port'] = WpThemeConfig\Configurator::getInstance()->get('system.smtp-port');
    $smtp['From'] = WpThemeConfig\Configurator::getInstance()->get('system.smtp-from-email');
    $smtp['FromName'] = WpThemeConfig\Configurator::getInstance()->get('system.smtp-from-name');
    $smtp['SMTPSecure'] = WpThemeConfig\Configurator::getInstance()->get('system.smtp-secure');
    $smtp['SMTPAuth'] = (WpThemeConfig\Configurator::getInstance()->get('system.smtp-auth')=='yes') ? true : false;
    $smtp['Username'] = WpThemeConfig\Configurator::getInstance()->get('system.smtp-auth-email');
    $smtp['Password'] = WpThemeConfig\Configurator::getInstance()->get('system.smtp-auth-pass');

    add_action('phpmailer_init', 'custom_phpmailer',10,1);
    function custom_phpmailer($phpmailer){
        global $smtp;
        if( $smtp['Host'] == '' || $smtp['From'] == '' ){
            return;
        }
        $phpmailer->IsSMTP();
        $phpmailer->Host = $smtp['Host'];
        $phpmailer->Port = $smtp['Port']; 
        $phpmailer->From = $smtp['From'];
        $phpmailer->FromName = $smtp['FromName'];
        $phpmailer->SMTPSecure = $smtp['SMTPSecure']; //tls or ssl （port=25留空，465为ssl）
        $phpmailer->SMTPAuth = $smtp['SMTPAuth'];
        if($phpmailer->SMTPAuth){
            $phpmailer->Username = $smtp['Username'];
            $phpmailer->Password = $smtp['Password'];
        }
    }

    /**
     * 修改 WordPress 发送邮件的默认邮箱和发件人
     * http://www.wpdaxue.com/change-wordpress-mail-from-info.html
     */  
    function custom_from_name($email){
        global $smtp;
        $wp_from_name = $smtp['FromName'];
        return $wp_from_name;
    }
    
    function custom_from_email($email) {
        global $smtp;
        $wp_from_email = $smtp['From'];
        return $wp_from_email;
    }
    
    if ( !empty($smtp['FromName']) ) {  
        add_filter('wp_mail_from_name', 'custom_from_name');
    }

    if ( !empty($smtp['From']) && is_email($smtp['From']) ) {
        add_filter('wp_mail_from', 'custom_from_email');
    }  
};
