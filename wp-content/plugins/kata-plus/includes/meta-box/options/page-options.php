<?php
/**
 * Page Options - Meta Box.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Kata_Plus_Meta_Box_Page_Options' ) ) {
	class Kata_Plus_Meta_Box_Page_Options {
		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Meta_Box_Page_Options
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
			$this->actions();
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_filter( 'rwmb_meta_boxes', [ $this, 'meta_boxes' ] );
		}

		public function meta_boxes( $meta_boxes ) {
			 $meta_boxes[] = [
				 'title'      => esc_html__( 'Page Options', 'kata-plus' ),
				 'id'         => 'kata-page',
				 // 'post_types' => [ 'page' ],
				  'kata-tabs' => [
					  'header'           => [
						  'title' => esc_html__( 'Header', 'kata-plus' ),
						  'icon'  => 'ti-layout-tab-window',
					  ],
					  'page-title'       => [
						  'title' => esc_html__( 'Page Title', 'kata-plus' ),
						  'icon'  => 'ti-text',
					  ],
					  'breadcrumb'       => [
						  'title' => esc_html__( 'Breadcrumb', 'kata-plus' ),
						  'icon'  => 'ti-direction',
					  ],
					  'sidebar'          => [
						  'title' => esc_html__( 'Sidebar', 'kata-plus' ),
						  'icon'  => 'ti-layout-sidebar-right',
					  ],
					  'full_page_slider' => [
						  'title' => esc_html__( 'Full Page Slider', 'kata-plus' ),
						  'icon'  => 'ti-view-list-alt',
					  ],
					  'footer'           => [
						  'title' => esc_html__( 'Footer', 'kata-plus' ),
						  'icon'  => 'ti-layout-accordion-merged',
					  ],
					  'page_style'       => [
						  'title' => esc_html__( 'Page Custom Style', 'kata-plus' ),
						  'icon'  => 'ti-image',
					  ],
				  ],
				 'fields'     => [
					 // -> Header Tab
					 [
						 'id'       => 'kata_show_header',
						 'type'     => 'switch',
						 'name'     => esc_attr__( 'Show Header:', 'kata-plus' ),
						 'std'      => 1,
						 'kata-tab' => 'header',
					 ],
					 [
						 'id'        => 'kata_make_header_transparent',
						 'type'      => 'switch',
						 'name'      => esc_attr__( 'Make header transparent:', 'kata-plus' ),
						 'std'       => 0,
						 'dependecy' => [
							 'kata_show_header' => '1',
						 ],
						 'kata-tab'  => 'header',
					 ],
					 [
						 'id'        => 'kata_header_transparent_white_color',
						 'type'      => 'switch',
						 'name'      => esc_attr__( 'Set white color for menu items', 'kata-plus' ),
						 'std'       => 0,
						 'dependecy' => [
							 'kata_make_header_transparent' => '1',
						 ],
						 'kata-tab'  => 'header',
					 ],

					 // -> Page Title Tab
					 [
						 'name'     => esc_attr__( 'Show Page Title:', 'kata-plus' ),
						 'type'     => 'button_group',
						 'id'       => 'kata_show_page_title',
						 'options'  => [
							 'inherit_from_customizer' => esc_attr__( 'Inherit', 'kata-plus' ),
							 '1'                       => esc_attr__( 'Show', 'kata-plus' ),
							 '0'                       => esc_attr__( 'Hide', 'kata-plus' ),
						 ],
						 'std'      => 'inherit_from_customizer',
						 'inline'   => true,
						 'multiple' => false,
						 'kata-tab' => 'page-title',
					 ],
					 [
						 'id'       => 'kata_page_title_text',
						 'type'     => 'text',
						 'name'     => esc_attr__( 'Custom Page Title:', 'kata-plus' ),
						 'desc'     => esc_attr__( 'Will be displayed instead of page title.', 'kata-plus' ),
						 'kata-tab' => 'page-title',
					 ],
					 [
						 'id'       => 'kata_styler_page_title',
						 'type'     => 'styler',
						 'name'     => esc_attr__( 'Page Title Style', 'kata-plus' ),
						 'kata-tab' => 'page-title',
					 ],

					 [
						 'id'       => 'styler_breadcrumbs',
						 'type'     => 'styler',
						 'name'     => esc_attr__( 'Breadcrumbs Style', 'kata-plus' ),
						 'kata-tab' => 'breadcrumb',
					 ],

					 // -> Sidebar Tab
					 [
						 'id'       => 'sidebar_position',
						 'type'     => 'button_group',
						 'name'     => esc_attr__( 'Sidebar Position:', 'kata-plus' ),
						 'options'  => [
							 'inherit_from_customizer' => esc_attr__( 'Inherit', 'kata-plus' ),
							 'none'                    => esc_attr__( 'None', 'kata-plus' ),
							 'right'                   => esc_attr__( 'Right', 'kata-plus' ),
							 'left'                    => esc_attr__( 'Left', 'kata-plus' ),
							 'both'                    => esc_attr__( 'Both', 'kata-plus' ),
						 ],
						 'std'      => 'inherit_from_customizer',
						 'inline'   => true,
						 'multiple' => false,
						 'kata-tab' => 'sidebar',
					 ],

					 // -> Edge Onepager
					 [
						 'id'       => 'full_page_slider',
						 'type'     => 'switch',
						 'name'     => esc_attr__( 'Full Page Slider', 'kata-plus' ),
						 'std'      => '0',
						 'kata-tab' => 'full_page_slider',
					 ],
					 [
						 'id'        => 'full_page_slider_navigation',
						 'type'      => 'switch',
						 'name'      => esc_html__( 'Navigation', 'kata-plus' ),
						 'std'       => '1',
						 'dependecy' => [
							 'full_page_slider' => '1',
						 ],
						 'kata-tab'  => 'full_page_slider',
					 ],
					 [
						 'id'        => 'full_page_slider_navigation_position',
						 'type'      => 'select',
						 'name'      => esc_html__( 'Navigation Position', 'kata-plus' ),
						 'std'       => 'right',
						 'options'   => [
							 'right' => esc_attr__( 'Right', 'kata-plus' ),
							 'left'  => esc_attr__( 'Left', 'kata-plus' ),
						 ],
						 'dependecy' => [
							 'full_page_slider' => '1',
						 ],
						 'kata-tab'  => 'full_page_slider',
					 ],
					 [
						 'id'        => 'full_page_slider_loop_bottom',
						 'type'      => 'switch',
						 'name'      => esc_html__( 'Loop Bottom', 'kata-plus' ),
						 'std'       => '1',
						 'dependecy' => [
							 'full_page_slider' => '1',
						 ],
						 'kata-tab'  => 'full_page_slider',
					 ],
					 [
						 'id'        => 'full_page_slider_loop_top',
						 'type'      => 'switch',
						 'name'      => esc_html__( 'Loop Top', 'kata-plus' ),
						 'std'       => '1',
						 'dependecy' => [
							 'full_page_slider' => '1',
						 ],
						 'kata-tab'  => 'full_page_slider',
					 ],
					 [
						 'id'        => 'full_page_slider_scrolling_speed',
						 'type'      => 'range',
						 'name'      => esc_html__( 'Scroll Speed', 'kata-plus' ),
						 'std'       => 850,
						 'min'       => 100,
						 'max'       => 2000,
						 'step'      => 1,
						 'dependecy' => [
							 'full_page_slider' => '1',
						 ],
						 'kata-tab'  => 'full_page_slider',
					 ],

					 // -> Start Footer Tab
					 [
						 'id'       => 'show_footer',
						 'type'     => 'switch',
						 'name'     => esc_attr__( 'Show Footer:', 'kata-plus' ),
						 'std'      => 1,
						 'kata-tab' => 'footer',
					 ],

					 // -> Page Custom Style
					 [
						 'id'        => 'styler_body',
						 'type'      => 'styler',
						 'name'      => esc_attr__( 'Body Style', 'kata-plus' ),
						 'kata-tab'  => 'page_style',
						 'selectors' => Kata_Styler::selectors( 'body' ),
					 ],
					 [
						 'id'        => 'styler_content',
						 'type'      => 'styler',
						 'name'      => esc_attr__( 'Content Style', 'kata-plus' ),
						 'kata-tab'  => 'page_style',
						 'selectors' => Kata_Styler::selectors( '.kata-content' ),
					 ],
				 ],
			 ];

			 return $meta_boxes;
		}
	} // class
	// Kata_Plus_Meta_Box_Page_Options::get_instance();
} // if
