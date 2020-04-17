<?php

namespace Lib\Util;

class Help{

  	// 移除除了 line feeds 和 carriage returns 所有控制字符
	public static function strip_control_characters($text){
		return preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F]/u', '', $text);	
		// return preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x80-\x9F]/u', '', $str);
	}

	// 去掉非 utf8mb4 字符
	public static function strip_invalid_text($str){
		$regex = '/
		(
			(?: [\x00-\x7F]                  # single-byte sequences   0xxxxxxx
			|   [\xC2-\xDF][\x80-\xBF]       # double-byte sequences   110xxxxx 10xxxxxx
			|   \xE0[\xA0-\xBF][\x80-\xBF]   # triple-byte sequences   1110xxxx 10xxxxxx * 2
			|   [\xE1-\xEC][\x80-\xBF]{2}
			|   \xED[\x80-\x9F][\x80-\xBF]
			|   [\xEE-\xEF][\x80-\xBF]{2}
			|    \xF0[\x90-\xBF][\x80-\xBF]{2} # four-byte sequences   11110xxx 10xxxxxx * 3
			|    [\xF1-\xF3][\x80-\xBF]{3}
			|    \xF4[\x80-\x8F][\x80-\xBF]{2}
			){1,50}                          # ...one or more times
		)
		| .                                  # anything else
		/x';

		return preg_replace($regex, '$1', $str);
	}

	// 获取纯文本
	public static function get_plain_text($text){

		$text = wp_strip_all_tags($text);
		
		$text = str_replace('"', '', $text); 
		$text = str_replace('\'', '', $text);	
		// replace newlines on mac / windows?
		$text = str_replace("\r\n", ' ', $text);
		// maybe linux uses this alone
		$text = str_replace("\n", ' ', $text);
		$text = str_replace("  ", ' ', $text);

		return trim($text);
	}

	// 获取第一段
	public static function get_first_p($text){
		if($text){
			$text = explode("\n", trim(strip_tags($text))); 
			$text = trim($text['0']); 
		}
		return $text;
	}

	/**
	 * Get excerpt from string
	 *
	 * @param String $str String to get an excerpt from
	 * @param Integer $startPos Position int string to start excerpt from
	 * @param Integer $maxLength Maximum length the excerpt may be
	 * @return String excerpt
	 */
	public static function substr($str, $startPos = 0, $maxLength = 100){
		if( strlen($str) > $maxLength ) {
			$excerpt = substr($str, $startPos, $maxLength - 3);
			$lastSpace = strrpos($excerpt, ' ');
			$excerpt = substr($excerpt, 0, $lastSpace);
			$excerpt .= '...';
		} else {
			$excerpt = $str;
		}
		return $excerpt;
	}

	// 中文截取方式
	public static function mb_strimwidth($text, $start=0, $length=40){
		return mb_strimwidth(wp_strip_all_tags($text), $start, $length, '...','utf-8');
	}

	public static function json_decode($json){
		$json	= self::strip_control_characters($json);

		if(empty($json)){
			return new WP_Error('empty_json', 'JSON 内容不能为空！');
		}

		$result	= json_decode($json,true);

		if(is_null($result)){
			require_once( ABSPATH . WPINC . '/class-json.php' );

			$wp_json	= new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			$result		= $wp_json->decode($json); 

			if(is_null($result)){
				if(isset($_GET['debug'])){
					print_r(json_last_error());
					print_r(json_last_error_msg());
				}
				
				trigger_error('json_decode_error '. json_last_error_msg()."\n".var_export($json,true));
				return new WP_Error('json_decode_error', json_last_error_msg());
			}else{
				return $result;
			}
		}else{
			return $result;
		}
	}

	public static function json_encode( $data, $options = JSON_UNESCAPED_UNICODE, $depth = 512){
		if(is_wp_error($data)){
			$data = array('errcode'=>$data->get_error_code(), 'errmsg'=>$data->get_error_message());
		}

		return wp_json_encode( $data, $options, $depth );
	}

	public static function send_json($response, $options = JSON_UNESCAPED_UNICODE, $depth = 512){
		if(isset($_REQUEST['callback'])){
			echo $_REQUEST['callback'].'('.self::json_encode($response, $options, $depth).')';
		}else{
			echo self::json_encode($response, $options, $depth);
		}
		exit;
	}

}
