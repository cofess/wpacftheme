<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-transform">
  <meta http-equiv="Cache-Control" content="no-siteapp">
  <meta name="robots" content="noindex,nofollow">
  <title><?php echo cs_get_option( 'maintenance-page-title','','_system_options' );?> - <?php bloginfo('name'); ?></title>
  <meta name="description" content="">
  <?php do_action('maintenance_header'); ?>
  <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <div class="page-overlay page-overlay-color page-overlay-image"></div>
  <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->
  <header class="header">
    <div class="container">
      <h1><?php echo cs_get_option( 'maintenance-subject','','_system_options' );?></h1>
      <div class="line">
        <div></div>
      </div>
      <div class="content"><?php echo cs_get_option( 'maintenance-content','','_system_options' );?></div>
    </div>
  </header>
  <!-- header end -->
  <section class="main">
    <div class="container">
      <ul id="countdown" data-date="<?php echo cs_get_option( 'maintenance-complete-date','','_system_options' );?>">
        <li>
          <span class="days">00</span>
          <p class="days_text">Days</p>
        </li>
        <li>
          <span class="hours">00</span>
          <p class="hours_text">Hours</p>
        </li>
        <li>
          <span class="minutes">00</span>
          <p class="minutes_text">Minutes</p>
        </li>
        <li>
          <span class="seconds">00</span>
          <p class="seconds_text">Seconds</p>
        </li>
      </ul>
    </div>
  </section>
  <!-- counnt dwon end -->
  <footer class="footer">
    <div class="container">
      <?php if (cs_get_option( 'enable-maintenance-social','','_system_options' )){;?>
      <div class="footer-social_menu">
        <ul class="social_icon">
          <?php if (tr_options_field('brand_options.facebook')){;?>
            <li><a href="<?php echo tr_options_field('brand_options.facebook');?>" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
          <?php }?>
          <?php if (tr_options_field('brand_options.twitter')){;?>
            <li><a href="<?php echo tr_options_field('brand_options.twitter');?>" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
          <?php }?>
          <?php if (tr_options_field('brand_options.google_plus')){;?>
            <li><a href="<?php echo tr_options_field('brand_options.google_plus');?>" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i></a></li>
          <?php }?>
          <?php if (tr_options_field('brand_options.pinterest')){;?>
            <li><a href="<?php echo tr_options_field('brand_options.pinterest');?>" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i></a></li>
          <?php }?>
          <?php if (tr_options_field('brand_options.instagram')){;?>
            <li><a href="<?php echo tr_options_field('brand_options.instagram');?>" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i></a></li>
          <?php }?>
          <?php if (tr_options_field('brand_options.linkedin')){;?>
            <li><a href="<?php echo tr_options_field('brand_options.linkedin');?>" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>
          <?php }?>
          <?php if (tr_options_field('brand_options.weibo')){;?>
            <li><a href="<?php echo tr_options_field('brand_options.weibo');?>" target="_blank" rel="nofollow"><i class="fa fa-weibo"></i></a></li>
          <?php }?>
        </ul>
      </div>
      <?php }?>
      <?php if (cs_get_option( 'maintenance-footer','','_system_options' )){;?>
        <div class="copyright"><?php echo cs_get_option( 'maintenance-footer','','_system_options' );?></div>
      <?php } else {;?>
        <div class="copyright">© <?php echo date('Y',current_time('timestamp')); ?> <?php bloginfo('name'); ?> All rights reserved.</div>
      <?php }?>
    </div>
  </footer>

  <?php do_action('maintenance_footer'); ?>
</body>

</html>