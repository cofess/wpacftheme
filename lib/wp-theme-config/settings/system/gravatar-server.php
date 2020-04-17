<?php

/************************************************************
 * Gravatar头像被墙的四种解决方案
 * From http://www.weeiy.com/wordpress-gravatar-4.html
 ************************************************************/
return function($value)
{
    global $custom_gravatar_server,$gravatar_cache_days;
    $custom_gravatar_server = $this->config['system.custom-gravatar-server'];
    $gravatar_cache_days = $this->config['system.gravatar-cache-days'];

    /*
    * 使用https方式（SSL）调用头像
    * Use https gravatar server to replace none-https.
    * Simplely replace from "http://*.gravatar.com" to "https://secure.gravatar.com".
    */
    function replace_gravatar_to_ssl($avatar){
        // $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
        if(strpos($avatar,'gravatar.com') !== false){
            // Replacement for HTTPS domain 替换为 https 的域名
            $avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "secure.gravatar.com", $avatar);
            // Replacement for HTTPS protocol 替换为 https 协议
            $avatar = str_replace("http:", "https:", $avatar);
        }
        return $avatar;
    }
    if ( $value == '1' ) {
        add_filter('get_avatar', 'replace_gravatar_to_ssl');
    }

    /*
    * Gravatar中国服务器，cn.gravatar.com
    */
    function replace_gravatar_to_cn($avatar){
        $avatar = str_replace(array('www.gravatar.com','0.gravatar.com','1.gravatar.com','2.gravatar.com','s.gravatar.com'),'cn.gravatar.com',$avatar);
        return $avatar;
    }
    if ( $value == '2' ) {
        add_filter('get_avatar', 'replace_gravatar_to_cn');
    }


    /*
    * 自定义第三方Gravatar镜像服务器,多说：gravatar.duoshuo.com,
    */
    function replace_gravatar_to_custom($avatar){
        global $custom_gravatar_server;
        $avatar = str_replace(array('www.gravatar.com','0.gravatar.com','1.gravatar.com','2.gravatar.com','s.gravatar.com'),$custom_gravatar_server,$avatar);
        return $avatar;
    }
    if ( $value == '3' && $custom_gravatar_server != '' ) {
        add_filter('get_avatar', 'replace_gravatar_to_custom');
    }

    /*
    * Gravatar头像缓存到本地,国内主机无法使用（无法访问国外网络）
    * http://www.wpdaxue.com/gravatar-is-blocked.html
    * https://www.wpdaxue.com/gravatar-cache.html
    * https://zhangzifan.com/wordpress-cache-gravatar.html
    * https://wordpress.stackexchange.com/questions/17413/removing-gravatar-com-support-for-wordpress-and-simple-local-avatars
    */
    function local_cache_avatar($avatar) {
        global $gravatar_cache_days;
        $cache_dir = WP_CONTENT_DIR . '/cache/avatar/';
        if(!is_dir($cache_dir))//判断是否有缓存目录
            mkdir($cache_dir, 0755, true);//否者创建头像缓存目录
        $tmp = strpos($avatar, 'http');
        $g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
        $tmp = strpos($g, 'avatar/') + 7;
        $f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
        list($width,$height,$type,$attr) = getimagesize($g);//获取头像参数
        $e = $cache_dir. $f .'-'.$width.'.jpg';
        // $t = 604800; //默认缓存天数，设定 7 天, 单位:秒
        $t = $gravatar_cache_days*86400;
        if ( empty($default) ) $default = get_template_directory_uri().'/static/public/images/default-avatar.jpg';
        if ( !is_file($e) || (time() - filemtime($e)) > $t ){ //当头像不存在或者文件超过 7 天才更新
            copy(htmlspecialchars_decode($g), $e);
        } else{
            $avatar = strtr($avatar, array($g => WP_CONTENT_URL .'/cache/avatar/'.$f.'-'.$width.'.jpg'));
        }
        if (filesize($e) < 500) copy($default, $e);
        return $avatar;
    }
    if ( $value == '4' && $gravatar_cache_days ) {
        add_filter('get_avatar', 'local_cache_avatar');
    }
};
