<article class="media article article-post">
  <div class="media-left">
    <div class="article-thumb img-holder">
      <a href="<?php the_permalink(); ?>"><img class="b-lazy" data-src="<?php echo bt_get_thumbnail(Lib\Core\Thumbnail::get_post_thumbnail_uri($post->ID),72,72);?>" alt="<?php the_title(); ?>"></a>
      <a class="article-extra" href="<?php the_permalink(); ?>"><span class="icon icon-round"><i class="fa fa-link fa-fw"></i></span></a>
    </div>
  </div>
  <div class="media-body">
    <h3 class="media-heading article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p class="article-desc"><?php echo get_the_excerpt()?></p>
    <div class="article-meta hide">
      <span class="meta meta-date">
        <time datetime="<?php the_time('Y-m-d h:s'); ?>" itemprop="datePublished"><?php the_time('Y-m-d'); ?></time>
      </span>
    </div>
  </div>
</article>