<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="site-content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @author ClimaxThemes
 * @package Kata
 * @since 1.0.0
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- Include Date Range Picker -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> <?php apply_filters( 'kata_body_attributes', 10 ); ?>>
	<?php wp_body_open(); ?>
	<a class="kt-skip-link" href="#kata-content"><?php echo esc_html__( 'Skip to content', 'kata' ); ?></a>
	<div id="kata-site" <?php Kata::site_class( 'kata-site clearfix' ); ?>>

		<?php
		$header_show = Kata_Helpers::is_blog_pages() ? '1' : Kata_Helpers::get_meta_box( 'kata_show_header' );
		if ( '1' === $header_show ) {
			$header_show = true;
		} elseif ( '0' === $header_show ) {
			$header_show = false;
		} elseif ( false === $header_show || empty( $header_show ) ) {
			$header_show = true;
		}
		if ( $header_show ) {
			do_action( 'kata_header' );
		}
		$page_title_meta = Kata_Helpers::get_meta_box( 'kata_show_page_title' );
		$page_title      = 'inherit_from_customizer' !== $page_title_meta ? $page_title_meta : get_theme_mod( 'kata_show_page_title', '1' );
		?>

		<!-- start content -->
		<div id="kata-content" class="kata-content clearfix <?php echo esc_attr( $page_title ) ? 'kata-section-with-page-title' : ''; ?>">
			<div class="kata-section clearfix">
