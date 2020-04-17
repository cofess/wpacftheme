<?php

namespace Lib\API;
use Lib\Util\Help;
use Lib\Http\Request;
use Lib\Util\Tool;

class Media {

	public static function get_qq_vid($id_or_url){
		if(filter_var($id_or_url, FILTER_VALIDATE_URL)){ 
			if(preg_match('#https://v.qq.com/x/page/(.*?).html#i',$id_or_url, $matches)){
				return $matches[1];
			}elseif(preg_match('#https://v.qq.com/x/cover/.*/(.*?).html#i',$id_or_url, $matches)){
				return $matches[1];
			}else{
				return '';
			}
		}else{
			return $id_or_url;
		}
	}

	public static function get_video_mp4($id_or_url){
		if(filter_var($id_or_url, FILTER_VALIDATE_URL)){ 
			if(preg_match('#http://www.miaopai.com/show/(.*?).htm#i',$id_or_url, $matches)){
				return 'http://gslb.miaopai.com/stream/'.esc_attr($matches[1]).'.mp4';
			}elseif(preg_match('#https://v.qq.com/x/page/(.*?).html#i',$id_or_url, $matches)){
				return self::get_qqv_mp4($matches[1]);
			}elseif(preg_match('#https://v.qq.com/x/cover/.*/(.*?).html#i',$id_or_url, $matches)){
				return self::get_qqv_mp4($matches[1]);
			}else{
				return Tool::urlencode_img_cn_name($id_or_url);
			}
		}else{
			return self::get_qqv_mp4($id_or_url);
		}
	}

	public static function get_qqv_mp4($vid){
		if(strlen($vid) > 20){
			return new WP_Error('invalid_qqv_vid', '非法的腾讯视频 ID');
		}

		$mp4 = wp_cache_get($vid, 'qqv_mp4');
		if($mp4 === false){
			$response	= Request::http_request('http://vv.video.qq.com/getinfo?otype=json&platform=11001&vid='.$vid, array(
				'timeout'			=>4,
				'need_json_decode'	=>false
			));

			if(is_wp_error($response)){
				return $response;
			}

			$response	= trim(substr($response, strpos($response, '{')),';');
			$response	= Help::json_decode($response);

			if(is_wp_error($response)){
				return $response;
			}

			if(empty($response['vl'])){
				return new WP_Error('illegal_qqv', '该腾讯视频不存在或者为收费视频！');
			}

			$u		= $response['vl']['vi'][0];
			$p0		= $u['ul']['ui'][0]['url'];
			$p1		= $u['fn'];
			$p2		= $u['fvkey'];

			$mp4	= $p0.$p1.'?vkey='.$p2;

			wp_cache_set($vid, $mp4, 'qqv_mp4', HOUR_IN_SECONDS*6);
		}

		return $mp4;
	}
}
