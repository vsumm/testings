<?php
/**
 * Kata functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata' ) ) {
	/**
	 * Kata.
	 *
	 * @author     Climaxthemes
	 * @package     Kata
	 * @since     1.0.0
	 */
	class Kata {
		/**
		 * Maintains the current version of Kata theme.
		 *
		 * @access public
		 * @var    string
		 */
		public static $version;

		/**
		 * Maintains theme slug.
		 *
		 * @access public
		 * @var    string
		 */
		public static $theme;

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
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $assets;

		/**
		 * The url of uploads file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $upload_dir;

		/**
		 * The url of uploads file url.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $upload_dir_url;

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
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Define the core functionality of the theme.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			$this->definitions();
			$this->actions();
			$this->filters();
			$this->dependencies();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$version 			= '1.1.7';
			self::$theme 			= wp_get_theme(); // Do not change value of slug
			self::$dir     			= trailingslashit( get_template_directory() );
			self::$url     			= trailingslashit( get_template_directory_uri() );
			self::$assets  			= self::$url . 'assets/';
			self::$upload_dir       = wp_get_upload_dir()['basedir'] . '/kata';
			self::$upload_dir_url   = wp_get_upload_dir()['baseurl'] . '/kata';
			define( 'KATA_VERSION', '1.1.7' );
			if ( ! get_theme_mod( 'KTSOURCE', '' ) || get_theme_mod( 'KTSOURCE' ) !== 'KATABLOG' ) {
				set_theme_mod( 'KTSOURCE', 'KATABLOG' );
			}
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
			add_action( 'wp_head', array( $this, 'pingback_header' ) );
			add_action( 'init', array( $this, 'reg_nav' ) );
			add_filter( 'wp_list_categories', array( $this, 'kata_category_list' ) );
		}

		/**
		 * Add filters.
		 *
		 * @since   1.0.0
		 */
		public function reg_nav() {
			register_nav_menus(
				array(
					'kt-header-menu'	=> esc_html__( 'Header Menu', 'kata' ),
					'kt-foot-menu'		=> esc_html__( 'Footer Menu', 'kata' ),
				)
			);
		}

		/**
		 * Add filters.
		 *
		 * @since   1.0.0
		 */
		public function filters() {
			add_filter( 'body_class', array( $this, 'body_classes' ) );
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			/**
			 * autoloader.
			 */
			require self::$dir . 'includes/autoloader/autoloader.php';
			/**
			 * Theme helpers.
			 */
			require self::$dir . 'includes/class-kata-helpers.php';
			/**
			 * Theme Page (dashboard).
			 */
			require self::$dir . 'includes/dashboard/class-kata-dashboard.php';
			/**
			 * Custom template tags.
			 */
			require self::$dir . 'includes/class-kata-template-tags.php';
			/**
			 * Customizer.
			 */
			require self::$dir . 'includes/customizer/kirki.php';
			require self::$dir . 'includes/theme-options/theme-options.php';

			/**
			 * Template parts.
			 */
			require self::$dir . 'template-parts/header.tpl.php';
			require self::$dir . 'template-parts/footer.tpl.php';

			/**
			 * Load Jetpack compatibility file.
			 */
			if ( defined( 'JETPACK__VERSION' ) ) {
				require self::$dir . 'includes/jetpack.php';
			}

			/**
			 * Load TGM.
			 */
			if ( ! class_exists( 'Kata_Plus' ) ) {
				require self::$dir . '/includes/tgm/class-tgm-plugin-activation.php';
				require self::$dir . 'includes/tgm/plugins.php';
			}
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since   1.0.0
		 */
		public function setup() {
			/**
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 * If you're building a theme based on Kata, use a find and replace
			 * to change 'kata' to the name of your theme in all the template files.
			 */
			load_theme_textdomain( 'kata', self::$dir . 'languages' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			/**
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5',
				array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				)
			);

			/**
			 * Add theme support for selective refresh for widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add theme support post formats.
			 */
			add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

			/**
			 * Kata registration.
			 */
			if ( get_option( 'kata_is_active' ) ) {
				update_option( 'kata_is_active', true );
			}

			/**
			 * Enable the use of a custom logo.
			 */
			add_theme_support( 'custom-logo' );

			/**
			 * Woocommerce Support.
			 */
			add_theme_support( 'woocommerce', array(
				'thumbnail_image_width' => get_theme_mod( 'kata_thumbnail_image_width', 400 ),
				'single_image_width'    => get_theme_mod( 'kata_single_image_width', 800 ),
				'product_grid'          => array(
					'default_rows'    => 3,
					'min_rows'        => 2,
					'max_rows'        => 8,
					'default_columns' => 4,
					'min_columns'     => 2,
					'max_columns'     => 5,
				),
			) );
			// Next setting from the WooCommerce 3.0+ enable built-in image slider on the single product page
			add_theme_support( 'wc-product-gallery-slider' );

			// Next setting from the WooCommerce 3.0+ enable built-in image zoom on the single product page
			add_theme_support( 'wc-product-gallery-zoom' );

			// Next setting from the WooCommerce 3.0+ enable built-in image lightbox on the single product page
			add_theme_support( 'wc-product-gallery-lightbox' );

			// Disable WooCommerce ads
			add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );

		}

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global  int $content_width
		 * @since   1.0.0
		 */
		public function content_width() {
			// Set content-width.
			global $content_width;
			if ( ! isset( $content_width ) ) {
				$content_width = 640;
			}
		}

		/**
		 * Register widget area.
		 *
		 * @link    https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
		 * @since   1.0.0
		 */
		public function widgets_init() {
			$sidebar = get_theme_mod( 'kata_blog_sidebar_setting', 'right' );
			if( $sidebar == 'left' || $sidebar == 'both' ) {
				register_sidebar(
					array(
						'name'          => esc_html__( 'Left Sidebar', 'kata' ),
						'id'            => 'kata-left-sidebar',
						'description'   => esc_html__( 'Add widgets here.', 'kata' ),
						'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h2 class="kata-widget-title"><span>',
						'after_title'   => '</span></h2>',
					)
				);
			}
			if( $sidebar == 'right' || $sidebar == 'both' ) {
				register_sidebar(
					array(
						'name'          => esc_html__( 'Right Sidebar', 'kata' ),
						'id'            => 'kata-right-sidebar',
						'description'   => esc_html__( 'Add widgets here.', 'kata' ),
						'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h2 class="kata-widget-title"><span>',
						'after_title'   => '</span></h2>',
					)
				);
			}
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Column 1', 'kata' ),
					'id'            => 'kata-footr-sidebar-1',
					'description'   => esc_html__( 'Add widgets here.', 'kata' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title"><span>',
					'after_title'   => '</span></h2>',
				)
			);
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Column 2', 'kata' ),
					'id'            => 'kata-footr-sidebar-2',
					'description'   => esc_html__( 'Add widgets here.', 'kata' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title"><span>',
					'after_title'   => '</span></h2>',
				)
			);
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Column 3', 'kata' ),
					'id'            => 'kata-footr-sidebar-3',
					'description'   => esc_html__( 'Add widgets here.', 'kata' ),
					'before_widget' => '<div class="%2$s-wrapper kata-widget" id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="kata-widget-title"><span>',
					'after_title'   => '</span></h2>',
				)
			);
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since   1.0.0
		 */
		public function scripts() {
			wp_enqueue_style( 'kata-main', get_template_directory_uri() . '/style.css', array(), self::$version );
			wp_enqueue_style( 'kata-grid', self::$assets . 'css/grid.css', array(), self::$version );
			wp_enqueue_style( 'kata-theme-styles', self::$assets . 'css/theme-styles.css', array(), self::$version );
			wp_enqueue_style( 'kata-blog-posts', self::$assets . 'css/blog-posts.css', array(), self::$version );
			wp_enqueue_style( 'kata-widgets', self::$assets . 'css/widgets.css', array(), self::$version );
			if ( is_single() || is_page() ) {
				wp_enqueue_style( 'kata-single-post', self::$assets . 'css/single.css', array(), self::$version );
				if ( comments_open() || get_comments_number() ) {
					wp_enqueue_style( 'kata-comments', self::$assets . 'css/comments.css', array(), self::$version );
				}
			}
			if ( class_exists( 'WooCommerce') ) {
				wp_enqueue_style( 'kata-woocommerce', self::$assets . 'css/kata-woo.css', array(), self::$version );
			}
			wp_enqueue_style( 'kata-menu-navigation', self::$assets . 'css/menu-navigation.css', array(), '1.0.2' );
			wp_enqueue_script( 'kata-default-scripts', self::$assets . 'js/default-scripts.js', array( 'jquery' ), self::$version, true );
			wp_enqueue_script( 'superfish', self::$assets . 'js/superfish.js', array( 'jquery', 'kata-default-scripts' ), self::$version, true );
			wp_enqueue_style( 'kata-dynamic-styles', self::$assets . '/css/dynamic-styles.css', array(), rand(1, 999));
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
		 *
		 * @since   1.0.0
		 */
		public function pingback_header() {
			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
			}
		}

		/**
		 * change HTML Category list.
		 *
		 * @param   array $list return html.
		 * @return  array
		 * @since   1.0.0
		 */
		public function kata_category_list( $list ) {
			// move count inside a tags
			$list = str_replace( '</a> (', '(', $list );
			$list = str_replace( ')', ')</a>', $list );
			return $list;
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
			if ( ! is_singular() ) {
				$classes[] = 'hfeed';
			}

			// Adds a class of no-sidebar when there is no sidebar present.
			$sidebar = get_theme_mod( 'kata_blog_sidebar_setting', 'right' );
			if ( ( 'none' === $sidebar ) || ( ! is_active_sidebar( 'kata-left-sidebar' ) && ! is_active_sidebar( 'kata-right-sidebar' ) ) ) {
				$classes[] = 'no-sidebar';
			}

			if ( Kata_Helpers::is_blog_pages() || is_single() ) {
				if ( is_active_sidebar( 'kata-right-sidebar' ) && is_active_sidebar( 'kata-left-sidebar' ) && $sidebar == 'both' ) {
					if ( 'both' === $sidebar ) {
						$classes[] = 'kata-both-sidebar';
					}
				}
			}
			if ( Kata_Helpers::is_blog_pages() || is_single() ) {
				if ( is_active_sidebar( 'kata-right-sidebar' ) ) {
					if ( 'right' === $sidebar ) {
						$classes[] = 'kata-right-sidebar';
					}
				}
			}
			if ( Kata_Helpers::is_blog_pages() || is_single() ) {
				if ( is_active_sidebar( 'kata-left-sidebar' ) ) {
					if ( 'left' === $sidebar ) {
						$classes[] = 'kata-left-sidebar';
					}
				}
			}
			
			/**
			 * Transparent header.
			 */
			if ( '1' === Kata_Helpers::get_meta_box( 'kata_make_header_transparent' ) && ! Kata_Helpers::is_blog_pages() ) {
				$classes[] = 'kata-make-header-transparent';
			}
			if ( '1' === Kata_Helpers::get_meta_box( 'kata_header_transparent_white_color' ) && ! Kata_Helpers::is_blog_pages() ) {
				$classes[] = 'kata-header-transparent-white-color';
			}
			
			/**
			 * Builders Transparent header.
			 */
			if ( Kata_Helpers::is_blog_pages() || is_404() ) {
				$kata_options = get_option( 'kata_options' );
				if ( Kata_Helpers::is_blog() && '1' == get_theme_mod( 'kata_blog_transparent_header', '0' ) ) {
					$classes[] = 'kata-make-header-transparent';
				}
				if ( is_archive() && '1' == get_theme_mod( 'kata_archive_transparent_header', '0' ) ) {
					$classes[] = 'kata-make-header-transparent';
				}
				if ( is_author() && '1' == get_theme_mod( 'kata_author_transparent_header', '0' ) ) {
					$classes[] = 'kata-make-header-transparent';
				}
				if ( is_search() && '1' == get_theme_mod( 'kata_search_transparent_header', '0' ) ) {
					$classes[] = 'kata-make-header-transparent';
				}
				if ( is_404() && '1' == get_theme_mod( 'kata_404_transparent_header', '0' ) ) {
					$classes[] = 'kata-make-header-transparent';
				}
			}
			if ( Kata_Helpers::is_blog_pages() || is_404() ) {
				$kata_options = get_option( 'kata_options' );
				if ( Kata_Helpers::is_blog() && '1' == get_theme_mod( 'kata_blog_header_transparent_white_color', '0' ) && '1' == get_theme_mod( 'kata_blog_transparent_header', '0' ) ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
				if ( is_archive() && '1' == get_theme_mod( 'kata_archive_header_transparent_white_color', '0' ) && '1' == get_theme_mod( 'kata_archive_transparent_header', '0' ) ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
				if ( is_author() && '1' == get_theme_mod( 'kata_author_header_transparent_white_color', '0' ) && '1' == get_theme_mod( 'kata_author_transparent_header', '0' ) ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
				if ( is_search() && '1' == get_theme_mod( 'kata_search_header_transparent_white_color', '0' ) && '1' == get_theme_mod( 'kata_search_transparent_header', '0' ) ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
				if ( is_404() && '1' == get_theme_mod( 'kata_404_header_transparent_white_color', '0' ) && '1' == get_theme_mod( 'kata_404_transparent_header', '0' ) ) {
					$classes[] = 'kata-header-transparent-white-color';
				}
			}
			return $classes;
		}

		/**
		 * Site classes.
		 *
		 * @param class $class add custom class to body.
		 * @since   1.0.0
		 */
		public static function site_class( $class = '' ) {
			$classes  = array();
			$classes[] = $class;
			$classes[] = get_theme_mod( 'kata_layout', 'kata-wide' );

			/**
			 * Separates classes with a single space, collates classes for site container element.
			 */
			echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
		}
	} // class

	Kata::get_instance();
}
