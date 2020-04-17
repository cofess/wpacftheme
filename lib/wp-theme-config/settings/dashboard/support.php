<?php

return function($option)
{
    $settings = ([
        'name'     => __('小张','BT_TEXTDOMAIN'),
        'services' => __('企业网站建设 | 外贸商城 | 阿里巴巴旺铺装修','BT_TEXTDOMAIN'),
        'qq'       => '285088180',
        'email'    => 'cofess@foxmail.com',
        'wechat'   => 'xiaoxu_2014',
        'blog'     => 'https://blog.cofess.com',
        'site'     => 'http://www.cofess.com'
    ]);

    $feed_callback = function() use($settings) {
        if($settings['name']){
            echo '<h3>'.__('联系人：','BT_TEXTDOMAIN').$settings['name'].'</h3>';
        }
        echo '<ul>';
        if($settings['services']){
            echo '<li>'.__('服务：','BT_TEXTDOMAIN').$settings['services'].'</li>';
        }
        if($settings['qq']){
            echo '<li>'.__('QQ：','BT_TEXTDOMAIN').'<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$settings['qq'].'&site=qq&menu=yes" title="点击这里给我发消息">'.$settings['qq'].'</a></li>';
        }
        if($settings['email']){
            echo '<li>'.__('邮箱：','BT_TEXTDOMAIN').'<a href="mailto:'.$settings['email'].'">'.$settings['email'].'</a></li>';
        }
        if($settings['wechat']){
            echo '<li>'.__('微信：','BT_TEXTDOMAIN').$settings['wechat'].'</li>';
        }
        if($settings['blog']){
            echo '<li>'.__('博客：','BT_TEXTDOMAIN').'<a href="'.$settings['blog'].'" target="_blank">'.$settings['blog'].'</a></li>';
        }
        if($settings['site']){
            echo '<li>'.__('网站：','BT_TEXTDOMAIN').'<a href="'.$settings['site'].'" target="_blank">'.$settings['site'].'</a></li>';
        }
        echo '</ul>';
        echo '<div>';
        echo '<a style="display:inline-block;line-height:inherit;height:23px;float:left;" target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=GSshLCkhISghKVloaDd6dnQ" style="text-decoration:none;"><img style="height:23px;width:auto;" src="http://rescdn.qqmail.com/zh_CN/htmledition/images/function/qm_open/ico_mailme_12.png"/></a>';
        if($settings['qq']){
            echo '<a style="display:inline-block;line-height:inherit;height:23px;float:left;margin-left:10px;" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$settings['qq'].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$settings['qq'].':51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>';
        }
        echo '<div style="clear:both"></div></div>';
    };

    Lib\Core\Dashboard::addSideWidget( 'dashboard-supports', __('技术支持','BT_TEXTDOMAIN'), $feed_callback );
};