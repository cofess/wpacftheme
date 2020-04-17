<?php

if(is_admin())
{
	// Create the function
	new Available_Shortcodes_Listing();
}

/**
 * View all available shorttcodes on an admin page
 *
 * @author
 **/
class Available_Shortcodes_Listing
{
	static $main_menus = array();
	static $sub_menus = array();
	static $hidden_pages = array(
		'content-manager',
		'typerocket_dev',
		'separator1',
		'separator2',
		'separator-last',
		'separator-woocommerce',
		'index.php',
		'upload.php',
		'link-manager.php',
		'edit-comments.php',
		'themes.php',
		'plugins.php',
		'users.php',
		'tools.php',
		'options-general.php',
		'edit.php?post_type=page',
		'edit.php?post_type=banner',
		'brand'
	);

	public function __construct()
	{
		$this->Admin();
	}
	/**
	 * Create the admin area
	 */
	public function Admin(){
		add_action( 'admin_menu', array(&$this,'Admin_Menu') );
	}
	/**
	 * Function for the admin menu to create a menu item in the settings tree
	 */
	public function Admin_Menu(){
		add_menu_page(__('Content'), __('Content'), 'manage_options', 'content-manager', array(&$this,'Display_Admin_Page'), 'dashicons-vault', 60);
	}

	// Output the HTML for one menu item in the editable menu list
	static function print_menu_editor_item( $item_info, $mainmenu_item_slug = '' ) {
		// var_dump($item_info);
		$slug = $item_info[2];
		$name_prefix = $mainmenu_item_slug ? 'submenu-' . $slug : $slug;
		$array_key = $mainmenu_item_slug ? 'submenu-' . $slug : $slug;
		$array_key = str_replace( '&amp;', '&', $array_key );
		$title_data = is_numeric( strpos( $item_info[0], '<' ) ) ? trim( substr( $item_info[0], 0, strpos( $item_info[0], '<' ) ) ) : $item_info[0];
		$title_show = $title_data ? $title_data : ( $item_info[3] ? $item_info[3] : _x( '(separator)', 'Item name in the admin menu editor', 'clientside' ) );
		$placeholder = $title_data != $saved_title ? $title_data : ( isset( $item_info[3] ) && $item_info[3] ? $item_info[3] : '' );
		$capability = $item_info[1];
		$icon = isset( $item_info[6] ) ? $item_info[6] : '';
		?>
		<i class="dashicons <?php echo $icon; ?>"></i>
		<h3><?php echo $title_show; ?></h3>
		<?php
	}

	// Output the HTML for one menu item in the editable menu list
	static function print_submenu_editor_item( $item_info, $mainmenu_item_slug = '' ) {
		$slug = $item_info[2];
		$link = $item_info[2];
		$name_prefix = $mainmenu_item_slug ? 'submenu-' . $slug : $slug;
		$array_key = $mainmenu_item_slug ? 'submenu-' . $slug : $slug;
		$array_key = str_replace( '&amp;', '&', $array_key );
		$title_data = is_numeric( strpos( $item_info[0], '<' ) ) ? trim( substr( $item_info[0], 0, strpos( $item_info[0], '<' ) ) ) : $item_info[0];
		$title_show = $title_data ? $title_data : ( $item_info[3] ? $item_info[3] : _x( '(separator)', 'Item name in the admin menu editor', 'clientside' ) );
		$placeholder = $title_data != $saved_title ? $title_data : ( isset( $item_info[3] ) && $item_info[3] ? $item_info[3] : '' );
		$capability = $item_info[1];
		$icon = isset( $item_info[6] ) ? $item_info[6] : '';
		?>
		<a href="<?php echo $link; ?>"><?php echo $title_show; ?></a>
		<?php
	}

	/**
	 * Display the admin page
	 */
	public function Display_Admin_Page(){
		$post_types = get_post_types( ['public' => true]);
    	unset($post_types['page'],$post_types['attachment']);
    	global $menu;
		global $submenu;

		foreach ( $menu as $position => $mainmenu_item ) {

			// var_dump($mainmenu_item);

			// Required param
			if ( ! isset( $mainmenu_item[2] ) ) {
				continue;
			}

			// Skip exceptions
			if ( isset( $mainmenu_item[1] ) && $mainmenu_item[1] == 'manage_links' && isset( $mainmenu_item[5] ) && $mainmenu_item[5] == 'menu-links' ) {
				continue;
			}

			// Skip hidden admin pages
			if ( in_array( $mainmenu_item[2], self::$hidden_pages ) ) {
				continue;
			}

			// Passed
			self::$main_menus[ $mainmenu_item[2] ] = $mainmenu_item;

		}

		// Filter submenu items
		foreach ( $submenu as $mainmenu_slug => $submenu_items ) {

			foreach ( $submenu_items as $submenu_item_key => $submenu_item ) {
				// var_dump($submenu_item[2]);
				// Skip hidden admin pages
				if ( in_array( $submenu_item[2], self::$hidden_pages ) ) {
					unset( $submenu_items[ $submenu_item_key ] );
				}

			}

			// Save as $parent_slug => $items array
			self::$sub_menus[ $mainmenu_slug ] = $submenu_items;

		}
		$main_menus_ordered = self::$main_menus;
    	?>
    	<div class="wrap">
			<h1><?php echo __('内容管理','BT_TEXTDOMAIN');?></h1>
			<?php settings_errors(); ?>
			<ul class="icon-box-list part-xs-2 part-sm-3 part-md-3 part-lg-4 part-xl-4">
				<?php
				foreach ( $main_menus_ordered as $mainmenu_item ) {
					$mainmenu_item_slug = $mainmenu_item[2];
					?>
					<li class="item icon-box">
						<div class="item-content text-center">
						<?php self::print_menu_editor_item( $mainmenu_item ); ?>
						<?php // Submenu ?>
						<?php if ( isset( self::$sub_menus[ $mainmenu_item_slug ] ) && count( self::$sub_menus[ $mainmenu_item_slug ] ) ) { ?>
							<ul class="clientside-admin-menu-editor clientside-admin-menu-editor-submenu">
								<?php foreach ( self::$sub_menus[ $mainmenu_item_slug ] as $submenu_item ) { ?>
									<li class="clientside-admin-menu-editor-item">
										<?php self::print_submenu_editor_item( $submenu_item, $mainmenu_item_slug ); ?>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
						</div>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
    	<?php
	}
} // END class Available_Shortcodes_Listing
?>
