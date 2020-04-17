<?php

// Register Post Type
$service = tr_post_type(__('服务','BT_TEXTDOMAIN'), __('服务','BT_TEXTDOMAIN'));
$service->setId('service');
$service->setArgument('supports', ['title','editor','thumbnail','excerpt','page-attributes'] );

// disable archive page
$service->setArgument('has_archive', false);

// Chain Methods with Eloquence
$service->setIcon('hour-glass');

$service->addColumn('thumbnail', false, __('Image'), function($id) {
	$post_thumbnail_id = get_post_thumbnail_id( $id );
    echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', '', array( "style" => "display:block;max-height:40px;width:auto;" ));
}, 'number');

// REST API
$service->setRest('service');

// Add Module Setting Page
if(in_array('plugin-module-options',\TypeRocket\Core\Config::locate('typerocket.plugins'))){
	add_action('typerocket_loaded', [new \TypeRocketModuleOptions\Plugin('service')]);
}