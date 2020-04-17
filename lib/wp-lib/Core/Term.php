<?php

namespace Lib\Core;

class Term{
  public $taxanomy;
  public $term;
  public $parent;
  public $name;
  public $termId;

  public function __construct($term, \Lib\Core\Taxanomy $taxanomy = null, $parent = null){
    $this->term     = $term;
    $this->id       = $term->term_id;
    $this->name     = $term->name;
    $this->taxanomy = $taxanomy;
    $this->parent   = $parent;
  }

  public function children(){
    $children = get_categories(
      [ 'parent' => $this->id ]
    );

    $children = [];
    foreach($children as $child){
      $children[]=new Term($child, $taxanomy, $this);
    }

    return $children;
  }

  /**
   * get terms limited to post type
   * @ $taxonomies - (string|array) (required) The taxonomies to retrieve terms from. 
   * @ $args  -  (string|array) all Possible Arguments of get_terms http://codex.wordpress.org/Function_Reference/get_terms
   * @ $post_type - (string|array) of post types to limit the terms to
   * @ $fields - (string) What to return (default all) accepts ID,name,all,get_terms. 
   * if you want to use get_terms arguments then $fields must be set to 'get_terms'
   */
  public function get_terms_by_post_type($taxonomies,$args,$post_type,$fields = 'all'){
    $args = array(
        'post_type' => (array)$post_type,
        'posts_per_page' => -1
    );
    $the_query = new WP_Query( $args );
    $terms = array();
    while ($the_query->have_posts()){
        $the_query->the_post();
        $curent_terms = wp_get_object_terms( $post->ID, $taxonomy);
        foreach ($curent_terms as $t){
          //avoid duplicates
            if (!in_array($t,$terms)){
                $terms[] = $c;
            }
        }
    }
    wp_reset_query();
    //return array of term objects
    if ($fields == "all")
        return $terms;
    //return array of term ID's
    if ($fields == "ID"){
        foreach ($terms as $t){
            $re[] = $t->term_id;
        }
        return $re;
    }
    //return array of term names
    if ($fields == "name"){
        foreach ($terms as $t){
            $re[] = $t->name;
        }
        return $re;
    }
    // get terms with get_terms arguments
    if ($fields == "get_terms"){
        $terms2 = get_terms( $taxonomies, $args );
        foreach ($terms as $t){
            if (in_array($t,$terms2)){
                $re[] = $t;
            }
        }
        return $re;
    }
  }
}
