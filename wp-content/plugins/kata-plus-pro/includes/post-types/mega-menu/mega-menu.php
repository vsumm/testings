<?php
/**
 * Mega Menu.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Mega_Menus' ) ) {
	class Kata_Plus_Pro_Mega_Menus {
		/**
		 * An array of arguments.
		 *
		 * @access	private
		 * @var		array
		 */
		private $args;

		/**
		 * Instance of this class.
         *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro_Mega_Menus
		 */
		public static $instance;

        /**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return	object
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
		 * @param null.
		 */
		public function __construct() {
			$this->definitions();
			$this->actions();
		}

		/**
		 * Global definitions.
		 *
		 * @since	1.0.0
		 */
		public function definitions() {
			/**
			 * Define the arguments for the post type in $args array. A full list
			 * of the available arguments can be found here:
			 * https://codex.wordpress.org/Function_Reference/register_post_type
			 */
			$this->args = [
				'public'		=> true,
				'query_var'		=> 'kata_mega_menu',
				'rewrite'		=> ['slug' => 'kata_mega_menu'],
				'supports'		=> ['title', 'editor'],
				'show_in_rest'	=> false,
				'show_in_menu'	=> false,
				'labels'		=> [
					'name'					=> esc_html__( 'Mega Menus', 'kata-plus' ),
					'all_items'				=> esc_html__( 'Mega Menus', 'kata-plus' ),
					'singular_name'			=> esc_html__( 'Mega Menu', 'kata-plus' ),
					'add_new'				=> esc_html__( 'Add New', 'kata-plus' ),
					'add_new_item'			=> esc_html__( 'Add New Mega Menu', 'kata-plus' ),
					'edit_item'				=> esc_html__( 'Edit Mega Menu', 'kata-plus' ),
					'new_item'				=> esc_html__( 'New Mega Menu', 'kata-plus' ),
					'view_item'				=> esc_html__( 'View Mega Menu', 'kata-plus' ),
					'search_items'			=> esc_html__( 'Search Mega Menus', 'kata-plus' ),
					'not_found'				=> esc_html__( 'No Mega Menus found', 'kata-plus' ),
					'not_found_in_trash'	=> esc_html__( 'No Mega Menus found in Trash', 'kata-plus' ),
					'show_in_rest'			=> true,
				],
			];
		}

		/**
		 * Add actions.
		 *
		 * @since	1.0.0
		 */
		public function actions() {
			add_action( 'init', [$this, 'create_mega_menu_post_type'], 99 );
			add_filter('single_template', [$this, 'mega_menu_template'], 99);
		}

		/**
		 * Create post type.
		 *
		 * @since	1.0.0
		 */
		public function create_mega_menu_post_type() {
			register_post_type( 'kata_mega_menu', $this->args );
		}

		/**
		 * Single Template
		 *
		 * @since	1.0.0
		 */
		public function mega_menu_template($template) {
			global $post;

			if ($post->post_type == "kata_mega_menu" && $template !== locate_template(array("single-kata_mega_menu.php"))){
				return plugin_dir_path( __FILE__ ) . "single-kata_mega_menu.php";
			}
			return $template;
		}
	} // end class

	Kata_Plus_Pro_Mega_Menus::get_instance();
}
