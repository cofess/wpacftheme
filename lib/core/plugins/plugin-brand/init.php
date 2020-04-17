<?php
if ( ! defined( 'ABSPATH' ) ) { die; } 

require_once __DIR__ . '/plugin.php';
require_once __DIR__ . '/menu.php';

$config = \TypeRocket\Core\Config::locate('typerocket.plugin-brand.post-types');

if($config && in_array('office',$config)){
    require_once __DIR__ . '/post-type/office-post-type.php';
    require_once __DIR__ . '/post-type/office_category_menu.php';
}

if($config && in_array('person',$config)){
    require_once __DIR__ . '/post-type/person-post-type.php';
    require_once __DIR__ . '/post-type/person_category_menu.php';
}

if($config && in_array('gallery',$config)){
    require_once __DIR__ . '/post-type/gallery-post-type.php';
    require_once __DIR__ . '/post-type/gallery_category_menu.php';
}

if($config && in_array('job',$config)){
    require_once __DIR__ . '/post-type/job-post-type.php';
}