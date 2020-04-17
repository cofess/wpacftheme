<?php
/**
 * WordPress 添加自定义文章类型的存档页面到菜单
 * http://www.wpdaxue.com/add-custom-post-types-archive-to-nav-menus.html
 * https://stackoverflow.com/questions/20879401/how-to-add-custom-post-type-archive-to-menu
 * @example $CustomPostTypeArchiveInMenu = new CustomPostTypeArchiveInMenu();
 */
if ( ! defined( 'ABSPATH' ) ) { die; }

class CustomPostTypeArchiveInMenu {
	public function __construct() {
		add_action( 'admin_head-nav-menus.php', array( &$this, 'cpt_navmenu_metabox' ) );
		add_filter( 'wp_get_nav_menu_items', array( &$this,'cpt_archive_menu_filter'), 10, 3 );
	}
	function cpt_navmenu_metabox() {
		add_meta_box( 'add-cpt', __('自定义文章类型存档'), array( &$this, 'cpt_navmenu_metabox_content' ), 'nav-menus', 'side', 'default' );
	}
	function cpt_navmenu_metabox_content() {
		$post_types = get_post_types( array( 'show_in_nav_menus' => true, 'has_archive' => true ), 'object' );
		if( $post_types ) {
			$items = array();
			$loop_index = 999999;

			foreach ($post_types as $post_type) {
				$item = new stdClass();
				$loop_index++;

				$item->object_id = $loop_index;
				$item->db_id = 0;
				$item->object = 'post_type_' . $post_type->query_var;
				$item->menu_item_parent = 0;
				$item->type = 'custom';
				$item->title = $post_type->labels->name;
				$item->url = get_post_type_archive_link($post_type->query_var);
				$item->target = '';
				$item->attr_title = '';
				$item->classes = array();
				$item->xfn = '';

				$items[] = $item;
			}

			$walker = new Walker_Nav_Menu_Checklist(array());

			echo '<div id="posttype-archive" class="posttypediv">';
			echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
			echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
			echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
			echo '</ul>';
			echo '</div>';
			echo '</div>';

			echo '<p class="button-controls">';
			echo '<span class="add-to-menu">';
			echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'andromedamedia') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
			echo '<span class="spinner"></span>';
			echo '</span>';
			echo '</p>';
		} else {
			echo __('没有自定义文章类型');
		}
	}
	function cpt_archive_menu_filter( $items, $menu, $args ) {
		foreach( $items as &$item ) {
			if( $item->object != 'cpt-archive' ) continue;
			$item->url = get_post_type_archive_link( $item->type );
			if( get_query_var( 'post_type' ) == $item->type ) {
				$item->classes[] = 'current-menu-item';
				$item->current = true;
			}
		}
		return $items;
	}
}
$CustomPostTypeArchiveInMenu = new CustomPostTypeArchiveInMenu();