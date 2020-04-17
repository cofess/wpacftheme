<?php

if ( ! defined( 'ABSPATH' ) ) { die; } 

// Add default posts and comments RSS feed links to head.
add_theme_support( 'automatic-feed-links' );

// WordPress 4.1 就添加了新的方法在主题中显示标题，取代之前的 wp_title() 函数用法
add_theme_support( 'title-tag' );

// enable menu
add_theme_support( 'menus' );

// 特色图像
add_theme_support( 'post-thumbnails', array( 'post','download','project','video','topic' ) );
/*
 * Enable support for Post Thumbnails on posts and pages.
 */
// add_theme_support( 'post-thumbnails' );
// set_post_thumbnail_size( 825, 510, true );

// 文章格式
add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support( 'html5', array(
    'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
) );

// custom-background
$args = array(
    'default-color' => '000000',
    'default-image' => '',
);
add_theme_support( 'custom-background', $args );
   
// custom-header
$args = array(
    'flex-width'    => true,
    'width'         => 980,
    'flex-height'    => true,
    'height'        => 200,
    'default-image' => '',
);
add_theme_support( 'custom-header', $args );