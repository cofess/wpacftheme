<?php

return function ($value)
{
	global $CDN_NAME,$watermark;

	require WP_THEME_CONFIG_INCLUDE_DIR .'/wpjam-functions.php';
	// require WP_THEME_CONFIG_INCLUDE_DIR .'/cdn/aliyun_oss.php';
	// require WP_THEME_CONFIG_INCLUDE_DIR .'/cdn/qcloud_cos.php';
	// require WP_THEME_CONFIG_INCLUDE_DIR .'/cdn/qiniu.php';

	$CDN_NAME = WpThemeConfig\Configurator::getInstance()->get('storage.cdn-server');
	$CDN_HOST = WpThemeConfig\Configurator::getInstance()->get('storage.host');

	$watermark = array();
	$watermark['watermark'] = WpThemeConfig\Configurator::getInstance()->get('storage.watermark');
	$watermark['opacity'] = WpThemeConfig\Configurator::getInstance()->get('storage.opacity');
	$watermark['position'] = WpThemeConfig\Configurator::getInstance()->get('storage.position');
	$watermark['dx'] = WpThemeConfig\Configurator::getInstance()->get('storage.dx');
	$watermark['dy'] = WpThemeConfig\Configurator::getInstance()->get('storage.dy');

	add_action('wp_loaded', 'cdn_ob_cache');
	// HTML 替换，镜像 CDN 主函数
	function cdn_ob_cache(){
		global $CDN_NAME;

		if($CDN_NAME){	// 如果有第三方 CDN
			
			if(cdn_can_remote_image()){

				// 远程图片的 Rewrite 规则，第三方插件需要 flush rewrite
				add_filter('wpjam_rewrite_rules', function ($rewrite_rules){
					$rewrite_rules[$CDN_NAME.'/([^/]+)/image/([^/]+)\.([^/]+)?$']	= 'index.php?p=$matches[1]&'.$CDN_NAME.'_image=$matches[2]&'.$CDN_NAME.'_image_type=$matches[3]';	
					return $rewrite_rules;
				});
				

				// 远程图片的 Query Var
				add_filter('query_vars', function ($query_vars) {
					global $CDN_NAME;
					$query_vars[] = $CDN_NAME.'_image';
					$query_vars[] = $CDN_NAME.'_image_type';
					return $query_vars;
				});

				// 远程图片加载模板
				add_action('template_redirect', function (){
					global $CDN_NAME;
					$remote_image 		= get_query_var($CDN_NAME.'_image');
					$remote_image_type 	= get_query_var($CDN_NAME.'_image_type');

					if($remote_image && $remote_image_type){
						include(WPJAM_BASIC_PLUGIN_DIR.'template/image.php');
						exit;
					}
				}, 5);
			}

			add_filter('the_content', 'cdn_content',1);
		}

		global $mq_blog_id;
		if(empty($mq_blog_id)){
			ob_start('cdn_html_replace');
		}
	}

	function cdn_html_replace($html){
		$html = apply_filters('wpjam_html_replace',$html);

		if(is_admin())	return $html;

		if(empty($CDN_NAME))	return $html;

		$cdn_exts	= wpjam_cdn_get_setting('exts');

		if(empty($cdn_exts)) return $html;

		$cdn_dirs	= str_replace('-','\-',wpjam_cdn_get_setting('dirs'));

		if($cdn_dirs){
			$regex	=  '/'.str_replace('/','\/',LOCAL_HOST).'\/(('.$cdn_dirs.')\/[^\s\?\\\'\"\;\>\<]{1,}.('.$cdn_exts.'))([\"\\\'\s\]\?]{1})/';
			$html =  preg_replace($regex, $CDN_HOST.'/$1$4', $html);

			$regex	=  '/'.str_replace('/','\/',LOCAL_HOST2).'\/(('.$cdn_dirs.')\/[^\s\?\\\'\"\;\>\<]{1,}.('.$cdn_exts.'))([\"\\\'\s\]\?]{1})/';
			$html =  preg_replace($regex, $CDN_HOST.'/$1$4', $html);
		}else{
			$regex	= '/'.str_replace('/','\/',LOCAL_HOST).'\/([^\s\?\\\'\"\;\>\<]{1,}.('.$cdn_exts.'))([\"\\\'\s\]\?]{1})/';
			$html =  preg_replace($regex, $CDN_HOST.'/$1$3', $html);

			$regex	= '/'.str_replace('/','\/',LOCAL_HOST2).'\/([^\s\?\\\'\"\;\>\<]{1,}.('.$cdn_exts.'))([\"\\\'\s\]\?]{1})/';
			$html =  preg_replace($regex, $CDN_HOST.'/$1$3', $html);
		}
		

		return $html;
	}

	function cdn_content($content){
		if(wpjam_get_json()){
			return $content;
		}
		return preg_replace_callback('|<img.*?(src=[\'"](.*?)[\'"]).*?>|i', function($matches){
			$img_url 	= trim($matches[2]);

			if(empty($img_url)) return;

			if(strpos($matches[0], 'srcset=')){
				return $matches[0];
			}

			$width = $height = 0;

			if(preg_match('|<img.*?width=[\'"](.*?)[\'"].*?>|i', $matches[0], $width_matches)){
				$width = $width_matches[1];
			}

			if(preg_match('|<img.*?height=[\'"](.*?)[\'"].*?>|i', $matches[0], $height_matches)){
				$height = $height_matches[1];
			}

			$img_url_2x	= wpjam_get_thumbnail($img_url, array(
				'width'		=> $width,
				'height'	=> $height,
				'retina'	=> 2,
				'content'	=> true,
			));

			$img_url	= wpjam_get_thumbnail($img_url, array(
				'width'		=> $width,
				'height'	=> $height,
				'retina'	=> 1,
				'content'	=> true,
			));

			return str_replace($matches[1], 'src="'.$img_url.'" srcset="'.$img_url.' 1x, '.$img_url_2x.' 2x"', $matches[0]);

		}, $content);
	}

	function cdn_can_remote_image($img_url=''){
		global $CDN_NAME,$watermark;
		if(get_option('permalink_structure') == false)	return false;	//	没开启固定链接
		if(WpThemeConfig\Configurator::getInstance()->get('storage.cache-remote-image') == false)	return false;	//	没开启选项

		if($img_url){
			$exceptions	= explode("\n", WpThemeConfig\Configurator::getInstance()->get('storage.exceptions'));	// 后台设置不加载的远程图片

			if($exceptions){
				foreach ($exceptions as $exception) {
					if(trim($exception) && strpos($img_url, trim($exception)) !== false ){
						return false;
					}
				}
			}
		}

		return true;
	}

	// 获取远程图片
	function get_content_remote_img_url($img_url){
		$img_type = strtolower(pathinfo($img_url, PATHINFO_EXTENSION));
		if($img_type != 'gif'){
			$img_type	= ($img_type == 'png')?'png':'jpg';
			$img_url	= $CDN_HOST.'/'.$CDN_NAME.'/'.get_the_ID().'/image/'.md5($img_url).'.'.$img_type;
		}
		
		return $img_url;
	}

	// 通过 query string 强制刷新 CSS 和 JS
	add_filter('script_loader_src',		'cdn_loader_src',10,2);
	add_filter('style_loader_src',		'cdn_loader_src',10,2);
	function cdn_loader_src($src, $handle){
		if(get_option('timestamp')){
			$src = remove_query_arg(array('ver'), $src);
			$src = add_query_arg('ver',get_option('timestamp'),$src);
		}
		return $src;		
	}

	add_filter('wp_resource_hints', function ($urls, $relation_type){
		if($CDN_NAME && $relation_type == 'dns-prefetch' && defined('$CDN_HOST')){
			$urls[]	= $CDN_HOST;
		}

		return $urls;
	}, 10, 2);

	add_action('wp_loaded', function (){
		global $CDN_NAME;
		if($CDN_NAME == '')
			return;
	
		add_filter('pre_option_thumbnail_size_w',	'__return_zero');
		add_filter('pre_option_thumbnail_size_h',	'__return_zero');
		add_filter('pre_option_medium_size_w',		'__return_zero');
		add_filter('pre_option_medium_size_h',		'__return_zero');
		add_filter('pre_option_large_size_w',		'__return_zero');
		add_filter('pre_option_large_size_h',		'__return_zero');
	
		add_filter('intermediate_image_sizes_advanced', function($sizes){
			if(isset($sizes['full'])){
				return ['full'=>$sizes['full']];
			}else{
				return [];
			}
		});
	
		add_filter('image_size_names_choose', function($sizes){
			if(isset($sizes['full'])){
				return ['full'=>$sizes['full']];
			}else{
				return [];
			}
		});
	
		// add_filter('upload_dir', function($uploads){
		// 	$uploads['url']		= wpjam_get_thumbnail($uploads['url']);
		// 	$uploads['baseurl']	= wpjam_get_thumbnail($uploads['baseurl']);
		// 	return $uploads;
		// });
	
		add_filter('wp_calculate_image_srcset_meta', '__return_empty_array');
	
		// add_filter('image_downsize', '__return_true');
		// add_filter('wp_get_attachment_image_src', function($image, $attachment_id, $size, $icon){
		// 	return  wpjam_get_attachment_image_src($attachment_id, $size);
		// }, 10 ,4);
	
		// add_filter('wp_prepare_attachment_for_js', function($response, $attachment, $meta){
		// 	if(isset($response['sizes'])){
		// 		$orientation	= $response['sizes']['full']['orientation'];
	
		// 		foreach (array('thumbnail', 'medium', 'medium_large', 'large') as $s) {
		// 			$image_src = wpjam_get_attachment_image_src($attachment->ID, $s);
	
		// 			$response['sizes'][$s]	= array(
		// 				'url'			=> $image_src[0],
		// 				'width'			=> $image_src[1],
		// 				'height'		=> $image_src[2],
		// 				'orientation'	=> $orientation
		// 			);
		// 		}
		// 	}
	
		// 	return $response;
		// }, 10, 3);
	}, 11);
};