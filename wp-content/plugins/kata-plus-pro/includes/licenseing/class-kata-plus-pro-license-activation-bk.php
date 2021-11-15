<?php

/**
 * Kata_Plus_Pro_license_Activation Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_license_Activation' ) ) {
	class Kata_Plus_Pro_license_Activation {
		/**
		* The remote address
		* @var string
		*/
		public $remote_address;

		/**
		* The plugin current version
		* @var string
		*/
		public $current_version;

		/**
		* The site url
		* @var string
		*/
		public $site_url;

		/**
		* The kata options
		* @var string
		*/
		public $itemid;

		/**
		 * Maintains the url of the plugin.
		 *
		 * @access  public
		 * @var     string
		 */
		public $plugin_url;

		/**
		* Plugin Slug ( plugin_directory/plugin_file.php )
		* @var string
		*/
		public $plugin_slug;

		/**
		* Plugin name ( plugin_file )
		* @var string
		*/
		public $slug;

		/**
		* Plugin response transient key
		* @var string
		*/
		public $response_transient_key;

		/**
		* Initialize a new instance of the WordPress Auto-Update class
		* @param string $current_version
		* @param string $plugin_slug
		*/
		function __construct( $current_version, $plugin_slug ) {
			// Set the class public variables
			$this->current_version	= $current_version;
			$this->remote_address	= 'https://katablogapi.climaxthemes.com/wp-json/kata-demo-webservice/v1/check-license/?doAction=';
			$this->plugin_url		= 'https://climaxthemes.com/kata-pro/';
			$this->itemid			= ['111','113', '704', '941'];
			$this->site_url			= get_site_url();
			$this->plugin_slug		= $plugin_slug;
			$this->slug				= $plugin_slug;
			$this->response_transient_key = md5( sanitize_key( $this->plugin_slug . '/' . $this->plugin_slug . '.php' ) . 'response_transient' );
			/**
			 * define the alternative API for updating checking
			 */
			add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'check_update' ], 50 );

			/**
			 * Define the alternative response for information checking
			 */
			add_filter( 'plugins_api', [$this, 'check_info'], 10, 3 );

			add_action( 'wp_ajax_kata_plus_activation', [$this, 'license_activation'] );

			add_action( 'delete_site_transient_update_plugins', [ $this, 'delete_transients' ] );

			remove_action( 'after_plugin_row_' . $this->plugin_slug . '/' . $this->plugin_slug . '.php', 'wp_plugin_update_row' );
			add_action( 'after_plugin_row_' . $this->plugin_slug . '/' . $this->plugin_slug . '.php', [ $this, 'show_update_notification' ], 10, 2 );

			$this->maybe_delete_transients();
		}

		/**
		* Add our self-hosted description to the filter
		*
		* @param boolean $false
		* @param array $action
		* @param object $arg
		* @return bool|object
		*/
		public function check_info( $false, $action, $arg ) {
			if ( isset( $arg->slug ) && $arg->slug === $this->slug ) {
				/**
				 * Get the remote version
				 */
				$remote_version = $this->getRemote_version();
				/**
				 * Get Remote Package
				 */
				$remote_package = $this->getRemote_package();
				/**
				 * Get Remote information
				 */
				$information = $this->getRemote_information();
				$information = json_decode( $information );

				$information->name				= Kata_Plus_Pro::$plugin_name;
				$information->slug				= Kata_Plus_Pro::$slug;
				$information->plugin_name		= Kata_Plus_Pro::$plugin_name;
				$information->version			= $remote_version;
				$information->download_link		= str_replace( '\/', '/', $remote_package );
				unset( $information->sections );
				$information->sections			= [
					'description'		=> 'Kata Plus Pro functionality',
					'changelog'			=> 'Kata Plus Pro functionality - Changelog'
				];

				return $information;
			}
			return false;
		}

		/**
		* Return the remote version
		* @return string $remote_version
		*/
		public function getRemote_version() {
			$kata_options = get_option( 'kata_options' );
			foreach ( $this->itemid as $id ) {
				$version = $this->remote_address . 'version&license=' . $kata_options['license']['purchase_code'] . '&itemId=' . $id . '&siteURL=' . $this->site_url;
				$request = wp_remote_retrieve_body(
					wp_remote_get(
						$version,
						[
							'body'			=> null,
							'timeout'		=> '120',
							'redirection'	=> '10',
							'user-agent'	=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
						]
					)
				);
				$request = json_decode( $request );
				if ( isset( $request->message ) ) {
					if ( ! Kata_Plus_Pro_Helpers::string_is_contain( $request->message, 'License key is not valid for' ) ) {
						return $request->message;
						break;
					}
				} else {
					return __( 'Server error 403, We can not conect to webservice.', 'kata-plus' );
				}
			}
			return false;
		}

		/**
		* Return the remote package
		* @return string $remote_package
		*/
		public function getRemote_package() {
			$kata_options = get_option( 'kata_options' );
			foreach ( $this->itemid as $id ) {
				$version = $this->remote_address . 'download&license=' . $kata_options['license']['purchase_code'] . '&itemId=' . $id . '&siteURL=' . $this->site_url;
				$request = wp_remote_retrieve_body(
					wp_remote_get(
						$version,
						[
							'body'			=> null,
							'timeout'		=> '120',
							'redirection'	=> '10',
							'user-agent'	=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
						]
					)
				);
				$request = json_decode( $request );
				if ( isset( $request->message ) ) {
					if ( 'License key is not valid for 10 Licenses for Kata' != $request->message || 'License key is not valid for 1 license for Kata' != $request->message ) {
						return str_replace( '\/', '/', $request->message );
						break;
					}
				}
			}
			return NULL;
		}

		/**
		* Get information about the remote version
		* @return bool|object
		*/
		public function getRemote_information() {
			$request = wp_remote_post('https://api.wordpress.org/plugins/info/1.0/kata-plus.json', array( 'timeout' => 30 ));
			if(!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
				return $request['body'];
			}

			return false;
		}

		/**
		* Return the status of the plugin licensing
		* @return boolean $remote_license
		*/
		public function getRemote_license( $license = '' ) {
			$kata_options	= get_option( 'kata_options' );
			$license		= $license ? $license : $kata_options['license']['purchase_code'];
			$invalid = '';
			foreach ( $this->itemid as $id ) {
				$version = $this->remote_address . 'activate&license=' . $license . '&itemId=' . $id . '&siteURL=' . $this->site_url;
				$request = wp_remote_retrieve_body(
					wp_remote_get(
						$version,
						[
							'body'			=> null,
							'timeout'		=> '120',
							'redirection'	=> '10',
							'user-agent'	=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36',
						]
					)
				);
				$request = json_decode( $request );
				if ( 'invalid' == $request->error ) {
					$invalid = $request->message;
					continue;
				} elseif ( 'valid' == $request->error ) {
					return $request->message;
					break;
				}
			}
			return $invalid;
		}

		public function delete_transients() {
			$this->delete_transient( $this->response_transient_key );
		}

		private function maybe_delete_transients() {
			global $pagenow;

			if ( 'update-core.php' === $pagenow && isset( $_GET['force-check'] ) ) {
				$this->delete_transients();
			}
		}

		private function check_transient_data( $_transient_data ) {
			if ( ! is_object( $_transient_data ) ) {
				$_transient_data = new \stdClass();
			}

			if ( empty( $_transient_data->checked ) ) {
				return $_transient_data;
			}

			$version_info = $this->get_transient( $this->response_transient_key );
			if ( false === $version_info ) {
				$version_info = $this->getRemote_information();
				$version_info = json_decode( $version_info );

				if ( is_wp_error( $version_info ) ) {
					$version_info = new \stdClass();
					$version_info->error = true;
				}

				$this->set_transient( $this->response_transient_key, $version_info );
			}

			if ( ! empty( $version_info->error ) ) {
				return $_transient_data;
			}

			// include an unmodified $wp_version
			include( ABSPATH . WPINC . '/version.php' );

			/**
			* Get the remote version
			*/
			$remote_version = $this->getRemote_version();

			if ( version_compare( $wp_version, $version_info->requires, '<' ) ) {
				return $_transient_data;
			}

			// Get the remote version
			$remote_version = $this->getRemote_version();
			// Package
			$remote_package = $this->getRemote_package();
			// If a newer version is available, add the update
			if ( version_compare( $this->current_version, $remote_version, '<' ) ) {
				$obj										= new stdClass();
				$obj->id									= '111';
				$obj->slug									= $this->slug;
				$obj->plugin								= $this->plugin_slug . '/' . $this->plugin_slug . '.php';
				$obj->new_version							= $remote_version;
				$obj->url									= $this->plugin_url;
				$obj->package								= str_replace( '\/', '/', $remote_package );
				$obj->icons									= [
					'2x' => 'https://ps.w.org/kata-plus/assets/icon-256x256.png',
					'1x' => 'https://ps.w.org/kata-plus/assets/icon-256x256.png',
				];
				$obj->banners								= [
					'2x' => 'https://ps.w.org/kata-plus/assets/banner-772x250.png',
					'1x' => 'https://ps.w.org/kata-plus/assets/banner-772x250.png',
				];
				$obj->banners_rtl							= [];
				$obj->sections								= [
					'description'		=> 'Kata Plus Pro functionality',
					'another_section'	=> 'This is another section',
					'changelog'			=> 'Kata Plus Pro functionality - Changelog'
				];
				$_transient_data->response[$this->plugin_slug . '/' . $this->plugin_slug . '.php']	= $obj;
			}

			$_transient_data->last_checked = current_time( 'timestamp' );
			$_transient_data->checked[ $this->plugin_slug . '/' . $this->plugin_slug . '.php' ] = $this->current_version;

			if ( ! isset( $_transient_data->translations ) ) {
				$_transient_data->translations = [];
			}

			$_transient_data->translations = array_filter( $_transient_data->translations, function( $translation ) {
				return ( $translation['slug'] !== $this->plugin_slug );
			} );

			if ( ! empty( $version_info->translations ) ) {
				foreach ( $version_info->translations as $translation ) {
					$_transient_data->translations[] = [
						'type'		 => 'plugin',
						'slug'		 => $this->plugin_slug,
						'language'	 => $translation['language'],
						'version'	 => $version_info->new_version,
						'updated'	 => $translation['updated'],
						'package'	 => $translation['package'],
						'autoupdate' => true,
					];
				}
			}

			return $_transient_data;
		}

		public function check_update( $_transient_data ) {
			global $pagenow;

			if ( ! is_object( $_transient_data ) ) {
				$_transient_data = new \stdClass();
			}

			if ( 'plugins.php' === $pagenow && is_multisite() ) {
				return $_transient_data;
			}

			return $this->check_transient_data( $_transient_data );
		}


		public function show_update_notification( $file, $plugin ) {
			if ( is_network_admin() ) {
				return;
			}

			if ( ! current_user_can( 'update_plugins' ) ) {
				return;
			}

			if ( ! is_multisite() ) {
				return;
			}

			if ( $this->plugin_slug . '/' . $this->plugin_slug . '.php' !== $file ) {
				return;
			}

			// Remove our filter on the site transient
			remove_filter( 'pre_set_site_transient_update_plugins', [ $this, 'check_update' ] );

			$update_cache = get_site_transient( 'update_plugins' );
			$update_cache = $this->check_transient_data( $update_cache );
			set_site_transient( 'update_plugins', $update_cache );

			// Restore our filter
			add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'check_update' ] );
		}

		protected function get_transient( $cache_key ) {
			$cache_data = get_option( $cache_key );

			if ( empty( $cache_data['timeout'] ) || current_time( 'timestamp' ) > $cache_data['timeout'] ) {
				// Cache is expired.
				return false;
			}

			return $cache_data['value'];
		}

		protected function set_transient( $cache_key, $value, $expiration = 0 ) {
			if ( empty( $expiration ) ) {
				$expiration = strtotime( '+12 hours', current_time( 'timestamp' ) );
			}

			$data = [
				'timeout' => $expiration,
				'value' => $value,
			];

			update_option( $cache_key, $data, 'no' );
		}

		protected function delete_transient( $cache_key ) {
			delete_option( $cache_key );
		}

		/**
		* Active The Kata Plus
		*
		* @since     1.0.0
		*/
		public function license_activation() {
			$settings		= $_POST;
			$kata_options	= get_option( 'kata_options' );

			/**
			* Get the remote version
			*/
			$remote_version = $this->getRemote_version();

			/**
			* Get the remote version
			*/
			$remote_license = $this->getRemote_license( sanitize_text_field( $settings['code'] ) );
			if ( 'Your license is activated.' == $remote_license ) {
				$kata_options['license']['purchase_code']	= sanitize_text_field( $settings['code'] );
				update_option( 'kata_options', $kata_options );
				wp_send_json(
					[
						'status'		=> 'success',
						'version'		=> Kata_Plus_Pro::$version,
						'message'		=> $remote_license,
					]
				);
			} else {
				$kata_options['license']['purchase_code']	= '';
				update_option( 'kata_options', $kata_options );
				wp_send_json(
					[
						'status'		=> 'faild',
						'version'		=> Kata_Plus_Pro::$version,
						'message'		=> $remote_license,
					]
				);
			}
			wp_die();
		}

	}
	new Kata_Plus_Pro_license_Activation( Kata_Plus_Pro::$version, Kata_Plus_Pro::$slug );
}
