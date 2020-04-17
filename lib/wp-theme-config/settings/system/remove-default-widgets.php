<?php

/**
 * Remove wordpress default widgets
 * https://premium.wpmudev.org/blog/how-to-remove-default-wordpress-widgets-and-clean-up-your-widgets-page/
 */
return function($value) 
{
	global $widgets;
	$widgets = $value;
    function unregister_default_widgets() {
		global $widgets;
		foreach( $widgets as $widget ){
			unregister_widget($widget);
		}
		// unregister_widget('WP_Widget_Pages');
		// unregister_widget('WP_Widget_Calendar');
		// unregister_widget('WP_Widget_Archives');
		// unregister_widget('WP_Widget_Links');
		// unregister_widget('WP_Widget_Meta');
		// unregister_widget('WP_Widget_Search');
		// unregister_widget('WP_Widget_Text');
		// unregister_widget('WP_Widget_Categories');
		// unregister_widget('WP_Widget_Recent_Posts');
		// unregister_widget('WP_Widget_Recent_Comments');
		// unregister_widget('WP_Widget_RSS');
		// unregister_widget('WP_Widget_Tag_Cloud');
		// unregister_widget('WP_Nav_Menu_Widget');
	}
	add_action('widgets_init', 'unregister_default_widgets', 11);
};