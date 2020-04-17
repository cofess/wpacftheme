<?php

return function($option) {
    $callback = function() use($settings) {
        global $wp_version;
        global $wp_post_types;

        echo '<ul class="nebula-fa-ul">';
        // echo '<li><i class="fa fa-fw fa-globe"></i> <a href="' . home_url('/') . '" target="_blank" rel="noopener">' . home_url('/') . '</a></li>'; 
        // WordPress Version
        // echo '<li><i class="fa fa-fw fa-wordpress"></i> <a href="https://codex.wordpress.org/WordPress_Versions" target="_blank" rel="noopener">WordPress</a> <strong>' . $wp_version . '</strong></li>'; 
        // Child Theme
        if (is_child_theme()) {
            echo '<li><i class="fa fa-fw fa-child"></i><a href="themes.php">Child theme</a> active <small>(' . get_option('stylesheet') . ')</small></li>';
        } 
        // Multisite (and Super Admin detection)
        if (is_multisite()) {
            $network_admin_link = '';
            if (is_super_admin()) {
                $network_admin_link = ' <small><a href="' . network_admin_url() . '">(Network Admin)</a></small></li>';
            } 
            echo '<li><i class="fa fa-fw fa-cubes"></i> Multisite' . $network_admin_link;
        } 
        // Post Types
        // foreach (get_post_types() as $post_type) {
        //     // Only show post types that show_ui (unless forced with one of the arrays below)
        //     $force_show = array('wpcf7_contact_form'); //These will show even if their show_ui is false.
        //     $force_hide = array('attachment', 'acf', 'deprecated_log'); //These will be skipped even if their show_ui is true.
        //     if ((!$wp_post_types[$post_type] -> show_ui && !in_array($post_type, $force_show)) || in_array($post_type, $force_hide)) {
        //         continue;
        //     } 

        //     $count_posts = get_transient('nebula_count_posts_' . $post_type);
        //     if (empty($count_posts)) {
        //         $count_posts = wp_count_posts($post_type);
        //         $cache_length = (is_plugin_active('transients-manager/transients-manager.php'))? WEEK_IN_SECONDS : DAY_IN_SECONDS; //If Transient Monitor (plugin) is active, transients with expirations are deleted when posts are published/updated, so this could be infinitely long.
        //         set_transient('nebula_count_posts_' . $post_type, $count_posts, $cache_length);
        //     } 

        //     $labels_plural = ($count_posts -> publish === 1)? $wp_post_types[$post_type] -> labels -> singular_name : $wp_post_types[$post_type] -> labels -> name;
        //     switch ($post_type) {
        //         case ('post'):
        //             $post_icon_img = '<i class="fa fa-fw fa-thumbtack"></i>';
        //             break;
        //         case ('page'):
        //             $post_icon_img = '<i class="fa fa-fw fa-file-alt"></i>';
        //             break;
        //         case ('wp_block'):
        //             $post_icon_img = '<i class="fa fa-fw fa-clone"></i>';
        //             break;
        //         case ('wpcf7_contact_form'):
        //             $post_icon_img = '<i class="fa fa-fw fa-envelope"></i>';
        //             break;
        //         default:
        //             $post_icon = $wp_post_types[$post_type] -> menu_icon;
        //             if (!empty($post_icon)) {
        //                 if (strpos('dashicons-', $post_icon) >= 0) {
        //                     $post_icon_img = '<i class="dashicons-before ' . $post_icon . '"></i>';
        //                 } else {
        //                     $post_icon_img = '<img src="' . $post_icon . '" style="width: 16px; height: 16px;" />';
        //                 } 
        //             } else {
        //                 $post_icon_img = '<i class="fa fa-fw fa-thumbtack"></i>';
        //             } 
        //             break;
        //     } 
        //     echo '<li>' . $post_icon_img . ' <a href="edit.php?post_type=' . $post_type . '"><strong>' . $count_posts -> publish . '</strong> ' . $labels_plural . '</a></li>';
        // } 
        // Earliest post
        $earliest_post = get_transient('nebula_earliest_post');
        if (empty($earliest_post)) {
            $earliest_post = new WP_Query(array('post_type' => 'any', 'post_status' => 'publish', 'showposts' => 1, 'orderby' => 'publish_date', 'order' => 'ASC'));
            set_transient('nebula_earliest_post', $earliest_post, WEEK_IN_SECONDS); //This transient is deleted when posts are added/updated, so this could be infinitely long.
        } while ($earliest_post -> have_posts()) {
            $earliest_post -> the_post();
            echo '<li><i class="dashicons dashicons-calendar"></i> Earliest: <strong>' . get_the_date() . '</strong> @ <strong>' . get_the_time() . '</strong></li>';
        } 
        wp_reset_postdata(); 
        // Last updated
        $latest_post = get_transient('nebula_latest_post');
        if (empty($latest_post)) {
            $latest_post = new WP_Query(array('post_type' => 'any', 'showposts' => 1, 'orderby' => 'modified', 'order' => 'DESC'));
            set_transient('nebula_latest_post', $latest_post, HOUR_IN_SECONDS * 12); //This transient is deleted when posts are added/updated, so this could be infinitely long.
        } while ($latest_post -> have_posts()) {
            $latest_post -> the_post();
            echo '<li><i class="dashicons dashicons-calendar-alt"></i> Updated: <strong>' . get_the_modified_date() . '</strong> @ <strong>' . get_the_modified_time() . '</strong></li>';
        } 
        wp_reset_postdata(); 
        // Revisions
        $revision_count = (WP_POST_REVISIONS == -1)? 'all' : WP_POST_REVISIONS;
        $revision_style = ($revision_count === 0)? 'style="color: red;"' : '';
        $revisions_plural = ($revision_count === 1)? 'revision' : 'revisions';
        echo '<li><i class="dashicons dashicons-backup"></i> Storing <strong ' . $revision_style . '>' . $revision_count . '</strong> ' . $revisions_plural . '.</li>'; 
        // Plugins
        $all_plugins = get_transient('nebula_count_plugins');
        if (empty($all_plugins)) {
            $all_plugins = get_plugins();
            set_transient('nebula_count_plugins', $all_plugins, HOUR_IN_SECONDS * 36);
        } 
        $all_plugins_plural = (count($all_plugins) === 1)? 'Plugin' : 'Plugins';
        $active_plugins = get_option('active_plugins', array());
        echo '<li><i class="dashicons dashicons-admin-plugins"></i> <a href="plugins.php"><strong>' . count($all_plugins) . '</strong> ' . $all_plugins_plural . '</a> installed <small>(' . count($active_plugins) . ' active)</small></li>'; 
        // Comments
        if (get_option('default_comment_status')) {
            $comments_count = wp_count_comments();
            $comments_plural = ($comments_count -> approved === 1)? 'Comment' : 'Comments';
            echo '<li><i class="dashicons dashicons-admin-comments"></i> <strong>' . $comments_count -> approved . '</strong> ' . $comments_plural . '</li>';
        } else {
            echo '<li><i class="dashicons dashicons-admin-comments"></i> Comments disabled <small>(via <a href="themes.php?page=nebula_options&tab=functions&option=comments">Nebula Options</a>)</small></li>';
        } 

        echo '</ul>';
    };

    Lib\Core\Dashboard :: addSideWidget('dashboard-status', __('Status', 'BT_TEXTDOMAIN'), $callback);
};
