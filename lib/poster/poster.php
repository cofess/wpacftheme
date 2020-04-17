<?php
add_action('wp_ajax_nopriv_create-bigger-image', 'get_bigger_img');
add_action('wp_ajax_create-bigger-image', 'get_bigger_img');

/** 画圆角
 * @param $radius 圆角位置
 * @param $color_r 色值0-255
 * @param $color_g 色值0-255
 * @param $color_b 色值0-255
 * @return resource 返回圆角
 */
function get_lt_rounder_corner($radius, $color_r, $color_g, $color_b){
    // 创建一个正方形的图像
    $img = imagecreatetruecolor($radius, $radius);
    // 图像的背景
    $bgcolor = imagecolorallocate($img, $color_r, $color_g, $color_b);
    $fgcolor = imagecolorallocate($img, 0, 0, 0);
    imagefill($img, 0, 0, $bgcolor);
    // $radius,$radius：以图像的右下角开始画弧
    // $radius*2, $radius*2：已宽度、高度画弧
    // 180, 270：指定了角度的起始和结束点
    // fgcolor：指定颜色
    imagefilledarc($img, $radius, $radius, $radius * 2, $radius * 2, 180, 270, $fgcolor, IMG_ARC_PIE);
    // 将弧角图片的颜色设置为透明
    imagecolortransparent($img, $fgcolor);
    return $img;
}

/**
 * @param $im  大的背景图，也是我们的画板
 * @param $lt_corner 我们画的圆角
 * @param $radius  圆角的程度
 * @param $image_h 图片的高
 * @param $image_w 图片的宽
 */
function myradus($im, $left, $top, $lt_corner, $radius, $image_h, $image_w){
/// lt(左上角)
    imagecopymerge($im, $lt_corner, $left, $top, 0, 0, $radius, $radius, 100);
// lb(左下角)
    $lb_corner = imagerotate($lt_corner, 90, 0);
    imagecopymerge($im, $lb_corner, $left, $image_h - $radius + $top, 0, 0, $radius, $radius, 100);
// rb(右上角)
    $rb_corner = imagerotate($lt_corner, 180, 0);
    imagecopymerge($im, $rb_corner, $image_w + $left - $radius, $image_h + $top - $radius, 0, 0, $radius, $radius, 100);
// rt(右下角)
    $rt_corner = imagerotate($lt_corner, 270, 0);
    imagecopymerge($im, $rt_corner, $image_w - $radius + $left, $top, 0, 0, $radius, $radius, 100);
}

