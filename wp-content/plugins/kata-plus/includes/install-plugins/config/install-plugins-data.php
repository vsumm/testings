<?php

/**
 * Install Plugins Data.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

$plugins = [
	[
		'name'      		=> esc_html__('Elementor', 'kata-plus'),
		'slug'      		=> 'elementor',
		'author'			=> '<a href="' . esc_url( 'https://elementor.com/' ) . '">' . esc_html__('Elementor.com', 'kata-plus') . '</a>',
		'images_url'		=> $this->images_url . 'kata-plugin-icon-2.png',
		'version'			=> '3.2.2',
		'required'			=> true,
		'force_activation'	=> false,
		'fast-mode' 		=> false,
	],
	[
		'name'      		=> esc_html__('Kata Plus', 'kata-plus'),
		'slug'      		=> 'kata-plus',
		'author'			=> '<a href="' . esc_url( 'https://climaxthemes.com/' ) . '">' . esc_html__('Climaxthemes.com', 'kata-plus') . '</a>',
		'images_url'		=> $this->images_url . 'kata-plugin-icon-2.png',
		'required'			=> true,
		'force_activation'	=> false,
		'fast-mode' 		=> false,
	],
	[
		'name'      	=> esc_html__('Swift Performance Lite', 'kata-plus'),
		'slug'      	=> 'swift-performance-lite',
		'author'		=> '<a href="' . esc_url( 'https://swteplugins.com' ) . '">' . esc_html__('SWTE', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-3.png',
		'required'		=> false,
		'fast-mode' 	=> true,
	],
	[
		'name'			=> esc_html__('Polylang', 'kata-plus'),
		'slug'			=> 'polylang',
		'author'		=> '<a href="' . esc_url( 'https://polylang.pro/' ) . '">' . esc_html__('WP SYNTEX', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-14.png',
		'fast-mode' 	=> false,
	],
	[
		'name'			=> esc_html__('Contact Form 7', 'kata-plus'),
		'slug'			=> 'contact-form-7',
		'author'		=> '<a href="' . esc_url( 'https://ideasilo.wordpress.com/' ) . '">' . esc_html__('Takayuki Miyoshi', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-15.png',
		'fast-mode' 	=> false,
	],
	[
		'name'			=> esc_html__('Ajax Domain Checker', 'kata-plus'),
		'slug'			=> 'ajax-domain-checker',
		'author'		=> '<a href="' . esc_url( 'https://asdqwe.net/wordpress-plugins/wp-domain-checker/' ) . '">' . esc_html__('Asdqwe Dev', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-22.png',
		'fast-mode' 	=> false,
	],
	[
		'name'			=> esc_html__('Gift Vouchers', 'kata-plus'),
		'slug'			=> 'gift-voucher',
		'author'		=> '<a href="' . esc_url( 'https://www.codemenschen.at/' ) . '">' . esc_html__('codemenschen', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-24.png',
		'fast-mode' 	=> false,
	],
	[
		'name'			=> esc_html__('Woocommerce', 'kata-plus'),
		'slug'			=> 'woocommerce',
		'author'		=> '<a href="' . esc_url( 'https://woocommerce.com/' ) . '">' . esc_html__('Automattic', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-16.png',
		'fast-mode' 	=> true,
	],
	[
		'name'			=> esc_html__('Rank Math', 'kata-plus'),
		'slug'			=> 'seo-by-rank-math',
		'author'		=> '<a href="' . esc_url( 'https://s.rankmath.com/home/' ) . '">' . esc_html__('Rank Math', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-25.png',
		'fast-mode' 	=> true,
	],
	[
		'name'			=> esc_html__('Wordfence', 'kata-plus'),
		'slug'			=> 'wordfence',
		'author'		=> '<a href="' . esc_url( 'http://www.wordfence.com/' ) . '">' . esc_html__('Wordfence', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-26.png',
		'fast-mode' 	=> true,
	],
	[
		'name'			=> esc_html__('All-in-One WP Migration', 'kata-plus'),
		'slug'			=> 'all-in-one-wp-migration',
		'author'		=> '<a href="' . esc_url( 'https://servmask.com/' ) . '">' . esc_html__('ServMask', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-27.png',
		'fast-mode' 	=> true,
	],
	[
		'name'			=> esc_html__('Site Kit by Google', 'kata-plus'),
		'slug'			=> 'google-site-kit',
		'author'		=> '<a href="' . esc_url( 'https://opensource.google.com/' ) . '">' . esc_html__('Google', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-28.png',
		'fast-mode' 	=> true,
	],
	[
		'name'			=> esc_html__('Amelia', 'kata-plus'),
		'slug'			=> 'ameliabooking',
		'author'		=> '<a href="' . esc_url( 'https://ideasilo.wordpress.com/' ) . '">' . esc_html__('TMS', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-28.png',
		'fast-mode' 	=> true,
	],
	[
		'name'			=> esc_html__('Hotel Booking Lite', 'kata-plus'),
		'slug'			=> 'motopress-hotel-booking-lite',
		'author'		=> '<a href="' . esc_url( 'https://motopress.com/' ) . '">' . esc_html__('MotoPress', 'kata-plus') . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-30.png',
		'fast-mode' 	=> false,
	],
	[
		'name'			=> esc_html__('Weather Atlas Widget', 'kata-plus'),
		'slug'			=> 'weather-atlas',
		'author'		=> '<a href="' . esc_url( 'https://www.weather-atlas.com/' ) . '">' . esc_html__( 'Yu Media Group d.o.o.', 'kata-plus' ) . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-31.png',
		'fast-mode' 	=> false,
	],
	[
		'name'			=> esc_html__('Wp Social', 'kata-plus'),
		'slug'			=> 'wp-social',
		'author'		=> '<a href="' . esc_url( 'https://wpmet.com/' ) . '">' . esc_html__( 'Wpmet', 'kata-plus' ) . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-32.png',
		'fast-mode' 	=> false,
	],
	[
		'name'			=> esc_html__('Cryptocurrency Widgets', 'kata-plus'),
		'slug'			=> 'cryptocurrency-price-ticker-widget',
		'author'		=> '<a href="' . esc_url( 'https://coolplugins.net/' ) . '">' . esc_html__( 'Cool Plugins', 'kata-plus' ) . '</a>',
		'images_url'	=> $this->images_url . 'kata-plugin-icon-33.png',
		'fast-mode' 	=> false,
	],
];

return $plugins;