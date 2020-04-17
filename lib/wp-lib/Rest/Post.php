<?php

namespace Lib\Rest;

use Lib\Abstracts\Post_Abstract;
use Lib\Traits\Singleton;

/**
 * Post
 *
 * @author  Mat Lipe
 * @since   3.10.2017
 *
 */
class Post extends Post_Abstract {
	use Singleton;

	const POST_TYPE = 'post';

	protected $taxonomies = [
		'category',
		'post_tag',
	];

	protected $allowed_meta_keys = [];

	protected $related = [];
}