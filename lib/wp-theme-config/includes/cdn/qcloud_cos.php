<?php
add_filter('wpjam_thumbnail',function ($img_url, $args){
	return get_qcloud_cos_thumbnail($img_url, $args);
},10,2);

//使用腾讯COS缩略图 API 进行裁图
function get_qcloud_cos_thumbnail($img_url, $args=array()){
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

	$quality	= $quality?:(WpThemeConfig\Configurator::getInstance()->get('storage.quality'));

	// if($width || $height || $format || $interlace || $quality){
	if($width || $height){
		$arg	= 'imageView2/'.$mode;

		if($width)		$arg .= '/w/'.$width;
		if($height) 	$arg .= '/h/'.$height;
		if($quality)	$arg .= '/q/'.$quality;

		if(strpos($img_url, 'imageView2')){
			$img_url	= preg_replace('/imageView2\/(.*?)#/', '', $img_url);
		}

		$img_url	= add_query_arg( array($arg => ''), $img_url );
		$img_url	= $img_url.'#';
	}

	return $img_url;
}