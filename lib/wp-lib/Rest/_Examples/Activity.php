<?php

namespace Lib\Rest;

use Lib\Abstracts\Post_Abstract;
use Lib\Post_Types\Activities;
use Lib\Taxonomies\ActivityCategories;
use Lib\Taxonomies\AgeRange;
use Lib\Taxonomies\Type;

/**
 * Activity
 *
 * @author  Mat Lipe
 * @since   1/11/2017
 *
 * @package WSWD\Rest_Api
 */
class Activity extends Post_Abstract {

	const POST_TYPE = Lib\Post_Types\Activity::NAME;

	protected $taxonomies = [
		'category',
		'post_tag',
		ActivityCategories::NAME,
		Type::NAME,
		AgeRange::NAME,
	];

	protected $allowed_meta_keys = [
		Activities::COST_META_KEY,
		Activities::SEASONS_META_KEY,
		Activities::HANDICAP_META_KEY,
		Activities::FEATURED_META_KEY,
	];

}
