<?php
/**
 * Module Name: Authentication
 */

function mps_load_custom_authentication() {
	require_once( MPS__PLUGIN_DIR . '/modules/authentication/authentication.php' );
}

/**
 * Add Settings section for module
 */
function mps_auth_add_settings() {
	add_settings_section(
		'mps_auth_section',
		'<span id="mps-auth-options">' . __( 'Authentication', 'mps' ) . '</span>',
		'mps_auth_section_callback',
		'mps'
	);
}

add_action( 'admin_init', 'mps_auth_add_settings' );

/**
 * Settings Description
 *
 * @return string
 */
function mps_auth_section_callback() {
	echo '<p>' .
	       esc_html__( 'Use these settings to manage authentication.', 'mps' ) .
	       '</p>';
}

mps_load_custom_authentication();
