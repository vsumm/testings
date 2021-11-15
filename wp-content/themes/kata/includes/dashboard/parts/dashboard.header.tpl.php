<?php
/**
 * Kata Dashboard Page
 * Template : Header
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$kata_options   = get_option( 'kata_options' );
$kata_options['prefers_color_scheme'] = isset( $kata_options['prefers_color_scheme'] ) ? $kata_options['prefers_color_scheme'] : '';
?>

<header class="kt-dashboard-header">
    <div class="kt-dashboard-container">
        <div class="kt-dashboard-row">
            <div class="kt-dashboard-col kt-dashbord-col-20">
                <div class="kt-dashboard-component-wrap">
                    <a href="https://climaxthemes.com/kata-wp/" class="kt-dashboard-logo" target="_blank">
                        <?php if ( isset( $kata_options['prefers_color_scheme'] ) && 'dark' === $kata_options['prefers_color_scheme'] ) { ?>
                            <img src="<?php echo esc_url( self::$assets . 'img/svg/kata-logo-w.svg' ) ?>" width="160" alt="<?php echo esc_attr__( 'Kata', 'kata' ); ?>">
                        <?php } else { ?>
                            <img src="<?php echo esc_url( self::$assets . 'img/svg/kata-logo.svg' ) ?>" width="160" alt="<?php echo esc_attr__( 'Kata', 'kata' ); ?>">
                        <?php } ?>
                    </a>
                </div>
            </div>
            <div class="kt-dashboard-col kt-dashboard-nav-wrap kt-dashbord-col-80">
                <div class="kt-dashboard-component-wrap">
                    <ul class="kt-dashboard-navigation">
                        <li class="kt-dashboard-navitem"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata-wp/' ); ?>" target="_blank"><?php echo esc_html__( 'Intro', 'kata'); ?></a></li>
                        <li class="kt-dashboard-navitem"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata-wp/demos/' ); ?>" target="_blank"><?php echo esc_html__( 'Demos', 'kata'); ?></a></li>
                        <li class="kt-dashboard-navitem"><a href="<?php echo esc_url( 'https://themeforest.net/item/kata-elementor-wordpress-theme/31049374/' ); ?>" target="_blank"><?php echo esc_html__( 'Download', 'kata'); ?></a></li>
                        <li class="kt-dashboard-navitem"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata-wp/support/' ); ?>" target="_blank"><?php echo esc_html__( 'Support', 'kata'); ?></a></li>
                        <li class="kt-dashboard-navitem"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/' ); ?>" target="_blank"><?php echo esc_html__( 'Help', 'kata'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<?php
