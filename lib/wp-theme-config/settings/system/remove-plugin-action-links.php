<?php

/**
 * WordPress 移除插件列表所有“编辑”和“停用”链接
 * http://www.wpdaxue.com/remove-plugin-actions.html
 */
return function() 
{
	function remove_plugin_action_links( $actions, $plugin_file, $plugin_data, $context ){
		// 移除所有“编辑”链接
		if ( isset( $actions['edit'] ) ){
			unset( $actions['edit'] );
		}
		// 移除插件的“停用”链接
		// if( isset( $actions['deactivate'] ) ){
		// 	unset( $actions['deactivate'] );
		// }
		// 移除所有“删除”链接
		if ( isset( $actions['delete'] ) ){
			unset( $actions['delete'] );
		}
		return $actions;
	}
	if( !current_user_can('administrator') ) {
		add_filter( 'plugin_action_links', 'remove_plugin_action_links', 10, 4 );
	}
};