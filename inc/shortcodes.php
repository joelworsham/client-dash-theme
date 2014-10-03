<?php

class ClientDash_Theme_Shortcodes extends ClientDash_Theme {

	public $shortcodes = array(
		array(
			'name' => 'foundation_column'
		),
		array(
			'name' => 'foundation_row'
		)
	);


	function __construct() {
		foreach ( $this->shortcodes as $shortcode ) {
			if ( ! isset( $shortcode['callback'] ) ) {
				$callback = $shortcode['name'];
			} else {
				$callback = $shortcode['callback'];
			}

			add_shortcode( $shortcode['name'], array( $this, $callback ) );
		}
	}

	public function foundation_row( $atts, $content ) {
		extract( shortcode_atts( array(
			'columns' => null
		), $atts ) );

		$output = '<div class="row">';

		$output .= $content;

		$output .= '</div>'; // .row

		return do_shortcode( $output );
	}

	public function foundation_column( $atts, $content ) {
		extract( shortcode_atts( array(
			'columns' => null
		), $atts ) );

		$output = "<div class='columns $columns'>";

		$output .= $content;

		$output .= '</div>'; // .columns

		return do_shortcode( $output );
	}
}

new ClientDash_Theme_Shortcodes();