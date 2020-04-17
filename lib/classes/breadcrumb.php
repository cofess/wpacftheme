<?php

function get_breadcrumb($custom_args=Array()) {

    $args = Array(
        'text_domain' => '',
        'delimiter' => ' &raquo; ',
        'home' => 'Home',
        'home_link' => get_bloginfo('url'),
        'before' => '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">',
        'after' => '<meta itemprop="position" content="%1$s" /></li>',
        'before_text' => '<span>',
        'after_text' => '</span>',
        'class' => 'breadcrumb',
        'container' => '<nav class="breadcrumb"><ol itemscope itemtype="http://schema.org/BreadcrumbList">%s</ol></nav>'
    );

    if (function_exists('get_text_domain') && $args['text_domain'] == '')
        $args['text_domain'] = get_text_domain();

    if (is_array($custom_args))
        $args = array_merge($args, $custom_args);

    $args = apply_filters('breadcrumb_args', $args);


    /**
     * html inside of the container
     */
    $inner_html = '';

    $html_output = '';

    $pos = 1;

    /**
     * add a new breadcrumb item to the html output
     * @param $html
     * @param bool $delimiter
     */
    $add_item = function($html, $delimiter=false) use (&$inner_html, &$pos, $args) {
        $inner_html .= sprintf($args['before'] . $html . $args['after'] . ($delimiter ? $args['delimiter'] : ''), $pos++);
    };

    $add_item_text = function($html, $delimiter=false) use ($add_item, $args) {
        $add_item($args['before_text'] . $html . $args['after_text'], $delimiter);
    };

    $add_item_link = function($link, $html, $delimiter=true) use ($add_item, $args) {
        $add_item(sprintf('<a href="%s">%s%s%s</a>', $link, $args['before_text'], $html, $args['after_text']), $delimiter);
    };

    /**
     * get all parent categories and add the result to the html output
     * @param $cat
     */
    $add_cat_parents = function ($cat) use ($add_item_link) {
        $tax = 'category';

        $term = get_term($cat, $tax);

        if (is_wp_error($term) || !$term)
            return;

        $parents = get_ancestors($term->term_id, $tax, 'taxonomy');

        foreach (array_reverse($parents) as $term_id) {
            $parent = get_term($term_id, $tax);
            $add_item_link(esc_url(get_term_link($parent->term_id, $tax)), $parent->name);
        }
        $add_item_link(esc_url(get_term_link($cat->term_id)), $cat->name);
    };

    $home_link = $args['home_link'];

    if (!is_home() && !is_front_page() || is_paged()) {

        global $post;

        if (get_query_var('paged'))
            $add_item_link($home_link, $args['home'], true);
        elseif ($post && $args['home_link'] == get_permalink($post->ID)) {
            $add_item_text($args['home']);
        } else {
            $add_item_link($home_link, $args['home'], true);

            if (is_category()) {
                global $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);

                if ($thisCat->parent != 0) {
                    $add_cat_parents($parentCat);
                }

                $add_item_text(single_cat_title('', false));

            } elseif (is_day()) {
                $add_item_link(get_year_link(get_the_time('Y')), get_the_time('Y'));
                $add_item_link(get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F'));
                $add_item_text(get_the_time('d'));

            } elseif (is_month()) {
                $add_item_link(get_year_link(get_the_time('Y')), get_the_time('Y'));
                $add_item_text(get_the_time('F'));

            } elseif (is_year()) {
                $add_item_text(get_the_time('Y'));

            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;

                    $add_item_link(sprintf('%s/%s/', $home_link, $slug['slug']), $post_type->labels->singular_name);
                    $add_item_text(get_the_title());
                } else {
                    $cat = array_reverse(get_the_category());

                    if (is_array($cat) && sizeof($cat) > 0)
                        $add_cat_parents($cat[0]);
                    $add_item_text(get_the_title());
                }

            } elseif (is_attachment()) {
                $parent = $post->post_parent > 0 ? get_post($post->post_parent) : false;

                $cat = array_reverse(get_the_category());

                if (is_array($cat) && sizeof($cat) > 0)
                    $add_cat_parents($cat[0]);
                if ($parent)
                    $add_item_link(get_permalink($parent), $parent->post_title);
                $add_item_text(get_the_title());

            } elseif (is_page() && !$post->post_parent) {
                $add_item_text(get_the_title());

            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $post = get_post($parent_id);
                    $breadcrumbs[] = Array(get_permalink($post->ID), get_the_title($post->ID));
                    $parent_id = $post->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);

                foreach ($breadcrumbs as $crumb) {
                    $add_item_link($crumb[0], $crumb[1]);
                }
                $add_item_text(get_the_title());

            } elseif (is_search()) {
                $add_item_text(sprintf('%s %s', __('Results for your search:', $args['text_domain']), get_search_query()));
            } elseif (is_tag()) {
                $add_item_text(sprintf('%s %s', __('Posts with the keyword:', $args['text_domain']), single_tag_title('', false)));
            } elseif (is_404()) {
                $add_item_text(__('Error 404', $args['text_domain']));
            }
        }

        if (get_query_var('paged')) {
            $inner_html .= $args['delimiter'];
            $add_item_text(sprintf('%s %s', __('Page', $args['text_domain']), get_query_var('paged')));
        }

    }

    if (is_home() || is_front_page())
        $add_item_link($home_link, $args['home'], false);

    if ($inner_html != '')
        $html_output = sprintf($args['container'], $inner_html);

    return apply_filters('breadcrumb_html', $html_output, $args);
}

function the_breadcrumb($custom_args=Array()) {
    echo get_breadcrumb($custom_args);
}