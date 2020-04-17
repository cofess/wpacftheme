<?php

namespace Lib\Util;

class Check{

  // 判断一个数组是关联数组，还是顺序数组
  public static function is_assoc_array(array $arr){
    if ([] === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
  }

  // 是否为登录注册页面
  public static function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
  }

  // 检测待审关键字和黑名单关键字
  public static function blacklist_check($str){
    $moderation_keys	= trim(get_option('moderation_keys'));
    $blacklist_keys		= trim(get_option('blacklist_keys'));

    $keys = $moderation_keys ."\n".$blacklist_keys;

    $words = explode("\n", $keys );

    foreach ( (array) $words as $word) {
        $word = trim($word);

        // Skip empty lines
        if ( empty($word) )
            continue;

        // Do some escaping magic so that '#' chars in the
        // spam words don't break things:
        $word = preg_quote($word, '#');

        $pattern = "#$word#i";
        if ( preg_match($pattern, $str) ) return true;
    }

    return false;
  }

  // 检测是否为真实浏览器
  static function is_real_user_browser() {
    //Unknown
    return (isset($_SERVER['HTTP_USER_AGENT']) && empty($_SERVER['HTTP_USER_AGENT']) === false && strpos($_SERVER['HTTP_USER_AGENT'], 'GTmetrix') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'Bot') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'bot') === false);
  }

  // 检测是否为手机号
  public static function is_mobile_number($number){
    return preg_match('/^0{0,1}(13[0-9]|15[0-3]|15[5-9]|147|170|17[6-8]|18[0-9])[0-9]{8}$/', $number);
  }

  // 检测是否为400号码
  public static function is_400_number($number){
    return preg_match('/^400(\d{7})$/', $number);
  }

  // 检测是否为800号码
  public static function is_800_number($number){
    return preg_match('/^800(\d{7})$/', $number);
  }

}
