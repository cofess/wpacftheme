<?php

/**
 *	Hide default welcome dashboard message and create a custom one
 *
 *	@see https://trickspanda.com/customize-wordpress-welcome-panel/
 */
return function($value) {
	/**
	 * Hide default welcome dashboard message and create a custom one
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function custom_welcome_panel() {
		// Bail if not viewing the main dashboard page
		if ( get_current_screen()->base !== 'dashboard' ) {
			return;
		}

		$wordpressVer = get_bloginfo('version');
		$themeInfo = wp_get_theme();

		// Memory and server stats
		$memLimit = (int) ini_get('memory_limit');
		$memUsage= function_exists('memory_get_peak_usage') ? round(memory_get_peak_usage(TRUE) / 1024 / 1024, 2) : 0;			
		if ( !empty($memUsage) && !empty($memLimit) ) {
			$memPercent = round ($memUsage / $memLimit * 100, 0);
		}		
		$server_ip_address = (!empty($_SERVER[ 'SERVER_ADDR' ]) ? $_SERVER[ 'SERVER_ADDR' ] : "");
		if ($server_ip_address == "") { // Added for IP Address in IIS
			$server_ip_address = (!empty($_SERVER[ 'LOCAL_ADDR' ]) ? $_SERVER[ 'LOCAL_ADDR' ] : "");
		}

		$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		$mysqlVersion = mysqli_get_server_info( $connection );

		$gdl = gd_info();

		$hostName = gethostname();
		$phpVersion = PHP_VERSION;
		$osBits = (PHP_INT_SIZE * 8);

		$settings = array(
	        array(
	            'icon'  => 'dashicons dashicons-admin-generic',
	            'title' => __( 'Operating System', 'BT_TEXTDOMAIN' ),
	            'desc'  => php_uname( 's' )
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-location',
	            'title' => __( 'Server IP', 'BT_TEXTDOMAIN' ),
	            'desc'  => $server_ip_address
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-cloud',
	            'title' => __( 'Server Info', 'BT_TEXTDOMAIN' ),
	            'desc'  => esc_html($_SERVER['SERVER_SOFTWARE'])
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-info',
	            'title' => __( 'PHP', 'BT_TEXTDOMAIN' ),
	            'desc'  => $phpVersion
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-image-filter',
	            'title' => __( 'MySQL', 'BT_TEXTDOMAIN' ),
	            'desc'  => $mysqlVersion
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-wordpress',
	            'title' => __( 'WordPress', 'BT_TEXTDOMAIN' ),
	            'desc'  => $wordpressVer
	        ),
	        array(
	            'icon'  => 'dashicons dashicons-media-default',
	            'title' => __( 'Max Upload Size', 'BT_TEXTDOMAIN' ),
	            'desc'  => size_format(wp_max_upload_size())
	        ),
	    );

	    ?>
		<div class="welcome-panel-content custom-welcome-panel-content" style="max-width: inherit;">
			<h2><?php echo __( 'System Information', 'BT_TEXTDOMAIN' );?></h2>
			<ul class="server-info part-xs-2 part-sm-3 part-md-3 part-lg-4 part-xl-6">
				<?php foreach ($settings as $key => $val) {?>
				<li class="item icon-box">
					<div class="item-content text-center">
						<i class='<?php echo $val['icon'];?>'></i>
						<strong><?php echo $val['title'];?></strong>
						<span><?php echo $val['desc'];?></span>
					</div>
				</li>
				<?php }?>
				<?php if (function_exists('ini_get')) : ?>
				<li class="item icon-box">
					<div class="item-content text-center">
						<i class='dashicons dashicons-info'></i>
						<strong><?php echo __( 'PHP Time Limit', 'BT_TEXTDOMAIN' );?></strong>
						<span><?php echo ini_get('max_execution_time'); ?></span>
					</div>
				</li>
				<?php endif; ?>
				<li class="item icon-box">
					<div class="item-content text-center">
						<i class='dashicons dashicons-format-image'></i>
						<strong><?php echo __( 'GD Library', 'BT_TEXTDOMAIN' );?></strong>
						<span><?php if($gdl) echo $gdl['GD Version'];else echo "No"; ?></span>
					</div>
				</li>
				<li class="item icon-box">
					<div class="item-content text-center">
						<i class='dashicons dashicons-chart-pie'></i>
						<strong><?php echo __( 'Memory Usage', 'BT_TEXTDOMAIN' );?></strong>
						<span><?php echo $memUsage . " / " . $memLimit . "MB (" . $memPercent . "%)";?></span>
					</div>
				</li>
			</ul>
		</div>
	<?php
	}

	add_action( 'welcome_panel', 'custom_welcome_panel' );
};