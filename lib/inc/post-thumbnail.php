<?php

/* Cannot access pages directly  */ 
if ( ! defined( 'ABSPATH' ) ) { die; }

/**
 * https://wordpress.stackexchange.com/questions/181877/generate-thumbnails-only-for-featured-images
 * This function will generate an image by temporarily registering an image size, generating the image (if necessary) and the removing the size so new images will not be created in that size.
 */
function lazy_image_size($image_id, $width, $height, $crop) {
    // Temporarily create an image size
    $size_id = 'lazy_' . $width . 'x' .$height . '_' . ((string) $crop);
    add_image_size($size_id, $width, $height, $crop);

    // Get the attachment data
    $meta = wp_get_attachment_metadata($image_id);

    // If the size does not exist
    if(!isset($meta['sizes'][$size_id])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $file = get_attached_file($image_id);
        $new_meta = wp_generate_attachment_metadata($image_id, $file);

        // Merge the sizes so we don't lose already generated sizes
        $new_meta['sizes'] = array_merge($meta['sizes'], $new_meta['sizes']);

        // Update the meta data
        wp_update_attachment_metadata($image_id, $new_meta);
    }

    // Fetch the sized image
    $sized = wp_get_attachment_image_src($image_id, $size_id);

    // Remove the image size so new images won't be created in this size automatically
    remove_image_size($size_id);
    return $sized;
}

/**
 * replace the original image with the the re-sized version.
 * https://stackoverflow.com/questions/21612154/automatically-resize-wordpress-images-to-a-maximum-width-and-height-upon-uploadi
 */
function replace_uploaded_image($image_data) {
    // if there is no large image : return
    if (!isset($image_data['sizes']['large'])) return $image_data;

    // paths to the uploaded image and the large image
    $upload_dir = wp_upload_dir();
    $uploaded_image_location = $upload_dir['basedir'] . '/' .$image_data['file'];
    $large_image_location = $upload_dir['path'] . '/'.$image_data['sizes']['large']['file'];

    // delete the uploaded image
    unlink($uploaded_image_location);

    // rename the large image
    rename($large_image_location,$uploaded_image_location);

    // update image metadata and return them
    $image_data['width'] = $image_data['sizes']['large']['width'];
    $image_data['height'] = $image_data['sizes']['large']['height'];
    unset($image_data['sizes']['large']);

    return $image_data;
}
add_filter('wp_generate_attachment_metadata','replace_uploaded_image');

/*
 *利用谷歌timthumb.php获取缩略图函数
 */
function post_thumbnail( $width = 100,$height = 80,$class='thumb' ){ 
    global $post;
    if( has_post_thumbnail() ){
        //有缩略图，则显示缩略图 
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full'); 
        $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb/timthumb.php?src='.$timthumb_src[0].'&h='.$height.'&w='.$width.'&zc=1" alt="'.$post->post_title.'" class="'.$class.'" />'; 
        echo $post_timthumb; 
    } else{ 
        $post_timthumb = ''; 
        ob_start(); 
        ob_end_clean(); 
        $output = preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $index_matches);    //获取日志中第一张图片 
        $first_img_src = $index_matches [1];    //获取该图片 src 
        if( !empty($first_img_src) ){    //如果日志中有图片 
            $path_parts = pathinfo($first_img_src);    //获取图片 src 信息 
            $first_img_name = $path_parts["basename"];    //获取图片名 
            $first_img_pic = get_bloginfo('wpurl'). '/cache/'.$first_img_name;    //文件所在地址 
            $first_img_file = ABSPATH. '/cache/'.$first_img_name;    //保存地址 
            $expired = 604800;    //过期时间 
            if ( !is_file($first_img_file) || (time() - filemtime($first_img_file)) > $expired ){ 
                copy($first_img_src, $first_img_file);    //远程获取图片保存于本地 
                $post_timthumb = '<img src="'.$first_img_src.'" alt="'.$post->post_title.'" class="'.$class.'" />';    //保存时用原图显示 
            } 
            $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb/timthumb.php?src='.$first_img_pic.'&h='.$height.'&w='.$width.'&zc=1" alt="'.$post->post_title.'" class="'.$class.'" />'; 
        } else {    //如果日志中没有图片，则显示默认 
            $imgrandom = mt_rand(1, 75); 
            $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb/timthumb.php?src='.get_bloginfo("template_url").'/lib/images/cover/'.$imgrandom.'.jpg&h='.$height.'&w='.$width.'&zc=1" alt="'.$post->post_title.'" class="'.$class.'" />'; 
        } 
        echo $post_timthumb; 
    } 
}