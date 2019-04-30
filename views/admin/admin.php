<h1><?php echo __( 'MPS Plugin', 'mps' ) ?></h1>

<div>
    <form method="post" action="options.php">
		<?php settings_fields( 'mps_cpt_section' ); ?>
        <?php MPS_Options::do_settings_section('mps', 'mps_cpt_section'); ?>
		<?php submit_button(); ?>
    </form>
</div>
<div>
    <form method="post" action="options.php">
		<?php settings_fields( 'mps_auth_section' ); ?>
        <?php MPS_Options::do_settings_section('mps', 'mps_auth_section'); ?>
		<?php submit_button(); ?>
    </form>
</div>