<?php
$the_query = bt_get_related_posts( get_the_ID(), 4 ); 
// Display posts
if ( $the_query->have_posts() ) : 
?>
<div class="widget widget-related-article">
  <h3 class="widget-title">Related News</h3>
  <div class="widget-body">
    <section class="row articles related-articles">
      <?php while ( $the_query->have_posts() ) : $the_query->the_post();?>
      <div class="col-md-6">
        <?php get_template_part( "views/item/item-related-post" ) ?>
      </div>
      <?php endwhile;?>
    </section>
  </div>
</div>
<?php endif; 
wp_reset_query();
?>
<div class="widget widget-related-article">
  <h3 class="widget-title">Related News</h3>
  <div class="widget-body">
    <section class="row articles related-articles">
    <?php
      $post_num = 4;
      $exclude_ids = array ($post->ID);
      $tags = wp_get_post_tags($post->ID);
      $cat_ids = wp_get_post_categories($post->ID);
      $i = 0;
      if ( $tags ) {
        $tag_ids = array();
        foreach($tags as $tag) {
          $tag_ids[] = $tag->term_id;
        }
        $args = array(
          'post_status'      => 'publish',
          'tag__in'          => $tag_ids,
          'post__not_in'     => $exclude_ids,
          'orderby'          => 'post_date',
          'caller_get_posts' => 1,
          'posts_per_page'   => $post_num
        );
        query_posts($args);
        while( have_posts() ) { the_post(); ?>
          <div class="col-md-6">
            <?php get_template_part( "templates/item/item-related-post" ) ?>
          </div>
          <?php
          $exclude_ids[] = $post->ID;
          $i ++;
        } wp_reset_query();
      }
      if ( $cat_ids && $i < $post_num ) {
        $args = array(
          'post_status'      => 'publish',
          'category__in'     => $cat_ids,
          'post__not_in'     => $exclude_ids,
          'orderby'          => 'post_date',
          'caller_get_posts' => 1,
          'posts_per_page'   => $post_num - $i
        );
        query_posts($args);
        while( have_posts() ) { the_post(); ?>
          <div class="col-md-6">
            <?php get_template_part( "templates/item/item-related-post" ) ?>
          </div>
          <?php $i++;
        } 
        wp_reset_query();
      }
      if ( $i  == 0 )  echo '<div class="col-md-12"><span>No related posts!</span></div>';
    ?>
    </section>
  </div>
</div>