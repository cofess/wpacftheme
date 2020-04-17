<?php

/**
 * 不使用插件实现对Wordpress默认编辑器的增强
 * 参考：http://www.vsay.cn/no-plug-in-to-enhance-wordpress-default-editor.html
 */ 
return function($value) 
{
    if ( ! $value) return;

    // if (version_compare(get_bloginfo('version'),'5.0.2') >= 0) return;

    function mce_buttons_1($original){
        // default mce_buttons
        // $mce_buttons = array( 'formatselect', 'bold', 'italic', 'bullist', 'numlist', 'blockquote', 'alignleft', 'aligncenter', 'alignright', 'link', 'wp_more', 'spellchecker' );
        $buttons_1 = array(
            'formatselect',
            'styleselect',
            'bold',
            'italic',
            'blockquote',
            'bullist',
            'numlist',
            'alignleft',
            'aligncenter',
            'alignright',
            'alignjustify',
            'link',
            'unlink',
            // 'image',
            'media',
            'spellchecker',
            'undo',
            'redo',
            'wp_more',
            'wp_page',
            'wp_adv'
        );
        if ( is_array( $original ) && ! empty( $original ) ) {
			$original = array_diff( $original, $buttons_1 );
			$buttons_1 = array_merge( $buttons_1, $original );
		}
        return $buttons_1;
    }

    function mce_buttons_2($original){
        // default mce_buttons_2
        // $mce_buttons_2 = array( 'strikethrough', 'hr', 'forecolor', 'pastetext', 'removeformat', 'charmap', 'outdent', 'indent', 'undo', 'redo' );
        $buttons_2 = array(
            'fontselect',
            'fontsizeselect',
            'strikethrough',
            'hr',
            'underline',
            'outdent',
            'indent',
            'forecolor',
            'backcolor',
            'cleanup',
            'sub',
            'sup',
            'copy',
            'paste',
            'cut',
            'pastetext',
            'removeformat',
            'charmap',
            'wp_help',
        );
        // if ( is_array( $original ) && ! empty( $original ) ) {
		// 	$original = array_diff( $original, $buttons_2 );
		// 	$buttons_2 = array_merge( $buttons_2, $original );
		// }
        return $buttons_2;
    }
    
    function mce_buttons_3($original) {
        //下面每一行代码都代表着一个功能按钮   
        //而后面的值就是wordpress内建的一些编辑功能   
        //您可以修改值里引号中的值（请参考文章后面的所有key）   
        //您也可以任意增加按钮和删除按钮   
        //方法就是删除下面的行或者复制出一行出来
        $buttons_3 = array(
            'fontselect',
            'fontsizeselect',
            'cleanup',
            'styleselect',
            'hr',
            'del',
            'sub',
            'sup',
            'copy',
            'paste',
            'cut',
            'undo',
            'image',
            'anchor',
            'backcolor',
            'wp_page',
            'charmap'
        );

        if ( is_array( $original ) && ! empty( $original ) ) {
			$original = array_diff( $original, $buttons_3 );
			$buttons_3 = array_merge( $buttons_3, $original );
		}

		return $buttons_3;  
    }

    function tiny_mce_plugins( $plugins ) {
        // default plugins
        // $plugins = array( 'anchor', 'code', 'insertdatetime', 'nonbreaking', 'print', 'searchreplace', 'table', 'visualblocks', 'visualchars' );
        $plugins = array(
			'advlist',
			'anchor',
			'code',
			'contextmenu',
			'emoticons',
			'importcss',
			'insertdatetime',
			'link',
			'nonbreaking',
			'print',
			'searchreplace',
			'table',
			'visualblocks',
			'visualchars',
			'wptadv',
		);

		return $plugins;
	}

    add_filter( 'mce_buttons', 'mce_buttons_1', 999, 2 );
    add_filter( 'mce_buttons_2', 'mce_buttons_2', 999 );
    // add_filter( 'mce_buttons_3', 'mce_buttons_3', 999 );
    // add_filter( 'tiny_mce_plugins', 'tiny_mce_plugins', 999 );
};
