<?php
/**
 * no_category_base
 */
add_filter('pre_option_category_base',function($value){
	return '.';
});

//设置 headers
// add_action('send_headers', function ($wp){
// 	header( 'Access-Control-Allow-Origin: *' );
// 	header( 'Access-Control-Allow-Methods: GET, POST' );
// 	header( 'Access-Control-Allow-Credentials: true' );
// 	header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
// 	header( 'Vary: Origin' );
// });