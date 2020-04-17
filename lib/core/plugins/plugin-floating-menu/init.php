<?php
if ( ! defined( 'ABSPATH' ) ) { die; } 

require_once __DIR__ . '/plugin.php';

add_action( 'typerocket_loaded', [new \TypeRocketFloatingMenu\Plugin()]);