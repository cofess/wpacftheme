<?php
function wpjam_initial_constants(){
	// 定义CDN和本地域名网址
	define('CDN_HOST',		untrailingslashit(WpThemeConfig\Configurator::getInstance()->get('storage.host') ?: get_option('home')));
	define('LOCAL_HOST',	untrailingslashit(WpThemeConfig\Configurator::getInstance()->get('storage.local-host') ?: get_option('home')));

	if(strpos('https://', LOCAL_HOST) !== false){
		define('LOCAL_HOST2',	str_replace('https://', 'http://', LOCAL_HOST));
	}else{
		define('LOCAL_HOST2',	str_replace('http://', 'https://', LOCAL_HOST));
	}

	define('CDN_NAME',	WpThemeConfig\Configurator::getInstance()->get('storage.cdn-server') ?: '');	// CDN 名称

	if(CDN_NAME){
		include(WP_THEME_CONFIG_INCLUDE_DIR.'/cdn/'.CDN_NAME.'.php');
	}
}
add_action('wp_loaded', 'wpjam_initial_constants');

function wpjam_get_term($term, $taxonomy, $children_terms=[], $max_depth=-1, $depth=0){
	if($max_depth == -1){
		return WPJAM_TaxonomySetting::parse_for_json($term, $taxonomy);
	}else{
		$term	= WPJAM_TaxonomySetting::parse_for_json($term, $taxonomy);
		if(is_wp_error($term)){
			return $term;
		}

		$term['children'] = [];

		if($children_terms){
			if(($max_depth == 0 || $max_depth > $depth+1 ) && isset($children_terms[$term['id']])){
				foreach($children_terms[$term['id']] as $child){
					$term['children'][]	= wpjam_get_term($child, $taxonomy, $children_terms, $max_depth, $depth + 1);
				}
				unset($children_terms[$term['id']]);
			} 
		}

		return $term;
	}
}

/**
 * $max_depth = -1 means flatly display every element.
 * $max_depth = 0 means display all levels.
 * $max_depth > 0 specifies the number of display levels.
 *
 */
function wpjam_get_terms($args, $max_depth=-1){
	if(wpjam_is_assoc_array($args)){
		$taxonomy	= $args['taxonomy'];

		$parent		= 0;
		if(isset($args['parent']) && ($max_depth != -1 && $max_depth != 1)){
			$parent		= $args['parent'];
			unset($args['parent']);
		}

		if($terms = get_terms($args)){
			if($max_depth == -1){
				array_walk($terms, function(&$term) use ($taxonomy){
					$term = wpjam_get_term($term, $taxonomy); 

					if(is_wp_error($term)){
						wpjam_send_json($term);
					}
				});
			}else{
				$top_level_terms	= [];
				$children_terms		= [];

				foreach($terms as $term){
					if(empty($term->parent)){
						if($parent){
							if($term->term_id == $parent){
								$top_level_terms[] = $term;
							}
						}else{
							$top_level_terms[] = $term;
						}
					}else{
						$children_terms[$term->parent][] = $term;
					}
				}

				if($terms = $top_level_terms){
					array_walk($terms, function(&$term) use ($taxonomy, $children_terms, $max_depth){
						$term = wpjam_get_term($term, $taxonomy, $children_terms, $max_depth, 0); 

						if(is_wp_error($term)){
							wpjam_send_json($term);
						}
					});
				}
			}
		}
	}else{
		// 以后再处理
	}

	return $terms;
}	

function is_wpjam_json($json=''){
	global $wpjam_json;

	$wpjam_json	= ($wpjam_json)??'';

	if($wpjam_json){
		if($json){
			return ($wpjam_json == $json);
		}else{
			return $wpjam_json;
		}
	}else{
		return false;
	}
}

function wpjam_get_json(){
	global $wpjam_json;

	return $wpjam_json;
}

// WP_Query 缓存
function wpjam_query($args=[], $cache_time='600'){
	return WPJAM_Cache::query($args, $cache_time);
}

function wpjam_image_hwstring($size, $retina=false){
	$size	= wpjam_parse_size($size);
	$width	= ($retina)?intval($size['width']/2):$size['width'];
	$height	= ($retina)?intval($size['height']/2):$size['height'];
	return image_hwstring($width, $height);
}

