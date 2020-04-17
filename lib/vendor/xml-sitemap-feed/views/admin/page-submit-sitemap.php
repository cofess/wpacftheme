<?php
/**
 * @author Crunchify.com
 * Plugin: All in One Webmaster
 * URL: https://crunchify.com/all-in-one-webmaster/
 */
add_action( 'admin_menu', 'add_submit_sitemap_menu' );
	function add_submit_sitemap_menu(){
	add_submenu_page('tools.php', 'Submit Sitemap', 'Submit Sitemap', 'manage_options', 'submit-sitemap', 'auto_submit_sitemap');
}

/**
 * Sitemap Submit.
 *
 * @since 9.0
 */
function all_in_one_premium_webmaster_sitemap_submit($sitemap_URL1, $search_engine, $OKmessage, $NOmessage) {
	$DONE_MSG = 'DONE';
	$NOPE_MSG = 'NOPE';

	$pingurl = $search_engine . $sitemap_URL1;
	$source = @file_get_contents ( $pingurl );

	if ($source != false) {

		$source = strip_tags ( $source );
		$source = "WEBMASTER" . $source;

		$isOKmessage = stripos ( $source, $OKmessage );
		$isNOmessage = stripos ( $source, $NOmessage );

		if (($isOKmessage != false) && ($isNOmessage == false)) {
			$finalMessage = $DONE_MSG . $OKmessage;
		}
		if (($isOKmessage == false) && ($isNOmessage != false)) {
			$finalMessage = $NOPE_MSG . $NOmessage;
		}
		if (($isOKmessage == false) && ($isNOmessage == false)) {
			$finalMessage = $NOPE_MSG . 'Submission error';
		}
	} else if ($source == false) {
		$finalMessage = $NOPE_MSG . 'search_engine error';
	}
	return array (
			$source,
			$finalMessage
	);
}

// in main file
function auto_submit_sitemap() {
    if (isset ( $_POST ['update_sitemap'] )) {

		update_option ( 'sitemap_URL', ( string ) sanitize_text_field($_POST ["sitemap_URL"] ));
		$sitemap_URL1 = esc_url(get_option ( 'sitemap_URL' ));

		$show_sitemap = '';
		$last3 = substr ( $sitemap_URL1, - 1, 3 );
		$last5 = substr ( $sitemap_URL1, - 1, 5 );
		$check1 = "xml";
		$icon_url = get_bloginfo ( 'wpurl' );

		if ($sitemap_URL1 == "") {
			$show_sitemap .= '<div id="message" class="updated fade"><p>' . "Oops!! Blank field. Please provide sitemap URL" . '<br /><br /> Sitemap must ends with .xml or .xml.gz';
			$show_sitemap .= '</p></div>';
		}

		else {
			$webmasterlink = array (

				'goo' => array (
					'webmaster_engine' => 'Google',
					'search_engine'    => 'http://www.google.com/webmasters/sitemaps/ping?sitemap=',
					'OKmessage'        => 'Sitemap Notification Received',
					'NOmessage'        => 'Bad Request'
				),

				'bin' => array (
					'webmaster_engine' => 'Bing',
					'search_engine'    => 'http://www.bing.com/webmaster/ping.aspx?siteMap=',
					'OKmessage'        => 'Thanks for submitting your sitemap',
					'NOmessage'        => 'Bad Request'
				),

				// 'ask' => array (
				// 	'webmaster_engine' => 'Ask.com',
				// 	'search_engine'    => 'http://submissions.ask.com/ping?sitemap=',
				// 	'OKmessage'        => 'Thanks for submitting your sitemap',
				// 	'NOmessage'        => 'Bad Request'
				// )
			);

			$show_sitemap .= '<div id="message" class="updated fade"><p>';

			foreach ( $webmasterlink as $siln => $myArray1 ) {
				$webmaster_engine = $myArray1 ['webmaster_engine'];
				$search_engine = $myArray1 ['search_engine'];
				$OKmessage = $myArray1 ['OKmessage'];
				$NOmessage = $myArray1 ['NOmessage'];

				list ( $source, $finalMessage ) = all_in_one_premium_webmaster_sitemap_submit ( $sitemap_URL1, $search_engine, $OKmessage, $NOmessage );

				$statusTag = substr ( $finalMessage, 0, 4 );
				if ($statusTag == 'DONE') {
					$icon = '<span class="dashicons-before dashicons-yes" style="color:#46b450"></span>';
					$alter_link = '<br />';
				} else if ($statusTag == 'NOPE') {
					$icon = '<span class="dashicons-before dashicons-no-alt" style="color:#dc3232"></span>';
					$submission_URL1 = $search_engine . $sitemap_URL1;
					$alter_link = '<a href="' . $submission_URL1 . '" target="_blank"> (Try manually)</a><br /><br />';
				} else {
					$icon = '';
					$alter_link = '';
				}
				$finalMessage = substr ( $finalMessage, 4 );
				$insert_sitemap = "\n" . $icon . "<b>" . $webmaster_engine . ":  </b><i>" . $finalMessage . "</i><br />" . $alter_link;
				$show_sitemap .= $insert_sitemap;
			}
			$show_sitemap .= '</p></div>';
		}
		// echo $show_sitemap;
	}

	include XMLSF_DIR . '/views/admin/field-submit-sitemap.php';
}
