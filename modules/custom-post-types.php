<?php
  /**
   * Module Name: Custom post types
   */
  
  function mps_load_custom_post_types() {
    require_once( MPS__PLUGIN_DIR . '/modules/custom-post-types/books.php' );
  }

  // Add Settings section for module
  function mps_cpt_add_settings() {
    add_settings_section(
      'mps_cpt_section',
      '<span id="mps-cpt-options">' . __( 'Custom Post Types', 'mps' ) . '</span>',
      'mps_cpt_section_callback',
      'mps'
    );
  }
  add_action( 'admin_init', 'mps_cpt_add_settings' );
  
  // Settings Description
  function mps_cpt_section_callback() {
    ?>
    <p>
      <?php esc_html_e( 'Use these settings to display different post types on your site.', 'mps' ); ?>
    </p>
    <?php
  }
  
  mps_load_custom_post_types();
