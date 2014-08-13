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
	public $version = '0.1.1';

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
		'shortcodes'
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
//				array(
//					'handle' => 'foundation',
//					'filename' => 'foundation.min',
//					'version' => 5
//				),
				array(
					'handle' => 'frontend-main',
					'filename' => 'frontend.main.min'
				),
			),
			'js' => array(
				array(
					'handle' => 'frontend-main',
					'filename' => 'frontend.main',
					'deps' => array( 'jquery', 'foundation' ),
					'footer' => true
				),
				array(
					'handle' => 'foundation',
					'filename' => 'foundation.min',
					'version' => 5,
					'deps' => array(
						'jquery',
						'modernizr',
						'fastclick',
						'jquery-cookie',
						'placeholder'
					),
					'footer' => true
				),
				array(
					'handle' => 'modernizr',
					'deps' => array( 'jquery' )
				),
				array(
					'handle' => 'fastclick',
					'deps' => array( 'jquery' ),
					'footer' => true
				),
				array(
					'handle' => 'jquery-cookie',
					'filename' => 'jquery.cookie',
					'deps' => array( 'jquery' ),
					'footer' => true
				),
				array(
					'handle' => 'placeholder',
					'deps' => array( 'jquery' ),
					'footer' => true
				)
			)
		),
		'backend' => array(
			'css' => array(
			),
			'js' => array(
			)
		),
	);

	/**
	 * The nav menus to register in WordPress.
	 *
	 * @since Client Dash Theme 0.1
	 */
	public $nav_menus = array(
		array(
			'ID' => 'site-nav',
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

		add_action( 'wp', array( $this, 'add_wrapper_classes' ) );

		add_action( 'init', array( $this, 'register_nav_menus' ) );

		add_filter( 'excerpt_length', array( $this, 'custom_excerpt_length'), 999 );

		add_theme_support( 'post-thumbnails' );
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
	 * Adds all classes for the wrapper.
	 *
	 * @since Client Dash Theme 0.1
	 */
	public function add_wrapper_classes() {
		if ( is_user_logged_in() ) {
			$this->wrapper_classes .= ' logged-in';
		}

		if ( is_home() ) {
			$this->wrapper_classes .= ' home';
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
}

$ClientDash_Theme = new ClientDash_Theme();