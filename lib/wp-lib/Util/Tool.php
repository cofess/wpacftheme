<?php

namespace Lib\Util;


class Tool{

	/**
	 * @brief 正则取 url 参数
	 * https://blog.csdn.net/u014595375/article/details/54986145
	 * @param $url
	 * @return 
	 */
	public static function getUrlKeyValue($url){
		$result = array();
		$mr     = preg_match_all('/(\?|&)(.+?)=([^&?]*)/i', htmlspecialchars_decode($url), $matchs);
		// $mr     = preg_match_all("~[\?&]([^&]+)=([^&]+)~", $url, $matchs);
		if ($mr !== false) {
			for ($i = 0; $i < $mr; $i++) {
				$result[$matchs[2][$i]] = $matchs[3][$i];
			}
		}
		return $result;
	}

	// 获取 url 参数
	public static function get_url_params($url){
		$query_str = parse_url(htmlspecialchars_decode($url), PHP_URL_QUERY);
		parse_str($query_str, $params);
		return $params;
	}

	// 获取用户头像src
	public static function get_avatar_src($avatar){
		preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $avatar, $matches);
        if( $matches && isset($matches[1]) && isset($matches[1][0]) ){	   
            return $matches[1][0];
        }
            
        return false;
	}

	public static function get_avatar_params($avatar){
		$avatar_src = self::get_avatar_src($avatar);
		if($avatar_src){
			$query_str = parse_url($avatar_src, PHP_URL_QUERY);
			parse_str($query_str, $params);
			var_dump($params);
			return $params;
		}
		return false;	
	}

	// 很多客户端不支持中文图片名
	public static function urlencode_img_cn_name($img_url){
		return str_replace(['%3A','%2F'], [':','/'], urlencode($img_url));
	}

	/**
	 * 时间显示为“XX分钟前”
	 */
	public static function human_time_diff($from,  $to=0) {
		$to		= ($to)?:time();
		$day	= date('Y-m-d',$from);
		$today	= date('Y-m-d');
		
		$secs	= $to - $from;	//距离的秒数
		$days	= $secs / DAY_IN_SECONDS;

		$from += get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ;

		if($secs > 0){
			if((date('Y')-date('Y',$from))>0 && $days>3){//跨年且超过3天
				return date('Y-m-d',$from);
			}else{

				if($days<1){//今天
					if($secs<60){
						return $secs.'秒前';
					}elseif($secs<3600){
						return floor($secs/60)."分钟前";
					}else {
						return floor($secs/3600)."小时前";
					}
				}else if($days<2){	//昨天
					$hour=date('g',$from);
					return "昨天".$hour.'点';
				}elseif($days<3){	//前天
					$hour=date('g',$from);
					return "前天".$hour.'点';
				}else{	//三天前
					return date('n月j号',$from);
				}
			}
		}else{
			if((date('Y')-date('Y',$from))<0 && $days<-3){//跨年且超过3天
				return date('Y-m-d',$from);
			}else{

				if($days>-1){//今天
					if($secs>-60){
						return absint($secs).'秒后';
					}elseif($secs>-3600){
						return floor(absint($secs)/60)."分钟前";
					}else {
						return floor(absint($secs)/3600)."小时前";
					}
				}else if($days>-2){	//昨天
					$hour=date('g',$from);
					return "明天".$hour.'点';
				}elseif($days>-3){	//前天
					$hour=date('g',$from);
					return "后天".$hour.'点';
				}else{	//三天前
					return date('n月j号',$from);
				}
			}
		}
	}

	public static function parse_shortcode_attr($str,  $tagnames=null){
		$pattern = get_shortcode_regex(array($tagnames));
		if(preg_match("/$pattern/", $str, $m)){
			return shortcode_parse_atts( $m[3] );
		}else{
			return array();
		}		
	}

	public static function get_parameter($parameter, $args=array()){
		extract(wp_parse_args($args, array(
			'method'	=> 'GET', 		
			'required'	=> false,
			'length'	=> false,
			'name'		=> '',
			'default'	=> NULL,
			'type'		=> NULL,
			'send'		=> true
		)));

		$value = NULL;

		if ($method == 'POST') {
			if(empty($_POST)){	// 支持 json 实体 POST
				$post_input	= self::get_post_input();

				if(is_array($post_input)){
					$value = $post_input[$parameter] ?? $default;
				}
			}else{
				$value = $_POST[$parameter]??$default;
			}
		} elseif ($method == 'GET') {
			$value = $_GET[$parameter] ?? $default;
		} else {
			$value = $_REQUEST[$parameter] ?? '';
			if(empty($value) && empty($_POST)){	// 支持 json 实体 POST

				$post_input	= self::get_post_input();
				
				if(is_array($post_input)){
					$value = $post_input[$parameter] ?? $default;
				}
			}

			$value	= $value ?: $default;
		}

		if($required && is_null($value)) {
			$wp_error = new WP_Error('missing_parameter', '缺少 '.$method.' 参数：'.$parameter);
			if($send){
				self::send_json($wp_error);
			}else{
				return $wp_error;
			}
		}

		if($type == 'int' && $value && !is_numeric($value)) {
			return intval($value);
			// $wp_error = new WP_Error('illegal_type', $parameter.' 参数类型错误！');
			// if($send){
			// 	self::send_json($wp_error);
			// }else{
			// 	return $wp_error;
			// }
		}

		if($length && is_int($length) && (mb_strlen($value) < $length)){
			$wp_error = new WP_Error('short_parameter', $name.'长度不能少于'.$length.'！');
			if($send){
				self::send_json($wp_error);
			}else{
				return $wp_error;
			}
		}
		

		return $value;
	}

	public static function get_parameters($parameters, $args=array()){
		if(!is_array($parameters)){
			$parameters = wp_parse_slug_list($parameters);
		}

		$result = array();
		foreach ($parameters as $parameter) {
			$value = self::get_parameter($parameter, $args);
			if(is_wp_error($value)){
				return $value;
			}
			$result[$parameter] = $value;
		}

		return $result;
	}

}
