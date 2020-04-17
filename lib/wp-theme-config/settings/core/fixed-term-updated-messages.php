<?php
/*
|--------------------------------------------------------------------------
| 修正自定义分类更新提示
|--------------------------------------------------------------------------
| https://blog.wpjam.com/m/wpjam-term_updated_messages/
*/
return function ($value) {
    add_filter('term_updated_messages', function($messages){
        global $taxonomy;

        if($taxonomy == 'post_tag' || $taxonomy == 'category'){
            return $messages;
        }

        $labels     = get_taxonomy_labels(get_taxonomy($taxonomy));
        $label_name = $labels->name;

        $messages[$taxonomy]    = array_map(function($message) use ($label_name){
            if($message == $label_name) return $message;

            return str_replace(
                ['项目', 'Item'],
                [$label_name, ucfirst($label_name)],
                $message
            );
        }, $messages['_item']);

        return $messages;
    });
};
