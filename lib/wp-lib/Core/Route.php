<?php

namespace Lib\Core;

use Lib\Traits\Singleton;

/**
 * Route
 *
 * Routes a custom url to a page template
 *
 * @example Route::init();
 * @example Route::add( 'custom-page', array( 'title' => __( 'Custom Page' ), 'template' => get_stylesheet_directory()
 *          . '/content/custom-page.php' ) );
 *
 */
class Route {
	use Singleton;

	const POST_TYPE = 'lib/core/route';
	const QUERY_VAR = 'lib/core/route_template';
	const PARAM_QUERY_VAR = 'lib/core/route_param';
	const OPTION = 'lib/core/route_cache';
	const POST_ID_OPTION = 'lib/core/route_post_id';

	/**
	 * post_id
	 *
	 * The id of the placeholder post
	 *
	 * @static
	 * @var int
	 */
	protected static $post_id = 0;

	/**
	 * routes
	 *
	 * @static
	 * @var array
	 */
	private static $routes = [];


	/**
	 * add_route
	 *
	 * @param string $url      - url appended to the sites home url
	 * @param array  $args     (
	 *                         title => string,
	 *                         template => string - full file path to template
	 *                         )
	 *
	 * @return void
	 */
	public static function add( $url, array $args ) {
		self::$routes[ $url ] = $args;
	}


	/**
	 * Register Post Type
	 *
	 * Setup a special post type to be used in the queries so we return
	 * an actual post and not a 404.
	 * A single post of this type is created to be queried
	 * We then filter the post to match our needs
	 *
	 * @static
	 *
	 * @return void
	 */
	public static function register_post_type() {

		$args = [
			'public'              => false,
			'show_ui'             => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'supports'            => [ 'title' ],
			'has_archive'         => false,
			'rewrite'             => [
				'slug'       => false,
				'with_front' => false,
				'feeds'      => false,
				'pages'      => false,
			],
		];
		register_post_type( self::POST_TYPE, $args );
	}


	public function hook() {
		add_filter( 'query_vars', [ $this, 'add_query_var' ] );
		add_action( 'init', [ $this, 'setup_endpoints' ] );
		add_action( 'init', [ __CLASS__, 'register_post_type' ] );
		add_action( 'pre_get_posts', [ $this, 'maybe_add_post_hooks' ], 10, 1 );

		add_action( 'wp_loaded', [ $this, 'maybe_flush_rules' ], 999999999999 );
	}


	/**
	 * Maybe Add Post Hooks
	 *
	 * Add the post filtering hooks only if we are parsing
	 * a custom route
	 *
	 * @param $query
	 *
	 * @return void
	 */
	public function maybe_add_post_hooks( $query ) {
		if( isset( $query->query_vars[ self::QUERY_VAR ] ) ){
			$this->add_post_hooks();
		}
	}


	/**
	 * Add Post Hooks
	 *
	 * Hooks we only run if we are retrieving a custom route
	 *
	 * @see $this->maybe_add_post_hooks
	 *
	 * @return void
	 */
	protected function add_post_hooks() {
		add_filter( 'the_title', [ $this, 'get_title' ], 10, 2 );
		add_filter( 'single_post_title', [ $this, 'get_title' ], 10, 2 );
		add_filter( 'body_class', [ $this, 'adjust_body_class' ], 99 );
		add_filter( 'template_include', [ $this, 'override_template' ], 10, 1 );

	}


	/**
	 * Adjust Body Class
	 *
	 * Remove misleading body classes generated by the post type and id
	 * Add a body class which matches the current route
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	public function adjust_body_class( $classes ) {
		$post = get_post();

		foreach( $classes as $k => $_class ){
			if( strpos( $_class, 'postid' ) !== false ){
				unset( $classes[ $k ] );
			} elseif( $_class == $post->post_name ) {
				unset( $classes[ $k ] );
			} elseif( strpos( $_class, 'page-template' ) !== false ) {
				unset( $classes[ $k ] );
			}
		}

		$route = self::get_current_route();
		$classes[] = sanitize_title_with_dashes( $route[ 'title' ] );
		$template = explode( '/', $route[ 'template' ] );
		$classes[] = 'page-template-' . str_replace( '.', '-', end( $template ) );

		return $classes;
	}


	/**
	 * Get Current Route
	 *
	 * Get the args like title and template for the current route
	 * Will return false is no route is found
	 *
	 * @return mixed
	 */
	public function get_current_route() {
		$route = get_query_var( self::QUERY_VAR );
		if( empty( $route ) || empty( self::$routes[ $route ] ) ){
			return false;
		}

		return self::$routes[ $route ];
	}


