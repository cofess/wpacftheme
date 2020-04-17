<?php

namespace Lib\Util;

class Path{

	/**
	 * 创建文件目录
	 * http://stackoverflow.com/questions/2303372/create-a-folder-if-it-doesnt-already-exist
	 * @param dirpath 文件目录
	 * @param $mode   目录权限
	 * @example create_dir(WP_CONTENT_DIR.'/cache/timthumb/',0777)
	 */
	public static function create_dir($dirpath,$mode=0777){
		if (!file_exists($dirpath)) {
			mkdir($dirpath, $mode, true);
		}
	}

  /**
	 * Get Current Url
	 *
	 * Returns the url of the page you are currently on
	 *
	 * @return string
	 */
	public static function get_current_url() {
		$prefix = is_ssl() ? "https://" : "http://";
		$current_url = $prefix . $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ];

		return $current_url;
  }

  // 获取当前页面 url
  public static function get_current_page_url(){
		$ssl		= (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? true:false;
		$sp			= strtolower($_SERVER['SERVER_PROTOCOL']);
		$protocol	= substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
		$port		= $_SERVER['SERVER_PORT'];
		$port		= ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
		$host		= isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		return $protocol . '://' . $host . $port . $_SERVER['REQUEST_URI'];
	}
  
  /**
   * get path url
   * 
   * 返回文件目录url路径
   */
  public static function get_path_url($path) {
    if( empty($path) ){
      return;
    }
    $dir_url = get_template_directory_uri() . str_replace(wp_normalize_path(get_template_directory()),'',wp_normalize_path($path));
    return $dir_url;
  }

}
