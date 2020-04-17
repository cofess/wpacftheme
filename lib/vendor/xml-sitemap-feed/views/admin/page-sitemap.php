<style type="text/css">
<?php include XMLSF_DIR . '/views/styles/admin.css'; ?>
</style>
<div class="wrap">

	<h1><?php _e('XML Sitemap','xml-sitemap-feed'); ?></h1>

	<p>
		<?php printf( /* translators: Plugin name */ __('These settings control the XML Sitemaps generated by the %s plugin.','xml-sitemap-feed'),__('XML Sitemap & Google News','xml-sitemap-feed')); ?>
		<?php printf( /* translators: Writing Settings URL */ __('For ping options, go to %s.','xml-sitemap-feed'),'<a href="options-writing.php">'.translate('Writing Settings').'</a>'); ?>
	</p>

	<nav class="nav-tab-wrapper">
		<a href="?page=xmlsf&tab=post_types" class="nav-tab <?php echo $active_tab == 'post_types' ? 'nav-tab-active' : ''; ?>"><?php _e('Post types','xml-sitemap-feed'); ?></a>
		<a href="?page=xmlsf&tab=taxonomies" class="nav-tab <?php echo $active_tab == 'taxonomies' ? 'nav-tab-active' : ''; ?>"><?php _e('Taxonomies','xml-sitemap-feed'); ?></a>
		<a href="?page=xmlsf&tab=advanced" class="nav-tab <?php echo $active_tab == 'advanced' ? 'nav-tab-active' : ''; ?>"><?php echo translate('Advanced'); ?></a>
	</nav>

	<div class="main">
		<form method="post" action="options.php">

			<?php settings_fields( 'xmlsf_'.$active_tab ); ?>

			<?php do_settings_sections( 'xmlsf_'.$active_tab ); ?>

			<?php submit_button(); ?>

		</form>
	</div>

	<div class="sidebar">
		<h3><span class="dashicons dashicons-welcome-view-site"></span> <?php echo translate('View'); ?></h3>
		<p>
			<?php
			printf (
			/* translators: Sitemap name with URL */
			__( 'Open your %s', 'xml-sitemap-feed' ),
			'<strong><a href="'.$url.'" target="_blank">'.__('XML Sitemap Index','xml-sitemap-feed') . '</a></strong><span class="dashicons dashicons-external"></span>'
			); ?>
		</p>

		<h3><span class="dashicons dashicons-admin-tools"></span> <?php echo translate('Tools'); ?></h3>
		<form action="" method="post">
			<?php wp_nonce_field( XMLSF_BASENAME.'-help', '_xmlsf_help_nonce' ); ?>
			<input type="submit" name="xmlsf-check-conflicts" class="button button-small" value="<?php _e( 'Check for conflicts', 'xml-sitemap-feed' ); ?>" /> &nbsp;
			<input type="submit" name="xmlsf-clear-settings" class="button button-small" value="<?php _e( 'Reset XML sitemaps', 'xml-sitemap-feed' ); ?>" onclick="javascript:return confirm('<?php _e('Clear all XML Sitemap & Google News Sitemap settings.','xml-sitemap-feed'); ?> <?php _e('This will revert all your sitemap settings to the plugin defaults.','xml-sitemap-feed'); ?>\n\n<?php echo translate('Are you sure you want to do this?'); ?>')" />
		</form>

	</div>

</div>