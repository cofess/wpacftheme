<?php
/**
 * 
 * Add custom post type to Right Now admin dashboard widget
 * 仪表盘“概览”小工具支持自定义内容类型
 *
 *
 * https://gist.github.com/11320359
 * https://toolset.com/forums/topic/add-custom-post-type-to-dashboard-at-a-glance-box/
 */
return function($value)
{
	// Add custom post types count action to WP Dashboard
	add_action('dashboard_glance_items', 'custom_posttype_glance_items');
	// Showing all custom posts count
	function custom_posttype_glance_items()
	{
		$glances = array();
		$args = array(
			'public'   => true,  // Showing public post types only
			'_builtin' => false  // Except the build-in wp post types (page, post, attachments)
		);
		// Getting your custom post types
		$post_types = get_post_types($args, 'object', 'and');
		foreach ($post_types as $post_type)
		{
			// Counting each post
			$num_posts = wp_count_posts($post_type->name);
			// Number format
			$num = number_format_i18n($num_posts->publish);
			// Text format
			$text = _n($post_type->labels->singular_name, $post_type->labels->name, intval($num_posts->publish));
			// If use capable to edit the post type
			if (current_user_can('edit_posts'))
			{
				// Show with link
				$glance = '<a class="'.$post_type->name.'-count" href="'.admin_url('edit.php?post_type='.$post_type->name).'">'.$num.' '.$text.'</a>';
			}
			else
			{
				// Show without link
				$glance = '<span class="'.$post_type->name.'-count">'.$num.' '.$text.'</span>';
			}
			// Save in array
			$glances[] = $glance;
		}
		// return them
		return $glances;
	}
};