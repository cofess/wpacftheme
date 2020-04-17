<?php

namespace Lib\Http;

class Request {

	//function to get the remote data
	public static function url_get_contents ($url) {
		if (function_exists('curl_exec')){ 
		  $conn = curl_init($url);
		  curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
		  curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
		  curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
		  $url_get_contents_data = (curl_exec($conn));
		  curl_close($conn);
		}elseif(function_exists('file_get_contents')){
		  $url_get_contents_data = file_get_contents($url);
		}elseif(function_exists('fopen') && function_exists('stream_get_contents')){
		  $handle = fopen ($url, "r");
		  $url_get_contents_data = stream_get_contents($handle);
		}else{
		  $url_get_contents_data = false;
		}
		return $url_get_contents_data;
	}

	public static function http_request($url, $args=array(), $err_args=array()){
		$args = wp_parse_args( $args, array(
			'timeout'			=> 5,
			'method'			=> '',
			'body'				=> array(),
			'sslverify'			=> false,
			'blocking'			=> true,	// 如果不需要立刻知道结果，可以设置为 false
			'stream'			=> false,	// 如果是保存远程的文件，这里需要设置为 true
			'filename'			=> null,	// 设置保存下来文件的路径和名字
			'need_json_decode'	=> true,
			'need_json_encode'	=> false,
			// 'headers'		=> array('Accept-Encoding'=>'gzip;'),	//使用压缩传输数据
			// 'headers'		=> array('Accept-Encoding'=>''),
			// 'compress'		=> false,
			'decompress'		=> true,
		));

		if(isset($_GET['debug'])){
			print_r($args);	
		}

		$need_json_decode	= $args['need_json_decode'];
		$need_json_encode	= $args['need_json_encode'];

		$method				= ($args['method'])?strtoupper($args['method']):($args['body']?'POST':'GET');

		unset($args['need_json_decode']);
		unset($args['need_json_encode']);
		unset($args['method']);

		if($method == 'GET'){
			$response = wp_remote_get($url, $args);
		}elseif($method == 'POST'){
			if($need_json_encode && is_array($args['body'])){
				$args['body']	= self::json_encode($args['body']);
			}
			$response = wp_remote_post($url, $args);
		}elseif($method == 'FILE'){	// 上传文件
			$args['method'] = ($args['body'])?'POST':'GET';
			$args['sslcertificates']	= isset($args['sslcertificates'])?$args['sslcertificates']: ABSPATH.WPINC.'/certificates/ca-bundle.crt';
			$args['user-agent']			= isset($args['user-agent'])?$args['user-agent']:'WordPress';
			$wp_http_curl	= new WP_Http_Curl();
			$response		= $wp_http_curl->request($url, $args);
		}

		if(is_wp_error($response)){
			trigger_error($url."\n".$response->get_error_code().' : '.$response->get_error_message()."\n".var_export($args['body'],true));
			return $response;
		}

		$headers	= $response['headers'];
		$response	= $response['body'];

		if($need_json_decode || isset($headers['content-type']) && strpos($headers['content-type'], '/json')){
			if($args['stream']){
				$response	= file_get_contents($args['filename']);
			}

			$response	= self::json_decode($response);

			if(get_current_blog_id() == 339){
				// print_r($response);
			}

			if(is_wp_error($response)){
				return $response;
			}
		}
		
		extract(wp_parse_args($err_args,  array(
			'errcode'	=>'errcode',
			'errmsg'	=>'errmsg',
			'detail'	=>'detail'
		)));

		if(isset($response[$errcode]) && $response[$errcode]){
			$errcode	= $response[$errcode];
			$errmsg		= isset($response[$errmsg])?$response[$errmsg]:'';
			$errmsg		.= isset($response[$detail])?"\n".$response[$detail]:'';

			trigger_error($url."\n".$errcode.' : '.$errmsg."\n".var_export($args['body'],true));
			return new WP_Error($errcode, $errmsg);
		}

		if(isset($_GET['debug'])){
			echo $url;
			print_r($response);
		}

		return $response;
	}
  
}
