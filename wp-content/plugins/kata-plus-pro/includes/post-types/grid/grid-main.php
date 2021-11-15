<?php

/**
 * Grid.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Grid_Main' ) ) {
	class Kata_Plus_Pro_Grid_Main {
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
		 * @var     Kata_Plus_Pro_Grid_Main
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
		        'name'					=> esc_html__( 'Portfolio' ),
		        'singular_name'			=> esc_html__( 'Portfolio' ),
		        'add_new'				=> esc_html__( 'Add Portfolio Item' ),
		        'add_new_item'			=> esc_html__( 'Add New Portfolio Item' ),
		        'edit_item'				=> esc_html__( 'Edit Portfolio Item' ),
		        'new_item'				=> esc_html__( 'New Portfolio Item' ),
		        'view_item'				=> esc_html__( 'View Portfolio Item' ),
		        'search_items'			=> esc_html__( 'Search Portfolio Item' ),
		        'not_found'				=> esc_html__( 'No Portfolio Items found' ),
		        'not_found_in_trash'	=> esc_html__( 'No Portfolio Items found in Trash' ),
		        'parent_item_colon'		=> '',
		        'menu_name'				=> esc_html__( 'Portfolio' )
		    );
		    $this->args = array(
		        'labels'			=> $labels,
		        'public'			=> true,
        		'has_archive'		=> true,
		        'show_ui'			=> true,
		        'query_var'			=> true,
		        'capability_type'	=> 'post',
		        'hierarchical'		=> true,
		        'map_meta_cap'		=> true,
		        'rewrite'			=> array( 'slug' => 'portfolio' ),
		        'supports'			=> array( 'title', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'thumbnail', 'author', 'page-attributes' ),
		        'menu_position'		=> 23,
				'menu_icon'			=> 'dashicons-grid-view',
				'taxonomies'		=> array( 'grid_category', 'grid_tags' ),
				'show_in_rest'		=> false,
		    );
		}

		/**
		 * Register Taxonomies.
		 *
		 * @since	1.0.0
		 */
		private function register_taxonomies() {

		    #Category Taxomonies
		    register_taxonomy( 'grid_category', 'kata_grid', array(
		    	'hierarchical'	=> true,
		    	'label' 		=> 'Portfolio Category',
		    	'query_var' 	=> true,
		    	'rewrite' 		=> array (
		    		'slug' => 'grid-type'
		    	)
		    ) );

		    if ( count( get_terms( 'grid_category', 'hide_empty=0' ) ) == 0 ) {
		        register_taxonomy( 'type', 'grid', array(
		        	'hierarchical'	=> true,
		        	'label'			=> 'Item Type'
		        ) );

		        $_categories = get_categories( 'taxonomy=type&title_li=' );
		        foreach ( $_categories as $_cat ) {
		            if ( ! term_exists( $_cat->name, 'grid_category' ) )
		                wp_insert_term( $_cat->name, 'grid_category' );
		        }

		        $grid = new WP_Query( array(
		        	'post_type' => 'kata_grid',
		        	'posts_per_page' => '-1'
		        ) );

		        while ($grid->have_posts()) : $grid->the_post();
		            $post_id = get_the_ID();
		            $_terms  = wp_get_post_terms( $post_id, 'type' );
		            $terms   = array();
		            foreach ( $_terms as $_term ) {
		                $terms[] = $_term->term_id;
		            }
		            wp_set_post_terms( $post_id, $terms, 'grid_category' );
		        endwhile;

		        wp_reset_query();
		        register_taxonomy( 'type', array() );
			}


			$labels = array(
			    'name'							=> esc_html__( 'Tags', 'taxonomy general name' ),
			    'singular_name'					=> esc_html__( 'Tag', 'taxonomy singular name' ),
			    'search_items'					=>  esc_html__( 'Search Tags' ),
			    'popular_items'					=> esc_html__( 'Popular Tags' ),
			    'all_items'						=> esc_html__( 'All Tags' ),
			    'parent_item'					=> null,
			    'parent_item_colon'				=> null,
			    'edit_item'						=> esc_html__( 'Edit Tag' ),
			    'update_item'					=> esc_html__( 'Update Tag' ),
			    'add_new_item'					=> esc_html__( 'Add New Tag' ),
			    'new_item_name'					=> esc_html__( 'New Tag Name' ),
			    'separate_items_with_commas'	=> esc_html__( 'Separate tags with commas' ),
			    'add_or_remove_items'			=> esc_html__( 'Add or remove tags' ),
			    'choose_from_most_used'			=> esc_html__( 'Choose from the most used tags' ),
			    'menu_name'						=> esc_html__( 'Tags' ),
			);

			# Tags Taxomonies
			register_taxonomy( 'grid_tags', 'kata_grid', array(
		    	'hierarchical'	=> false,
		    	'labels'		=> $labels,
		    	'title' 		=> 'Portfolio Tags',
		    	'query_var'		=> true,
		    	'show_ui'		=> true,
			    'rewrite'		=> array( 'slug' => 'grid-tag' ),
		    ) );
		}

		/**
		 * Add new grid cloumns.
		 *
		 * @since	1.0.0
		 */
		public function add_new_grid_columns() {
			$columns['cb'] 				= '<input type="checkbox" />';
		 	$columns['title'] 			= esc_html__( 'Title', 'kata-plus' );
			$columns['thumbnail'] 		= esc_html__( 'Thumbnail', 'kata-plus' );
			$columns['author']			= esc_html__( 'Author', 'kata-plus' );
			$columns['grid_category'] 	= esc_html__( 'Portfolio Categories', 'kata-plus' );
			$columns['date'] 			= esc_html__( 'Date', 'kata-plus' );
			return $columns;
		}

		/**
		 * Manage grid cloumns.
		 *
		 * @since	1.0.0
		 */
		public function manage_grid_columns( $columns ) {
			global $post;
			switch ( $columns ) {
				case 'thumbnail':
				 	if( get_the_post_thumbnail( $post->ID, 'thumbnail' ) ) {
						echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
					} else {
						echo '<span style="width: 150px;height: 150px;border-radius: 2px;background-color: #ddd;text-align: center;display: inherit;vertical-align: middle;position: relative;font-family: tahoma;color: #fff;font-size: 25px;font-weight: bold;pointer-events: none;" title="no image">No Image!</span>';
					}
				break;
			 	case 'grid_category':
					$terms = wp_get_post_terms( $post->ID, 'grid_category' );
					foreach ( $terms as $term ) {
						echo $term->name .'&nbsp;&nbsp; ';
					}
				break;
			}
		}

		/**
		 * Add actions.
		 *
		 * @since	1.0.0
		 */
		public function actions() {
			add_action( 'init', [$this, 'create_grid_post_type'], 99 );
			add_filter( 'manage_edit-kata_grid_columns', [$this, 'add_new_grid_columns'] );
			add_action( 'manage_kata_grid_posts_custom_column', [$this, 'manage_grid_columns'], 5, 2 );
		}

		/**
		 * Create post type.
		 *
		 * @since	1.0.0
		 */
		public function create_grid_post_type() {
			register_post_type( 'kata_grid', $this->args );
			$this->register_taxonomies();
		}
	} // end class

	Kata_Plus_Pro_Grid_Main::get_instance();
}
