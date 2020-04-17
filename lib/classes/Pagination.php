<?php

/**
 * Pagination
 * @author palmtreephp
 * https://github.com/palmtreephp/wp-pagination
 */

namespace Palmtree\WordPress\Pagination;

class Pagination
{
    protected $query;
    protected $maxPage;
    protected $links;

    protected $args = [
        'show_all'         => true,
        'prev_text'        => '&laquo;',
        'next_text'        => '&raquo;',
        'end_size'         => 2,
        'mid_size'         => 1,
        'container'        => true,
        'pagination_class' => 'pagination',
    ];

    /**
     * Pagination constructor.
     *
     * @param \WP_Query $query
     * @param array     $args
     */
    public function __construct($maxPage = 1, $query = null, $args = [])
    {
        $this->maxPage = $maxPage ? $maxPage : 1;
        $this->query = $query ? $query : $GLOBALS['wp_query'];

        foreach ($args as $key => $value) {
            $this->args[$key] = $value;
        }
    }

    /**
     * @return \WP_Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param \WP_Query $query
     *
     * @return Pagination
     */
    public function setQuery(\WP_Query $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @param array $args
     *
     * @return Pagination
     */
    public function setArgs(array $args)
    {
        $this->args = $args;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return Pagination
     */
    public function addArg($key, $value)
    {
        $this->args[$key] = $value;

        return $this;
    }

    /**
     * Returns bootstrap HTML output for our links
     *
     * @return string
     */
    public function getHtml()
    {
        $links = $this->getLinks();

        if (!$links) {
            return '';
        }

        $output = '';

        if($this->args['container']){
            $output .= '<nav class="navbar navbar-pagination" aria-label="Page navigation">';
        }

        $pagination_class = $this->args['pagination_class'] ? $this->args['pagination_class'] : 'pagination';

        $output .= '<ul class="'.$pagination_class.'">';

        foreach ($links as $link) {
            $itemClass = 'page-item';

            if (stripos($link, 'current') > -1) {
                $itemClass .= ' active';
            }

            $output .= '<li class="' . $itemClass . '">' . $link . '</li>';
        }

        $output .= '</ul>';

        if($this->args['container']){
            $output .= '</nav>';
        }

        return $output;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        if (!$this->links) {
            $this->generateLinks();
        }

        return $this->links;
    }

    /**
     * @param int $maxPage
     */
    public function setMaxPage($maxPage)
    {
        return $this->maxPage = $maxPage;
    }

    public function getMaxNumPages()
    {
        $maxPage = ($this->query->max_num_pages) ? $this->query->max_num_pages : $this->maxPage;
        return $maxPage;
    }

    /**
     * @return array
     */
    protected function generateLinks()
    {
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $big   = 999999999; // need an unlikely integer

        $args = array_replace($this->getArgs(), [
            'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'  => '?paged=%#%',
            'current' => $paged,
            'total'   => $this->getMaxNumPages(),
            'type'    => 'array',
        ]);

        $this->links = paginate_links($args);
    }

    /**
     * @return array
     */
    public function output()
    {
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $big   = 999999999; // need an unlikely integer

        $args = array_replace($this->getArgs(), [
            'base'     => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'   => '?paged=%#%',
            'current'  => $paged,
            'show_all' => false,
            'total'    => $this->getMaxNumPages(),
            'type'     => 'list',
            'end_size' => 2,
            'mid_size' => 1
        ]);

        return paginate_links($args);
    }
}
