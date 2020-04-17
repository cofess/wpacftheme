<?php

/*
 |--------------------------------------------------------------------------
 | remove meta box
 |--------------------------------------------------------------------------
 | https://codex.wordpress.org/Function_Reference/remove_meta_box
 | https://wordpress.stackexchange.com/questions/131814/if-current-user-is-admin-or-editor
 |
 */

return function ($value)
{
	global $adminTheme;
	$adminTheme = array();

	$adminTheme['is_enabled'] = WpThemeConfig\Configurator::getInstance()->get('core.custom-admin-appearance');
	$adminTheme['is_themed'] = WpThemeConfig\Configurator::getInstance()->get('core.admin-theme');
	$adminTheme['hide_separators'] = WpThemeConfig\Configurator::getInstance()->get('core.hide-separators');
	$adminTheme['menu_collapsed'] = WpThemeConfig\Configurator::getInstance()->get('core.menu-collapsed');

	add_filter( 'admin_body_class', 'filter_add_body_classes', 11 );

    // Add CSS classes to the page's <body> tag
	function filter_add_body_classes( $body_classes ) {
		global $adminTheme;
		$new_classes = array();

		// Only when logged in
		if ( ! is_user_logged_in() ) {
			return $body_classes;
		}

		// If non-mobile (.mobile is added by default)
		if ( ! wp_is_mobile() ) {
			$new_classes[] = 'not-mobile';
		}

		// If theming is enabled
		if ( $adminTheme['is_enabled'] ) {
			$new_classes[] = 'clientside-enabled';
		}

		// If theming is enabled
		if ( $adminTheme['is_themed'] ) {
			$new_classes[] = 'clientside-theme';
		}

		// If enable-separators option is enabled
		if ( $adminTheme['hide_separators'] ) {
			$new_classes[] = 'clientside-hide-menu-separators';
		}

		$new_classes[] = 'clientside-inline-submenus';

		// Menu default collapse option
		if ( $adminTheme['menu_collapsed'] ) {
			$new_classes[] = 'clientside-menu-collapsed-default';
			$new_classes[] = 'clientside-menu-toggled';
			$new_classes[] = 'folded';
		}
		else {
			$new_classes[] = 'clientside-menu-not-collapsed-default';
		}

		// Merge & return
		if ( is_array( $body_classes ) ) {
			return array_merge( $body_classes, $new_classes );
		}
		return $body_classes . ' ' . implode( ' ', $new_classes ) . ' ';

	}

	add_action( 'admin_enqueue_scripts', 'action_enqueue_admin_scripts' );

	// Enqueue admin scripts
	function action_enqueue_admin_scripts() {
		global $adminTheme;

		// Add localized strings
		wp_localize_script( 'jquery', 'clientside', array(
			'L10n' => array(
				// Source: navMenuL10n
				'saveAlert' => __( 'The changes you made will be lost if you navigate away from this page.' ),
				'untitled' => _x( '(no label)', 'missing menu item navigation label' ),
				// Custom:
				'backToTop' => _x( 'Back to top', 'Title attribute for the Back to top button.', 'clientside' ),
				'revertConfirm' => _x( 'Are you sure you want to remove all customizations and start from scratch?', 'Confirmation message when reverting the Admin Menu Editor to default.', 'clientside' ),
				'screenOptions' => __( 'Screen Options' ),
				'help' => __( 'Help' ),
				'exportLoading' => __( 'Loading...', 'clientside' )
			),
			// Non-translation variables
			'isMobile' => wp_is_mobile() ? 1 : '',
			'themeEnabled' => $adminTheme['is_themed'] ? 1 : '',
			'clientsideEnabled' => $adminTheme['is_enabled'] ? 1 : '',
		) );

	}

	add_action( 'admin_bar_menu', 'action_add_toolbar_nodes_sooner', 0 );
	add_action( 'admin_bar_menu', 'action_add_toolbar_nodes_later' );

	// Add items to the admin toolbar, part 1 (triggered at the earliest priority)
	function action_add_toolbar_nodes_sooner( $wp_toolbar ) {

		// Add menu expand button for when the menu is collapsed
		if ( is_admin() ) {
			$wp_toolbar->add_node(
				array(
					'id' => 'clientside-menu-expand',
					'title' => '<span class="dashicons dashicons-menu"></span>'
				)
			);
		}

	}

	// Add items to the admin toolbar, part 2 (triggered at a later priority)
	function action_add_toolbar_nodes_later( $wp_toolbar ) {


	}
};