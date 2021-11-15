<?php
/**
 * Team Member
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Team_Member_Main' ) ) {
	class Kata_Plus_Pro_Team_Member_Main {
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
		 * @var     Kata_Plus_Pro_Team_Member_Main
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
			$labels = array(
		        'name' 			       => esc_html__('Team Member'),
		        'singular_name'		   => esc_html__('Team Member'),
		        'add_new' 			   => esc_html__('Add Team Member Item'),
		        'add_new_item' 		   => esc_html__('Add New Team Member Item'),
		        'edit_item' 		   => esc_html__('Edit Team Member Item'),
		        'new_item' 			   => esc_html__('New Team Member Item'),
		        'view_item' 		   => esc_html__('View Team Member Item'),
		        'search_items' 		   => esc_html__('Search Team Member Item'),
		        'not_found' 		   => esc_html__('No Team Member Items found'),
		        'not_found_in_trash'   => esc_html__('No Team Member Items found in Trash'),
		        'parent_item_colon'    => '',
		        'menu_name' 		   => esc_html__('Team Member')
		    );
		    $this->args = array(
		        'labels'   			=> $labels,
		        'public' 			=> true,
        		'has_archive' 		=> true,
		        'show_ui' 			=> true,
		        'query_var'        	=> true,
		        'capability_type'  	=> 'post',
		        'hierarchical'     	=> true,
		        'map_meta_cap' 		=> true,
		        'rewrite' 			=> array( 'slug' => 'team-member'),
		        'supports' 			=> array( 'title', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'thumbnail', 'author', 'page-attributes' ),
		        'menu_position'		=> 23,
				'menu_icon' 		=> 'dashicons-groups',
				'show_in_rest'		=> false,
		    );
		}

		/**
		 * Add new Team Member cloumns.
		 *
		 * @since	1.0.0
		 */
		public function add_new_team_member_columns() {
			$columns['cb'] 			= '<input type="checkbox" />';
			$columns['title'] 		= esc_html__( 'Title', 'kata-plus' );
			$columns['thumbnail']	= esc_html__( 'Image', 'kata-plus' );
			$columns['author']		= esc_html__( 'Author', 'kata-plus' );
			$columns['date'] 		= esc_html__( 'Date', 'kata-plus' );
			return $columns;
		}

		/**
		 * Manage Team Member cloumns.
		 *
		 * @since	1.0.0
		 */
		public function manage_team_member_columns( $columns ) {
			global $post;
			if( get_the_post_thumbnail( $post->ID, 'thumbnail' ) ) {
				echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
			} else {
				echo '<span style="width: 150px;height: 150px;border-radius: 2px;background-color: #ddd;text-align: center;display: inherit;vertical-align: middle;position: relative;font-family: tahoma;color: #fff;font-size: 25px;font-weight: bold;pointer-events: none;" title="no image">No Image!</span>';
			}
		}

		/**
		 * Add actions.
		 *
		 * @since	1.0.0
		 */
		public function actions() {
			add_action( 'init', [$this, 'create_team_member_post_type'], 99 );
			add_filter( 'manage_edit-kata_team_member_columns', [$this, 'add_new_team_member_columns'] );
			add_action( 'manage_kata_team_member_posts_custom_column', [$this, 'manage_team_member_columns'], 5, 2 );
		}

		/**
		 * Create post type.
		 *
		 * @since	1.0.0
		 */
		public function create_team_member_post_type() {
			register_post_type( 'kata_team_member', $this->args );
		}
	} // end class

	Kata_Plus_Pro_Team_Member_Main::get_instance();
}
