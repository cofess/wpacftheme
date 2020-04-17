<?php
/**
 * 固定链接配置
 * https://blog.wpjam.com/m/wpjam-rewrite/
 */
return array(

    /*
    |--------------------------------------------------------------------------
    | Attachment Pages Redirect
    |--------------------------------------------------------------------------
    |
    | * Makes attachment pages redirects (301) to post parent if any. If not, redirects (302) to home page.
    */
    
    'attachment-pages-redirect' => true,
    
    /*
    |--------------------------------------------------------------------------
    | Pretty search URLs 美化搜索链接
    |--------------------------------------------------------------------------
    | 温馨提示：仅推荐使用关键词进行搜索时使用该规则，在使用多个搜索条件搜索时，使用该规则，可能无法正常获取搜索条件字段值，导致搜索不到
    | * Redirects search results from /?s=query to /search/query
    |
    | http://txfx.net/wordpress-plugins/nice-search/
    | http://www.wpdaxue.com/redirect-wordpress-searches.html
    |
    */

    'pretty-search-url' => true,

    /*
    |--------------------------------------------------------------------------
    | Pretty author URLs 美化搜索链接
    |--------------------------------------------------------------------------
    | 避免直接使用用户名，提高安全性，推荐使用用户ID，使用昵称可能会存在昵称相同的情况，这时候只会显示ID较早的用户（解决思路是修改个人资料时，如果使用了相同昵称，进行提示。）
    | 注意：昵称不要包含空格，同时不建议使用中文，此外，使用昵称方式记得将“公开显示为”设置为非用户名
    | 搜索结果页面默认链接：domain/?s=keywordk，优化后：domain/search/keyword
    |
    | https://boke112.com/3624.html
    |
    */

    'pretty-author-url' => 'id', // id:作者存档链接中的用户名改为用户ID, nickname:作者存档链接中的用户名改为昵称

    /*
    |--------------------------------------------------------------------------
    | No Category Base 去除分类标志
    |--------------------------------------------------------------------------
    | 删除分类目录链接中那有些多余的 /category/ 字样
    | Description: Removes '/category' from your category permalinks. WPML compatible.
    |
    | https://www.mywpku.com/no-category-base-code-2.html
    |
    */
   
    'no-category-base' => true,

    /*
    |--------------------------------------------------------------------------
    | Rewrite 优化
    |--------------------------------------------------------------------------
    | 将 WordPress 现有的一些无用的 Rewrite 规则删除，加快 WordPress 加载速度 
    |
    | https://blog.wpjam.com/m/wpjam-rewrite/
    |
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
    'remove-rewrites' => array(
        'comment-page', // 留言分页 Rewrite 规则
        'comment', // 留言 Rewrite 规则
        'author', // 作者 Rewrite 规则
        'type/', // 文章格式 Rewrite 规则
        // 'feed=', // 分类 Feed Rewrite 规则，会导致xml-sitemap-feed生成sitemap.xml失效
        // 'attachment' // 附件页面 Rewrite 规则
    )
);