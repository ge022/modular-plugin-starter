<?php
/**
 * Module Name: Custom post types
 */

function mps_load_custom_post_types() {
	require_once( MPS__PLUGIN_DIR . '/modules/custom-post-types/books.php' );
}


/**
 * Add Settings section for module
 */
function mps_cpt_add_settings() {
	add_settings_section(
		'mps_cpt_section',
		'<h2 id="mps-cpt-options">' . __( 'Custom Post Types', 'mps' ) . '</h2>',
		'mps_cpt_section_callback',
		'mps'
	);
}

add_action( 'admin_init', 'mps_cpt_add_settings' );

/**
 * Settings Description
 *
 * @return string
 */
function mps_cpt_section_callback() {
	echo '<p>' .
	       esc_html__( 'Use these settings to manage custom post types.', 'mps' ) .
	       '</p>';
}

mps_load_custom_post_types();
