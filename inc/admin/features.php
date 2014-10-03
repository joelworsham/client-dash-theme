<?php

class ClientDash_Theme_Features {

	public $meta_boxes = array(
		array(
			'ID'       => 'cd-feature-icon',
			'title'    => 'Icon',
			'callback' => array( __CLASS__, 'icon_callback' ),
			'page'     => 'feature',
			'context'  => 'side',
			'priority' => 'default',
			'options'  => array(
				'_cd_feature_icon',
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
			'name'               => 'Features',
			'singular_name'      => 'Feature',
			'menu_name'          => 'Features',
			'add_new'            => 'Add New Feature',
			'add_new_item'       => 'Add New Feature',
			'edit_item'          => 'Edit Feature',
			'new_item'           => 'New Feature',
			'view_item'          => 'View Feature',
			'search_items'       => 'Search Features',
			'not_found'          => 'No features found',
			'not_found_in_trash' => 'No features found in Trash',
			'parent_item_colon'  => 'Feature',
		);

		register_post_type( 'feature', array(
			'labels'        => $labels,
			'label'         => 'Features',
			'public'        => false,
			'show_ui'       => true,
			'menu_position' => 5,
			'menu_icon'     => 'dashicons-star-filled',
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

		$icon = get_post_meta( $post->ID, '_cd_feature_icon', true );

		?>
		<label for="cd-icon-data-icon" class="icon <?php echo isset( $icon ) ? 'icon-' . $icon : 'icon-star3'; ?>"></label>
		<input type="text" name="_cd_feature_icon" id="cd-icon-data-icon"
		       value="<?php echo isset( $icon ) ? $icon : 'star3'; ?>"/>
	<?php
	}

	public function save_meta_boxes( $post_ID = 0 ) {

		// Oops, how did we get here?
		if ( $post_ID === 0 ) {
			return $post_ID;
		}

		// Verify this came from the right place
		if ( ! isset( $_POST['feature_nonce'] ) || ! wp_verify_nonce( $_POST['feature_nonce'], plugin_basename( __FILE__ ) ) ) {
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
		<input type="hidden" name="feature_nonce" id="feature_nonce"
		       value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>"/>
	<?php
	}
}

new ClientDash_Theme_Features();