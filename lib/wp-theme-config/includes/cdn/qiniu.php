<?php
add_filter('wpjam_thumbnail',function ($img_url, $args){
	return get_qiniu_thumbnail($img_url, $args);
},10,2);

//使用七牛缩略图 API 进行裁图
function get_qiniu_thumbnail($img_url, $args=array()){
	extract(wp_parse_args($args, array(
		'crop'		=> 1,
		'width'		=> 0,
		'height'	=> 0,
		'retina'	=> 1,
		'mode'		=> null,
		'format'	=> '',
		'interlace'	=> 0,
		'quality'	=> 0,
	)));

	if($mode === null){
		$crop	= $crop && ($width && $height);	// 只有都设置了宽度和高度才裁剪
		$mode	= $mode?:($crop?1:2);
	}
	
	$width		= intval($width)*$retina;
	$height		= intval($height)*$retina;

	$format		= $format?:(WpThemeConfig\Configurator::getInstance()->get('storage.webp')?'webp':'');
	$interlace	= $interlace?:(WpThemeConfig\Configurator::getInstance()->get('storage.interlace')?1:0);
	$quality	= $quality?:(WpThemeConfig\Configurator::getInstance()->get('storage.quality'));

	// if($width || $height || $format || $interlace || $quality){
	if($width || $height){
		$arg	= 'imageView2/'.$mode;

		if($width)		$arg .= '/w/'.$width;
		if($height) 	$arg .= '/h/'.$height;
		if($format)		$arg .= '/format/'.$format;
		if($interlace)	$arg .= '/interlace/'.$interlace;
		if($quality)	$arg .= '/q/'.$quality;

		if(strpos($img_url, 'imageView2')){
			$img_url	= preg_replace('/imageView2\/(.*?)#/', '', $img_url);
		}

		if(strpos($img_url, 'watermark')){
			$img_url	= $img_url.'|'.$arg;
		}else{
			$img_url	= add_query_arg( array($arg => ''), $img_url );
		}

		if(!empty($args['content'])){
			$img_url	= get_qiniu_watermark($img_url);
		}

		$img_url	= $img_url.'#';
	}

	return $img_url;
}

// 获取七牛水印
function get_qiniu_watermark($img_url, $args=array()){
	extract(wp_parse_args($args, array(
		'watermark'	=> '',
		'dissolve'	=> '',
		'gravity'	=> '',
		'dx'		=> 0,
		'dy'		=> 0,
	)));

	$watermark	= $watermark?:WpThemeConfig\Configurator::getInstance()->get('storage.watermark');
	if($watermark){
		$watermark	= str_replace(array('+','/'),array('-','_'),base64_encode($watermark));
		$dissolve	= $dissolve?:(WpThemeConfig\Configurator::getInstance()->get('storage.opacity')?:100);
		$gravity	= $gravity?:(WpThemeConfig\Configurator::getInstance()->get('storage.position')?:'SouthEast');
		$dx			= $dx?:(WpThemeConfig\Configurator::getInstance()->get('storage.dx')?:10);
		$dy			= $dy?:(WpThemeConfig\Configurator::getInstance()->get('storage.dy')?:10);

		$watermark	= 'watermark/1/image/'.$watermark.'/dissolve/'.$dissolve.'/gravity/'.$gravity.'/dx/'.$dx.'/dy/'.$dy;

		if(strpos($img_url, 'imageView2')){
			$img_url = $img_url.'|'.$watermark;
		}else{
			$img_url = add_query_arg(array($watermark=>''), $img_url);
		}
	}

	return $img_url;
}

function get_qiuniu_timestamp($img_url){
	$t		= dechex(time()+HOUR_IN_SECONDS*6);	
	$key	= '';
	$path	= parse_url($img_url, PHP_URL_PATH);
	$sign	= strtolower(md5($key.$path.$t));

	return add_query_arg(array('sign' => $sign, 't'=>$t), $img_url);
}

function get_qiniu_image_info($img_url){
	$img_url 	= add_query_arg(array('imageInfo'=>''),$img_url);
	
	$response	= wp_remote_get($img_url);
	if(is_wp_error($response)){
		return $response;
	}

	$response	= json_decode($response['body'], true);

	if(isset($response['error'])){
		return new WP_Error('error', $response['error']);
	}

	return $response;
}