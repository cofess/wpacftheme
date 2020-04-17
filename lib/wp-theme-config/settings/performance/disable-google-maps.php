<?php

/**
 * Disable Google maps
 */

return function($value)
{
	add_action("wp_loaded", array($this, 'disableGoogleMapsObStart'));

	function disableGoogleMapsObStart()
	{
		ob_start(array($this, 'disableGoogleMapsObEnd'));
	}
	/**
	 * @param string $html
	 * @return mixed
	 */
	function disableGoogleMapsObEnd($html)
	{
		global $post;

		$exclude_ids = array();
		$exclude_from_disable_google_maps = $this->getOption('exclude_from_disable_google_maps');

		if( '' !== $exclude_from_disable_google_maps ) {
			$exclude_ids = array_map('intval', explode(',', $exclude_from_disable_google_maps));
		}
		if( $post && !in_array($post->ID, $exclude_ids, true) ) {
			$html = preg_replace('/<script[^<>]*\/\/maps.(googleapis|google|gstatic).com\/[^<>]*><\/script>/i', '', $html);

			if( $this->getOption('remove_iframe_google_maps') ) {
				$html = preg_replace('/<iframe[^<>]*\/\/(www\.)?google\.com(\.\w*)?\/maps\/[^<>]*><\/iframe>/i', '', $html);
			}
		}

		return $html;
	}
};
