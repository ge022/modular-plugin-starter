<?php
/*
 * CPT main class
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! class_exists( 'MPS' ) ) {

	class MPS {

		/**
		 * Holds the singleton instance of this class
		 */
		static $instance = false;

		/**
		 * Singleton
		 *
		 * @static
		 */
		public static function init() {
			if ( ! self::$instance ) {
				self::$instance = new MPS;
			}

			return self::$instance;
		}

		/**
		 * Constructor. Initializes WordPress hooks
		 */
		private function __construct() {
			// Add the plugin settings pages
			add_action( 'admin_menu', [ $this, 'admin_init' ] );

		}

		public static function plugin_activate() {
			MPS_Options::update_option( 'activated', 1 );

			MPS::plugin_initialize();

			flush_rewrite_rules();
		}

		public static function plugin_deactivate() {
		}

		private static function plugin_initialize() {
			MPS::load_modules();
		}

		static function load_modules() {
			$modules = require_once( MPS__PLUGIN_DIR . 'config/modules.php' );

			foreach ( $modules as $index => $module ) {
				include_once( MPS::get_module_path( $module ) );
			}

			// Include non-modules
			require_once( MPS__PLUGIN_DIR . 'modules/module-extras.php' );
		}

		public static function get_module_path( $slug ) {
			return MPS__PLUGIN_DIR . "modules/$slug.php";
		}


		/**
		 *  Plugin settings pages and links
		 */
		function admin_init() {
			add_menu_page( __( 'MPS', 'mps' ), __( 'MPS', 'mps' ), 'manage_options', 'mps', [
				$this,
				'admin_index'
			], 'dashicons-admin-page', 110 );

			// Add plugin settings page link to plugins page
			add_filter( 'plugin_action_links_' . MPS__PLUGIN_IDENTIFIER, [ $this, 'plugin_action_links' ] );
		}

		function plugin_action_links( $actions ) {
			$settings_link = [ 'settings-link' => sprintf( '<a href="%s">%s</a>', MPS::admin_url( 'page=mps' ), __( 'Settings', 'mps' ) ) ];

			return array_merge( $settings_link, $actions );
		}

		public static function admin_url( $args = null ) {
			$args = wp_parse_args( $args, [ 'page' => 'mps' ] );
			$url  = add_query_arg( $args, admin_url( 'admin.php' ) );

			return $url;
		}

		function admin_index() {
			require_once MPS__PLUGIN_DIR . 'views/admin/admin.php';
		}
	}
}
