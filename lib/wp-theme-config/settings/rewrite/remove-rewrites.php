<?php
/**
 * Plugin Name: Rewrite 优化
 * Plugin URI: https://blog.wpjam.com/project/wpjam-basic/
 * Description: 清理无用的 Rewrite 代码，和添加自定义 rewrite 代码。 
 * Version: 1.0
 */
/*
 |--------------------------------------------------------------------------
 | 1. 文章格式Rewrite规则
 | type/video 等这类文章格式生成的 rewrite 规则，如果你的主题没有使用文章格式（Post Format）功能，建议移除。
 | 
 | 2. 留言Rewrite规则
 | comment/ 打头的规则，一般建议移除。
 | 
 | 3. 留言分页Rewrite规则
 | 各个页面为了支持留言分页，而生成的 comment-page- 相关的 rewrite 规则，如果你的文章页面留言没有分页，或者采用 AJAX 分页，建议移除。
 | 
 | 4. 作者Rewrite规则
 | author/ 打头的作者文章列表页的 rewrite 规则，如果你的博客是多作者博客，并且每个作者都要有个人页，建议保留，否则移除。
 | 
 | 5. 分类Feed Rewrite规则
 | 分类 Feed 的 rewrite 规则，一般博客有个整个博客的 Feed 地址即可，所以建议移除。
 | 
 | 6. 附件Rewrite规则
 | 移除 /attachment/ 附件相关的 rewrite 规则，一般博客都不会使用到附件的地址，所以移除。
 |--------------------------------------------------------------------------
 */
return function($options)
{
    global $remove_rewrites;
    $remove_rewrites = $options;

    add_action('generate_rewrite_rules', function ($wp_rewrite){
        $wp_rewrite->rules              = remove_rewrite_rules($wp_rewrite->rules); 
        $wp_rewrite->extra_rules_top    = remove_rewrite_rules($wp_rewrite->extra_rules_top);
    });

    function remove_rewrite_rules($rules){
        global $remove_rewrites;

        $unuse_rewrite_keys = ['comment-page','comment','author','type/','feed=','attachment'];

        foreach ($unuse_rewrite_keys as $i=>$unuse_rewrite_key) {
            if(!in_array($unuse_rewrite_key, $remove_rewrites)){
                unset($unuse_rewrite_keys[$i]);
            }
        }
        
        foreach ($rules as $key => $rule) {
            if($unuse_rewrite_keys){
                foreach ($unuse_rewrite_keys as $unuse_rewrite_key) {
                    if( strpos($key, $unuse_rewrite_key) !== false || strpos($rule, $unuse_rewrite_key) !== false){
                        unset($rules[$key]);
                    }
                }
            }

            if(WpThemeConfig\Configurator::getInstance()->get('system.disable-embeds')){
                if( strpos($rule, 'embed=true') !== false){
                    unset($rules[$key]);
                }
            }

            if(WpThemeConfig\Configurator::getInstance()->get('system.disable-trackbacks')){
                if( strpos($rule, 'tb=1') !== false){
                    unset($rules[$key]);
                }
            }
        }

        return $rules;
    }

    flush_rewrite_rules();
};
