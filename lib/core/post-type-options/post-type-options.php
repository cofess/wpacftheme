<?php

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { die; } 

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
	add_action( 'typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('post','category')]);
}