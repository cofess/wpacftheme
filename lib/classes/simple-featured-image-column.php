<?php
/**
 * Plugin Name: Simple Featured Image Column
 * Plugin URI: https://github.com/dedevillela/Simple-Featured-Image-Column/
 * Description: A simple plugin that displays the "Featured Image" column in admin post type listing. Supports Post, Pages and Custom Posts.
 * Version: 1.0.8
 * Author: Andre Aguiar Villela
 * Author URI: https://dedevillela.com/
 * License: GPLv2+
 **/

  if (!defined('ABSPATH') || preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) {
  	die("Hey, dude! What are you doing here?");
  }

  if (!class_exists('Simple_Featured_Image_Column')) {

	class Simple_Featured_Image_Column {

		public function __construct() {
			add_action('admin_init', array($this, 'init'));
		}

		public function init() {

			$post_types = apply_filters('Simple_Featured_Image_Column_post_types', get_post_types(array('public' => true)));
			if (empty($post_types)) {
				return;
			}

			// add_action('admin_head', function() { 
			// 	echo '<style>th#featured-image  { width: 100px; }</style>'."\r\n"; 
			// });
			
			foreach ($post_types as $post_type) {
				if (!post_type_supports($post_type, 'thumbnail')) {
					continue;
				}
				add_filter("manage_{$post_type}_posts_columns", array($this, 'columns'));
				add_action("manage_{$post_type}_posts_custom_column", array($this, 'column_data'), 10, 2);
			}
		}

		public function columns($columns) {
			
			if (!is_array($columns)) {
				$columns = array();
			}
			$new = array();
			foreach ($columns as $key => $title){
				if ($key == 'title') {
					$new['image'] = __('Image');
				}
				$new[$key] = $title;
			}
			return $new;
		}

		public function column_data($column_name, $post_id) {
			
			if ('image' != $column_name) {
				return;
			}
			$style = 'display: block; max-height: 40px; width: auto;';
			$style = apply_filters('Simple_Featured_Image_Column_image_style', $style);

			// 获取内容段中第一张图片
			$the_post = get_post($post_id);
			$post_content = $the_post->post_content;
			preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', do_shortcode($post_content), $matches);

			if(has_post_thumbnail($post_id)){
	            $thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'thumbnail')[0];
	        } elseif($matches && isset($matches[1]) && isset($matches[1][0])){
	            $thumbnail_image_url = $matches[1][0];
	        } else{
	            $thumbnail_image_url = esc_url(get_template_directory_uri().'/static/public/images/default.png');
	        }
	        $thumbnail_image_url = get_bloginfo("template_url").'/timthumb.php?src='.$thumbnail_image_url.'&h=150&w=150&zc=1';
	        echo '<img style="'.$style.'" src="'.$thumbnail_image_url.'" />';

			// if (has_post_thumbnail($post_id)) {
			// 	$size = 'thumbnail';
			// 	echo get_the_post_thumbnail($post_id, $size, 'style='.$style);
			// } elseif ($matches && isset($matches[1]) && isset($matches[1][0])) {
			// 	echo '<img style="'.$style.'" src="'.$matches[1][0].'" />';
			// } else {
			// 	echo '<img style="'.$style.'" src="'.esc_url(get_template_directory_uri().'/static/public/images/default.png').'" />';
			// }	
		}
	}
	$featured_image_column = new Simple_Featured_Image_Column;
};
