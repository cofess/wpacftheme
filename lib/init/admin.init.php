<?php

if ( ! defined( 'ABSPATH' ) ) { die; } 

/**
 * 更改编辑器默认视图为可视化
 * http://www.wpdaxue.com/tinymce-custom-methods.html
 */
// add_filter('wp_default_editor', create_function('', 'return "tinymce";'));

//设置 HTML 为默认编辑器
//add_filter( 'wp_default_editor', create_function('', 'return "html";') );

/**
 * WordPress 给“特色图像”模块添加说明文字
 * http://www.wpdaxue.com/add-featured-image-instruction.html
 */
add_filter( 'admin_post_thumbnail_html', 'add_featured_image_instruction');
function add_featured_image_instruction( $content ) {
	return $content .= '<p>特色图像将用来作为缩略图，请务必设置特色图像。</p>';
}

/*
 * 用户列表隐藏超级管理员账户（ID为1的管理员）
 * From https://wordpress.org/support/topic/hide-admin-from-user-list-1
 */
add_action('pre_user_query','hide_wp_admin_account');
function hide_wp_admin_account($user_search) {
	$user = wp_get_current_user();
	if ($user->ID!=1) { // Is not administrator, remove administrator
		global $wpdb;
		$user_search->query_where = str_replace('WHERE 1=1',"WHERE 1=1 AND {$wpdb->users}.ID<>1",$user_search->query_where);
	}
}

/**
 * WordPress 4.2 修复仪表盘头像错位
 * https://www.wpdaxue.com/disable-emoji.html
 */
function fixed_activity_widget_avatar_style(){
	echo '<style type="text/css">
			  #activity-widget #the-comment-list .avatar {
			  position: absolute;
			  top: 13px;
			  width: 50px;
			  height: 50px;
			}
			</style>';
}
// add_action('admin_head', 'fixed_activity_widget_avatar_style' );

/**
 * remove meta box
 */
function remove_admin_meta_boxes() {
	// if ( ! current_user_can( 'manage_options' ) ) {
		remove_meta_box( 'postexcerpt', 'post', 'normal' ); // 摘要
		remove_meta_box( 'slugdiv', 'post', 'normal' ); // 别名
		remove_meta_box( 'trackbacksdiv', 'post', 'normal' ); // 发送Trackback
		remove_meta_box( 'postcustom', 'post', 'normal' ); // 自定义栏目
		remove_meta_box( 'commentstatusdiv', 'post', 'normal' ); // 讨论
		remove_meta_box( 'commentsdiv', 'post', 'normal' ); // 评论
		remove_meta_box( 'revisionsdiv', 'post', 'normal' ); // 修订版本
		remove_meta_box( 'authordiv', 'post', 'normal' ); // 作者
	// }
}
add_action( 'admin_menu', 'remove_admin_meta_boxes' );

/**
 * WordPress文章编辑页将作者模块移到发布模块内
 * https://www.ludou.org/move-author-metabox-publish-metabox-wordpress.html
 */
add_action( 'admin_menu', 'remove_author_metabox' );
add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );
function remove_author_metabox() {
    remove_meta_box( 'authordiv', 'post', 'normal' );
}
function move_author_to_publish_metabox() {
    global $post_ID;
    $post = get_post( $post_ID );
    echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">作者： ';
    post_author_meta_box( $post );
    echo '</div>';
}

//激活多媒体路径设置，可能导致获取不到正确的图片路径
// if(get_option('upload_path')=='wp-content/uploads' || get_option('upload_path')==null) {
// 	update_option('upload_path',WP_CONTENT_DIR.'/uploads');
// }

/**
 * 用户切换
 */
// add_filter('user_row_actions', function($actions, $user){
// 	$capability	= (is_multisite())?'manage_site':'manage_options';
// 	if(current_user_can($capability)){
// 		$actions['login_as']	= '<a title="以此身份登陆" href="'.wp_nonce_url("users.php?action=login_as&amp;users=$user->ID", 'bulk-users').'">以此身份登陆</a>';
// 	}
	
// 	return $actions;
// }, 10, 2);

// add_filter('handle_bulk_actions-users', function($sendback, $action, $user_ids){
// 	if($action == 'login_as'){
// 		wp_set_auth_cookie($user_ids, true);
// 		wp_set_current_user($user_ids);
// 	}
// 	return admin_url();
// },10,3);