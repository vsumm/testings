<?php
/**
 * Layout Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Kata_Plus_Theme_Options_WooCommerce' ) ) {
	class Kata_Plus_Theme_Options_WooCommerce extends Kata_Plus_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {

			Kirki::add_field(
				self::$opt_name,
				[
					'section'         => 'woocommerce_product_images',
					'settings'        => 'kata_thumbnail_image_width',
					'label'           => esc_html__('Thumbnail Image Width', 'kata-plus'),
					'description'     => esc_html__('Please enter numbers, Example:400,500,600', 'kata-plus'),
					'type'            => 'number',
					'default'         => 400,
					'choices'         => [
						'min'  => 0,
						'max'  => 1920,
						'step' => 1,
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'section'         => 'woocommerce_product_images',
					'settings'        => 'kata_single_image_width',
					'label'           => esc_html__('single Image Width', 'kata-plus'),
					'description'     => esc_html__('Please enter numbers, Example:400,500,600', 'kata-plus'),
					'type'            => 'number',
					'default'         => 800,
					'choices'         => [
						'min'  => 0,
						'max'  => 1920,
						'step' => 1,
					],
				]
			);
		}
	} // class

	Kata_Plus_Theme_Options_WooCommerce::set_options();
}
