<?php
if ( ! defined( 'ABSPATH' ) ) { die; }

function load_poster_styles() {
    if(is_singular()):
        wp_enqueue_style('poster', POSTER_URI . '/css/poster.css');
    endif;
}

function load_poster_scripts() {
    if(is_singular()):
        wp_enqueue_script('poster', POSTER_URI . '/js/poster.js', array(), '1.0.0', true);
    endif;
}

function add_poster_links($actions, $post){
	// $poster_create_link = admin_url('post.php'.wp_nonce_url(add_query_arg(array('post'=>$post->ID,'action'=>'poster_create'),$url),'edit_my_cpt_nonce'));
	$bigger_cover = get_post_meta($post->ID, 'bigger_cover', true);
	if($bigger_cover){
		$actions['poster_link'] = '<a class="bigger_cover" href="'.$bigger_cover.'" target="_blank">' . __('海报','BT_TEXTDOMAIN') . '</a>';
	}
	// $actions['poster_create_link'] = '<a class="poster_create" href="'.$poster_create_link.'">' . __('生成海报','BT_TEXTDOMAIN') . '</a>';

	return $actions;
}

function poster_setup(){
	$posterPath = get_template_directory_uri().str_replace(wp_normalize_path(get_template_directory()),'',wp_normalize_path(dirname(__FILE__)));
	define('POSTER_DIR', dirname( __FILE__ ));
	define('POSTER_URI', $posterPath);
	require_once __DIR__ . '/poster.php';

	add_action('wp_enqueue_scripts', 'load_poster_styles');
	add_action('wp_footer', 'load_poster_scripts');

	add_filter('post_row_actions', 'add_poster_links', 10, 2);
}
add_action('after_setup_theme', 'poster_setup');


/**
 * 海报生成：未完成
 * https://rudrastyh.com/wordpress/duplicate-post.html
 */
function poster_create(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}

	/*
	 * Nonce verification
	 */
	// if ( !isset( $_GET['_wpnonce'] ) || !wp_verify_nonce( $_GET['_wpnonce'], basename( __FILE__ ) ) )
	// 	return;

	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );

	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();

	if ( ! current_user_can( 'delete_post', $post_id ) ) {
		wp_die( __( 'Sorry, you are not allowed to move this item to the Trash.' ) );
	}

	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
		$date = array('day' => get_the_time('d', $post_id), 'year' => get_the_time('Y/m', $post_id));
		$title = get_the_title($post_id);
		$title = substr_ext($title, 0, 20, 'utf-8', '');

		// 文章摘要
		$content = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
		$content = substr_ext(strip_tags(strip_shortcodes($content)), 0, 100, 'utf-8', '...');
		$content = str_replace(PHP_EOL, '', strip_tags(apply_filters('the_excerpt', $content)));

		// 特色图像
		$head_img = post_thumbnail_src($post);

		// 二维码
		if (WpThemeConfig\Configurator::getInstance()->get('theme.share_bigger_img_qrcode')) {
			$qrcode_img = POSTER_URI . '/share/qrcode.php?data=' . get_the_permalink($post_id);
		} else {
			$qrcode_img = null;
		}

		$result = create_bigger_image($post_id, $date, $title, $content, $head_img, $qrcode_img);
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		// wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		// exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
// add_action( 'admin_action_poster_create', 'poster_create' );