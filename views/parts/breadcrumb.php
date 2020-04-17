<?php 
  // $breadcrumb = get_breadcrumb(Array(
  //   'text_domain' => '',
  //   'delimiter'   => false,
  //   'home'        => 'Home',
  //   'home_link'   => get_bloginfo('url'),
  //   'before'      => '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">',
  //   'after'       => '<meta itemprop="position" content="%1$s" /></li>',
  //   'before_text' => '<span>',
  //   'after_text'  => '</span>',
  //   'class'       => 'breadcrumb',
  //   'container'   => '<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">%s</ol>'
  // ));
  // echo $breadcrumb;
?>
  <?php if ( function_exists( 'bread_crumb' ) ) bread_crumb(); ?> 
  <!-- <ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="#">About ASTA</a></li>
    <li class="active">Gallery</li>
  </ol> -->