<?php
namespace Lib\Core;
use Lib\Util\Help;

class Post{

	public $post;

	public function __construct(\WP_Post $post){
		$this->post = $post;
	}

	public function title(){
		return $this->post->post_title;
	}
	
	public function permalink(){
		return get_permalink($this->post);
	}

	static function getPostTypes($args = [], $field = false, $operator = 'and'){
        global $wp_post_types;
        return wp_filter_object_list($wp_post_types, $args, $operator, $field);
    }

    static function getPosTaxonomies($postName = "", $field = false, $operator = 'and'){
        global $wp_taxonomies;
        return wp_filter_object_list($wp_taxonomies, ['object_type' => [$postName]], $operator, $field);
    }

  	//获取日志摘要
	public static function get_post_excerpt($post=null, $excerpt_length=240){
		$post = get_post($post);
		if(empty($post)) return '';

		$post_excerpt = $post->post_excerpt;
		if($post_excerpt == ''){
			$post_content   = strip_shortcodes($post->post_content);
			//$post_content = apply_filters('the_content',$post_content);
			$post_content   = wp_strip_all_tags( $post_content );
			$excerpt_length = apply_filters('excerpt_length', $excerpt_length);	 
			$excerpt_more   = apply_filters('excerpt_more', ' ' . '...');
			$post_excerpt   = Help::get_first_p($post_content); // 获取第一段
			if(mb_strwidth($post_excerpt) < $excerpt_length*1/3 || mb_strwidth($post_excerpt) > $excerpt_length){ // 如果第一段太短或者太长，就获取内容的前 $excerpt_length 字
				$post_excerpt = mb_strimwidth($post_content,0,$excerpt_length,$excerpt_more,'utf-8');
			}
		}else{
			$post_excerpt = wp_strip_all_tags( $post_excerpt );	
		}
		
		$post_excerpt = trim( preg_replace( "/[\n\r\t ]+/", ' ', $post_excerpt ), ' ' );

		return $post_excerpt;
	}

	/**
     * Show Posts related to current Author only
     */
    function showOnlyRelatedPosts($wp_query){
        global $current_user;
        if (is_admin() && !current_user_can('edit_others_posts')) {
            $wp_query->set('author', $current_user->ID);
        }
	}
	
	public function terms($termId){
		if(is_a($termId, '\Lib\Core\Taxanomy'))
		  $termId = $termId->id;
	
		$terms = wp_get_post_terms($this->post->ID, $termId, [
		  'orderby'  => 'name',
		  'order'    => 'ASC'
		]);
	
		return array_map(function($term){
		  return new \Lib\Core\Term($term);
		}, $terms);
	}
}
