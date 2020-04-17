<?php
/**
 * @author Crunchify.com
 * Plugin: All in One Webmaster
 * URL: https://crunchify.com/all-in-one-webmaster/
 */
?>

<div class=wrap>
	<h1><?php _e('Automatic submit sitemap to search engines','xml-sitemap-feed'); ?></h1>
	<?=$show_sitemap?>
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<?php wp_nonce_field( XMLSF_BASENAME.'-submit-sitemap', '_xmlsf_submit_sitemap_nonce' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label>Sitemap URL</label>
					</th>
					<td>
						<input name="sitemap_URL" type="text" size="75" value="<?php echo get_option('sitemap_URL'); ?>" />
						<br />(example: http://example.com/sitemap.xml)
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" name="update_sitemap" class="button-primary" value="<?php _e('Submit to Google and Bing'); ?>" />
				<a class="button" href="http://www.bing.com/webmaster/ping.aspx?siteMap=<?php echo get_option('sitemap_URL'); ?>" target="_blank">手动提交到Bing</a>
				<a class="button" href="http://www.google.com/webmasters/sitemaps/ping?sitemap=<?php echo get_option('sitemap_URL'); ?>" target="_blank">手动提交到Google</a>
			</div>
	</form>
</div>