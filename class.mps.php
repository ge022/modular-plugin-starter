<?php
  /*
   * CPT main class
   */
  
  // Don't load directly
  if ( !defined( 'ABSPATH' ) ) {
    die();
  }
  
  if ( !class_exists( 'MPS' ) ) {
    
    class MPS {
      
      const CUSTOM_POST_TYPE = 'books';
      
      /**
       * Holds the singleton instance of this class
       */
      static $instance = false;
      
      /**
       * Singleton
       * @static
       */
      public static function init() {
        if ( !self::$instance ) {
          self::$instance = new MPS;
        }
        
        return self::$instance;
      }
      
      /**
       * Constructor. Initializes WordPress hooks
       */
      private function __construct() {
      
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
        $modules = array(
          'custom-post-types'
        );
        
        foreach ( $modules as $index => $module ) {
          include_once( MPS::get_module_path( $module ) );
        }
        
        // Include non-modules
        require_once( MPS__PLUGIN_DIR . 'modules/module-extras.php' );
      }
      
      public static function get_module_path( $slug ) {
        return MPS__PLUGIN_DIR . "modules/$slug.php";
      }
      
    }
    
  }
