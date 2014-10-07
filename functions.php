<?php

/**
 * Class ClientDash_Theme
 *
 * The main class for all functionality of the theme.
 *
 * @package WordPress
 * @subpackage Client Dash Theme
 *
 * @since Client Dash Theme 0.1
 */
class ClientDash_Theme {
	/**
	 * The current theme version.
	 *
	 * @since Client Dash Theme 0.1
	 */
	public $version = '0.2';

	/**
	 * Classes to go into the wrapper div.
	 *
	 * @since Client Dash Theme 0.1
	 *
	 */
	public $wrapper_classes = '';
	/**
	 * All necessary files to require.
	 *
	 * @since Client Dash Theme 0.1
	 */
	public $necessities = array(
		'scripts',
		'shortcodes',
		'admin/features',
		'admin/addons',
	);

	/**
	 * All files to load.
	 *
	 * @since JWorsham Side Loader 0.1
	 */
	public $files = array(
		'frontend' => array(
			'css' => array(
				array(
					'handle' => 'normalize'
				),
				array(
					'handle'   => 'frontend-main',
					'filename' => 'client-dash-theme-frontend.min'
				),
			),
			'js'  => array(
				array(
					'handle'   => 'frontend-main',
					'filename' => 'client-dash-theme.min',
					'deps'     => array( 'frontend-deps' ),
					'footer'   => true
				),
				array(
					'handle'   => 'frontend-deps',
					'filename' => 'client-dash-theme-deps.min',
					'deps'     => array( 'jquery' ),
					'footer'   => true
				),
			),
		),
		'backend'  => array(
			'css' => array(
				array(
					'handle'   => 'backend-main',
					'filename' => 'client-dash-theme-backend.min',
				),
			),
			'js'  => array(
				array(
					'handle'   => 'backend-main',
					'filename' => 'client-dash-theme-backend.min',
					'deps'     => array( 'jquery', 'jquery-ui-core' ),
					'footer'   => true,
				),
			),
		),
	);

	/**
	 * The nav menus to register in WordPress.
	 *
	 * @since Client Dash Theme 0.1
	 */
	public $nav_menus = array(
		array(
			'ID'   => 'site-nav',
			'name' => 'Site Navigation'
		)
	);

	/**
	 * The global length of the excerpt.
	 *
	 * @since JWorsham Side Loader 0.1
	 */
	public $excerpt_length = 100;

	/**
	 * The main construct function.
	 *
	 * @since Client Dash Theme 0.1
	 */
	function __construct() {
		$this->require_necessities();

		// Register nav menus
		add_action( 'init', array( $this, 'register_nav_menus' ) );

		// Modify the default excerpt length
		add_filter( 'excerpt_length', array( $this, 'custom_excerpt_length' ), 999 );

		// Add sidebars
		add_action( 'init', array( $this, 'register_sidebars' ) );

		// Add some separators
		add_action( 'admin_menu', array( $this, 'add_separators' ), 9999 );

		// Allow featured images
		add_theme_support( 'post-thumbnails' );

		// Show draft posts on addons archive
		add_action( 'pre_get_posts', array( $this, 'addons_show_draft' ) );

		// Modify breadcrumbs
		add_filter( 'wpseo_breadcrumb_single_link', array( $this, 'modify_breadcrumbs' ), 10, 2 );
		add_filter( 'wpseo_breadcrumb_output', array( $this, 'modify_breadcrumbs_wrapper' ) );

		// Remove page title on generator confirm
		if ( isset( $_POST['gform_submit'] ) && $_POST['gform_submit'] == '1' ) {
			add_filter( 'cd_page_title', '__return_false' );
		}

		// Google Analytics
		add_action( 'wp_head', array( $this, 'google_analytics' ), 999 );
	}

	/**
	 * Requires all files for the theme.
	 *
	 * @since Client Dash Theme 0.1
	 */
	private function require_necessities() {
		foreach ( $this->necessities as $file ) {
			require_once( get_template_directory() . '/inc/' . $file . '.php' );
		}
	}

	/**
	 * Registers all nav menus for the theme.
	 *
	 * @since Client Dash Theme 0.1
	 */
	public function register_nav_menus() {
		foreach ( $this->nav_menus as $menu ) {
			register_nav_menu( $menu['ID'], $menu['name'] );
		}
	}

	public function register_sidebars() {

		register_sidebar( array(
			'name' => 'Blog',
			'id' => 'blog',
			'description' => 'Shows on the blog feed.',
		) );
	}

	public function add_separators() {

		global $menu;

		// Move posts up one so there's room for a separator
		$menu[4] = $menu[5];

		$menu[5] = array(
			'',
			'read',
			'cd-separator-1',
			'',
			'wp-menu-separator'
		);

		$menu[8] = array(
			'',
			'read',
			'cd-separator-2',
			'',
			'wp-menu-separator'
		);
	}

	public function addons_show_draft( $query ) {

		$query->set( 'post_status', array( 'publish', 'draft' ) );
		$query->set( 'post_status', array( 'numberposts', -1 ) );
	}

	public function modify_breadcrumbs( $html, $link ) {

		$class = $link['url'] == 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ? 'class="current"' : '';
		$link['url'] = $link['url'] == 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ? '#' : $link['url'];
		return "<li $class><a href='$link[url]'>$link[text]</a></li>";
	}

	public function modify_breadcrumbs_wrapper( $breadcrumb ) {

		// Replace all the gunk with nothing
		return preg_replace( '/ » |\n|\t|\r|<span.*?>|<\/span>/', '', $breadcrumb );
	}

	/**
	 * Modifies the default excerpt length.
	 *
	 * @since Client Dash Theme 0.1
	 *
	 * @return int The new excerpt length.
	 */
	public function custom_excerpt_length() {
		return $this->excerpt_length;
	}

	/**
	 * Provides a URI for the theme images directory.
	 *
	 * @since Client Dash Theme 0.1
	 */
	public static function images_dir() {
		echo get_template_directory_uri() . '/assets/images/';
	}

	public function google_analytics() {

		if ( ! is_user_logged_in() ) {
			ob_start();
			?>
			<script>
				(function (i, s, o, g, r, a, m) {
					i['GoogleAnalyticsObject'] = r;
					i[r] = i[r] || function () {
						(i[r].q = i[r].q || []).push(arguments)
					}, i[r].l = 1 * new Date();
					a = s.createElement(o),
						m = s.getElementsByTagName(o)[0];
					a.async = 1;
					a.src = g;
					m.parentNode.insertBefore(a, m)
				})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

				ga('create', 'UA-37145568-2', 'auto');
				ga('send', 'pageview');

			</script>
			<?php
			echo ob_get_clean();
		}
	}
}

$ClientDash_Theme = new ClientDash_Theme();