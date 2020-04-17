<?php

return function($feeds)
{
    include_once ABSPATH . WPINC . '/feed.php';

    foreach($feeds as $feed){

        $rss = fetch_feed($feed['rss']);
        $limit = $feed['limit'] ? $feed['limit'] : 8;

        if (!is_wp_error($rss)):
            $maxitems = $rss->get_item_quantity($limit); 
            $rss_items = $rss->get_items(0, $maxitems);
        endif;

        $feed_callback = function() use($maxitems, $rss_items, $feed) {
            if ( $maxitems == 0 ){
                echo __('暂无内容','BT_TEXTDOMAIN');
            } else {
                $html = '<div class="rss-widget"><ul>';
                foreach ( $rss_items as $item ) {
                    $title = esc_html($item->get_title());
                  
                    $date = date_i18n(get_option('date_format'), $item->get_date('U'));
                    
                    $description = str_replace(array("\n", "\r"), ' ', esc_attr(strip_tags(@html_entity_decode($item->get_description(), ENT_QUOTES, get_option('blog_charset')))));
                    $description = wp_html_excerpt( $description, 120 );
        
                    if ('[...]' == substr( $description, -5 )):
                        $description = substr($description, 0, -5) . '[&hellip;]';
                    elseif ('[&hellip;]' != substr($description, -10)):
                        $description .= ' [&hellip;]';
                    endif;
                    
                    $description = esc_html( $description );
        
                    $link = $item->get_link();
                    
                    while (stristr($link, 'http') != $link):
                        $link = substr($link, 1);
                    endwhile;
                        
                    $link = esc_url(strip_tags($link));
        
                    // html content
                    $html .= '<li>';
                    $html .= '<a href="'. esc_url($link) .'" target="_blank" style="display:block">'. esc_html($title) .'</a>';
                    if( $feed['excerpt'] ){
                        $html .= '<div class="rss-summary">'. esc_html($description) .'</div>';
                    }
                    $html .= '<span class="rss-date">'. esc_html($date) .'</span>';
                    $html .= '</li>';
                }
                $html .= '</ul></div>';
                echo $html;
            }
        };

        if($feed['type'] == 'side'){
            Lib\Core\Dashboard::addSideWidget( $feed['id'], $feed['name'], $feed_callback );
        } else{
            Lib\Core\Dashboard::addMainWidget( $feed['id'], $feed['name'], $feed_callback );
        }

    }
};
