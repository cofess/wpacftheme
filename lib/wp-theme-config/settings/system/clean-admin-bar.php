<?php

/**
 * clean admin bar
 */

return function($value)
{
    global $remove_nodes;
    $remove_nodes = $value;
    // Remove items from the admin toolbar (all removed functionality is moved to other places of the interface)
	function action_remove_toolbar_nodes( $wp_toolbar ) {
        global $remove_nodes;

        foreach( $remove_nodes as $node){
            $wp_toolbar->remove_node( $node );
        }
        // Remove the WP logo & dropdown menu
        // $wp_toolbar->remove_node( 'wp-logo' );

		// Remove the Updates item
		// $wp_toolbar->remove_node( 'updates' );

		// Remove the Comments button
		// $wp_toolbar->remove_node( 'comments' );

		// Remove the View Posts (archive view) button
	    // $wp_toolbar->remove_node( 'archive' );

		// Remove the New button & dropdown menu
		// $wp_toolbar->remove_node( 'new-content' );

		// Remove the front-end toolbar search
		// $wp_toolbar->remove_node( 'search' );

		// Remove the Customize button
		// $wp_toolbar->remove_node( 'customize' );

		// Remove the "My Sites" dropdown (multisite)
		// $wp_toolbar->remove_node( 'my-sites' );

		// Remove the Site name & dropdown menu
		// $wp_toolbar->remove_node( 'site-name' );

		// Remove User menu parts that are added differently
		// $wp_toolbar->remove_node( 'user-info' );
		// $wp_toolbar->remove_node( 'edit-profile' );

    }
    
    add_action( 'admin_bar_menu', 'action_remove_toolbar_nodes', 999 );
};
