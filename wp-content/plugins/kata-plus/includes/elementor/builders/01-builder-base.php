<?php

/**
 * Widget Base Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Plugin;
use Elementor\Post_CSS_File;
use Elementor\Core\Files\CSS\Post;

if ( class_exists( 'Elementor\Plugin' ) ) {
	if ( ! class_exists('Kata_Plus_Builders_Base') ) {
		class Kata_Plus_Builders_Base extends \Elementor\Core\Base\Document {

			/**
			 * An array of arguments.
			 *
			 * @access  protected
			 * @var     array
			 */
			protected $args;

			/**
			 * Builder action.
			 *
			 * @access  protected
			 * @var     String
			 */
			protected $action;

			/**
			 * Builder before content.
			 *
			 * @access  protected
			 * @var     String
			 */
			protected $before;

			/**
			 * Builder after content.
			 *
			 * @access  protected
			 * @var     String
			 */
			protected $after;

			/**
			 * Builder name.
			 *
			 * @access  protected
			 * @var     String
			 */
			public $name;

			/**
			 * Builder default content.
			 *
			 * @access  protected
			 * @var     String
			 */
			protected $default_content;

			/**
			 * Instance of this class.
			 *
			 * @since   1.0.0
			 * @access  public
			 * @var     Kata
			 */
			public static $instance;

			/**
			 * Provides access to a single instance of a module using the singleton pattern.
			 *
			 * @since   1.0.0
			 * @return  object
			 */
			public static function get_instance()
			{
				if (self::$instance === null) {
					self::$instance = new self();
				}
				return self::$instance;
			}

			/**
			 * Constructor.
			 *
			 * @since    1.0.0
			 */
			public function __construct()
			{
				$this->definitions();
				$this->builder_definitions();
				$this->actions();
			}

			/**
			 * Definitions.
			 *
			 * @since   1.0.0
			 */
			public function definitions()
			{
			}

			/**
			 * Header definitions.
			 *
			 * @since   1.0.0
			 */
			public function builder_definitions() {
				/**
				 * Define the arguments for the post type in $args array. A full list
				 * of the available arguments can be found here:
				 * https://codex.wordpress.org/Function_Reference/register_post_type
				 */
				$this->args = [
					'description'         => esc_html__( 'Description.', 'kata-plus' ),
					'public'              => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'query_var'           => true,
					'rewrite'             => ['slug' => 'kata-plus-builder'],
					'has_archive'         => true,
					'hierarchical'        => true,
					'exclude_from_search' => true,

					'supports'            => ['title', 'editor', 'elementor'],
					'labels'              => [
						'name'               => _x( 'Builders', 'post type general name', 'kata-plus' ),
						'singular_name'      => _x( 'Builder', 'post type singular name', 'kata-plus' ),
						'menu_name'          => _x( 'Builders', 'admin menu', 'kata-plus' ),
						'name_admin_bar'     => _x( 'Builders', 'add new on admin bar', 'kata-plus' ),
						'add_new'            => _x( 'Add New Builder', 'Builder', 'kata-plus' ),
						'add_new_item'       => esc_html__( 'Add New Builder', 'kata-plus' ),
						'new_item'           => esc_html__( 'New Builder', 'kata-plus '),
						'edit_item'          => esc_html__( 'Edit Builder', 'kata-plus '),
						'view_item'          => esc_html__( 'View Builder', 'kata-plus '),
						'all_items'          => esc_html__( 'All Builders', 'kata-plus '),
						'search_items'       => esc_html__( 'Search Builders', 'kata-plus '),
						'parent_item_colon'  => esc_html__( 'Parent Builders:', 'kata-plus '),
						'not_found'          => esc_html__( 'No Builder found.', 'kata-plus '),
						'not_found_in_trash' => esc_html__( 'No Builder found in Trash.', 'kata-plus '),
					],
				];
			}

			public function get_name() {
				return $this->name;
			}

			/**
			 * Actions.
			 *
			 * @since     1.0.0
			 */
			public function actions() {
				add_action( 'init', [$this, 'setup'], 99 );
				add_action( 'init', [$this, 'create_builder_post_type'], 99 );
				add_action( $this->action, [$this, 'load_the_builder'], 99 );
				add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );
				add_action( 'admin_notices', [$this, 'notice'], 99 );
				add_action( 'elementor/editor/after_enqueue_scripts', [$this, 'define_builder_name'], 99 );
			}

			/**
			 * Get Builder ID.
			 *
			 * @since   1.0.0
			 */
			public function get_builder_id() {
				return self::get_post_by_title($this->name);
			}

			/**
			 * Get Builder ID.
			 *
			 * @since   1.0.0
			 */
			public static function builder_url( $post_title = '' ) {
				$post_title = $post_title ? $post_title : $this->name;
				return admin_url( 'post.php?post=' . self::get_post_by_title( $post_title ) . '&action=elementor' );
			}

			/**
			 * Setup.
			 *
			 * @since   1.0.0
			 */
			public function setup() {
				$this->setup_post( $this->name );
			}

			/**
			 * Define Builder Name.
			 *
			 * @since   1.0.0
			 */
			public function define_builder_name() {
				if ( isset( $_GET ) && isset( $_GET['action'] ) && isset( $_GET['post'] ) && $_GET['post'] == $this->get_builder_id() ) {
					$name = preg_replace('/.*?_(.*?)/', '$1', strtolower($this->action));
					$name = $name == 'post' ? 'single' : $name;
					echo ('<script>var kata_plus_this_page_name = "' . $name . '";</script>');
				}
			}

			/**
			 * Setup Post.
			 *
			 * @since   1.0.0
			 */
			private function setup_post( $post_title ) {
				global $wpdb;
				$query = $wpdb->prepare(
					'SELECT * FROM ' . $wpdb->posts . '
					WHERE post_title = %s
					AND post_type = \'kata_plus_builder\' order by \'publish_date\' desc',
					$post_title
				);
				$wpdb->query( $query );

				if ( $wpdb->num_rows ) {
					$post = $wpdb->get_row( $query );
					return $post->ID;
				} else {
					$new_post   = [
						'post_title'    => $post_title,
						'post_content'  => '',
						'post_status'   => 'publish',
						'post_date'     => date('Y-m-d H:i:s'),
						'post_author'   => '',
						'post_type'     => 'kata_plus_builder',
						'post_category' => [0],
					];
					$post_id    = wp_insert_post( $new_post );
					$this->post = get_post( $post_id );
					update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
					update_post_meta( $post_id, '_elementor_template_type', 'post' );
					update_post_meta( $post_id, '_wp_page_template', 'default' );
					update_post_meta( $post_id, '_edit_lock', time() . ':1' );
					update_post_meta( $post_id, '_elementor_version', '0.4' );
					update_post_meta( $post_id, '_elementor_data', $this->default_content );

					return $post_id;
				}

				return false;
			}

			/**
			 * Load The Header
			 *
			 * @since     1.0.0
			 */
			public function load_the_builder() {
				if ( ! class_exists( '\Elementor\Plugin' ) ) {
					return;
				}

				if ( isset( $_REQUEST['elementor-preview'] ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					if ( get_the_title() == 'Kata Header' || get_the_title() == 'Kata Sticky Header' || get_the_title() == 'Kata Footer' ) {
						if ( get_the_title() != $this->name ) {
							return;
						}
					}
				}
				if ( Kata_Plus_helpers::is_blog_pages() || is_404() ) {
					$kata_options = get_option( 'kata_options' );
					if ( $this->name == 'Kata Header' && is_search() && ! get_theme_mod( 'kata_search_show_header', true ) ) {
						return;
					}
					if ( $this->name == 'Kata Header' && is_404() && ! get_theme_mod( 'kata_404_show_header', true ) ) {
						return;
					}
					if ( $this->name == 'Kata Header' && is_author() && ! get_theme_mod( 'kata_author_show_header', true ) ) {
						return;
					}
					if ( $this->name == 'Kata Header' && is_archive() && ! get_theme_mod( 'kata_archive_show_header', true ) ) {
						return;
					}
					if ( $this->name == 'Kata Header' && Kata_Plus_helpers::is_blog() && ! get_theme_mod( 'kata_blog_show_header', true ) ) {
						return;
					}
				}

				$id = self::get_post_by_title( $this->name );
				echo !empty($this->before) ? $this->before : '';
				echo '<div class="kata-builder-wrap ' . esc_attr( sanitize_title( $this->name ) ) . '">';
				if ( $this->name == 'Kata Sticky Header' ) {
					echo '<div class="kata-sticky-box" id="box-1" data-pos-des="' . get_theme_mod( 'kata_sticky_box_position', 'top' ) . '" data-pos-tablet="' . get_theme_mod( 'kata_sticky_box_position_tablet', 'top' ) . '" data-pos-mobile="' . get_theme_mod( 'kata_sticky_box_position_mobile', 'top' ) . '" data-sec="' . get_theme_mod( 'kata_sticky_just_in_parent', 'no' ) . '">';
					echo Plugin::instance()->frontend->get_builder_content_for_display( $id, false );
					echo '</div>';
				} else {
					echo Plugin::instance()->frontend->get_builder_content_for_display( $id, false );
				} //kata-sticky-box
				echo '</div>';
				echo !empty( $this->after ) ? $this->after : '';

				if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
					$css_file = new Post($id);
				} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
					$css_file = new Post_CSS_File($id);
				}
				$css_file->enqueue();
			}

			/**
			 * Get Post.
			 *
			 * @since   1.0.0
			 */
			public static function get_post_by_title( $post_title ) {
				if ( isset( $post_title ) && ! empty( $post_title ) ) {
					$post_id = get_page_by_title( $post_title, ARRAY_A, $post_type = 'kata_plus_builder' );
					if ( isset( $post_id['ID'] ) ) {
						return $post_id['ID'];
					} else {
						return false;
					}
				}
			}

			/**
			 * Create post type.
			 *
			 * @since   1.0.0
			 */
			public function create_builder_post_type() {
				register_post_type( 'kata_plus_builder', $this->args );
			}

			/**
			 * Enqueue Scripts
			 *
			 * @since     1.0.0
			 */
			public function enqueue_scripts() {
				if ( class_exists( '\Elementor\Plugin' ) ) {
					$elementor = \Elementor\Plugin::instance();
					$elementor->frontend->enqueue_styles();
				}

				if ( class_exists( '\ElementorPro\Plugin' ) ) {
					$elementor_pro = \ElementorPro\Plugin::instance();
					$elementor_pro->enqueue_styles();
				}
			}

			/**
			 * Notice
			 *
			 * @since     1.0.0
			 */
			public function notice() {
				$id = self::get_post_by_title( $this->name );
				if ( get_post_status( $id ) == 'trash' ) {
					$restore_link = wp_nonce_url(
						"post.php?action=untrash&amp;post=$id",
						"untrash-post_$id"
					); ?>
					<div id="message" class="error notice is-dismissible">
						<p><?php echo esc_html( $this->name ) . ' ' . __('is in the Trash.', 'kata-plus'); ?> <a href="<?php echo esc_url($restore_link); ?>"><?php echo __('Please restore it.', 'kata-plus'); ?></a></p>
						<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo __('Dismiss this notice.', 'kata-plus'); ?></span></button>
					</div>
					<?php
				}
			}
		} // class
	}
}
