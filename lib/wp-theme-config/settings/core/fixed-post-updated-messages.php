<?php
/*
|--------------------------------------------------------------------------
| 修正自定义文章类型更新提示
|--------------------------------------------------------------------------
| https://blog.wpjam.com/m/wpjam-post_updated_messages/
*/
return function ($value) {
    add_filter('post_updated_messages', function($messages){
        global $post_type;

        if($post_type == 'page' || $post_type == 'post'){
            return $messages;
        }

        if(is_post_type_hierarchical($post_type)){
            $messages['page']   =  fixed_post_updated_messages($messages['page'], $post_type);
        }else{
            $messages['post']   =  fixed_post_updated_messages($messages['post'], $post_type);
        }

        return $messages;
    });

    function fixed_post_updated_messages($messages, $post_type){
        $labels     = get_post_type_labels(get_post_type_object($post_type));
        $label_name = $labels->name;

        return array_map(function($message) use ($label_name){
            if($message == $label_name) return $message;

            return str_replace(
                ['文章', '页面', 'post', 'Post'],
                [$label_name, $label_name, $label_name, ucfirst($label_name)],
                $message
            );
        }, $messages);
    }
};
