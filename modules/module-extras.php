<?php

$tools = [
	//    'custom-post-types/books.php',
];

$mps_tools_to_include = apply_filters( 'mps_tools_to_include', $tools );
if ( ! empty( $mps_tools_to_include ) ) {
	foreach ( $mps_tools_to_include as $tool ) {
		if ( file_exists( MPS__PLUGIN_DIR . '/modules/' . $tool ) ) {
			require_once( MPS__PLUGIN_DIR . '/modules/' . $tool );
		}
	}
}