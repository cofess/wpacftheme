<article class="article article-product">
  <div class="article-thumb img-holder">
    <a href="<?php the_permalink(); ?>"><img class="b-lazy" data-src="<?php echo bt_get_thumbnail(wp_get_attachment_image_src( tr_posts_field('images')[0],full)[0],400,400);?>" alt="<?php the_title(); ?>"></a>
  </div>
  <div class="article-body">
    <h3 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  </div>
  <a class="article-extra" href="<?php the_permalink(); ?>"></a>
</article>
