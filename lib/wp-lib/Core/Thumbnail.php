<?php

namespace Lib\Core;

class Thumbnail{

    public function __construct(){

    }

    public static function get_attachment_url_by_id($image_id, $size='full'){
        if($thumb = wp_get_attachment_image_src($image_id, $size)){
            return $thumb[0];
        }
        return false;
    }

    /**
     * 获取内容段中第一张图片
     * @example Lib\Thumbnail::get_post_first_image(get_post(1)->post_content);
     */
    public static function get_post_first_image($post_content='', $size='full'){
        if(!$post_content){
            $the_post		= get_post();
            $post_content	= $the_post->post_content;
        }
    
        // preg_match_all( '/class=[\'"].*?wp-image-([\d]*)[\'"]/i', $post_content, $matches );
        // if( $matches && isset($matches[1]) && isset($matches[1][0]) ){	
        //     $image_id = $matches[1][0];
        //     if($image_url = Thumbnail::get_post_image_url_by_id($image_id, $size)){
        //         return $image_url;
        //     }
        // }
    
        preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', do_shortcode($post_content), $matches);
        if( $matches && isset($matches[1]) && isset($matches[1][0]) ){	   
            return $matches[1][0];
        }
            
        return false;
    }

    /**
     * 获取文章内所有图片
     * @example Lib\Thumbnail::get_post_images(get_post(1)->post_content);
     */
    public static function get_post_images($post_content='', $size='full'){
        if(!$post_content){
            $the_post		= get_post();
            $post_content	= $the_post->post_content;
        }
    
        preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', do_shortcode($post_content), $matches);

        if( $matches && isset($matches[1]) ){	   
            return $matches[1];
        }
            
        return false;
    }

    public static function get_content_images($content, $width=750, $strip_size=true){
        return preg_replace_callback('|<img.*?src=[\'"](.*?)[\'"].*?>|i',function($matches) use ($width, $strip_size){
            $img_url	= wpjam_get_thumbnail(trim($matches[1]), array('width'=>$width, 'content'=>true));
    
            $result		= str_replace($matches[1], $img_url, $matches[0]);
    
            if($strip_size){
                $result	= preg_replace('|width=[\'"](.*?)[\'"]|i', '', $result);
                $result	= preg_replace('|height=[\'"](.*?)[\'"]|i', '', $result);
            }
                
            return $result;
        }, $content);
    }

    /**
     * 获取分类缩略图
     */
    public function get_thumbnail_uri_by_category($post){

    }

    /**
     * 文章类型缩略图
     */
    public function get_thumbnail_uri_by_post_type($post){
        $post_type = $post->post_type;
        $attachment_id = tr_options_field('module_'.$post_type.'_options.thumb');
        return wp_get_attachment_image_src( $attachment_id, full )[0];
    }

    /**
     * 默认缩略图
     */
    public function get_default_thumbnail_uri(){
        $default_thumbnail = get_template_directory_uri() .'/static/public/images/placehold.png';
        return $default_thumbnail;
    }

    /**
     * 获取文章缩略图
     * 缩略图获取顺序为：特色图像->文章第一张图片->分类缩略图->标签缩略图->文章类型缩略图->默认缩略图
     */
    public static function get_post_thumbnail_uri($post=null, $size='full'){
        $post = get_post($post);
	    if(!$post)	return false;
	
        $post_id = $post->ID;

        $thumbnail_image_url ='';
        
        if(has_post_thumbnail($post_id)){
            $thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size )[0];
        } elseif(self::get_post_first_image($post->post_content)){
            $thumbnail_image_url = self::get_post_first_image($post->post_content);
        } elseif(self::get_thumbnail_uri_by_post_type($post)){
            $thumbnail_image_url = self::get_thumbnail_uri_by_post_type($post);
        } else{
            $thumbnail_image_url = self::get_default_thumbnail_uri();
        }
        return $thumbnail_image_url;
    }

}