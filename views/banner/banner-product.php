<?php
/**
 * https://codex.wordpress.org/Class_Reference/WP_Query
 */
$args = array( 
	'post_type'      => 'banner',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
  'showposts'      => 1,
  'meta_query'     => array(
    'relation'        => 'AND',
		'position_clause' => array(
			'key'     => 'position',
			'value'   => 1,
			'compare' => '=',
    ),
    'type_clause' => array(
      'key'     => 'bind_post_type',
      'value'   => 'product',
      'compare' => '=',
    ),
  ),
  'orderby'     => 'post_date',
	'order'       => 'desc',
);
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();?>
<?php if(tr_posts_field('sliders')) : ?>
<div class="topSlider sliderContainer">
  <div class="royalSlider rsMinW rs-theme-flat full-width-slider">
    <?php foreach(tr_posts_field('sliders') as $banner) {?>
    <div class="rsContent">
      <?php if($banner['url']) : ?>
        <a href="<?php echo $banner['url'];?>">
          <img class="rsImg" src="<?php echo wp_get_attachment_image_src($banner['image'],full)[0];?>" alt="<?php echo $banner['title'];?>" />
        </a>
      <?php else : ?>
        <img class="rsImg" src="<?php echo wp_get_attachment_image_src($banner['image'],full)[0];?>" alt="<?php echo $banner['title'];?>" />
      <?php endif; ?>
    </div>
    <?php } ?>
  </div>
</div>
<?php endif; ?>
<?php endwhile; wp_reset_query(); ?>