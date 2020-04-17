<?php

namespace Lib\Core;
use Lib\Core\Meta;

class Taxonomy{

    /**
	 * term_id
	 *
	 * @var int
	 */
	protected $term_id;

	/**
	 * term
	 *
	 * @var \WP_Term
	 */
    protected $term = null;
    
    public function __construct( $term_id ) {
		$this->term_id = $term_id;
    }
    
    public function get_term() {
		if ( null !== $this->term ) {
			return $this->term;
		}
		$this->term = get_term( $this->term_id );

		return $this->term;

    }

    public function get_terms(){
        $terms = [];
        foreach(get_categories([
          'taxonomy' => $this->term_id,
          'orderby'  => 'name',
          'order'    => 'ASC'
        ]) as $term)
        $terms[] = new \Lib\Core\Term($term, $this);
    
        return $terms;
    }
    
    public function get_id() {
		return (int) $this->term_id;
    }
    
    /**
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get_meta( string $key, $default = null ) {
		$value = Meta::get_meta( $this->term_id, $key, 'term' );
		if ( null !== $default && empty( $value ) ) {
			return $default;
		}

		return $value;
	}

    /**
     * add taxtonomy filter
     * @author cofess | cofess@foxmail.com
     * @param string $post_type 内容类型
     * @param string $taxonomy  分类目录
     */
    public static function add_taxtonomy_filter($post_type, $taxonomy) {
        return function() use($post_type, $taxonomy) {
            global $typenow;
    
            if($typenow == $post_type) {
                $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
                $info_taxonomy = get_taxonomy($taxonomy);
                $terms = get_terms($taxonomy);
                if(count($terms) > 0) {
                    wp_dropdown_categories(array(
                        'show_option_all'   => __("Show All {$info_taxonomy->label}"),
                        'taxonomy'          => $taxonomy,
                        'name'              => $taxonomy,
                        'orderby'           => 'name',
                        'selected'          => $selected,
                        'hierarchical'      => true,
                        'depth'             =>  2,
                        'show_count'        => true,
                        'hide_empty'        => false,
                    ));
                }
            }
        };
    }
    
    /**
     * parse taxtonomy filter query
     * @author cofess | cofess@foxmail.com
     * @param  string $post_type 内容类型
     * @param  string $taxonomy  分类目录
     */
    public static function parse_taxtonomy_filter_query($post_type, $taxonomy) {
    
        return function($query) use($post_type, $taxonomy) {
            global $pagenow;
    
            $q_vars = &$query->query_vars;
    
            if( $pagenow == 'edit.php'
                && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type
                && isset($q_vars[$taxonomy])
                && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0
            ) {
                $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
                $q_vars[$taxonomy] = $term->slug;
            }
        };
    }

}
