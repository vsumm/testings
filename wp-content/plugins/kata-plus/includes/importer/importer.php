<?php

/**
 * Importer Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Utils;
use Elementor\Plugin;

if (!class_exists('Kata_Plus_Importer')) {
	class Kata_Plus_Importer
	{
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
		 * The url of Kata API.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $api_url;

		/**
		 * Demo data.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $demos_data;

		/**
		 * The directory of demo folder.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $demos_data_dir;

		/**
		 * The url protocol.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $protocol;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Importer
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
		 * @since   1.0.0
		 */
		public function __construct()
		{
			$this->definitions();
			$this->actions();
			$this->dependencies();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions()
		{
			self::$dir            	= Kata_Plus::$dir . 'includes/importer/';
			self::$url            	= Kata_Plus::$url . 'includes/importer/';
			self::$demos_data_dir 	= Kata_Plus::$upload_dir . '/importer/';
			self::$protocol			= Kata_Plus_Helpers::ssl_url();
			self::$api_url        	= self::$protocol . 'katablogapi.climaxthemes.com/Demo';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions()
		{
			if (isset($_GET['page']) && $_GET['page'] == 'kata-plus-demo-importer') {
				add_action('admin_enqueue_scripts', [$this, 'enqueue_styles']);
				add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
				add_action('kata_plus_before_start_importer', [$this, 'build_importer_dir']);
			}
			add_action('wp_ajax_ImporterBuildSteps', [$this, 'BuildSteps']);
			add_action('wp_ajax_reset_site', [$this, 'reset_site']);
			add_action('wp_ajax_BuildImporter', [$this, 'BuildImporter']);
			add_action('wp_ajax_Importer', [$this, 'Importer']);
			add_action('wp_ajax_ImportDone', [$this, 'ImportDone']);
			add_filter('pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false');
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies()
		{
			Kata_Plus_Autoloader::load(self::$dir . 'core/includes', 'API');
		}

		/**
		 * Build Importer Directory.
		 *
		 * @since   1.0.0
		 */
		public function build_importer_dir()
		{
			if (!wp_mkdir_p(self::$demos_data_dir)) {
				wp_mkdir_p(self::$demos_data_dir);
			}
		}

		/**
		 * Get Demo Data From API.
		 *
		 * @since   1.0.0
		 */
		public static function get_demo_data($action, $key = false, $method = false)
		{

			$data = '{}';
			switch ($action) {
				case 'List':
					$data = json_decode(wp_remote_request(static::$api_url . '/' . $action . '/')['body']);
					$data = isset($data->list) ? $data->list : $data;
					break;
				case 'Contents':
					$data = json_decode(wp_remote_request(static::$api_url . '/' . $action . '/' . $key)['body']);
					break;
				case 'Information':
					$data = json_decode(wp_remote_request(static::$api_url . '/' . $action . '/' . $key)['body']);
					break;
				case 'Plugins':
					$data = json_decode(wp_remote_request(static::$api_url . '/' . $action . '/' . $key)['body']);
					break;
				case 'Content':
					$data = json_decode(wp_remote_request(static::$api_url . '/' . $action . '/' . $key . '/' . $method)['body']);
					break;
				case 'Images':
					$data = json_decode(wp_remote_request(static::$api_url . '/' . $action . '/' . $key)['body']);
					break;
			}

			return $data;
		}

		/**
		 * Demos List.
		 *
		 * @since   1.0.0
		 */
		public function demos()
		{
			return Kata_Plus_API::get_instance()->demo('List');
		}

		/**
		 * GoPro.
		 *
		 * @since   1.0.0
		 */
		public function GoPro( $demo_name, $screenshot, $is_pro ) {
			if ( $is_pro && ! class_exists( 'Kata_Plus_pro' ) ) {
				$this->access_denied_step( $demo_name, $screenshot, '<p style="margin-top: 0;">' . __( 'To import Pro & Fast demos you must buy the pro version', 'kata-plus' ) . '</p><div class="ktp-go-pro"><a href="' . esc_url( 'https://my.climaxthemes.com/buy/' ) . '" class="kata-btn"> ' . __( 'Buy Pro version', 'kata-plus' ) . '</a></div>' );
				return false;
			} elseif ( class_exists( 'Kata_Plus_Pro_license_Activation' ) && class_exists( 'Kata_Plus_pro' ) && $is_pro ) {
				$license = new Kata_Plus_Pro_license_Activation( Kata_Plus_Pro::$version, Kata_Plus_Pro::$slug );

				if ( 'Please fill all parameters.' == $license->getRemote_package() ) {
					$this->access_denied_step( $demo_name, $screenshot, '<p style="margin-top: 0;">' . __( 'Please enter your license activation key', 'kata-plus' ) . '</p><div class="ktp-go-pro"><a href="' . esc_url( admin_url( '?page=kata-plus-theme-activation' ) ) . '" target="_blank" class="kata-btn"> ' . __( 'Enter license', 'kata-plus' ) . '</a></div>' );
					return false;
				}
				return true;
			}
		}

		/**
		 * Header modal.
		 *
		 * @since   1.0.0
		 */
		public function HeaderModal($name) {
			?>
			<ul class="kata-import-wizard-header">
				<li class="kt-importer-step kt-last-step" data-step="2"> <a href="#"><span>3. </span><?php echo esc_html__('Import Progress', 'kata-plus'); ?></a> </li>
				<li class="kt-importer-step" data-step="1"> <a href="#"><span>2. </span><?php echo esc_html__('Select Content', 'kata-plus'); ?></a> </li>
				<li class="kt-importer-step kt-active-step" data-step="0"> <a href="#"> <span>1. </span><?php echo esc_html__('Install Plugins', 'kata-plus'); ?></a> </li>
			</ul>
			<h2 class="kata-import-demo-title"><?php echo esc_html($name); ?></h2>
			<?php
		}

		/**
		 * Body Modal.
		 *
		 * @since   1.0.0
		 */
		public function BuildSteps() {
			check_ajax_referer('kata_importer_nonce', 'nonce');

			// allow upload svg
			if ( is_multisite() ) {
                $FileToImport   = explode( ' ', get_site_option( 'upload_filetypes' ) );
                $size		= sizeof($FileToImport);
                if ( ! in_array( 'svg', $FileToImport ) ) {
                    $FileToImport[$size] = 'svg';
                    $FileToImport = implode( ' ', $FileToImport );
                    update_site_option( 'upload_filetypes', $FileToImport );
                }
			}

			$settings = $_POST;
			$key = $settings['key'];
			if ( ! isset( $key ) ) {
				return;
			}

			$key            = $key;
			$demo_name      = $settings['name'];
			$screenshot     = $settings['screenshot'];
			$demo_url     	= $settings['demo_url'];
			$authentication = Kata_Plus_API::get_instance()->authenticate($key);

			if (!$authentication || isset($authentication->message)) {
				$message = isset($authentication->message) ? __('Server Error:', 'kata-plus') . ' ' . $authentication->message : false;
				return $this->access_denied_step($demo_name, $screenshot, $message);
			}

			$demo_data = Kata_Plus_API::get_instance()->demo('Information', $key);

			$is_pro		= $demo_data->is_pro;
			$is_hidden	= $demo_data->is_hidden;
			$required_plugins_arr = [];
			if( $demo_data->data->plugins ) {
				foreach ($demo_data->data->plugins as $plugin) {
					$required_plugins_arr[] = $plugin->slug;
				}
				$plugins          = TGM_Plugin_Activation::$instance->plugins;
				$tgmpa_list_table = new TGMPA_List_Table();
				$required_plugins = [];
			}
			// $this->GoPro( $demo_name, $screenshot, $is_pro );
			?>

			<i class="ti-close"></i>
			<div class="kata-lightbox-contents">
				<div class="kata-lightbox">
					<?php self::HeaderModal($demo_data->data->name); ?>
					<input type="hidden" name="demo_url" class="demo_url" value="<?php echo esc_attr( $demo_url ); ?>">
					<div class="kata-lightbox-content kata-importer-settings">
						<?php $result = Kata_Plus_Notices::EvaluateServerResources(); ?>
						<?php if ( $result ) { ?>
							<div class="initial-notice">
								<h3><?php echo __( 'Warning', 'kata-plus' ); ?></h3>
								<p><?php echo __( 'Seems there are some minor issues, Your server configuration did not pass the Kata requirements.', 'kata-plus' ); ?> </p>
								<p><?php echo __( 'For getting best result in demo import process, Please improve your server configuration.', 'kata-plus' ); ?> </p>
								<?php echo wp_kses_post( $result['html'] ); ?>
								<p><?php echo __( 'You can ignore this message and start the import process. However, there is a chance that some parts of the demo wont be import as they should.', 'kata-plus' ); ?> </p>
								<div class="kata-checkbox-wrap importer-wraning warning-1">
									<input type="checkbox" class="kata-checkbox-input warning-1" value="warning-1">
									<label for="warning-1" class="kata-checkbox-label"><span><?php echo esc_html__( 'I read the above notice. I want start import') ?></span></label>
								</div>
								<div class="resume-import-progress-wrapper">
									<a href="#" class="resume-import-progress"><?php echo __( 'resume import process', 'kata-plus' ) ?></a>
								</div>
							</div>
						<?php } ?>
						<div class="steps step3" data-tab="step1">
							<div class="kata-col-import-demo-image">
								<img src="<?php echo esc_url($demo_data->data->images[0]); ?>" alt="<?php echo esc_attr($demo_data->data->name); ?>">
							</div>
							<div class="kata-col-import-demo">
								<div class="kata-install-plugins">
									<h3><?php echo esc_html__('Required plugins', 'kata-plus'); ?></h3>
									<a href="#" class="kata-btn kata-btn-install-plugins" data-action="<?php echo esc_attr__( 'install', 'kata-plus' ) ?>"><?php echo esc_html__('Install & Activate All Plugins', 'kata-plus'); ?></a>
								</div>
								<div class="kata-required-plugins">
									<?php
									if ( $required_plugins_arr ) {
										foreach ( $required_plugins_arr as $slg ) {
											if (array_key_exists($slg, $plugins)) {
												$required_plugins[$slg] = $plugins[$slg];
											}
										}
									}
									if ( $required_plugins ) {
										foreach ($required_plugins as $plugin) {
											$plugin['type']             = isset($plugin['type']) ? $plugin['type'] : 'recommended';
											$plugin['sanitized_plugin'] = $plugin['name'];
											$plugin_action              = $tgmpa_list_table->kata_plus_actions_plugin($plugin);
											$is_plugin_active_class     = TGM_Plugin_Activation::$instance->is_plugin_active($plugin['slug']) ? ' active' : '';
											?>
											<div class="kata-required-plugin<?php echo esc_attr($is_plugin_active_class); ?>" data-plugin-name="<?php echo esc_attr($plugin['name']); ?>">
												<h4><?php echo esc_html($plugin['name']); ?></h4>
												<span class="kata-required-plugin-line"></span>
												<?php echo wp_kses_post($plugin_action); ?>
											</div>
											<?php
										}
									}
									?>
								</div>
							</div>
						</div>
						<div class="steps step2" data-tab="step2">
							<div class="kata-col-import-demo-image">
								<img src="<?php echo esc_url($demo_data->data->images[0]); ?>" alt="<?php echo esc_attr($demo_data->data->name); ?>">
							</div>
							<div class="kata-col-import-demo">
								<div class="kata-import-content-wrap wp-clearfix">
									<div class="kata-checkbox-wrap all">
										<input type="checkbox" class="kata-checkbox-input all" id="all" name="import_content" value="all">
										<label for="all" class="kata-checkbox-label"></label>
										<span>All</span>
									</div>
									<?php
									foreach ($demo_data->data->contents as $type => $content) {
									?>
										<div class="kata-checkbox-wrap <?php echo esc_attr($type); ?>">
											<input type="checkbox" class="kata-checkbox-input <?php echo esc_attr($type); ?>" data-type="<?php echo esc_attr($type); ?>" name="import_content" value="<?php echo esc_attr($content); ?>">
											<label for="<?php echo esc_attr($type); ?>" class="kata-checkbox-label"></label>
											<span>
												<?php echo str_replace('_', ' ', self::import_option_name($type) ); ?>
											</span>
										</div>
									<?php
									}
									?>
								</div>
								<div class="kata-import-demo-btn-wrap">
									<a href="#" class="kata-import-demo-btn disabled" data-key="<?php echo esc_attr( $key ); ?>"><?php echo esc_html__('Import', 'kata-plus'); ?></a>
									<!-- <a href="#" class="kata-import-demo-reset" data-details="<?php // echo esc_attr( $key ); ?>"><span class="updating-message dashicons dashicons-update-alt"></span><?php // echo esc_html__('Uninstall', 'kata-plus'); ?></a> -->
								</div>
							</div>
						</div>
						<div class="steps step1 active" data-tab="step3">
							<div class="kata-col-import-demo-image">
								<img src="<?php echo esc_url($demo_data->data->images[0]); ?>" alt="<?php echo esc_attr($demo_data->data->name); ?>">
							</div>
							<div class="kata-col-import-demo">
								<h3><?php echo esc_html__('Importing in Progress', 'kata-plus'); ?></h3>
								<div class="meter">
									<span style="width: 0;"></span>
								</div>
								<div class="kata-importer-tasks">
									<ul class="tasks">

									</ul>
								</div>
								<!-- end .kata-import-content-wrap -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			wp_die();
		}

		/**
		 * Reset site content.
		 *
		 * @since   1.0.0
		 */
		public function reset_site() {
			check_ajax_referer('kata_importer_nonce', 'nonce');
			$action = sanitize_text_field( $_POST['reset'] );
			if ( $action !== 'yes' ) {
				return wp_send_json(
					[
						'message'	=> __( 'Sorry, You are not allowed to remove the site contents.', 'kata-plus' ),
						'status'	=> 'not_allowed'
					],
					200, 1
				);
				wp_die();
			} else {
				// Clear Builders
				$Builders = get_posts( ['post_type' => 'kata_plus_builder', 'numberposts' => -1] );
				foreach( $Builders as $eachBuilder ) {
					wp_delete_post( $eachBuilder->ID, true );
				}
				// Clear Pages
				$Pages = get_posts( ['post_type' => 'page', 'numberposts' => -1] );
				foreach( $Pages as $eachPage ) {
					wp_delete_post( $eachPage->ID, true );
				}
				// Clear Posts
				$Posts = get_posts( ['post_type' => 'post', 'numberposts' => -1] );
				foreach( $Posts as $eachPost ) {
					wp_delete_post( $eachPost->ID, true );
				}
				// Clear contact form7
				$contact_form7 = get_posts( ['post_type' => 'wpcf7_contact_form', 'numberposts' => -1] );
				foreach( $contact_form7 as $eachcontact_form7 ) {
					wp_delete_post( $eachcontact_form7->ID, true );
				}
				// Clear media
				$contact_form7 = get_posts( ['post_type' => 'attachment', 'numberposts' => -1] );
				foreach( $contact_form7 as $eachcontact_form7 ) {
					wp_delete_post( $eachcontact_form7->ID, true );
				}
				// Clean Menus
				$menus = wp_get_nav_menus();
				foreach ($menus as $menu) {
					wp_delete_nav_menu($menu->term_id);
				}
				return wp_send_json(
					[
						'message'	=> __( 'Site remove contents task ha been finished.', 'kata-plus' ),
						'status'	=> 'allowed'
					],
					200, 1
				);
				wp_die();
			}
		}

		/**
		 * Import Done.
		 *
		 * @since   1.0.0
		 */
		public function ImportDone() {
			check_ajax_referer('kata_importer_nonce', 'nonce');
			do_action('customize_preview_init');
			$settings 		= $_POST;
			$demo_data		= Kata_Plus_API::get_instance()->demo('Information', $settings['key']);
			$setting_key	= $settings['key'];
			if ( ! isset( $setting_key ) ) {
				return;
			}
			$status = false;
			$reports = $settings['reports'];
			foreach ( $reports as $key => $report ) {
				if ( $report === 'true' ) {
					$status = true;
					break;
				}
			}
			
			if ( isset( $settings['reports']['pages'] ) && $status === true ) {
				$front_page_id = get_page_by_title( 'Home' );
				$blog_page_id = get_page_by_title( 'Blog' );
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $front_page_id->ID );
				update_option( 'page_for_posts', $blog_page_id->ID );
				if ( class_exists( 'Elementor\Plugin' ) ) {
					$manager	= new \Elementor\Core\Files\Manager;
					$manager->clear_cache();
				}
			}

			do_action('customize_preview_init');
			if ($status === true) {
				Kata_Plus_API::get_instance()->ImportDone( $setting_key );
				$kata_options = get_option( 'kata_options' );
				$kata_options['imported_demos'][] = $setting_key;
				update_option( 'kata_options', $kata_options );
			}

			if ( file_exists( WP_PLUGIN_DIR . '/' . 'kata-plus-pro/kata-plus-pro.php' ) ) {
				activate_plugins( 'advanced-custom-fields-pro/acf.php' );
			}
			?>
			<?php if ( $status === true ) : ?>
				<i class="ti-close"></i>
				<div class="kata-lightbox-contents">
					<div class="kata-lightbox">
						<?php self::HeaderModal($demo_data->data->name); ?>
						<div class="kata-lightbox-content kata-importer-settings">
							<div class="kata-col-import-demo-image">
								<img src="<?php echo esc_url($demo_data->data->images[0]); ?>" alt="<?php echo esc_attr($demo_data->data->name); ?>">
							</div>
							<div class="kata-col-import-demo" style="width:19% !important;">
								<div class="kata-import-demo-done-100">
									<?php echo __('The Demo is Imported Successfully', 'kata-plus'); ?>
								</div>
								<div class="kata-suc-imp-links">
									<a href="<?php echo site_url(); ?>"><?php echo __('View Website', 'kata-plus'); ?></a>
								</div>
							</div><!-- end .kata-col-import-demo -->
						</div> <!-- end .lightbox-content -->
						<!-- end .kata-suc-imp-content-wrap -->
					</div> <!-- end .kata-lightbox -->
				</div> <!-- end .kata-lightbox-contents -->
			<?php else : ?>
				<i class="ti-close"></i>
				<div class="kata-lightbox-contents">
					<div class="kata-lightbox">
						<?php self::HeaderModal($demo_data->data->name); ?>
						<div class="kata-lightbox-content kata-importer-settings">
							<div class="kata-col-import-demo-image">
								<img src="<?php echo esc_url($demo_data->data->images[0]); ?>" alt="<?php echo esc_attr($demo_data->data->name); ?>">
							</div>
							<div class="kata-col-import-demo" style="width:19% !important;">
								<div class="kata-import-demo-failed">
									<?php echo __('Demo Import Failed', 'kata-plus'); ?>
								</div>
								<div class="kata-imp-fail-tx">
									<?php echo __('Please check', 'kata-plus'); ?> .... <a href="<?php echo admin_url( 'admin.php?page=kata-plus-help' ); ?>" target="_blank"><?php echo __('System Status', 'kata-plus'); ?></a> <?php echo __('and try again', 'kata-plus'); ?>.
								</div>
							</div><!-- end .kata-col-import-demo -->
						</div> <!-- end .lightbox-content -->
						<!-- end .kata-suc-imp-content-wrap -->
					</div> <!-- end .kata-lightbox -->
				</div> <!-- end .kata-lightbox-contents -->
			<?php endif; ?>
		<?php
			wp_die();
		}

		/**
		 * Importer Option name.
		 *
		 * @access public
		 * @return void
		 */
		public static function import_option_name($name) {
			if ($name == 'builders') {
				$name = 'header, footer...';
			}
			if ($name == 'customizer') {
				$name = 'options';
			}
			return __( $name, 'kata-plus' );
		}

		/**
		 * Access Denied Step.
		 *
		 * @access public
		 * @return void
		 */
		public function access_denied_step($demo_name, $screenshot, $message = false)
		{
		?>
			<i class="ti-close"></i>
			<div class="kata-lightbox-contents">
				<div class="kata-lightbox">
					<?php self::HeaderModal($demo_name); ?>
					<div class="kata-lightbox-content kata-importer-settings">
						<div class="steps step2" data-tab="step2">
							<div class="kata-col-import-demo-image"></div>
						</div>
						<div class="steps step2" data-tab="step2">
							<div class="kata-col-import-demo-image"><img src="<?php echo esc_url( $screenshot ); ?>"></div>

							<div class="kata-col-import-demo">
								<div class="kata-import-demo-failed">
									<?php echo __('Demo Import Failed', 'kata-plus'); ?>
								</div>
								<div class="kata-imp-fail-tx">
									<?php
									if ($message) {
										echo wp_kses_post( $message );
									} else {
										echo __('Please check', 'kata-plus') . ' .... <a href="' . admin_url( 'admin.php?page=kata-plus-help' ) . '" target="_blank">' . __('System Status', 'kata-plus') . '</a> ' . __('and try again', 'kata-plus') . '.';
									}
									?>
								</div>
							</div><!-- end .kata-col-import-demo -->
						</div> <!-- end .lightbox-content -->
						<div class="steps step2" data-tab="step2">
							<div class="kata-col-import-demo-image"></div>
						</div>
						<!-- end .kata-suc-imp-content-wrap -->
					</div> <!-- end .kata-lightbox -->
				</div> <!-- end .kata-lightbox -->
			</div> <!-- end .kata-lightbox-contents -->
		<?php
			wp_die();
		}

		/**
		 * Build Importer Data.
		 *
		 * @access public
		 * @return void
		 */
		public function BuildImporter()
		{
			check_ajax_referer('kata_importer_nonce', 'nonce');
			$settings   = $_POST;
			$key        = $settings['key'];
			$contents   = Kata_Plus_API::get_instance()->demo('Contents', $key)->contents;
			$upload_dir = Kata_Plus::$upload_dir . '/importer';
			if (!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777);
			}
			$upload_dir .= '/' . $key;
			if (!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777);
			}
		?>
			<li class="kata-importer-task-package kata-import-done" data-action="download_files"><?php echo esc_html__('Download Files', 'kata-plus'); ?></li>
			<?php
			set_time_limit(300);
			$demo_data = $settings['demo_data'];
			foreach ( $demo_data as $value) {
				if (!$value) {
					continue;
				}
				$file_to_download = $contents->$value;
				$tmp_file = download_url( $file_to_download );

				// Sets file final destination.
				$filepath = $upload_dir . '/' . $value . '.zip';

				// Copies the file to the final destination and deletes temporary file.
				copy( strval( $tmp_file ), $filepath );
				@unlink( $tmp_file );
				?>
				<li class="kata-importer-task-menus" data-action="<?php echo esc_attr( $value ); ?>" data-status="pending"><?php echo esc_html__('Import', 'kata-plus') . ' ' . str_replace('_', ' ', $value); ?></li>
				<!-- kata-import-active -->
				<?php
			}
			if ( file_exists( WP_PLUGIN_DIR . '/' . 'kata-plus-pro/kata-plus-pro.php' ) ) {
				deactivate_plugins( 'advanced-custom-fields-pro/acf.php' );
			}
			wp_die();
		}

		/**
		 * Import Data.
		 *
		 * @access public
		 * @return void
		 */
		public function Importer()
		{
			check_ajax_referer('kata_importer_nonce', 'nonce');
			$settings = $_POST;
			$key      = $settings['key'];
			if (!class_exists('\OCDI\CustomizerImporter')) {
				Kata_Plus_Autoloader::load(self::$dir . 'core/libraries', 'one-click-demo-import');
			}
			if ( ! class_exists( 'Zip' ) ) {
				require_once ABSPATH . 'wp-admin/includes/class-pclzip.php';
			}
			
			$upload_dir    = Kata_Plus::$upload_dir . '/importer/' . $key . '/';
			$zip_file_path = $upload_dir . $settings['import_item'] . '.zip';
			if( ! file_exists( $zip_file_path ) ) {
				static::print_output(
					[
						'status'  => 'error',
						'message' => __( 'Can not find the source file', 'kata-plus' ),
					]
				);
			}
			$import_item = $settings['import_item'];
			if ( $import_item != 'sliders' && $import_item != 'fonts' ) {
				if ( class_exists( 'PclZip' ) ) {
					$zip = new PclZip($zip_file_path);
					$zip->extract(PCLZIP_OPT_PATH, $upload_dir);
				} else {
					$zip = new Zip();
					$zip->unzip_file($zip_file_path, $upload_dir);
				}
			}

			switch ( $import_item ) {
				case 'customizer':
					$file_path = $upload_dir . $import_item . '.dat';
					$results   = \CEI_Core::_custom_import($file_path);
					if (is_wp_error($results)) {
						$error_message = $results->get_error_message();
						static::print_output(
							[
								'status'  => 'error',
								'message' => $error_message,
							]
						);
					} else {
						static::print_output(
							[
								'status' => 'success',
							]
						);
					}
					break;
				case 'media':
					$file_path = $upload_dir . $import_item . '.xml';
					$content = file_get_contents($file_path);
					preg_match('/<wp:base_site_url>(.*?)<\/wp:base_site_url>/', $content, $base_site_url);
					if($base_site_url[1] != get_site_url()) {
						$content = str_replace(
							$base_site_url[1] . '/wp-content/uploads/',
							Kata_Plus::$upload_dir_url . '/importer/' . $key . '/uploads/',
							$content
						);
						file_put_contents( $file_path, $content );
					}

					$logger    = new OCDI\Logger();
					$import    = new OCDI\Importer(
						[
							'fetch_attachments' => true
						],
						$logger
					);
					$import->import_content($file_path);
					if (!empty($logger->error_output)) {
						static::print_output(
							[
								'status'  => 'error',
								'message' => $logger->error_output,
							]
						);
					} else {
						static::print_output(
							[
								'status' => 'success',
							]
						);
					}
					Utils::replace_urls( 'https://climaxthemes.com/kata/' . $settings['demo'] , get_site_url() );
					break;
				case 'pages':
				case 'posts':
				case 'grids':
				case 'contact_form':
				case 'builders':
				case 'menu':
				case 'templates':
				case 'mega_menu':
				case 'products':
				case 'recipes':
				case 'crypto':
					$kata_options = get_option('kata_options');

					$file_path = $upload_dir . $settings['import_item'] . '.xml';

					$content = file_get_contents($file_path);
					preg_match('/<wp:base_site_url>(.*?)<\/wp:base_site_url>/', $content, $base_site_url);
					if($base_site_url[1] != get_site_url()) {
						$content = str_replace($base_site_url[1], get_site_url(), $content);
						file_put_contents($file_path, $content);
					}
					
					// Clear Builders
					if ( $settings['import_item'] == 'builders') {
						$Builders = get_posts(['post_type' => 'kata_plus_builder', 'numberposts' => -1]);
						foreach ($Builders as $eachBuilder) {
							wp_delete_post($eachBuilder->ID, true);
						}
					}

					// Clear Posts
					if ( $settings['import_item'] == 'posts') {
						$Posts = get_page_by_title( 'Hello world!', ARRAY_A, $post_type = 'post' );
						wp_delete_post($Posts['ID'], true);
					}

					// Clear Pages
					if ( $settings['import_item'] == 'pages') {
						$Posts = get_page_by_title( 'Sample Page', ARRAY_A, $post_type = 'post' );
						wp_delete_post($Posts['ID'], true);
					}

					// Clear contact form7
					// if ( $settings['import_item'] == 'contact_form') {
					// 	$contact_form7 = get_posts(['post_type' => 'wpcf7_contact_form', 'numberposts' => -1]);
					// 	foreach ($contact_form7 as $eachcontact_form7) {
					// 		wp_delete_post($eachcontact_form7->ID, true);
					// 	}
					// }
					// Clean Menus
					// if ( $settings['import_item'] == 'menu') {
					// 	$menus = wp_get_nav_menus();
					// 	foreach ($menus as $menu) {
					// 		wp_delete_nav_menu($menu->term_id);
					// 	}
					// }

					$logger    = new OCDI\Logger();
					$import    = new OCDI\Importer(
						[
							'update_attachment_guids' => true,
							'fetch_attachments' => true
						],
						$logger
					);
					$import->import_content($file_path);
					if (!empty($logger->error_output)) {
						static::print_output(
							[
								'status'  => 'error',
								'message' => $logger->error_output,
							]
						);
					} else {
						static::print_output(
							[
								'status' => 'success',
							]
						);
					}
					Utils::replace_urls( 'https://climaxthemes.com/kata-blog/' . $settings['demo'], get_site_url() );
					Utils::replace_urls( 'https://climaxthemes.com/kata/' . $settings['demo'], get_site_url() );
					break;
				case 'widgets':
					$file_path = $upload_dir . $settings['import_item'] . '.wie';
					$results   = OCDI\WidgetImporter::import($file_path);
					if (is_wp_error($results)) {
						$error_message = $results->get_error_message();
						static::print_output(
							[
								'status'  => 'error',
								'message' => $error_message,
							]
						);
					} else {
						static::print_output(
							[
								'status' => 'success',
							]
						);
					}
					break;
				case 'ess_grid':
					$file_path = $upload_dir . $settings['import_item'] . '.json';
					self::import_essential_grid( $file_path );
					break;
				case 'data_configuration':
					$file_path = $upload_dir . $settings['import_item'] . '.json';
					self::data_condiguration( $file_path );
					break;
				case 'sliders':
					if (class_exists('RevSlider')) {
						$slider = new \RevSlider();
						$status = $slider->importSliderFromPost(true, true, $zip_file_path);
						if ($status['success'] == true) {
							static::print_output(
								[
									'status' => 'success',
								]
							);
						} else {
							static::print_output(
								[
									'status'  => 'error',
									'message' => $status['error'],
								]
							);
						}
					} else {
						static::print_output(
							[
								'status'  => 'error',
								'message' => __('The RevSlider is not installed', 'kata-plus'),
							]
						);
					}
					break;
				case 'fonts':
					global $wpdb;

					$sql = 'SELECT * FROM ' . $wpdb->prefix . Kata_Plus::$fonts_table_name;
					$sql .= ' WHERE source<>"upload-icon" limit=1';
					$wpdb->hide_errors();
					if (strpos($wpdb->last_error, "doesn't exist")) {
						$sql = 'SELECT * FROM ' . $wpdb->prefix . 'kata_plus_typography_fonts';
						$wpdb->hide_errors();
						if (strpos($wpdb->last_error, "doesn't exist")) {
							$charset_collate = $wpdb->get_charset_collate();
							$sql = 'CREATE TABLE ' . $wpdb->prefix . \Kata_Plus::$fonts_table_name . " (
								ID int(9) NOT NULL AUTO_INCREMENT,
								name text NOT NULL,
								source varchar(200) NOT NULL,
								selectors text NOT NULL,
								subsets text NOT NULL,
								variants text NOT NULL,
								url text DEFAULT '' NOT NULL,
								place varchar(50) NOT NULL DEFAULT 'before_head_end',
								status varchar(50) NOT NULL DEFAULT 'publish',
								created_at int(12) NOT NULL,
								updated_at int(12) NOT NULL,
								PRIMARY KEY  (ID)
							) $charset_collate;";

							require_once ABSPATH . 'wp-admin/includes/upgrade.php';
							dbDelta($sql);
						}
					}
					$upload_dir = Kata_Plus::$upload_dir . '/fonts/';
					if (!file_exists($upload_dir)) {
						mkdir($upload_dir);
					}
					if ( class_exists( 'PclZip' ) ) {
						$zip = new PclZip($zip_file_path);
						$zip->extract(PCLZIP_OPT_PATH, $upload_dir);
					} else {
						$zip = new Zip();
						$zip->unzip_file($zip_file_path, $upload_dir);
					}
					$json_file = realpath( $upload_dir . '/fonts.json' );
					if (!$json_file) {
						static::print_output(
							[
								'status'  => 'error',
								'message' => __("Can't find the fonts.json file", 'kata-plus'),
							]
						);
					}
					$importData = json_decode(file_get_contents($json_file), true);
					@unlink($json_file);
					if (!$importData) {
						static::print_output(
							[
								'status'  => 'error',
								'message' => __("Can't recognize the fonts.json file content", 'kata-plus'),
							]
						);
					}
					foreach ($importData as $font) {
						if (is_array($font['url'])) {
							$font['url'] = json_encode($font['url']);
						}
						$font['url'] = str_replace('{{siteUrl}}', site_url(), $font['url']);
						$wpdb->insert(
							$wpdb->prefix . Kata_Plus::$fonts_table_name,
							array(
								'name'       => $font['name'],
								'source'     => $font['source'],
								'selectors'  => $font['selectors'],
								'subsets'    => $font['subsets'],
								'variants'   => $font['variants'],
								'url'        => $font['url'],
								'place'      => $font['place'],
								'status'     => $font['status'],
								'created_at' => $font['created_at'],
								'updated_at' => $font['updated_at'],
							)
						);
					}
					static::print_output(
						[
							'status' => 'success',
						]
					);
					break;
			}
			wp_die();
		}

		/**
		 * Data Configuration
		 *
		 * @param [Array] $data
		 * @return void
		 */
		public static function data_condiguration( $src ) {
			$configs = file_get_contents( $src );
			$configs = json_decode( $configs, true )[0];
			foreach ( $configs as $key => $values ) {
				if( $key == 'options' ) {
					foreach ( $values as $opt_name => $opt_value ) {
						$results = update_option( $opt_name, $opt_value );
					}
				}
			}
			if (is_wp_error($results)) {
				$error_message = $results->get_error_message();
				static::print_output(
					[
						'status'  => 'error',
						'message' => $error_message,
					]
				);
			} else {
				static::print_output(
					[
						'status' => 'success',
					]
				);
			}
		}

		/**
		 * Copy Target Directory to Destiny Directory
		 *
		 * @param [Array] $data
		 * @return void
		 */
		private static function copy_dir($src, $dest)
		{
			foreach (scandir($src) as $file) {
				if (!is_readable($src . '/' . $file)) continue;
				if (is_dir($src . '/' . $file) && ($file != '.') && ($file != '..')) {
					if (!realpath($dest . '/' . $file)) {
						mkdir($dest . '/' . $file, 0777, true);
					}
					static::copy_dir($src . '/' . $file, $dest . '/' . $file);
					unlink($src . '/' . $file);
				} else if ($file != '.' && $file != '..') {
					if (file_exists($dest . '/' . $file)) {
						unlink($dest . '/' . $file);
					}
					copy($src . '/' . $file, $dest . '/' . $file);
					unlink($src . '/' . $file);
				}
			}
		}


		/**
		 * Print Data Array as Json Output
		 *
		 * @param [Array] $data
		 * @return void
		 */
		public static function import_essential_grid( $essential_grid_file_path ) {
			$data = [];
			$content = file_get_contents( $essential_grid_file_path );
			$content = json_decode( $content );
			foreach( $content as $key => $item ) {
				if ( 'grids' == $key ) {
					if ( ! isset( $data['imports']['data-grids'] ) ) {
						foreach( $item as $grid ) {
							$data['imports']['data-grids'][] = json_encode( $grid );
						}
					}
				}
				if ( 'skins' == $key ) {
					if ( ! isset( $data['imports']['data-skins'] ) ) {
						foreach( $item as $grid ) {
							$data['imports']['data-skins'][] = json_encode( $grid );
						}
					}
					if ( ! isset( $data['imports']['import-skins-id'] ) ) {
						foreach ($item as $k => $v) {
							$data['imports']['import-skins-id'][] = $v->id;
						}
					}
				}
				if ( 'global-css' == $key ) {
					$data['imports']['data-global-css'] = json_encode( $item );
				}
				if ( ! isset( $data['imports']['import-grids'] ) ) {
					$data['imports']['import-grids'] = 'true';
				}
				if ( ! isset( $data['imports']['import-grids-id'] ) ) {
					foreach ($item as $k => $v) {
						$data['imports']['import-grids-id'][] = $v->id;
					}
				}
				if ( ! isset( $data['imports']['import-skins'] ) ) {
					$data['imports']['import-skins'] = 'true';
				}
				if ( ! isset( $data['imports']['import-global-styles'] ) ) {
					$data['imports']['import-global-styles'] = 'on';
				}
				if ( ! isset( $data['imports']['global-styles-overwrite'] ) ) {
					$data['imports']['global-styles-overwrite'] = 'append';
				}
			}
			if ( class_exists( 'Essential_Grid' ) ) {
				if(!isset($data['imports']) || empty($data['imports'])){
					Essential_Grid::ajaxResponseError(__('No data for import selected', EG_TEXTDOMAIN), false);
					exit();
				}
				try{
					$im = new Essential_Grid_Import();

					$temp_d = @$data['imports'];
					unset($temp_d['data-grids']);
					unset($temp_d['data-skins']);
					unset($temp_d['data-elements']);
					unset($temp_d['data-navigation-skins']);
					unset($temp_d['data-global-css']);

					$im->set_overwrite_data($temp_d); //set overwrite data global to class

					$skins = @$data['imports']['data-skins'];
					if(!empty($skins) && is_array($skins)){
						foreach($skins as $key => $skin){
							$tskin = json_decode(stripslashes($skin), true);
							if(empty($tskin)) $tskin = json_decode($skin, true);

							if(class_exists('Essential_Grid_Plugin_Update')){
								$tskin = Essential_Grid_Plugin_Update::process_update_216($tskin, true);
							}

							$skins[$key] = $tskin;
						}
						if(!empty($skins)){
							$skins_ids = @$data['imports']['import-skins-id'];
							$skins_imported = $im->import_skins($skins, $skins_ids);
						}
					}

					$navigation_skins = @$data['imports']['data-navigation-skins'];
					if(!empty($navigation_skins) && is_array($navigation_skins)){
						foreach($navigation_skins as $key => $navigation_skin){
							$tnavigation_skin = json_decode($navigation_skin, true);
							if(empty($tnavigation_skin)) $tnavigation_skin = json_decode($navigation_skin, true);

							$navigation_skins[$key] = $tnavigation_skin;
						}
						if(!empty($navigation_skins)){
							$navigation_skins_ids = @$data['imports']['import-navigation-skins-id'];
							$navigation_skins_imported = $im->import_navigation_skins(@$navigation_skins, $navigation_skins_ids);
						}
					}

					$grids = @$data['imports']['data-grids'];
					if(!empty($grids) && is_array($grids)){
						foreach($grids as $key => $grid){
							$tgrid = json_decode(stripslashes($grid), true);
							if(empty($tgrid)) $tgrid = json_decode($grid, true);

							$grids[$key] = $tgrid;
						}
						if(!empty($grids)){
							$grids_ids = @$data['imports']['import-grids-id'];
							$grids_imported = $im->import_grids($grids, $grids_ids);
						}
					}

					$elements = @$data['imports']['data-elements'];
					if(!empty($elements) && is_array($elements)){
						foreach($elements as $key => $element){
							$telement = json_decode(stripslashes($element), true);
							if(empty($telement)) $telement = json_decode($element, true);

							$elements[$key] = $telement;
						}
						if(!empty($elements)){
							$elements_ids = @$data['imports']['import-elements-id'];
							$elements_imported = $im->import_elements(@$elements, $elements_ids);
						}
					}

					$custom_metas = @$data['imports']['data-custom-meta'];
					if(!empty($custom_metas) && is_array($custom_metas)){
						foreach($custom_metas as $key => $custom_meta){
							$tcustom_meta = json_decode(stripslashes($custom_meta), true);
							if(empty($tcustom_meta)) $tcustom_meta = json_decode($custom_meta, true);

							$custom_metas[$key] = $tcustom_meta;
						}
						if(!empty($custom_metas)){
							$custom_metas_handle = @$data['imports']['import-custom-meta-handle'];
							$custom_metas_imported = $im->import_custom_meta($custom_metas, $custom_metas_handle);
						}
					}

					$custom_fonts = @$data['imports']['data-punch-fonts'];
					if(!empty($custom_fonts) && is_array($custom_fonts)){
						foreach($custom_fonts as $key => $custom_font){
							$tcustom_font = json_decode(stripslashes($custom_font), true);
							if(empty($tcustom_font)) $tcustom_font = json_decode($custom_font, true);

							$custom_fonts[$key] = $tcustom_font;
						}
						if(!empty($custom_fonts)){
							$custom_fonts_handle = @$data['imports']['import-punch-fonts-handle'];
							$custom_fonts_imported = $im->import_punch_fonts($custom_fonts, $custom_fonts_handle);
						}
					}

					if(@$data['imports']['import-global-styles'] == 'on'){
						$global_css = @$data['imports']['data-global-css'];

						$global_styles_imported = $im->import_global_styles($global_css);

					}

					Essential_Grid::ajaxResponseSuccess(__('Successfully imported data', EG_TEXTDOMAIN), array('is_redirect' => true, 'redirect_url' => Essential_Grid_Base::getViewUrl("","",'essential-'.Essential_Grid_Admin::VIEW_START)));

				} catch( Exception $d ) {
					$error = __('Something went wrong, please contact the developer', EG_TEXTDOMAIN);
				}
			}
		}

		/**
		 * Print Data Array as Json Output
		 *
		 * @param [Array] $data
		 * @return void
		 */
		public static function print_output($data)
		{
			if (!is_array($data) && !is_object($data)) {
				$data = [$data];
			}

			header('Content-Type: application/json');
			echo json_encode($data);
			exit();
		}

		/**
		 * Enqueue Styles.
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_styles()
		{
			wp_enqueue_style( 'kata-plus-importer', Kata_Plus::$assets . 'css/backend/importer.css' );
			if ( is_rtl() ) {
				wp_enqueue_style( 'kata-plus-importer-rtl', Kata_Plus::$assets . 'css/backend/importer-rtl.css' );
			}
			wp_enqueue_style( 'kata-plus-book-table-select', Kata_Plus::$assets . 'css/libraries/nice-select.css', [], Kata_Plus::$version );
		}

		/**
		 * Enqueue Javascripts.
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_scripts()
		{
			wp_enqueue_script( 'lozad', Kata_Plus::$assets . 'js/libraries/lozad.min.js', [ 'jquery' ], Kata_Plus::$version, false );
			wp_enqueue_script( 'kata-plus-book-table-select', Kata_Plus::$assets . 'js/libraries/jquery.nice-select.js', [ 'jquery' ], Kata_Plus::$version, true );
			wp_enqueue_script( 'kata-plus-importer', Kata_Plus::$assets . 'js/backend/importer.js', ['jquery', 'kata-plus-book-table-select'], Kata_plus::$version, true );
			wp_localize_script(
				'kata-plus-importer',
				'importer_localize',
				[
					'ajax' => [
						'url'				=> admin_url('admin-ajax.php'),
						'nonce'				=> wp_create_nonce('kata_importer_nonce'),
						'reset_message'		=> __( 'Are you sure about removing all your site contents like Pages, Posts, Builders, Media, Contact Form7, Menu, etc?'),
						'restarted_message' => __( 'All site contents like Pages, Posts, Builders, Media, Contact Form7, Menu, etc has been removed.'),
					],
				]
			);

			wp_localize_script(
				'kata-plus-importer',
				'kata_install_plugins',
				array(
					'translation' => array(
						'activate'           => esc_html__('Activate', 'kata-plus'),
						'deactivate'         => esc_html__('Deactivate', 'kata-plus'),
						'fail-plugin-action' => esc_html__('There was a problem with your action. Please try again or reload the page.', 'kata-plus'),
					),
				)
			);
		}
	} // class

	Kata_Plus_Importer::get_instance();
} // if
