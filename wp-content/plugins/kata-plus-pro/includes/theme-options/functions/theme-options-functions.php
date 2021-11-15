<?php

/**
 * Kata Plus Theme Options Helpers.
 *
 * @since   1.0.0
 */

if ( !class_exists( 'Kata_Plus_Pro_Theme_Options_Functions' ) ) {
	class Kata_Plus_Pro_Theme_Options_Functions {
		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Theme_Options_Functions
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return   object
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
			$this->actions();
		}

		/**
		 * Add actions.
		 *
		 * @since    1.0.0
		 */
		public function actions() {
			// Critical CSS
			add_action( 'wp_head', [$this, 'critical_css'], -1 );
			// Maintenance Mode
			add_action( 'template_redirect', [$this, 'maintenance_mode'] );
			// Smooth Scroll
			add_action( 'wp_enqueue_scripts', [$this, 'option_smooth_scroll'] );
			// Enqueue Scripts
			add_action( 'elementor/frontend/after_register_scripts', [$this, 'enqueue'] );
			// Option Preloader
			if( get_theme_mod( 'kata_enable_preloader' ) ) {
				add_action( 'wp_enqueue_scripts', [$this, 'kata_preloader'] );
				add_action( 'wp_body_open', [$this, 'kata_preloader_template'] );
			}
			// Option Back To Top Icon
			add_filter( 'wp_footer', [$this, 'option_back_to_top_icon'] );
			// Option Nicescroll
			add_filter( 'wp_footer', [$this, 'option_nicescroll'], 150 );
			// Section Slider Page
			add_action( 'kata_page_before_loop', [$this, 'start_full_page_slider'], 40 );
			add_action( 'kata_page_after_loop', [$this, 'end_full_page_slider'], 40 );
			// GDPR
			add_filter( 'wp_footer', [$this, 'gdpr'] );
			// white label WP Admin Logo and Custom css
			add_action( 'login_enqueue_scripts', [$this, 'white_label_admin_logo'] );
			add_action( 'init', [$this, 'post_type_manager'], 999  );
			add_action( 'customize_preview_init', [$this, 'admin_custom_css'], 999999 );
			// Custom Code
			add_action( 'wp_head', [$this, 'space_before_head'] );
			add_action( 'wp_footer', [$this, 'space_before_body'] );
			// dynamic styles
			add_filter( 'option_dynamic_styles', [$this, 'option_dynamic_styles'] );
			add_filter( 'kata_plus_inline_scripts', [$this, 'kata_plus_inline_scripts'] );

			add_action( 'wp_enqueue_scripts', [$this, 'manage_scripts'], 9999999999 );
		}


		/**
		 * Manage scripts.
		 *
		 * @since   1.0.0
		 */
		public function manage_scripts() {
			$scripts = json_decode( get_option( 'kata_script_manager' ), true );
			if ( isset( $scripts['scripts'] ) ) {
				foreach ( $scripts['scripts'] as $script ) {
					if ( get_theme_mod( 'kata_prevent_load_script_' . $script, false ) ) {
						wp_deregister_script( $script );
						wp_dequeue_script( $script );
					}
				}
			} 
			if ( isset( $scripts['styles'] ) ) {
				foreach ( $scripts['styles'] as $style ) {
					if ( get_theme_mod( 'kata_prevent_load_style_' . $style, false ) ) {
						wp_deregister_style( $style );
						wp_dequeue_style( $style );
					}
				}
			} 
		}

		/**
		 * Enqueue dynamic inline scripts.
		 *
		 * @since   1.0.0
		 */
		public function kata_plus_inline_scripts( $scripts ) {
			/**
			 * lazyload
			 */
			$lazyload = get_theme_mod( 'kata_plus_pro_lazyload', false );
			if ( $lazyload === true ) {
				$scripts .= 'const observer = lozad(".kata-lazyload img", { rootMargin: "10px 0px", threshold: 0.1, enableAutoReload: true, });';
				$scripts .= 'observer.observe();';
				$scripts .= '$(window).load(function() {';
				$scripts .= 'const observer = lozad(".kata-lazyload img", { rootMargin: "10px 0px", threshold: 0.1, enableAutoReload: true, });';
				$scripts .= 'observer.observe();';
				$scripts .= '});';
			}
			return $scripts;
		}

		/**
		 * Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function option_dynamic_styles( $css ) {
			/**
			 * lazyload
			 */
			$lazyload = get_theme_mod( 'kata_plus_pro_lazyload', false );
			if ( $lazyload === true ) {
				$css .= '.kata-lazyload img {display: inline-block;}';
				$css .= '.kata-lazyload img:not([data-loaded="true"]) {text-indent: -10000px;background-image:linear-gradient(90deg,#eee 0,#ddd 50%,#eee 100%);background-position:0px 0px;background-repeat:repeat;animation:animatedBackground 1s ease infinite;}';
				$css .= '.kata-lazyload img[data-loaded="true"] {background-image:none;}';
				$css .= '@keyframes animatedBackground{from{background-position: 0 0;} to {background-position: 800px 0;}}';
			}
			return $css;
		}

		/**
		 * Enqueue Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function enqueue() {
			if ( Kata_Plus_Pro_Helpers::get_meta_box('full_page_slider') == '1' ) :
				wp_enqueue_style('fullpage', Kata_Plus::$assets . 'css/libraries/fullpage.css');
				wp_enqueue_script('fullpage-easings', Kata_Plus::$assets . 'js/libraries/easings.min.js', ['jquery'], true);
				wp_enqueue_script('fullpage', Kata_Plus::$assets . 'js/libraries/fullpage.min.js', ['jquery'], true);
			endif;

			$lazyload = get_theme_mod( 'kata_plus_pro_lazyload', false );
			if ( $lazyload === true ) {
				wp_enqueue_script( 'lozad', Kata_Plus::$assets . 'js/libraries/lozad.min.js', [ 'jquery' ], Kata_Plus::$version, true );
			}
			/**
			 * GDPR Enqueue styles
			 */
			if (get_theme_mod('kata_gdpr_box') == '1' && !isset($_COOKIE['KataCookieGDPR'])) :
				wp_dequeue_style( 'kata-gdpr-style' );
				wp_enqueue_style( 'kata-plus-gdpr-style', Kata_Plus::$assets . 'css/frontend/gdpr.css' );
			endif;
			/**
			 * Nice Scroll
			 */
			if ( get_theme_mod( 'kata_custom_scrollbar', '0' ) == '1' ) {
				wp_enqueue_script('kata-nicescroll-script', Kata_Plus::$assets . 'js/libraries/jquery.nicescroll.js', ['jquery'], Kata_Plus::$version, true);
			}
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function space_before_head() {
			echo '<!-- space before head -->';
			echo get_theme_mod('kata_space_before_head', '');
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function space_before_body() {
			echo '<!-- space before body -->';
			echo get_theme_mod('kata_space_before_body', '');
		}

		/**
		 * Maintenance Mode.
		 *
		 * @since   1.0.0
		 */
		public function maintenance_mode() {
			$maintenance	= get_theme_mod('maintenance_mode', '0');
			$url			= get_the_permalink(get_theme_mod('kata_maintenance_page_id'));
			if($maintenance) {
				if(!is_page(get_theme_mod('kata_maintenance_page_id')) && $url && !current_user_can('edit_posts')) {
					wp_redirect($url);
					exit;
				}
			}
		}

		/**
		 * Start Section Slider Page.
		 *
		 * @since   1.0.0
		 */
		public function start_full_page_slider() {
			if (Kata_Helpers::get_meta_box('full_page_slider') == '1') {
				echo '<div id="kata-full-page-slider" class="kata-full-page-slider"
						data-navigation ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_navigation')) . '"
						data-navigation-position ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_navigation_position')) . '"
						data-loop-bottom ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_loop_bottom')) . '"
						data-loop-top ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_loop_top')) . '"
						data-scrolling-speed ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_scrolling_speed')['size']) . '"
					>';
			}
		}

		/**
		 * End Section Slider Page.
		 *
		 * @since   1.0.0
		 */
		public function end_full_page_slider() {
			if (Kata_Helpers::get_meta_box('edge_one_pager') == '1') {
				echo '</div>';
			}
		}

		/**
		 * Breadcrumbs.
		 * @param $seperator
		 * @since   1.0.0
		 */
		public static function breadcrumbs( $start = '', $seperator = '' ) {
			// Breadcrumbs
			if (!is_front_page()) {?>
				<div id="kata-breadcrumbs" class="kata-breadcrumbs">
					<div class="container">
						<div class="col-sm-12">
							<?php
							if (function_exists('kata_plus_breadcrumbs')) {
								kata_plus_breadcrumbs( $start, $seperator );
							}
							?>
						</div>
					</div>
				</div> <!-- #kata-breadcrumbs -->
			<?php
			}
		}

		/**
		 * GDPR.
		 *
		 * @since   1.0.0
		 */
		public function gdpr() {
			$gdpr_box          = get_theme_mod('kata_gdpr_box', '0');
			$gdpr_agree_text   = get_theme_mod('kata_gdpr_agree_text', __('I Agree', 'kata-plus'));
			$gdpr_privacy_text = get_theme_mod('kata_gdpr_pp_text', __('Privacy Preference', 'kata-plus'));
			$gdpr_privacy_link = get_theme_mod('kata_gdpr_pp_link', '#');
			$gdprContent       = get_theme_mod('kata_gdpr_content', __('We use cookies from third party services to offer you a better experience. Read about how we use cookies and how you can control them by clicking Privacy Preferences.', 'kata-plus'));

			if ($gdpr_box == '1' && !isset($_COOKIE['KataCookieGDPR'])) :
				wp_enqueue_style('kata-gdpr-style', Kata_Plus::$assets . 'css/frontend/gdpr.css');
			?>
				<div class="kata-gdpr-box">
					<div class="gdpr-content-box-wrap">
						<div class="gdpr-content-wrap">
							<p><?php echo esc_attr($gdprContent); ?></p>
						</div>
						<div class="gdpr-buttons">
							<?php if (!empty($gdpr_privacy_text)) : ?>
								<div class="gdpr-button-privacy">
									<a href="<?php echo esc_html($gdpr_privacy_link); ?>" target="_blank">
										<span><?php echo esc_html($gdpr_privacy_text); ?></span>
									</a>
								</div>
							<?php endif; ?>
							<div class="gdpr-button-agree"><button class="dbg-color"><?php echo esc_html($gdpr_agree_text); ?></button></div>
						</div>
					</div>
				</div>
			<?php
			endif;
		}

		/**
		 * Admin Custom Css
		 *
		 * @since   1.0.0
		 */
		public function admin_custom_css() {
			$styles = get_theme_mod('kata_theme_admin_custom_css', '');
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}
			$uploaddir = wp_get_upload_dir();
			$wp_filesystem->put_contents(
				$uploaddir['basedir'] . '/kata/css/admin-custom.css',
				Kata_Plus_Pro_Helpers::cssminifier($styles),
				FS_CHMOD_FILE
			);
		}

		/**
		 * White Label
		 *
		 * @since   1.0.0
		 */
		public function white_label() {
			// Get Options
			$white_label_name           = get_theme_mod( 'kata_theme_white_label_name', '0' );
			$white_label_version        = get_theme_mod( 'kata_theme_version', '0' );
			$white_label_theme_logo     = get_theme_mod( 'kata_theme_admin_logo', '0' );
			$white_label_control_panel  = get_theme_mod( 'kata_theme_control_panel_fields', [] );
			$white_label_dashboard_menu = get_theme_mod( 'kata_theme_remove_submenu_fields', '0' );
			// Proccess to set object
			$white_label_img   = (object) $white_label_theme_logo;
			$manage_menu       = (object) $white_label_control_panel;
			$dashboard_submenu = (object) $white_label_dashboard_menu;
			// Get Fields For Image URL
			$white_label_theme_img = $white_label_theme_logo ? $white_label_img->url : '';
			$activation            = $demo_importer = $plugin_manager = $font_manager = $customizer = $page_options = $template_library = $fast_mode = $add_new = $finder = $help_menu = '';
			// Get Fields For Control Panel
			if ($manage_menu) {
				foreach ($manage_menu as $menu) {
					switch ($menu) {
						case 'activation':
							$activation = '1';
							break;
						case 'demo_importer':
							$demo_importer = '1';
							break;
						case 'plugin_manager':
							$plugin_manager = '1';
							break;
						case 'font_manager':
							$font_manager = '1';
							break;
						case 'customizer':
							$customizer = '1';
							break;
						case 'page_options':
							$page_options = '1';
							break;
						case 'template_library':
							$template_library = '1';
							break;
						case 'add_new':
							$add_new = '1';
							break;
						case 'fast_mode':
							$fast_mode = '1';
							break;
						case 'finder':
							$finder = '1';
							break;
						case 'help_menu':
							$help_menu = '1';
							break;
					}
				}
			}
			// Get Fields For Dashboard Menu
			$demo_importers = $plugins = $header = $heaeder_sticky = $footer = $blog = $single = $portfolio = $fast_mode = $archive = $author = $search = $error_404 = $mega_menu = $help = '';
			if ($dashboard_submenu) {
				foreach ($dashboard_submenu as $submenu) {
					switch ($submenu) {
						case 'demo_importers':
							$demo_importers = '1';
							break;
						case 'plugins':
							$plugins = '1';
							break;
						case 'header':
							$header = '1';
							break;
						case 'heaeder_sticky':
							$heaeder_sticky = '1';
							break;
						case 'footer':
							$footer = '1';
							break;
						case 'blog':
							$blog = '1';
							break;
						case 'single':
							$single = '1';
							break;
						case 'portfolio':
							$portfolio = '1';
							break;
						case 'fast_mode':
							$fast_mode = '1';
							break;
						case 'archive':
							$archive = '1';
							break;
						case 'author':
							$author = '1';
							break;
						case 'search':
							$search = '1';
							break;
						case 'error_404':
							$error_404 = '1';
							break;
						case 'mega_menu':
							$mega_menu = '1';
							break;
						case 'help':
							$help = '1';
							break;
					}
				}
			}
			// Return Fields
			return (object) [
				'name'             => $white_label_name,
				'version'          => $white_label_version,
				'url'              => $white_label_theme_img,
				'activation'       => $activation,
				'demo_importer'    => $demo_importer,
				'plugin_manager'   => $plugin_manager,
				'font_manager'     => $font_manager,
				'customizer'       => $customizer,
				'page_options'     => $page_options,
				'template_library' => $template_library,
				'add_new'          => $add_new,
				'finder'           => $finder,
				'help_menu'        => $help_menu,
				'demo_importers'   => $demo_importers,
				'plugins'          => $plugins,
				'header'           => $header,
				'heaeder_sticky'   => $heaeder_sticky,
				'footer'           => $footer,
				'blog'             => $blog,
				'single'           => $single,
				'portfolio'		   => $portfolio,
				'fast_mode'		   => $fast_mode,
				'archive'          => $archive,
				'author'           => $author,
				'search'           => $search,
				'error_404'        => $error_404,
				'mega_menu'        => $mega_menu,
				'help'             => $help,
			];
		}

		/**
		 * White Label Admin Logo
		 *
		 * @since   1.0.0
		 */
		function white_label_admin_logo() {
			$white_label_wp_admin      = get_theme_mod('kata_admin_login_logo', '0');
			$white_label_wp_admin_logo = (object) $white_label_wp_admin;
			$url                       = $white_label_wp_admin ? $white_label_wp_admin_logo->url : '';
			if ($url) {
				echo '<style type="text/css">
					#login h1 a,
					.login h1 a {
						background-image: url(' . $url . ');
						background-size: contain;
						background-repeat: no-repeat;
						padding-bottom: 7px;
					}
				</style> ';
			}
		}

		/**
		 * Custom Post Type Manager
		 *
		 * @since   1.0.0
		 */
		public function post_type_manager() {
			$white_label_cpt      = get_theme_mod('kata_theme_cpt_fields', '0');
			$white_label_cpt_show = (object) $white_label_cpt;
			// Get Fielde For Custom Post Types
			$grid = $testimonial = $recipe = $team_member = '';
			if ($white_label_cpt_show) {
				foreach ($white_label_cpt_show as $cpt_show) {
					switch ($cpt_show) {
						case 'grid':
							$grid = '1';
							break;
						case 'testimonial':
							$testimonial = '1';
							break;
						case 'recipe':
							$recipe = '1';
							break;
						case 'team_member':
							$team_member = '1';
							break;
					}
				}
			}
			if ($grid == 1) :
				unregister_post_type('kata_grid');
			endif;
			if ($testimonial == 1) :
				unregister_post_type('kata_testimonial');
			endif;
			if ($recipe == 1) :
				unregister_post_type('kata_recipe');
			endif;
			if ($team_member == 1) :
				unregister_post_type('kata_team_member');
			endif;
		}

		/**
		 * Smooth Scroll.
		 *
		 * @since   1.0.0
		 */
		public function option_smooth_scroll() {
			if (get_theme_mod('kata_smooth_scroll', false)) {
				$settings        = [
					'plugin_sent'       => '1',
					'timestamp'         => hexdec(uniqid()),
					'frameRate'         => 2000,
					'animationTime'     => 1000,
					'stepSize'          => 100,
					'pulseAlgorithm'    => 1,
					'pulseScale'        => 4,
					'pulseNormalize'    => 1,
					'accelerationDelta' => 50,
					'accelerationMax'   => 3,
					'keyboardSupport'   => 1,
					'arrowScroll'       => 50,
					'fixedBackground'   => 1,
					'allowedBrowsers'   => [
						'IEWin7',
						'Chrome',
						'Safari',
					],
				];
				$allowedBrowsers = sprintf(
					'var allowedBrowsers=["%s"];',
					implode('","', $settings['allowedBrowsers'])
				);
				file_put_contents(Kata_Plus::$assets_dir . 'js/libraries/wpmssab.min.js', $allowedBrowsers);

				$content = sprintf(
					'SmoothScroll({' .
						'frameRate:%d,' .
						'animationTime:%d,' .
						'stepSize:%d,' .
						'pulseAlgorithm:%d,' .
						'pulseScale:%d,' .
						'pulseNormalize:%d,' .
						'accelerationDelta:%d,' .
						'accelerationMax:%d,' .
						'keyboardSupport:%d,' .
						'arrowScroll:%d,' .
						'fixedBackground:%d' .
						'})',
					intval($settings['frameRate']),
					intval($settings['animationTime']),
					intval($settings['stepSize']),
					intval($settings['pulseAlgorithm']),
					intval($settings['pulseScale']),
					intval($settings['pulseNormalize']),
					intval($settings['accelerationDelta']),
					intval($settings['accelerationMax']),
					intval($settings['keyboardSupport']),
					intval($settings['arrowScroll']),
					intval($settings['fixedBackground'])
				);
				file_put_contents(Kata_Plus::$assets_dir . 'js/libraries/wpmss.min.js', $content);

				wp_enqueue_script('kata-plus-wpmssab', Kata_Plus::$assets . 'js/libraries/wpmssab.js', ['jquery'], $settings['timestamp'] + 1410, 1);
				wp_enqueue_script('kata-plus-SmoothScroll', Kata_Plus::$assets . 'js/libraries/SmoothScroll.js', ['kata-plus-wpmssab'], '1.4.10', 1);
				wp_enqueue_script('kata-plus-wpmss', Kata_Plus::$assets . 'js/libraries/wpmss.js', ['kata-plus-SmoothScroll'], $settings['timestamp'] + 1410, 1);
			}
		}

		/**
		 * Critical CSS.
		 *
		 * @since   1.0.0
		 */
		public function critical_css() {
			echo '<style id="kata-plus-critical-css">' . Kata_Plus_Pro_Helpers::cssminifier( get_theme_mod( 'kata_plus_pro_critical_css' ) ) . '</style>';
		}

		/**
		 * Enqueue Preloader.
		 *
		 * @since    1.0.0
		 */
		public function kata_preloader_template() {
			$preload_src = '';
			if ( get_theme_mod( 'kata_enable_preloader' ) ) {
				if( 'ball-chasing' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-ball-chasing">
							<div class="kata-loader">
								<div class="kata-ball-1"></div>
								<div class="kata-ball-2"></div>
							</div>
						</div>';
				}
				if( 'ball-pulse' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-ball-pulse">
							<div class="kata-loader">
								<div class="kata-ball"></div>
							</div>
						</div>';
				}
				if( 'ball-pulse-double' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-ball-pulse-double">
							<div class="kata-loader">
								<div class="kata-ball-1"></div>
								<div class="kata-ball-2"></div>
							</div>
						</div>';
				}
				if( 'wave' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-wave">
							<div class="kata-loader">
								<div class="kata-line-1"></div>
								<div class="kata-line-2"></div>
								<div class="kata-line-3"></div>
								<div class="kata-line-4"></div>
								<div class="kata-line-5"></div>
							</div>
						</div>';
				}
				if( 'wave-spread' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-wave-spread">
							<div class="kata-loader">
								<div class="kata-line-1"></div>
								<div class="kata-line-2"></div>
								<div class="kata-line-3"></div>
								<div class="kata-line-4"></div>
								<div class="kata-line-5"></div>
							</div>
						</div>';
				}
				if( 'circle-pulse' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-circle-pulse">
							<div class="kata-loader">
								<div class="kata-circle"></div>
							</div>
						</div>';
				}
				if( 'circle-pulse-multiple' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-circle-pulse-multiple">
							<div class="kata-loader">
								<div class="kata-circle-1"></div>
								<div class="kata-circle-2"></div>
								<div class="kata-circle-3"></div>
							</div>
						</div>';
				}
				if( 'arc-rotate-double' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-arc-rotate-double">
							<div class="kata-loader">
								<div class="kata-arc-1"></div>
								<div class="kata-arc-2"></div>
							</div>
						</div>';
				}
				if( 'square-split' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-square-split">
							<div class="kata-loader">
								<div class="kata-square-1"></div>
								<div class="kata-square-2"></div>
								<div class="kata-square-3"></div>
								<div class="kata-square-4"></div>
							</div>
						</div>';
				}
				if( 'arc-rotate' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-arc-rotate">
							<div class="kata-loader">
								<div class="kata-arc"></div>
							</div>
						</div>';
				}
				if( 'arc-rotate2' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-arc-rotate2">
							<div class="kata-loader">
								<div class="kata-arc"></div>
							</div>
						</div>';
				}
				if( 'arc-scale' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-arc-scale">
							<div class="kata-loader">
								<div class="kata-arc"></div>
							</div>
						</div>';
				}
				if( 'clock' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-clock">
							<div class="kata-loader">
								<div class="kata-arc"></div>
							</div>
						</div>';
				}
				if( 'square-rotate-3d' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-square-rotate-3d">
							<div class="kata-loader">
								<div class="kata-square"></div>
							</div>
						</div>';
				}
				if( 'spinner' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '<div class="kata-loader-wrapper kata-spinner"></div>';
				}
				if( 'whirlpool' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-whirlpool">
							<div class="kata-ring kata-ring1"></div>
							<div class="kata-ring kata-ring2"></div>
							<div class="kata-ring kata-ring3"></div>
							<div class="kata-ring kata-ring4"></div>
							<div class="kata-ring kata-ring5"></div>
							<div class="kata-ring kata-ring6"></div>
							<div class="kata-ring kata-ring7"></div>
							<div class="kata-ring kata-ring8"></div>
							<div class="kata-ring kata-ring9"></div>
						</div>';
				}
				if( 'drawing' == get_theme_mod( 'kata_preloader_type', 'ball-chasing' ) ) {
					$preload_src = '
						<div class="kata-loader-wrapper kata-drawing">
							<div class="kata-loading-dot"></div>
						</div>';
				}
				echo '
					<div class="kata-preloader-screen dbg-color">
						' . $preload_src . '
					</div>';
			}
		}

		/**
		 * Enqueue Preloader.
		 *
		 * @since    1.0.0
		 */
		public function kata_preloader() {
			if ( ! get_theme_mod( 'kata_preloader_preview', false ) ) {
				wp_enqueue_script( 'kata-preloader', Kata_Plus::$assets . '/js/libraries/preloader.js', [], false, true );
			}
			wp_enqueue_style( 'kata-loader', Kata_Plus::$assets . '/css/libraries/loader.css' );
			wp_enqueue_style( 'kata-preloader', Kata_Plus::$assets . '/css/libraries/preloader.css' );
		}


		/**
		 * Back to top icon
		 *
		 * @since    1.0.0
		 */
		public function option_back_to_top_icon() {
			$back_to_top_btn_icon      = get_theme_mod('kata_back_to_top_btn_icon');
			$enable_back_to_top        = get_theme_mod('kata_backto_top_btn', '1');
			$enable_back_to_top_mobile = get_theme_mod('kata_back_to_top_btn_on_mobile', '0') == '0' ? 'disable-in-mobile' : 'enable-in-mobile';
			$back_to_top_icon          = get_theme_mod('kata_back_to_top_btn_custom_icon');
			$back_to_top_icon          = $back_to_top_icon && $back_to_top_btn_icon == '1' ? '<i class="fa ' . $back_to_top_icon . '"></i>' : Kata_Plus_Pro_Helpers::get_icon('themify', 'arrow-up');
			if ($enable_back_to_top == '1') {
				?>
				<span id="scroll-top" class="<?php echo esc_attr($enable_back_to_top_mobile); ?>"><a class="scrollup"><?php echo $back_to_top_icon; ?></a></span>
				<?php
				$css = '@media(max-width:420px) { .disable-in-mobile { display: none; } }';
			}
		}

		/**
		 * Scroll Bar
		 *
		 * @since    1.0.0
		 */
		public function option_nicescroll() {
			if ( get_theme_mod( 'kata_custom_scrollbar', '0') == '1' ) {
				echo '
				<script>
					jQuery("body").niceScroll();
					var bheight = jQuery("body").height();
					jQuery(document).ready(function(){
						jQuery(window).scroll(function(){
							var live_size = jQuery("body").height();
							if(bheight < live_size || bheight > live_size){
								bheight = live_size;
								jQuery("body").getNiceScroll().resize();
							}
						});
					});
				</script>';
			}
		}

		/**
		 * Backup Customizer.
		 *
		 * @since   1.0.0
		 */
		public function backup_customizer() {
			if ( strlen(json_encode(get_option( 'theme_mods_kata' ))) < 86 ) {
				return;
			}
			if ( ! get_option( 'customizer_backup' ) ) {
				add_option( 'customizer_backup', get_option( 'theme_mods_kata' ) );
				add_option( 'customizer_backup_date', date( 'Ymd' ) );
			}
			if ( get_option( 'customizer_backup_date' ) <= date( 'Ymd' ) && '-' !== get_option( 'theme_mods_kata' ) ) {
				update_option( 'customizer_backup', get_option( 'theme_mods_kata' ) );
				update_option( 'customizer_backup_date', date( 'Ymd' ) );
			}
		}

		/**
		 * Restore Backup Customizer.
		 *
		 * @since   1.0.0
		 */
		public function restore_backup_customizer() {
			if ( get_option( 'customizer_backup' ) && get_option( 'customizer_backup_date' ) ) {
				if ( '-' == get_option( 'theme_mods_kata' ) ) {
					$user			= wp_get_current_user();
					$allowed_roles	= ['editor', 'administrator', 'author'];
					if ( array_intersect( $allowed_roles, $user->roles ) ) {
						echo '<div class="kata-plus-customizer-problem" style="background:#ffb0b0;padding:10px 10px 7px;"><h3 style="line-height:1.2;font-size:21px;font-weight:normal;color:#ad0000;">' . __( 'There is a problem with customizer (theme options) data\'s please refresh the page to resolve the problem', 'kata-plus' ) . '</h3></div>';
					}
					update_option( 'theme_mods_kata', get_option( 'customizer_backup' ) );
				}
			}
		}

	} // Class

	Kata_Plus_Pro_Theme_Options_Functions::get_instance();
}
