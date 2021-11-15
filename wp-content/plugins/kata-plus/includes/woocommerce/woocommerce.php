<?php
/**
 * Woocommerce Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */
return;
// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Woocommerce
if ( ! class_exists( 'Kata_Plus_Woocommerce' ) ) {
	class Kata_Plus_Woocommerce {
		/**
		 * The directory of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $dir;

		/**
		 * The url of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $url;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Woocommerce
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
		 */
		public static function get_instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			$this->definitions();
			$this->actions();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir = Kata_Plus::$dir . 'includes/woocommerce/';
			self::$url = Kata_Plus::$url . 'includes/woocommerce/';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {

			add_action( 'init', [$this, 'dependencies'] );
			add_action( 'after_setup_theme', [$this, 'setup'] );
			add_action( 'wp_enqueue_scripts', [$this, 'styles'], 9999 );
			add_filter( 'body_class', [$this, 'body_classes'] );
			add_action( 'widgets_init', [ $this, 'widgets_init' ] );

			// Cart
			add_action( 'woocommerce_before_cart', [$this, 'open_container'] );
			add_action( 'woocommerce_after_cart', [$this, 'close_container'] );
			// Checkout
			add_action( 'woocommerce_before_checkout_form', [$this, 'open_container'] );
			add_action( 'woocommerce_after_checkout_form', [$this, 'close_container'] );
			// Thank you
			add_action( 'woocommerce_before_thankyou', [$this, 'open_container'] );
			add_action( 'woocommerce_order_details_after_customer_details', [$this, 'close_container'] );
			// My Account
			add_action( 'woocommerce_before_account_navigation', [$this, 'open_container'] );
			add_action( 'woocommerce_after_my_account', [$this, 'close_container'] );
			// Single
			add_action( 'kata_woocommerce_before_loop', [$this, 'open_container'] );
			add_action( 'kata_woocommerce_after_loop', [$this, 'close_container'] );

		}

		/**
		 * Register widget area.
		 *
		 * @link    https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
		 * @since   1.0.0
		 */
		public function widgets_init() {
			register_sidebar(
				[
					'name'          => esc_html__( 'Woocommerce sidebar', 'kata-plus' ),
					'id'            => 'woocommerce-sidebar',
					'description'   => esc_html__( 'Displayed in shop and single product page.', 'kata-plus' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title">',
					'after_title'   => '</h2>',
				]
			);
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				return;
			}
		}

		/**
		 * setup.
		 *
		 * @since   1.0.0
		 */
		public function setup() {
			add_theme_support(
				'woocommerce',
				apply_filters(
					'kata_plus_woocommerce_args',
					[
						'single_image_width'	=> 416,
						'thumbnail_image_width'	=> 324,
						'product_grid'			=> [
							'default_columns'	=> 4,
							'default_rows'	=> 4,
							'max_rows'		=> 5,
							'min_columns'	=> 1,
							'max_columns'	=> 6,
							'min_rows'		=> 1,
						],
					]
				)
			);
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
			// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param   array $classes Classes for the body element.
		 * @return  array
		 * @since   1.0.0
		 */
		public function body_classes( $classes ) {
			// Adds a class of hfeed to non-singular pages.
			if ( self::is_cart_empty() ) {
				$classes[] = 'kata-plus-empty-cart';
			}

			return $classes;
		}
		/**
		 * open Checkout.
		 *
		 * @since   1.0.0
		 */
		public function open_container() {
			echo '<div class="container">';
		}

		/**
		 * close Checkout.
		 *
		 * @since   1.0.0
		 */
		public function close_container() {
			echo '</div>';
		}

		/**
		 * close Checkout.
		 *
		 * @since   1.0.0
		 */
		public static function is_cart_empty() {
			if ( class_exists( 'WooCommerce' ) ) {
				if ( WC()->cart->cart_contents ) {
					return false;
				} else {
					return true;
				}
			}
		}

		/**
		 * Styles.
		 *
		 * @since   1.0.0
		 */
		public function styles() {}


	} // class

	Kata_Plus_Woocommerce::get_instance();
}
