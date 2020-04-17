<?php

/**
 * Disable RSS Feeds
 */
return function() 
{
    add_action('do_feed', 'disable_rss_feeds', 1);
	add_action('do_feed_rdf', 'disable_rss_feeds', 1);
	add_action('do_feed_rss', 'disable_rss_feeds', 1);
	add_action('do_feed_rss2', 'disable_rss_feeds', 1);
	add_action('do_feed_atom', 'disable_rss_feeds', 1);
	add_action('do_feed_rss2_comments', 'disable_rss_feeds', 1);
    add_action('do_feed_atom_comments', 'disable_rss_feeds', 1);

    // remove feed link
    remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
    
    function disable_rss_feeds() {
        wp_die(__('No feed available, please visit the <a href="' . esc_url(home_url('/')) . '">homepage</a>!'));
    }
};
