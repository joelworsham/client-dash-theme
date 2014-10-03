<?php

class ClientDash_Theme_Addons {

	public $meta_boxes = array(
		array(
			'ID'       => 'cd-addon-icon',
			'title'    => 'Icon',
			'callback' => array( __CLASS__, 'icon_callback' ),
			'page'     => 'addon',
			'context'  => 'side',
			'options'  => array(
				'_cd_addon_icon',
			)
		),
		array(
			'ID'       => 'cd-addon-link',
			'title'    => 'Download Link',
			'callback' => array( __CLASS__, 'link_callback' ),
			'page'     => 'addon',
			'context'  => 'normal',
			'options'  => array(
				'_cd_addon_link',
			)
		),
	);

	public function __construct() {

		add_action( 'init', array( $this, 'register_post_type' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		add_action( 'save_post', array( $this, 'save_meta_boxes' ) );
	}

	public function register_post_type() {

		$labels = array(
			'name'               => 'Addons',
			'singular_name'      => 'Addon',
			'menu_name'          => 'Addons',
			'add_new'            => 'Add New Addon',
			'add_new_item'       => 'Add New Addon',
			'edit_item'          => 'Edit Addon',
			'new_item'           => 'New Addon',
			'view_item'          => 'View Addon',
			'search_items'       => 'Search Addons',
			'not_found'          => 'No addons found',
			'not_found_in_trash' => 'No addons found in Trash',
			'parent_item_colon'  => 'Addon',
		);

		register_post_type( 'addon', array(
			'labels'        => $labels,
			'label'         => 'Addons',
			'public'        => true,
			'menu_position' => 5,
			'has_archive'   => 'addons',
			'menu_icon'     => 'dashicons-plus',
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
		) );
	}

	public function add_meta_boxes() {

		foreach ( $this->meta_boxes as $meta_box ) {

			// Substitute static classname for object
			$meta_box['callback'][0] = $this;

			add_meta_box(
				isset( $meta_box['ID'] ) ? $meta_box['ID'] : null,
				isset( $meta_box['title'] ) ? $meta_box['title'] : null,
				isset( $meta_box['callback'] ) ? $meta_box['callback'] : null,
				isset( $meta_box['page'] ) ? $meta_box['page'] : null,
				isset( $meta_box['context'] ) ? $meta_box['context'] : null,
				isset( $meta_box['priority'] ) ? $meta_box['priority'] : null
			);
		}
	}

	public function icon_callback() {

		global $post;

		// Security
		self::_nonce();

		$icon = get_post_meta( $post->ID, '_cd_addon_icon', true );

		?>
		<label for="cd-icon-data-icon" class="icon <?php echo isset( $icon ) ? 'icon-' . $icon : 'icon-star3'; ?>"></label>
		<input type="text" name="_cd_addon_icon" id="cd-icon-data-icon"
		       value="<?php echo isset( $icon ) ? $icon : 'star3'; ?>"/>
	<?php
	}

	public function link_callback() {

		global $post;

		// Security
		self::_nonce();

		$link = get_post_meta( $post->ID, '_cd_addon_link', true );

		?>
		<label for="cd-addon-link">Generally WP.org, but can be elsewhere.</label><br/>
		<input type="text" name="_cd_addon_link" id="cd-addon-link" class="widefat"
		       value="<?php echo isset( $link ) ? $link : ''; ?>"/>
	<?php
	}

	public function save_meta_boxes( $post_ID = 0 ) {

		// Oops, how did we get here?
		if ( $post_ID === 0 ) {
			return $post_ID;
		}

		// Verify this came from the right place
		if ( ! isset( $_POST['addon_nonce'] ) || ! wp_verify_nonce( $_POST['addon_nonce'], plugin_basename( __FILE__ ) ) ) {
			return $post_ID;
		}

		// Make sure user has rights
		if ( ! current_user_can( 'edit_post', $post_ID ) ) {
			return $post_ID;
		}

		// Save all of our meta (if it's been set)
		foreach ( $this->meta_boxes as $meta_box ) {

			foreach ( $meta_box['options'] as $option_name ) {

				if ( isset( $_POST[ $option_name ] ) ) {
					update_post_meta( $post_ID, $option_name, $_POST[ $option_name ] );
				} else {
					delete_post_meta( $post_ID, $option_name );
				}
			}

		}
	}

	private static function _nonce() {
		?>
		<input type="hidden" name="addon_nonce" id="addon_nonce"
		       value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>"/>
	<?php
	}
}

new ClientDash_Theme_Addons();