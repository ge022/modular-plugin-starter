<?php
// TODO: Update to WP 5.0

class MPS_Book {
	const CUSTOM_POST_TYPE = 'mps_book';
	const OPTION_NAME = 'mps_book';

	static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new MPS_Book;
		}

		return $instance;
	}

	private function __construct() {
		$this->register_post_type();
	}

	/**
	 * Register Post Type
	 */
	function register_post_type() {
		if ( post_type_exists( self::CUSTOM_POST_TYPE ) ) {
			return;
		}

		add_action( 'admin_init', [ $this, 'settings_api_init' ] );

		$setting = MPS_Options::get_option_and_ensure_autoload( self::OPTION_NAME, '0' );
		if ( empty( $setting ) ) {
			return;
		}

		register_post_type( self::CUSTOM_POST_TYPE, [
				'label'  => 'Book',
				'public' => true,
			]
		);
	}

	/**
	 * Add a checkbox field in 'Settings' > 'Writing'
	 * for enabling CPT functionality.
	 *
	 * @return null
	 */
	function settings_api_init() {
		add_settings_field(
			self::OPTION_NAME,
			'<h3 class="mps-cpt-option">' . __( 'Books', 'mps' ) . '</h3>',
			[ $this, 'setting_html' ],
			'mps',
			'mps_cpt_section'
		);

		register_setting(
			'mps_cpt_section',
			self::OPTION_NAME,
			'intval'
		);

	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the CPT setting.
	 *
	 * @return string
	 */
	function setting_html() {
		echo '<label for="' . esc_attr( self::OPTION_NAME ) . '">' .
		     '<input name="' . esc_attr( self::OPTION_NAME ) . '" id="' . esc_attr( self::OPTION_NAME ) . '"' . checked( get_option( self::OPTION_NAME, '0' ), true, false ) . 'type="checkbox" value="1" />' .
		     esc_html__( 'Enable Books for this site.', 'mps' ) .
		     '</label>';
	}

}

add_action( 'init', [ 'MPS_Book', 'init' ] );