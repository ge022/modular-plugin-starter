<?php
  
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
  
      add_action( 'admin_init', array( $this, 'settings_api_init' ) );
      
      $setting = MPS_Options::get_option_and_ensure_autoload( self::OPTION_NAME, '0' );
      if ( empty( $setting ) ) {
        return;
      }
  
      register_post_type( self::CUSTOM_POST_TYPE, array(
          'label' => 'Book',
          'public' => true,
        )
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
        '<span class="mps-cpt-option">' . __( 'Books', 'mps' ) . '</span>',
        array( $this, 'setting_html' ),
        'writing',
        'mps_cpt_section'
      );
    
      register_setting(
        'writing',
        self::OPTION_NAME,
        'intval'
      );
      
    }
  
    /**
     * HTML code to display a checkbox true/false option
     * for the CPT setting.
     *
     * @return html
     */
    function setting_html() {
      if ( $this->site_supports_custom_post_type() ) : ?>
        <label for="<?php echo esc_attr( self::OPTION_NAME ); ?>">
          <input name="<?php echo esc_attr( self::OPTION_NAME ); ?>" id="<?php echo esc_attr( self::OPTION_NAME ); ?>" <?php echo checked( get_option( self::OPTION_NAME, '0' ), true, false ); ?> type="checkbox" value="1" />
          <?php esc_html_e( 'Enable Books for this site.', 'mps' ); ?>
        </label>
      <?php endif;
    }
    
    function site_supports_custom_post_type() {
      return true;
    }
    
  }
  
  add_action( 'init', array( 'MPS_Book', 'init' ) );