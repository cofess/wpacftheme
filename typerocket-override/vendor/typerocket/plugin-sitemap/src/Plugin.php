<?php
namespace TypeRocketSitemap;

class Plugin
{
    public $match = 'seo\/sitemap\.xml';
    public $noTrailing = true;
    public $do = 'index@Sitemap:\TypeRocketSitemap\Controllers\SitemapController';

    function __construct()
    {
        do_action('trp_sitemap', $this);

        add_action('tr_load_routes', function() {
            tr_route()
                ->get()
                ->noTrailingSlash($this->noTrailing)
                ->match($this->match)
                ->do($this->do);
        });
    }
}