// 输出缩略图地址
function post_thumbnail_src($post = null) {
	if ($post === null) {
		global $post;
	} 

	if (has_post_thumbnail($post)) {
		// 如果有特色缩略图，则输出缩略图地址
		$post_thumbnail_src = get_post_thumbnail_id($post -> ID);
	} else {
		$post_thumbnail_src = '';
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if (!empty($matches[1][0])) {
			global $wpdb;
			$att = $wpdb->get_row($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid LIKE '%s'", $matches[1][0]));

			if ($att) {
				$post_thumbnail_src = $att->ID;
			} else {
				$post_thumbnail_src = $matches[1][0];
			} 
		} else {
			$post_thumbnail_src = get_template_directory_uri() . '/static/front/images/default.jpg';
		} 
	} 
	return $post_thumbnail_src;
} 

/**
 * 图像裁切
 */
function timthumb($src, $size = null, $set = null) {
	$modular = WpThemeConfig\Configurator::getInstance()->get('theme.thumbnail_handle');

	if (is_numeric($src)) {
		if ($modular == 'wpthumb') {
			$src = image_downsize($src, $size['w'] . '-' . $size['h']);
		} else {
			$src = image_downsize($src, 'full');
		} 
		$src = $src[0];
	} 

	if ($set == 'original') {
		return $src;
	} 

	if ($modular == 'timthumb' || empty($modular) || $set == 'tim') {
		return get_stylesheet_directory_uri() . '/timthumb.php?src=' . $src . '&h=' . $size["h"] . '&w=' . $size['w'] . '&zc=1&a=c&q=100&s=1';
	} else {
		return $src;
	} 
}

function substr_ext($str, $start = 0, $length, $charset = 'utf-8', $suffix = '') {
	if (function_exists('mb_substr')) {
		return mb_substr($str, $start, $length, $charset) . $suffix;
	} 
	if (function_exists('iconv_substr')) {
		return iconv_substr($str, $start, $length, $charset) . $suffix;
	} 
	$re['utf-8'] = '/[-]|[?-?][?-?]|[?-?][?-?]{2}|[?-?][?-?]{3}/';
	$re['gb2312'] = '/[-]|[?-?][?-?]/';
	$re['gbk'] = '/[-]|[?-?][@-?]/';
	$re['big5'] = '/[-]|[?-?]([@-~]|?-?])/';
	preg_match_all($re[$charset], $str, $match);
	$slice = join('', array_slice($match[0], $start, $length));
	return $slice . $suffix;
}

function mi_str_encode($string) {
	return $string;
	$len = strlen($string);
	$buf = '';
	$i = 0;
	while ($i < $len) {
		if (ord($string[$i]) <= 127) {
			$buf .= $string[$i];
		} elseif (ord($string[$i]) < 192) {
			$buf .= '&#xfffd;';
		} elseif (ord($string[$i]) < 224) {
			$buf .= sprintf('&#%d;', ord($string[$i + 0]) + ord($string[$i + 1]));
			$i = $i + 1;
			$i += 1;
		} elseif (ord($string[$i]) < 240) {
			ord($string[$i + 2]);
			$buf .= sprintf('&#%d;', ord($string[$i + 0]) + ord($string[$i + 1]) + ord($string[$i + 2]));
			$i = $i + 2;
			$i += 2;
		} else {
			ord($string[$i + 2]);
			ord($string[$i + 3]);
			$buf .= sprintf('&#%d;', ord($string[$i + 0]) + ord($string[$i + 1]) + ord($string[$i + 2]) + ord($string[$i + 3]));
			$i = $i + 3;
			$i += 3;
		} 
		$i = $i + 1;
	} 
	return $buf;
}

function draw_txt_to($card, $pos, $str, $iswrite, $font_file) {
	$_str_h = $pos['top'];
	$fontsize = $pos['fontsize'];
	$width = $pos['width'];
	$margin_lift = $pos['left'];
	$hang_size = $pos['hang_size'];
	$temp_string = '';
	$tp = 0;
	$font_color = imagecolorallocate($card, $pos['color'][0], $pos['color'][1], $pos['color'][2]);
	$i = 0;
	while ($i < mb_strlen($str)) {
		$box = imagettfbbox($fontsize, 0, $font_file, mi_str_encode($temp_string));
		$_string_length = $box[2] - $box[0];
		$temptext = mb_substr($str, $i, 1);
		$temp = imagettfbbox($fontsize, 0, $font_file, mi_str_encode($temptext));
		if ($_string_length + $temp[2] - $temp[0] < $width) {
			$temp_string .= mb_substr($str, $i, 1);
			if ($i == mb_strlen($str) - 1) {
				$_str_h = $_str_h + $hang_size;
				$_str_h += $hang_size;
				$tp = $tp + 1;
				if ($iswrite) {
					imagettftext($card, $fontsize, 0, $margin_lift, $_str_h, $font_color, $font_file, mi_str_encode($temp_string));
				} 
			} 
		} else {
			$texts = mb_substr($str, $i, 1);
			$isfuhao = preg_match('/[\\pP]/u', $texts) ? true : false;
			if ($isfuhao) {
				$temp_string .= $texts;
				$f = mb_substr($str, $i + 1, 1);
				$fh = preg_match('/[\\pP]/u', $f) ? true : false;
				if ($fh) {
					$temp_string .= $f;
					$i = $i + 1;
				} 
			} else {
				$i = $i + -1;
			} 
			$tmp_str_len = mb_strlen($temp_string);
			$s = mb_substr($temp_string, $tmp_str_len - 1, 1);
			if (is_firstfuhao($s)) {
				$temp_string = rtrim($temp_string, $s);
				$i = $i + -1;
			} 
			$_str_h = $_str_h + $hang_size;
			$_str_h += $hang_size;
			$tp = $tp + 1;
			if ($iswrite) {
				imagettftext($card, $fontsize, 0, $margin_lift, $_str_h, $font_color, $font_file, mi_str_encode($temp_string));
			} 
			$temp_string = '';
		} 
		$i = $i + 1;
	} 
	return $tp * $hang_size;
}

function is_firstfuhao($str) {
	$fuhaos = array('0' => '"', '1' => '“', '2' => '\'', '3' => '<', '4' => '《');
	return in_array($str, $fuhaos);
}

// 生成封面
function create_bigger_image($post_id, $date, $title, $content, $author_name, $author_avatar, $head_img, $qrcode_img = null) {
	$img = imagecreatetruecolor(750, 1334); //设置海报整体的宽高

	// 颜色
	$white = imagecolorallocate($img, 255, 255, 255);
	$silver = imagecolorallocate($img, 246, 246, 246);
	$lightgray = imagecolorallocate($img, 200, 200, 200);
	$gray = imagecolorallocate($img, 119, 119, 119);
	$darkgray = imagecolorallocate($img, 51, 51, 51);
	$black = imagecolorallocate($img, 0, 0, 0);
	$title_text_color = imagecolorallocate($img, 51, 51, 51);

	// 字体
	$english_font = get_template_directory() . '/static/public/fonts/Montserrat-Regular.ttf';
	$chinese_font = get_template_directory() . '/static/public/fonts/FZHTK.TTF';
	$chinese_font_2 = get_template_directory() . '/static/public/fonts/FZHTK.TTF';

	// 白色填充画布
	imagefill($img, 0, 0, $white);
	// 在画布底部绘制矩形
	imagefilledrectangle($img, 0, 1134, 750, 1334, $silver);

	$head_img = imagecreatefromstring(file_get_contents(timthumb($head_img, array('w' => 750, 'h' => '675'), 'tim')));
	imagecopy($img, $head_img, 0, 0, 0, 0, 750, 675);
	$day = $date['day'];
	$day_width = imagettfbbox(85, 0, $english_font, $day);
	$day_width = abs($day_width[2] - $day_width[0]);
	$year = $date['year'].'/'.$date['month'];
	$year_width = imagettfbbox(24, 0, $english_font, $year);
	$year_width = abs($year_width[2] - $year_width[0]);
	$day_left = ($year_width - $day_width) / 2;
	imagettftext($img, 80, 0, 50 + $day_left, 575, $white, $english_font, $day);
	imageline($img, 50, 590, 50 + $year_width, 590, $white);
	imagettftext($img, 24, 0, 50, 625, $white, $english_font, $year);
	$title = mi_str_encode($title);
	$title_width = imagettfbbox(28, 0, $chinese_font, $title);
	$title_width = abs($title_width[2] - $title_width[0]);
	$title_left = 350 - $title_width / 2;
	// imagettftext($img, 28, 0, $title_left, 830, $black, $chinese_font, $title);
	imagettftext($img, 28, 0, 50, 800, $black, $chinese_font, $title);
	$conf = array(
		'color' => array('0' => 99, '1' => 99, '2' => 99), 
		'fontsize' => 20, 
		'width' => 650, 
		'left' => 50,
		'top' => 850,
		'hang_size' => 24
	);
	draw_txt_to($img, $conf, $content, true, $chinese_font_2);
	// $style = array();
	// imagesetstyle($img, $style);
	imageline($img, 0, 1136, 750, 1136, IMG_COLOR_STYLED);
	// if(strpos($author_avatar,'.png') == false && strpos($author_avatar,'.jpg') == false){
	// 	$author_avatar = $author_avatar.'.png';
	// }
	// $author_avatar = imagecreatefromjpeg($author_avatar);
	$author_avatar = imagecreatefromstring(file_get_contents($author_avatar));
	$foot_text = $author_name;
	$foot_text2 = $date['year'].'-'.$date['month'].'-'.$date['day'];
	if ($qrcode_img) {
		imagecopyresized($img, $author_avatar, 50, 1200, 0, 0, 64, 64, 80, 80);
		// 头像添加圆角
		$radius = 32;
		$lt_corner = get_lt_rounder_corner($radius, '246', '246', '246');
		//圆角的背景色
		myradus($img, 50, 1200, $lt_corner, $radius, 64, 64);
		imagettftext($img, 22, 0, 130, 1220, $darkgray, $chinese_font_2, $foot_text);
		imagettftext($img, 16, 0, 130, 1260, $gray, $chinese_font_2, $foot_text2);
		$qrcode_str = file_get_contents($qrcode_img);
		$qrcode_size = getimagesizefromstring($qrcode_str);
		$qrcode_img = imagecreatefromstring($qrcode_str);
		imagecopyresized($img, $qrcode_img, 580, 1174, 0, 0, 120, 120, $qrcode_size[0], $qrcode_size[1]);
	} else {
		imagecopyresized($img, $author_avatar, 636, 1200, 0, 0, 64, 64, 80, 80);
		// 头像添加圆角
		$radius = 32;
		$lt_corner = get_lt_rounder_corner($radius, '246', '246', '246');
		//圆角的背景色
		myradus($img, 636, 1200, $lt_corner, $radius, 64, 64);
		imagettftext($img, 22, 0, 50, 1220, $darkgray, $chinese_font_2, $foot_text);
		imagettftext($img, 16, 0, 50, 1260, $gray, $chinese_font_2, $foot_text2);
		// $foot_text_width = imagettfbbox(22, 0, $chinese_font, $foot_text);
		// $foot_text_width = abs($foot_text_width[2] - $foot_text_width[0]);
		// $foot_text_left = 750 - 64 - 50 - $foot_text_width / 2;
		// imagettftext($img, 22, 0, $foot_text_left, 1220, $darkgray, $chinese_font_2, $foot_text);

		// $foot_text2_width = imagettfbbox(16, 0, $chinese_font, $foot_text2);
		// $foot_text2_width = abs($foot_text2_width[2] - $foot_text2_width[0]);
		// $foot_text2_left = 750 - 64 - 50 - $foot_text2_width / 2;
		// imagettftext($img, 16, 0, $foot_text2_left, 1260, $gray, $chinese_font_2, $foot_text2);
	} 
	$upload_dir = wp_upload_dir();
	$filename = '/bigger-' . uniqid() . '.png';
	$file = $upload_dir['path'] . $filename;
	imagepng($img, $file);
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	$src = media_sideload_image($upload_dir['url'] . $filename, $post_id, null, 'src');
	unlink($file);
	error_reporting(0);
	imagedestroy($img);
	if (is_wp_error($src)) {
		return false;
	} 
	return $src;
}

function get_bigger_img() {
	$post_id = sanitize_text_field($_POST['id']);
	if (wp_verify_nonce($_POST['nonce'], 'mi-create-bigger-image-' . $post_id)) {
		$date = array('day' => get_the_time('d', $post_id), 'month' => get_the_time('m', $post_id), 'year' => get_the_time('Y', $post_id));
		// $post_extend = get_post_meta($post_id, 'post_extend', true);
		// $post_extend = wp_parse_args((array)$xz_data[$xz_k], array('bigger_head_img' => '', 'bigger_title' => '', 'bigger_desc' => ''));
		$title = get_the_title($post_id);
		$share_title = get_the_title($post_id);
		$title = substr_ext($title, 0, 20, 'utf-8', '');
		$post = get_post($post_id);

		// 文章摘要
		$content = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
		$content = substr_ext(strip_tags(strip_shortcodes($content)), 0, 100, 'utf-8', '...');
		$share_content = '【' . $share_title . '】' . substr_ext(strip_tags(strip_shortcodes($content)), 0, 80, 'utf-8', '');
		$content = str_replace(PHP_EOL, '', strip_tags(apply_filters('the_excerpt', $content)));

		// 特色图像
		$head_img = post_thumbnail_src($post ? $post : get_post($post_id));
		$att = wp_get_attachment_image_src($head_img, 'full');
		$head_img = $att[0];

		// Get author's display name
		$author_name = get_the_author_meta( 'display_name', $post->post_author );
		if ( empty( $author_name ) ){
			$author_name = get_the_author_meta( 'nickname', $post->post_author );
		}

		// 用户头像
		$author_avatar = get_avatar_url( get_the_author_meta( 'user_email', $post->post_author ) , array('size' => 80) );

		// 二维码
		if (WpThemeConfig\Configurator::getInstance()->get('theme.share_bigger_img_qrcode')) {
			$qrcode_img = POSTER_URI . '/share/qrcode.php?data=' . get_the_permalink($post_id);
		} else {
			$qrcode_img = null;
		}

		$result = create_bigger_image($post_id, $date, $title, $content, $author_name, $author_avatar, $head_img, $qrcode_img);
		if ($result) {
			$pic = '&pic=' . urlencode($result);
			if (get_post_meta($post_id, 'bigger_cover', true)) {
				update_post_meta($post_id, 'bigger_cover', $result);
			} else {
				add_post_meta($post_id, 'bigger_cover', $result);
			} 
			$share_link = sprintf('https://service.weibo.com/share/share.php?url=%s&type=button&language=zh_cn&searchPic=true%s&title=%s', urlencode(get_the_permalink($post_id)), $pic, $share_content);
			if (get_post_meta($post_id, 'bigger_cover_share', true)) {
				update_post_meta($post_id, 'bigger_cover_share', $share_link);
			} else {
				add_post_meta($post_id, 'bigger_cover_share', $share_link);
			} 
			$msg = array('s' => 200, 'src' => $result, 'share' => $share_link);
		} else {
			$msg = array('s' => 404, 'm' => 'ERROR:404,封面生成失败，请稍后再试！');
		} 
	} else {
		$msg = array('s' => 404, 'm' => 'ERROR:404,图片消失啦~请联系管理员解决此问题！');
	} 
	echo json_encode($msg);
	exit(0);
} 
