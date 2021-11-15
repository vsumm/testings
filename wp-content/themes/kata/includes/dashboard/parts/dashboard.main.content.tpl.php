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
?>

<div class="kata-admin kt-dashboard-main-content" <?php echo esc_attr( 'data-color_scheme=' . $kata_options['prefers_color_scheme'] ); ?>>
    <div class="kt-dashboard-container">
        <div class="kt-dashboard-row">
            <div class="kt-dashboard-col kt-dashbord-col-70 kd-dashboard-content-wrapper">
                <!-- Options -->
                <?php $this->kata_plus_install_notice(); ?>

                <div class="kt-dashboard-box start-customizing">
                    <h3 class="kt-dashboard-box-title"><i class="dashicons dashicons-admin-customizer"></i><?php echo esc_html__( 'Start Customizing', 'kata' ); ?></h3>
                    <ul class="kt-dashboard-ul">
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=title_tagline' ) ) ?>"><i class="dashicons dashicons-format-image"></i><?php echo esc_html__( 'Site Identity', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=static_front_page' ) ) ?>"><i class="dashicons dashicons-visibility"></i><?php echo esc_html__( 'Homepage Settings', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=kata_header_section' ) ) ?>"><i class="dashicons dashicons-table-row-after"></i><?php echo esc_html__( 'Header', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=kata_container_section' ) ) ?>"><i class="dashicons dashicons-layout"></i><?php echo esc_html__( 'Container', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=kata_page_panel' ) ) ?>"><i class="dashicons dashicons-admin-page"></i><?php echo esc_html__( 'Page', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=kata_footer_panel' ) ) ?>"><i class="dashicons dashicons-table-row-before"></i><?php echo esc_html__( 'Footer', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=styling_typography_section' ) ) ?>"><i class="dashicons dashicons-editor-textcolor"></i><?php echo esc_html__( 'Styling & Typography', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=kata_blog_panel' ) ) ?>"><i class="dashicons dashicons-welcome-write-blog"></i><?php echo esc_html__( 'Blog', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=nav_menus' ) ) ?>"><i class="dashicons dashicons-menu-alt"></i><?php echo esc_html__( 'Menus', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bpanel%5D=widgets' ) ) ?>"><i class="dashicons dashicons-welcome-widgets-menus"></i><?php echo esc_html__( 'Widgets', 'kata' ); ?></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-50"><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus%5Bsection%5D=custom_css' ) ) ?>"><i class="dashicons dashicons-editor-code"></i><?php echo esc_html__( 'Additional CSS', 'kata' ); ?></a></li>
                    </ul>
                </div>
                <!-- Pro features -->
                <div class="kt-dashboard-box pro-features">
                    <h3 class="kt-dashboard-box-title"><i class="dashicons dashicons-star-filled"></i><?php echo esc_html__( 'Pro Features', 'kata' ); ?></h3>
                    <ul class="kt-dashboard-ul">
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/kata-overview/' ); ?>"><?php echo esc_html__( 'Kata Overview', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/font-manager/' ); ?>"><?php echo esc_html__( 'Fonts Manager', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/portfolio/' ); ?>"><?php echo esc_html__( 'Portfolio Features', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/plugin-manager/' ); ?>"><?php echo esc_html__( 'Plugin Manager', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/header-builder/' ); ?>"><?php echo esc_html__( 'Header Builder', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/footer-builder/' ); ?>"><?php echo esc_html__( 'Footer Builder', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/mega-menu-builder/' ); ?>"><?php echo esc_html__( 'Mega Menu Builder', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/archive-builder/' ); ?>"><?php echo esc_html__( 'Archive Builder', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/author-builder/' ); ?>"><?php echo esc_html__( 'Author Page Builder', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/search-builder/' ); ?>"><?php echo esc_html__( 'Search Resault Builder', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/404-builder/' ); ?>"><?php echo esc_html__( '404 Builder', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/single-builder/' ); ?>"><?php echo esc_html__( 'Single Builder', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/icon-manager/' ); ?>"><?php echo esc_html__( 'Icon Manager', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/section-templates/' ); ?>"><?php echo esc_html__( 'Section Templates Library', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/theme-option-pro-features/' ); ?>"><?php echo esc_html__( 'Pro Theme Option', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/styler-pro-vs-free/' ); ?>"><?php echo esc_html__( 'Pro Styler', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                        <li class="kt-dashboard-li kt-dashbord-col-100"><a href="<?php echo esc_url( 'https://climaxthemes.com/kata/documentation/presets/' ); ?>"><?php echo esc_html__( 'Presets', 'kata' ); ?><span class="kt-pro-learn-more"><?php echo esc_html__( 'Learn More', 'kata' ); ?><i class="dashicons dashicons-arrow-right-alt2"></i></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="kt-dashboard-col kt-dashbord-col-30 kd-dashboard-sidebar">
                <div class="sidebar-content-wrap">
                    <!-- importer -->
                    <div class="kt-dashboard-box kt-dashboard-has-pad">
                        <h3 class="kt-dashboard-box-title"><i class="dashicons dashicons-database-import"></i><?php echo esc_html__( 'Import Starter Template', 'kata' ); ?></h3>
                        <div class="kt-dashboard-sidebar-widget">
                            <img src="<?php echo esc_url( self::$assets . 'img/importer.png' ) ?>" width="242" alt="<?php echo esc_attr__( 'Starter Templates', 'kata' ); ?>">
                            <p>
                                <?php
                                // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
                                echo wp_sprintf( esc_html__( 'Make sure to checkout Kata\'s %1$s Starter Template %2$s,', 'kata' ), '<a href="' . esc_url( 'https://climaxthemes.com/kata/documentation/demo-importer/' ) . '" class="kt-dashboard-links">', '</a>' );
                                ?>
                                <?php if ( class_exists( 'Kata_Plus' ) ) : ?>
                                    <?php
                                    // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
                                    echo wp_sprintf( esc_html__( 'In just one simple click, you\'ll %1$s import your desired design %2$s and can start customizing your site.', 'kata' ), '<a href="' . esc_url( admin_url( 'admin.php?page=kata-plus-demo-importer' ) ) . '" class="kt-dashboard-links">', '</a>' );
                                    ?>
                                <?php else: ?>
                                        <?php
                                        // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
                                        echo wp_sprintf( esc_html__( 'In just one simple click, you\'ll import your desired design and can start customizing your site. %1$sinstall plugins%2$s', 'kata' ), '<a href="' . esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ) . '" class="kt-dashboard-links">', '</a>' );
                                        ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <!-- Documentation -->
                    <div class="kt-dashboard-box kt-dashboard-has-pad">
                        <h3 class="kt-dashboard-box-title"><i class="dashicons dashicons-book"></i><?php echo esc_html__( 'Knowledge Base', 'kata' ); ?></h3>
                        <div class="kt-dashboard-sidebar-widget">
                            <p>
                            <?php
                            // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
                            echo wp_sprintf( esc_html__( 'Are you familiare with how Kata works? Make sure to read our comprehensive %1$s online Documentation %2$s which includes helpful video tutorials', 'kata' ), '<a href="https://climaxthemes.com/kata/documentation/" class="kt-dashboard-links">', '</a>' );
                            ?>
                            </p>
                        </div>
                    </div>
                    <!-- Review -->
                    <div class="kt-dashboard-box kt-dashboard-has-pad">
                        <h3 class="kt-dashboard-box-title"><i class="dashicons dashicons-star-filled"></i><?php echo esc_html__( 'Rate us', 'kata' ); ?></h3>
                        <div class="kt-dashboard-sidebar-widget">
                            <p>
                                <?php
                                // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
                                echo wp_sprintf( esc_html__( 'Are you enjoying Kata? Please support us by leaving a positive review for us %1$shere%2$s', 'kata' ), '<a href="https://themeforest.net/downloads/" class="kt-dashboard-links">', '<i class="dashicons dashicons-arrow-right-alt2"></i></a>' );
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
