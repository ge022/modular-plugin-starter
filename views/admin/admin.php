<h1><?php echo __( 'MPS Plugin', 'mps' ) ?></h1>

<div>
  <form method="post" action="options.php">
    <?php // TODO: dynamic loading ?>
    <?php settings_fields( 'mps_book' ); ?>
    <?php do_settings_sections( 'mps' ); ?>
    <?php submit_button(); ?>
  </form>
  <?php
  ?>
</div>