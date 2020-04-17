<?php
/**
 * Header Template - Displays the Header of the website
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<!--[if lt IE 9]>
	<script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
	<![endif]-->
</head>

<body <?php body_class(); ?>>
<header id="site-header">
		<nav class="navbar navbar navbar-inverse navbar-static-top" role="navigation">
		  <div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapsed">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <div class="navbar-brand">
		      	<?php if(has_header_image()) :?>
		      		<a href="<?php echo home_url(); ?>" class="site-logo"><img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo('name'); ?>" /></a>
		       <?php else: ?>
		        	<a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a><br>
		        	<small><?php bloginfo( 'description'); ?></small>
		      <?php endif; ?>
		      </div>
		    </div>

		        <?php
		            wp_nav_menu( array(
		                'menu'              => 'primary-menu',
		                'theme_location'    => 'primary-menu',
		                'depth'             => 2,
		                'container'         => 'div',
		                'container_class'   => 'collapse navbar-collapse',
		        		'container_id'      => 'navbar-collapsed',
		                'menu_class'        => 'nav navbar-nav navbar-right',
		                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		                'walker'            => new wp_bootstrap_navwalker())
		            );
		        ?>
		    </div>
		</nav>
</header><!-- #masthead -->

<div class="main-content">