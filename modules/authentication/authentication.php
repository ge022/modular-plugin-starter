<?php

class MPS_Authentication {
	const OPTION_NAME = 'mps_authentication';

	static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new MPS_Authentication;
		}

		return $instance;
	}

	private function __construct() {
		add_action( 'admin_init', [ $this, 'settings_api_init' ] );

		$setting = MPS_Options::get_option_and_ensure_autoload( self::OPTION_NAME, '0' );
		if ( empty( $setting ) ) {
			return;
		}

		$this->init_ajax();
		$this->init_shortcodes();
	}

	/**
	 * Add the authentication ajax actions
	 */
	function init_ajax() {
		add_action( 'wp_ajax_mps_authentication_action', [ $this, 'mps_authentication_action' ] );
	}

	/**
	 * Add the authentication shortcodes
	 */
	function init_shortcodes() {
		add_shortcode( 'mps_auth_login', [ $this, 'mps_auth_login' ] );
	}

	/**
	 * The login ajax POST request.
	 */
	function mps_authentication_action() {
		echo json_encode(['test' => 'The ajax test is working']);
		wp_die();
	}

	/**
	 * The login shortcode.
	 * Enqueues the required scripts and styles,
	 * and returns the login form html.
	 */
	function mps_auth_login() {
		// Enqueue the scripts and styles
		wp_enqueue_style( 'mps-auth', plugin_dir_url( __FILE__ ) . 'assets/css/login.css', [], null );
		wp_enqueue_script( 'mps-auth', plugin_dir_url( __FILE__ ) . 'assets/js/login.js', [], null );

		return require_once plugin_dir_path( __FILE__ ) . 'views/login.php';
	}

	/**
	 * Add a checkbox field in 'Settings' > 'Writing'
	 * for enabling Authentication functionality.
	 *
	 * @return null
	 */
	function settings_api_init() {
		add_settings_field(
			self::OPTION_NAME,
			'<span class="mps-auth-option">' . __( 'Authentication', 'mps' ) . '</span>',
			[ $this, 'setting_html' ],
			'mps',
			'mps_auth_section'
		);

		register_setting(
			'mps_auth_section',
			self::OPTION_NAME,
			'intval'
		);

	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the Authentication setting.
	 *
	 * @return string|null
	 */
	function setting_html() {
		echo '<label for="' . esc_attr( self::OPTION_NAME ) . '">' .
		     '<input name="' . esc_attr( self::OPTION_NAME ) . '" id="' . esc_attr( self::OPTION_NAME ) . '"' . checked( get_option( self::OPTION_NAME, '0' ), true, false ) . 'type="checkbox" value="1" />' .
		     esc_html__( 'Enable Authentication for this site.', 'mps' ) .
		     '</label>';
	}
}

add_action( 'init', [ 'MPS_Authentication', 'init' ] );