	/**
	 * Maybe Flush Rules
	 *
	 * Adding rewrite rules requires a flush of all rules
	 * This checks for new ones then flushes as needed
	 *
	 * @return void
	 */
	public function maybe_flush_rules() {
		if( get_option( self::OPTION ) != md5( serialize( self::$routes ) ) ){
			flush_rewrite_rules();
			update_option( self::OPTION, md5( serialize( self::$routes ) ) );
		}
	}


	/**
	 * Add Query Var
	 *
	 * Add a query var to allow for our custom urls to be specificed
	 *
	 * @param $vars
	 *
	 * @return array
	 */
	public function add_query_var( $vars ) {
		$vars[] = self::QUERY_VAR;
		$vars[] = self::PARAM_QUERY_VAR;

		return $vars;
	}


	/**
	 * Setup Endpoints
	 *
	 * Register the rewrite rules to send the appropriate urls to our
	 * custom query var which will tell us what route we are using
	 *
	 *
	 * @return void
	 */
	public function setup_endpoints() {
		foreach( self::$routes as $_route => $_args ){
			add_rewrite_rule( $_route . '/([^/]+)/?.?', 'index.php?post_type=' . self::POST_TYPE . '&p=' . self::get_post_id() . '&' . self::QUERY_VAR . '=' . $_route . '&' . self::PARAM_QUERY_VAR . '=$matches[1]', 'top' );

			add_rewrite_rule( $_route, 'index.php?post_type=' . self::POST_TYPE . '&p=' . self::get_post_id() . '&' . self::QUERY_VAR . '=' . $_route, 'top' );

		}
	}


	/**
	 * Get Post ID
	 *
	 * Get the ID of the placeholder post
	 *
	 * @static
	 * @return int
	 */
	protected static function get_post_id() {
		if( self::$post_id ){
			return self::$post_id;
		}

		self::$post_id = (int) get_option( self::POST_ID_OPTION, false );
		if( self::$post_id ){
			return self::$post_id;
		}

		$posts = get_posts( [
			'post_type'      => self::POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		] );
		if( $posts ){
			self::$post_id = $posts[ 0 ];
		} else {
			self::$post_id = self::make_post();
		}

		if( self::$post_id ){
			update_option( self::POST_ID_OPTION, (int) self::$post_id );
		}

		return self::$post_id;
	}


	/**
	 * Make Post
	 *
	 * Make a new placeholder post
	 *
	 * @static
	 * @return int The ID of the new post
	 */
	private static function make_post() : int {
		$post = [
			'post_title'  => 'WP Libs Placeholder Post',
			'post_status' => 'publish',
			'post_type'   => self::POST_TYPE,
		];
		$id = wp_insert_post( $post );
		if( is_wp_error( $id ) ){
			return 0;
		}

		return $id;
	}


	/**
	 * Override Template
	 *
	 * Use the specified template file based on the current route
	 *
	 * @param string $template
	 *
	 * @return string
	 */
	public function override_template( $template ) {
		$route = $this->get_current_route();

		return $route[ 'template' ];
	}


	/********** statics ***************/


	/**
	 * Is Current Route
	 *
	 * Are we currently on a specified route page?
	 *
	 * @param string $route - the route slug
	 *
	 * @return bool
	 */
	public function is_current_route( $route ) {
		if( get_query_var( self::QUERY_VAR ) === $route ){
			return true;
		}

		return false;
	}


	/**
	 * Get Url Parameter
	 *
	 * Retrieves the value sent within the url
	 * /%route%/%param%/
	 *
	 * @example If the url is /profile/mat/ this will return 'mat'
	 *
	 * @return string
	 */
	public function get_url_parameter() {
		return get_query_var( self::PARAM_QUERY_VAR );
	}


	/**
	 * Get Title
	 *
	 * Set the title for the placeholder page
	 *
	 * @param string $title
	 * @param int    $post_id
	 *
	 * @return string
	 */
	public function get_title( $title, $post ) {
		$post = get_post( $post );
		if( $post->ID == self::get_post_id() ){
			$route = $this->get_current_route();

			return $route[ 'title' ];
		}

		return $title;
	}

}