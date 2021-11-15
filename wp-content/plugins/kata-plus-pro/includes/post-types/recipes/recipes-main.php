<?php
/**
 * Recipes
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Recipes_Main' ) ) {
	class Kata_Plus_Pro_Recipes_Main {
		/**
		 * An array of arguments.
		 *
		 * @access  private
		 * @var     array
		 */
		private $args;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro_Recipes_Main
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
		 * @param null.
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
			/**
			 * Define the arguments for the post type in $args array. A full list
			 * of the available arguments can be found here:
			 * https://codex.wordpress.org/Function_Reference/register_post_type
			 */
			$labels     = array(
				'name'               => esc_html__( 'Recipe' ),
				'singular_name'      => esc_html__( 'Recipe' ),
				'add_new'            => esc_html__( 'Add Recipe Item' ),
				'add_new_item'       => esc_html__( 'Add New Recipe Item' ),
				'edit_item'          => esc_html__( 'Edit Recipe Item' ),
				'new_item'           => esc_html__( 'New Recipe Item' ),
				'view_item'          => esc_html__( 'View Recipe Item' ),
				'search_items'       => esc_html__( 'Search Recipe Item' ),
				'not_found'          => esc_html__( 'No Recipe Items found' ),
				'not_found_in_trash' => esc_html__( 'No Recipe Items found in Trash' ),
				'parent_item_colon'  => '',
				'menu_name'          => esc_html__( 'Recipe' ),
			);
			$this->args = array(
				'labels'          => $labels,
				'public'          => true,
				'has_archive'     => true,
				'show_ui'         => true,
				'query_var'       => true,
				'capability_type' => 'post',
				'hierarchical'    => true,
				'map_meta_cap'    => true,
				'rewrite'         => array( 'slug' => 'recipe' ),
				'supports'        => array( 'title', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'thumbnail', 'author', 'page-attributes', 'post-formats' ),
				'menu_position'   => 23,
				'menu_icon'       => 'dashicons-carrot',
				'taxonomies'      => array( 'recipe_category', 'recipe_tags' ),
				'show_in_rest'    => false,
			);
		}

		/**
		 * Register Taxonomies.
		 *
		 * @since   1.0.0
		 */
		private function register_taxonomies() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => __( 'Recipes', 'kata-plus' ),
				'singular_name'     => __( 'Recipe', 'kata-plus' ),
				'search_items'      => __( 'Search Recipes', 'kata-plus' ),
				'all_items'         => __( 'All Recipes', 'kata-plus' ),
				'parent_item'       => __( 'Parent Recipe', 'kata-plus' ),
				'parent_item_colon' => __( 'Parent Recipe:', 'kata-plus' ),
				'edit_item'         => __( 'Edit Recipe', 'kata-plus' ),
				'update_item'       => __( 'Update Recipe', 'kata-plus' ),
				'add_new_item'      => __( 'Add New Recipe', 'kata-plus' ),
				'new_item_name'     => __( 'New Recipe Name', 'kata-plus' ),
				'menu_name'         => __( 'Recipe Category', 'kata-plus' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'kata_recipe_category' ),
			);

			register_taxonomy( 'kata_recipe_category', array( 'kata_recipe' ), $args );

			unset( $args );
			unset( $labels );

			// Add new taxonomy, NOT hierarchical (like tags)
			$labels = array(
				'name'                       => __( 'Tag', 'kata-plus' ),
				'singular_name'              => __( 'Writer', 'kata-plus' ),
				'search_items'               => __( 'Search Tag', 'kata-plus' ),
				'popular_items'              => __( 'Popular Tag', 'kata-plus' ),
				'all_items'                  => __( 'All Tag', 'kata-plus' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Writer', 'kata-plus' ),
				'update_item'                => __( 'Update Writer', 'kata-plus' ),
				'add_new_item'               => __( 'Add New Writer', 'kata-plus' ),
				'new_item_name'              => __( 'New Writer Name', 'kata-plus' ),
				'separate_items_with_commas' => __( 'Separate tag with commas', 'kata-plus' ),
				'add_or_remove_items'        => __( 'Add or remove tag', 'kata-plus' ),
				'choose_from_most_used'      => __( 'Choose from the most used tag', 'kata-plus' ),
				'not_found'                  => __( 'No tag found.', 'kata-plus' ),
				'menu_name'                  => __( 'Recipe tag', 'kata-plus' ),
			);

			$args = array(
				'hierarchical'          => false,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'writer' ),
			);

			register_taxonomy( 'kata_recipe_tag', array( 'kata_recipe' ), $args );
		}

		/**
		 * Add new recipe cloumns.
		 *
		 * @since   1.0.0
		 */
		public function add_new_recipe_columns() {
			$columns['cb']              = '<input type="checkbox" />';
			$columns['title']           = esc_html__( 'Title', 'kata-plus' );
			$columns['thumbnail']       = esc_html__( 'Thumbnail', 'kata-plus' );
			$columns['author']          = esc_html__( 'Author', 'kata-plus' );
			$columns['recipe_category'] = esc_html__( 'recipe Categories', 'kata-plus' );
			$columns['date']            = esc_html__( 'Date', 'kata-plus' );
			return $columns;
		}

		/**
		 * Manage recipe cloumns.
		 *
		 * @since   1.0.0
		 */
		public function manage_recipe_columns( $columns ) {
			global $post;
			switch ( $columns ) {
				case 'thumbnail':
					if ( get_the_post_thumbnail( $post->ID, 'thumbnail' ) ) {
						echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
					} else {
						echo '<span style="width: 150px;height: 150px;border-radius: 2px;background-color: #ddd;text-align: center;display: inherit;vertical-align: middle;position: relative;font-family: tahoma;color: #fff;font-size: 25px;font-weight: bold;pointer-events: none;" title="no image">No Image!</span>';
					}
					break;
				case 'recipe_category':
					$terms = wp_get_post_terms( $post->ID, 'recipe_category' );
					foreach ( $terms as $term ) {
						echo $term->name . '&nbsp;&nbsp; ';
					}
					break;
			}
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'init', [ $this, 'create_recipe_post_type' ], 99 );
			add_filter( 'manage_edit-kata_recipe_columns', [ $this, 'add_new_recipe_columns' ] );
			add_action( 'manage_kata_recipe_posts_custom_column', [ $this, 'manage_recipe_columns' ], 5, 2 );
		}

		/**
		 * Create post type.
		 *
		 * @since   1.0.0
		 */
		public function create_recipe_post_type() {
			register_post_type( 'kata_recipe', $this->args );
			$this->register_taxonomies();
		}
	} // end class

	Kata_Plus_Pro_Recipes_Main::get_instance();
}
