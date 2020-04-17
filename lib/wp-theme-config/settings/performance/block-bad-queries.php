<?php

/**
 * 阻止非法访问
 */

return function($value)
{
	add_action('init', 'block_bad_queries');
	function block_bad_queries()
	{
		if (is_admin()) {
			return;
		}
		//if(strlen($_SERVER['REQUEST_URI']) > 255 ||
		if (
			strpos($_SERVER['REQUEST_URI'], "eval(") ||
			strpos($_SERVER['REQUEST_URI'], "base64") ||
			strpos($_SERVER['REQUEST_URI'], "/**/")
		) {
			@header("HTTP/1.1 414 Request-URI Too Long");
			@header("Status: 414 Request-URI Too Long");
			@header("Connection: Close");
			@exit;
		}
	}
};
