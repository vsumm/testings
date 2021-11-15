<?php
$kata_options   = get_option( 'kata_options' );
$kata_options['prefers_color_scheme'] = isset( $kata_options['prefers_color_scheme'] ) ? $kata_options['prefers_color_scheme'] : '';
?>
<div class="kata-admin kata-dashboard-page wrap about-wrap" data-color_scheme="<?php echo esc_attr( $kata_options['prefers_color_scheme'] ) ?>">

    <?php
    if ( class_exists( 'Kata_Plus_Admin_Panel' ) ) {
        $admin_panel = new Kata_Plus_Admin_Panel();
        echo $admin_panel->header();
    }
    ?>
	<div class="kata-container">