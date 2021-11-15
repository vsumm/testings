<?php
/**
* Fast mode Template 1.
* Choose Website Type.
* @author  ClimaxThemes
* @package Kata Plus
* @since   1.0.0
*/

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="kt-fst-mod-1" class="kt-fst-mod-wrapper">
	<h1 id="page-title" class="chose-bussiness-type"><?php echo esc_html__( 'What is the type of website you want to create?', 'kata-plus' ); ?></h1>
	<div class="kt-fst-mod-inner-wrapper">
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=business' ) );?>"><?php echo esc_html__( 'Business', 'kata-plus' ); ?></a>
		</div>
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=portfolio' ) );?>"><?php echo esc_html__( 'Portfolio', 'kata-plus' ); ?></a>
		</div>
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=blog' ) );?>"><?php echo esc_html__( 'Blog', 'kata-plus' ); ?></a>
		</div>
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=food' ) );?>"><?php echo esc_html__( 'Food', 'kata-plus' ); ?></a>
		</div>
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=software' ) );?>"><?php echo esc_html__( 'Software', 'kata-plus' ); ?></a>
		</div>
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=health' ) );?>"><?php echo esc_html__( 'Health', 'kata-plus' ); ?></a>
		</div>
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=design' ) );?>"><?php echo esc_html__( 'Design', 'kata-plus' ); ?></a>
		</div>
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=online-store' ) );?>"><?php echo esc_html__( 'Online Store', 'kata-plus'); ?></a>
		</div>
		<div class="website-type">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2&websitetype=personal' ) );?>"><?php echo esc_html__( 'Personal', 'kata-plus' ) ?></a>
		</div>
	</div>
</div>