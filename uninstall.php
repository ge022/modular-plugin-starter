<?php
  
  if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die();
  }
  
  define( 'MPS__PLUGIN_DIR', plugin_dir_path( __FILE__ )  );
  require_once MPS__PLUGIN_DIR . 'class.mps-options.php';
  
  MPS_Options::delete_all_known_options();