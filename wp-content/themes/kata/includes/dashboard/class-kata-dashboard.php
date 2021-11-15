<?php
/**
 * Kata Dashboard Page
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Dashboard' ) ) {
	/**
	 * Kata.
	 *
	 * @author     Climaxthemes
	 * @package     Kata
	 * @since     1.0.0
	 */
	class Kata_Dashboard {

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
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $version;

		/**
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $menu_name;

		/**
		 * The theme page appearance.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $theme_page;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Dashboard
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
			$this->dependencies();
			$this->actions();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir     			= Kata::$dir . 'includes/dashboard/';
			self::$url     			= Kata::$url;
			self::$version     		= Kata::$version;
			self::$assets  			= Kata::$url . 'assets/';
			self::$menu_name		= wp_get_theme()->Name;
			self::$theme_page		= 'appearance_page_kata-dashboard';
			if ( ! get_theme_mod( 'install-kata-plus' ) ) set_theme_mod( 'install-kata-plus', 'true' );
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
        public function dependencies() {}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'admin_menu', array( $this, 'kata_dashboard' ) );
			add_action( 'current_screen', array( $this, 'current_screen' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'admin_notices', array( $this, 'kata_plus_install_notice' ) );
			add_action( 'wp_ajax_install_required_plugins', [$this, 'install_required_plugins'] );
        }

		/**
		 * Add Kata theme page (dashboard).
		 *
		 * @since   1.0.0
		 */
        public function kata_plus_install_notice() {
			if ( class_exists( 'Kata_Plus' ) && class_exists( 'Elementor\Plugin' ) ) {
				return false;
			}
			if ( isset( $_GET['hide_kata_plus'] ) ) {
				set_theme_mod( 'install-kata-plus', sanitize_text_field( wp_unslash( $_GET['hide_kata_plus'] ) ) );
				return false;
			}
			if ( 'false' == get_theme_mod( 'install-kata-plus' ) ) {
				return false;
			}
			$url = admin_url( 'themes.php?page=tgmpa-install-plugins' );
			$plugins = TGM_Plugin_Activation::$instance->plugins;
			$tgmpa_list_table = new TGMPA_List_Table();
			?>
			<style>
				.kata-notice.notice.is-dismissible {
					padding-left: 270px;
					background-image: url(<?php echo esc_url( self::$assets . 'img/dashboard-notice.png' ); ?>);
					background-repeat: no-repeat;
					background-position: 2px 2px;
					background-size: 252px;
					border-left-color: #908efc;
					min-height: 170px;
					padding-right: 10px;
				}

				.kata-notice.notice.is-dismissible h2 {
					margin-bottom: 8px;
					margin-top: 21px;
					font-size: 17px;
					font-weight: 700;
				}

				.kata-notice.notice.is-dismissible a:not(.notice-dismiss) {
					border-radius: 3px;
					border-color: #6d6af8;
					color: #fff;
					text-shadow: unset;
					background: #6d6af8;
					font-weight: 400;
					font-size: 14px;
					line-height: 18px;
					text-decoration: none;
					text-transform: capitalize;
					padding: 12px 20px;
					display: inline-block;
					margin: 7px 0 13px;
					box-shadow: 0 1px 2px rgba(0,0,0,0.1);
					letter-spacing: 0.4px;
				}

				.kata-notice.notice.is-dismissible a:not(.notice-dismiss):hover {
					border-color: #17202e;
					background: #17202e;
				}

				.kt-dashboard-row .kata-notice.notice.is-dismissible {
					display: block;
					margin: 0 0 25px;
					border-left: 4px solid #6d6af8;
					border-radius: 2px;
					overflow: hidden;
					box-shadow: 0 2px 7px -1px rgba(0,0,0,0.04);
				}

				.kt-dashboard-row .kata-notice.notice.is-dismissible .notice-dismiss {
					display: none;
				}

				.kt-dashboard-row .kata-notice.notice.is-dismissible h2 {
					letter-spacing: -0.3px;
				}
				.kata-install-required i {
					margin-right: 5px;
					-webkit-animation: spin 4s linear infinite;
					-moz-animation: spin 4s linear infinite;
					animation: spin 4s linear infinite;
				}

				@-moz-keyframes spin {
					100% {
						-moz-transform: rotate(360deg);
					}
				}

				@-webkit-keyframes spin {
					100% {
						-webkit-transform: rotate(360deg);
					}
				}

				@keyframes spin {
					100% {
						-webkit-transform: rotate(360deg);
						transform: rotate(360deg);
					}
				}
			</style>
			<div class="kata-notice kt-dashboard-box notice notice-success is-dismissible">
				<h2><?php echo esc_html__( 'Enable all Features of Kata theme', 'kata' ); ?></h2>
				<p><?php echo esc_html__( 'In order to take full advantage of Kata theme and enabling its demo importer, please install the required plugins.', 'kata' ); ?></p>
				<p><a href="<?php echo esc_url( $url ); ?>" class="kata-install-required">
					<i class="dashicons dashicons-update" style="display: none;"></i>
					<span><?php echo esc_html__( 'Install plugins', 'kata' ) ?></span>
				</a></p>
				<a class="notice-dismiss" style="z-index: 9;" href="?hide_kata_plus=false"></a>
			</div>
			<?php
			if ( isset( $_GET['hide_kata_plus'] ) ) {
				set_theme_mod( 'install-kata-plus', sanitize_text_field( wp_unslash( $_GET['hide_kata_plus'] ) ) );
			}
		}

		/**
		 * Processes bulk installation and activation actions.
		 *
		 * The bulk installation process looks for the $_POST information and passes that
		 * through if a user has to use WP_Filesystem to enter their credentials.
		 *
		 * @since 2.2.0
		 */
		public function install_required_plugins() {
			$tgmpa_list_table = new TGMPA_List_Table();

			// Bulk installation process.
			if ( 'tgmpa-bulk-install' === $_GET['tgmaction'] || 'tgmpa-bulk-update' === $_GET['tgmaction'] ) {

				// check_admin_referer( 'bulk-' . $tgmpa_list_table->_args['plural'] );


				$install_type = 'install';
				if ( 'tgmpa-bulk-update' === $_GET['tgmaction'] ) {
					$install_type = 'update';
				}

				$plugins_to_install = array();

				$_POST['plugin'] = $_GET['toinstall'];
				// Did user actually select any plugins to install/update ?
				if ( empty( $_POST['plugin'] ) ) {
					if ( 'install' === $install_type ) {
						$message = __( 'No plugins were selected to be installed. No action taken.', 'kata' );
					} else {
						$message = __( 'No plugins were selected to be updated. No action taken.', 'kata' );
					}

					echo '<div id="message" class="error"><p>', esc_html( $message ), '</p></div>';

					wp_die();
				}

				if ( is_array( $_POST['plugin'] ) ) {
					$plugins_to_install = (array) $_POST['plugin'];
				} elseif ( is_string( $_POST['plugin'] ) ) {
					// Received via Filesystem page - un-flatten array (WP bug #19643).
					$plugins_to_install = explode( ',', $_POST['plugin'] );
				}

				// Sanitize the received input.
				$plugins_to_install = array_map( 'urldecode', $plugins_to_install );

				// No need to proceed further if we have no plugins to handle.
				if ( empty( $plugins_to_install ) ) {
					if ( 'install' === $install_type ) {
						$message = __( 'No plugins are available to be installed at this time.', 'kata' );
					} else {
						$message = __( 'No plugins are available to be updated at this time.', 'kata' );
					}

					echo '<div id="message" class="error"><p>', esc_html( $message ), '</p></div>';

					wp_die();
				}

				// Pass all necessary information if WP_Filesystem is needed.
				$url = wp_nonce_url(
					$tgmpa_list_table->tgmpa->get_tgmpa_url(),
					'bulk-' . $tgmpa_list_table->_args['plural']
				);

				// Give validated data back to $_POST which is the only place the filesystem looks for extra fields.
				$_POST['plugin'] = implode( ',', $plugins_to_install ); // Work around for WP bug #19643.

				$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
				$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

				if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
					wp_die(); // Stop the normal page form from displaying, credential request form will be shown.
				}

				// Now we have some credentials, setup WP_Filesystem.
				if ( ! WP_Filesystem( $creds ) ) {
					// Our credentials were no good, ask the user for them again.
					request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

					wp_die();
				}

				/* If we arrive here, we have the filesystem */

				// Store all information in arrays since we are processing a bulk installation.
				$names      = array();
				$sources    = array(); // Needed for installs.
				$file_paths = array(); // Needed for upgrades.
				$to_inject  = array(); // Information to inject into the update_plugins transient.

				// Prepare the data for validated plugins for the install/upgrade.
				$tgmpa_list_table->tgmpa->plugins = [
					'elementor' => [
						'name'                  => 'Elementor',
						'slug'                  => 'elementor',
						'source'                => 'repo',
						'required'              => true,
						'version'               => '3.2.2',
						'force_activation'      => false,
						'force_deactivation'    => false,
						'external_url'          => '',
						'is_callable'           => '',
						'file_path'             => 'elementor',
						'source_type'           => 'repo',
					],
					'kata-plus' => [
						'name'                  => 'Kata Plus',
						'slug'                  => 'kata-plus',
						'source'                => 'repo',
						'required'              => false,
						'version'               => '1.0.6',
						'force_activation'      => false,
						'force_deactivation'    => false,
						'external_url'          => '',
						'is_callable'           => '',
						'file_path'             => 'kata-plus/kata-plus.php',
						'source_type'           => 'repo',
					],
					'kata-plus-pro' => [
						'name'                  => 'Kata Plus Pro',
						'slug'                  => 'kata-plus-pro',
						'source'                => 'https://climaxthemes.com/kata/requirements/pp/kata-plus-pro.zip',
						'required'              => true,
						'version'               => '1.0.6',
						'force_activation'      => false,
						'force_deactivation'    => false,
						'external_url'          => '',
						'is_callable'           => '',
						'file_path'             => 'kata-plus-pro/kata-plus-pro.php',
						'source_type'           => 'external',
					]
				];
				foreach ( $plugins_to_install as $slug ) {
					$name   = $tgmpa_list_table->tgmpa->plugins[ $slug ]['name'];
					$source = $tgmpa_list_table->tgmpa->get_download_url( $slug );
					if ( ! empty( $name ) && ! empty( $source ) ) {
						$names[] = $name;

						switch ( $install_type ) {

							case 'install':
								$sources[] = $source;
								break;

							case 'update':
								$file_paths[]                 = $tgmpa_list_table->tgmpa->plugins[ $slug ]['file_path'];
								$to_inject[ $slug ]           = $tgmpa_list_table->tgmpa->plugins[ $slug ];
								$to_inject[ $slug ]['source'] = $source;
								break;
						}
					}
				}
				unset( $slug, $name, $source );

				// Create a new instance of TGMPA_Bulk_Installer.
				$installer = new TGMPA_Bulk_Installer(
					new TGMPA_Bulk_Installer_Skin(
						array(
							'url'          => esc_url_raw( $tgmpa_list_table->tgmpa->get_tgmpa_url() ),
							'nonce'        => 'bulk-' . $tgmpa_list_table->_args['plural'],
							'names'        => $names,
							'install_type' => $install_type,
						)
					)
				);

				// Wrap the install process with the appropriate HTML.
				echo '<div class="tgmpa">',
					'<h2 style="font-size: 23px; font-weight: 400; line-height: 29px; margin: 0; padding: 9px 15px 4px 0;">', esc_html( get_admin_page_title() ), '</h2>
					<div class="update-php" style="width: 100%; height: 98%; min-height: 850px; padding-top: 1px;">';

				// Process the bulk installation submissions.
				add_filter( 'upgrader_source_selection', array( $tgmpa_list_table->tgmpa, 'maybe_adjust_source_dir' ), 1, 3 );

				if ( 'tgmpa-bulk-update' === $_GET['tgmaction'] ) {
					// Inject our info into the update transient.
					$tgmpa_list_table->tgmpa->inject_update_info( $to_inject );

					$installer->bulk_upgrade( $file_paths );
				} else {
					$installer->bulk_install( $sources );
				}

				// remove_filter( 'upgrader_source_selection', array( $tgmpa_list_table->tgmpa, 'maybe_adjust_source_dir' ), 1 );

				echo '</div></div>';
				$_GET['tgmaction'] = 'tgmpa-bulk-activate';
			}

			// Bulk activation process.
			if ( 'tgmpa-bulk-activate' === $_GET['tgmaction'] ) {
				// Did user actually select any plugins to activate ?
				$_POST['plugin'] = $_GET['toinstall'];
				if ( empty( $_POST['plugin'] ) ) {
					echo '<div id="message" class="error"><p>', esc_html__( 'No plugins were selected to be activated. No action taken.', 'kata' ), '</p></div>';
					wp_die();
				}

				// Grab plugin data from $_POST.
				$plugins_to_activate = [
					'elementor/elementor.php',
					'kata-plus-pro/kata-plus-pro.php',
					'kata-plus/kata-plus.php'
				];

				// Return early if there are no plugins to activate.
				if ( empty( $plugins_to_activate ) ) {
					echo '<div id="message" class="error"><p>', esc_html__( 'No plugins are available to be activated at this time.', 'kata' ), '</p></div>';

					wp_die();
				}

				// Now we are good to go - let's start activating plugins.
				$activate = activate_plugins( $plugins_to_activate );

				if ( is_wp_error( $activate ) ) {
					echo '<div id="message" class="error"><p>', $activate->get_error_message(), '</p></div>';
				} else {
					$count        = count( $plugin_names ); // Count so we can use _n function.
					$plugin_names = array_map( array( 'TGMPA_Utils', 'wrap_in_strong' ), $plugin_names );
					$last_plugin  = array_pop( $plugin_names ); // Pop off last name to prep for readability.
					$imploded     = empty( $plugin_names ) ? $last_plugin : ( implode( ', ', $plugin_names ) . ' ' . esc_html_x( 'and', 'plugin A *and* plugin B', 'kata' ) . ' ' . $last_plugin );

					// phpcs:ignore WordPress.Security.EscapeOutput.DeprecatedWhitelistCommentFound
					printf( // WPCS: xss ok.
						'<div id="message" class="updated"><p>%1$s %2$s.</p></div>',
						esc_html( _n( 'The following plugin was activated successfully:', 'The following plugins were activated successfully:', $count, 'kata' ) ),
						$imploded
					);

					// Update recently activated plugins option.
					$recent = (array) get_option( 'recently_activated' );
					foreach ( $plugins_to_activate as $plugin => $time ) {
						if ( isset( $recent[ $plugin ] ) ) {
							unset( $recent[ $plugin ] );
						}
					}
					update_option( 'recently_activated', $recent );
				}

				unset( $_POST ); // Reset the $_POST variable in case user wants to perform one action after another.

				wp_die();
			}

			wp_die();
		}

		/**
		 * Add Kata theme page (dashboard).
		 *
		 * @since   1.0.0
		 */
        public function kata_dashboard() {
            add_theme_page(
				self::$menu_name . ' Theme',
				self::$menu_name . ' Theme',
                'edit_theme_options',
                'kata-dashboard',
               array( $this, 'output' )
            );
        }

		/**
		 * Add Kata theme page styles.
		 *
		 * @since   1.0.0
		 */
        public function enqueue_styles() {
			if ( self::$theme_page === self::current_screen() ) {
				wp_enqueue_style( 'kata-dashboard', self::$assets . 'css/dashboard.css', array(), self::$version );
				if ( is_super_admin() ) {
					remove_all_actions('admin_notices');
				}
			}
        }

		/**
		 * Current Screen
		 *
		 * @since   1.0.0
		 */
		public static function current_screen() {
			return get_current_screen()->base;
		}


		/**
		 * Theme page output.
		 *
		 * @since   1.0.0
		 */
        public function output() {
            if ( self::$theme_page === self::current_screen() ) {
				require self::$dir . 'parts/dashboard.header.tpl.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
				require self::$dir . 'parts/dashboard.main.content.tpl.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			}
		}



	} // class

	Kata_Dashboard::get_instance();

}