function wpjam_parse_size($size){
	global $content_width, $_wp_additional_image_sizes;	

	if(is_array($size)){
		if(wpjam_is_assoc_array($size)){
			return $size;
		}else{
			$width	= intval($size[0]??0);
			$height	= intval($size[1]??0);
		}
	}else{
		if(strpos($size, 'x')){
			$size	= explode('x', $size);
			$width	= intval($size[0]);
			$height	= intval($size[1]);
		}elseif(is_numeric($size)){
			$width	= $size;
			$height	= 0;
		}elseif($size == 'thumb' || $size == 'thumbnail' || $size == 'post-thumbnail'){
			$width	= 
			$height = 150;
		}elseif($size == 'medium'){
			$width	= 
			$height = 300;
		}elseif($size == 'medium_large'){
			$width	= 768;
			$height	= 0;
		}elseif($size == 'large'){
			$width	= 1024;
			$height	= 0;
		}elseif(isset($_wp_additional_image_sizes) && isset($_wp_additional_image_sizes[$size])){
			$width	= intval($_wp_additional_image_sizes[$size]['width']);
			$height	= intval($_wp_additional_image_sizes[$size]['height']);
		}else{
			$width	= 0;
			$height	= 0;
		}
	}

	return compact('width','height');
}


// 1. $img_url 简单替换一下 CDN 域名
// 2. $img_url, array('width'=>100, 'height'=>100)	// 这个为最标准版本
// 3. $img_url, 100x100
// 4. $img_url, 100
// 5. $img_url, array(100,100)
// 6. $img_url, array(100,100), $crop=1, $retina=1
// 7. $img_url, 100, 100, $crop=1, $retina=1
function wpjam_get_thumbnail(){
	$args_num	= func_num_args();
	$args		= func_get_args();

	$img_url	= $args[0];

	if(empty($img_url))	return '';

	if(WpThemeConfig\Configurator::getInstance()->get('storage.cdn-server') == '') return $img_url;

	if($args_num == 1){
		$thumb_args = [];
	}elseif($args_num == 2){
		$thumb_args = wpjam_parse_size($args[1]);
	}else{
		if(is_numeric($args[1])){
			$width	= $args[1]??0;
			$height	= $args[2]??0;
			$crop	= $args[3]??1;
			$retina	= $args[4]??1;
		}else{
			$size	= wpjam_parse_size($args[1]);
			$width	= $size['width'];
			$height	= $size['height'];
			$crop	= $args[2]??1;
			$retina	= $args[3]??1;
		}

		$thumb_args = compact('width','height','crop','retina');
	}

	$local_hosts	= WpThemeConfig\Configurator::getInstance()->get('storage.other-host') ?: [];
	$local_hosts	= array_map('untrailingslashit', $local_hosts);
	$local_hosts	= array_merge($local_hosts, [LOCAL_HOST, LOCAL_HOST2]);
	$img_url		= str_replace($local_hosts, CDN_HOST, $img_url);

	if(strpos($img_url, CDN_HOST) === false){

		if(isset($thumb_args['content']) && wpjam_cdn_can_remote_image($img_url)){
			$img_url	= get_content_remote_img_url($img_url);
		}
	}
	

	return apply_filters('wpjam_thumbnail', $img_url, $thumb_args);
}

function wpjam_get_attachment_image_src($attachment_id, $size='full'){
	$img_url 	= wp_get_attachment_url($attachment_id);

	if(empty($img_url)){
		return ['', 0, 0, false];
	}

	$image_meta		= wp_get_attachment_metadata($attachment_id);
	$meta_width		= $image_meta['width']??0;
	$meta_height	= $image_meta['height']??0;

	$size		= wpjam_parse_size($size);

	if($size['width'] || $size['height']){
		$img_url	= wpjam_get_thumbnail($img_url, $size);

		$width		= min($size['width'], $meta_width);
		$height		= min($size['height'], $meta_height);

		$height		= $height?:intval($meta_height/$meta_width)*$width;

		return [$img_url, $width, $height, false];
	}else{
		$img_url	= wpjam_get_thumbnail($img_url);

		return [$img_url, $meta_width, $meta_height, false];
	}
}

// 判断一个数组是关联数组，还是顺序数组
function wpjam_is_assoc_array(array $arr){
	if ([] === $arr) return false;
	return array_keys($arr) !== range(0, count($arr) - 1);
}

