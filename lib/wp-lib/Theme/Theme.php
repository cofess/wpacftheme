<?php
/**
 * https://github.com/creative-workflow/lib-wordpress
 */
namespace Lib\Theme;
use Lib\Traits\Singleton;

class Theme{

  use Singleton;

  public $header='';
  public $footer='';

  public function addSupport($feature, $args=null){
    add_action( 'after_setup_theme', function() use($feature, $args){
      add_theme_support($feature, $args);
    });

    return $this;
  }

  public function loadTextDomain($key, $src){
    add_action( 'after_setup_theme', function() use($key, $src){
      load_theme_textdomain($key, $src);
    });

    return $this;
  }

  public function addBodyClass($class){
    add_filter( 'body_class', function($classes) use($class){
      if(is_callable($class))
        $class = $class();

      if($class)
        $classes[] = $class;

      return $classes;
    } );

    return $this;
  }

  public function conditional($action, $callable){
    add_action($action, function() use($callable){
      call_user_func($callable, $this);
    });
    return $this;
  }

  function addFooterContent($input) {
    add_action( 'wp_footer', function() use($input){
      echo $input;
    }, 101 );
    return $this;
  }

  function addHeaderContent($input) {
    add_action( 'wp_head', function() use($input){
      echo $input;
    }, 101 );

    return $this;
  }

  public function pageTemplate(){
    return get_query_template('page');
  }

  public function postTemplate(){
    return get_query_template('single');
  }

  public function parentTemplate($which){
    return get_template_directory() . '/' .$which;
  }

  public function header($header=null){
    if($header === null)
      return $this->header;

    $this->header = $header;
    return $this;
  }

  public function footer($footer=null){
    if($footer === null)
      return $this->footer;

    $this->footer = $footer;
    return $this;
  }

  /**
   * Adding the Open Graph Meta Info
   * Docs: http://ogp.me
   */
  function addToHeaderOpenGraphMeta(){
    //TODO Review this to publish all information about Post to facebook OpenGraph
    if (is_single()) {
      global $post;
      if (has_excerpt($post->ID)) {
        $description = strip_tags(get_the_excerpt());
      } else {
        $description = str_replace("\r\n", ' ', substr(strip_tags(strip_shortcodes($post->post_content)), 0, 160));
      }
      if (empty($description)) {
        $description = get_bloginfo('description');
      }
      $pageThumb = "";
      if (has_post_thumbnail($post->ID)) {
        $thumbnailSrc = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
        $pageThumb = esc_attr($thumbnailSrc[0]);
      }
      $metas = [
        'og:site_name' => get_bloginfo('name'),
        'og:url' => get_permalink(),
        'og:type' => 'article',
        'og:image' => $pageThumb,
        'og:title' => get_the_title(),
        'og:description' => $description
      ];
      foreach ($metas as $property => $content) {
        echo "<meta property='$property' content='$content'>\n";
      }
    }
  }
  
}
