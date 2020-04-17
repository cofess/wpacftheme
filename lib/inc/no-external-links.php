<?php

if (! defined('ABSPATH')) {
	die;
} 

/**
 * 外链转内链接，链接加密
https://boke112.com/3550.html
 */
// 文章外链跳转伪静态版，链接加密，改进版
add_filter('the_content', 'external_link_jump', 999);
function external_link_jump($content) {
	preg_match_all('/<a(.*?)href="(.*?)"(.*?)>/', $content, $matches);
	if ($matches) {
		foreach($matches[2] as $val) {
			if (strpos($val, '://') !== false && strpos($val, home_url()) === false && !preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff)/i', $val) && !preg_match('/(ed2k|thunder|Flashget|flashget|qqdl):\/\//i', $val)) {
				$content = str_replace("href=\"$val\"", "href=\"" . get_template_directory_uri() . "/go/?url=" . base64_encode($val) . "\"", $content);
			} 
		} 
	} 
	return $content;
} 
/**
 * 评论作者链接新窗口打开，外链转内链接，链接加密
 * https://zhang.ge/4683.html
 * https://github.com/dipakcg/wp-open-comment-links-in-new-window
 */
function open_link_in_new_window($url) {
	$return_url = str_replace('<a', '<a target="_blank"', $url); 
	// 字符串URL正则
	$regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
	preg_match($regex, $return_url, $matches);
	if ($matches) {
		$link = $matches[0];
		$return_url = preg_replace($regex, get_template_directory_uri() . "/go/?url=" . base64_encode($link), $return_url);
	} 
	return $return_url;
} 
add_filter('get_comment_author_link', 'open_link_in_new_window');
add_filter('comment_text', 'open_link_in_new_window');
// 下载外链跳转
function links_nofollow($url) {
	if (strpos($url, '://') !== false && strpos($url, home_url()) === false && !preg_match('/(ed2k|thunder|Flashget|flashget|qqdl):\/\//i', $url)) {
		$url = str_replace($url, get_template_directory_uri() . "/go/?url=" . base64_encode($url), $url);
	} 
	return $url;
} 
// 网址跳转
function sites_nofollow($url) {
	$url = str_replace($url, get_template_directory_uri() . "/go/?url=" . base64_encode($url), $url);
	return $url;
} 
