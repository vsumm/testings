<?php
/**
 * API Class
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_API' ) ) {
	class Kata_Plus_API {

		/**
		 * The directory of this path
		 *
		 * @access  public
		 * @var     string
		 */
        public static $dir;

		/**
		 * The Demo Key
		 *
		 * @access  public
		 * @var     string
		 */
		public static $key;

		/**
		 * The URL protocol
		 *
		 * @access  public
		 * @var     string
		 */
        public static $protocol;

		/**
		 * The API URL
		 *
		 * @access  public
		 * @var     string
		 */
		public static $url;

		/**
		 * The Second Server API URL
		 *
		 * @access  public
		 * @var     string
		 */
        public static $second_url;

		/**
		 * The API Token
		 *
		 * @access  public
		 * @var     string
		 */
        public static $token;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_API
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
		 * @since   1.0.0
		 */
		public function __construct() {
			$this->definitions();
			$this->dependencies();
        }

        /**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			Kata_Plus_Autoloader::load( self::$dir . 'vendor', 'autoload' );
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$protocol		= Kata_Plus_Helpers::ssl_url();
			self::$url      	= self::$protocol . 'katablogapi.climaxthemes.com/WebService';
			self::$second_url 	= self::$protocol . 'katablogapi.climaxthemes.com/WebService';
            self::$dir      	= Kata_Plus::$dir . 'includes/importer/core/includes/';
            self::$token    	= get_option('kata_plus_api_token');
            self::$key      	= '';
        }

        /**
		 * Authenticate the website for using kata-plus importer features
		 *
		 * @since   1.0.0
		 */
		public function authenticate($key) {
            static::$key = $key;
            $licence	= true;
            $website	= get_bloginfo('url');
            $email		= get_bloginfo('admin_email');
            $wp_version	= get_bloginfo('version');
            $data		= [
                'licence'		=> $licence,
                'website'		=> $website,
                'email'			=> $email,
                'key'			=> $key,
                'version'		=> Kata_Plus::$version,
                'wp_version'	=> $wp_version
            ];

            $response = $this->get( 'Authentication', $data );

            if ( ! $response ) {
                return false;
            }

            if ( isset( $response->message ) ) {
                return $response;
            }

            static::$token = $response->token;
            update_option( 'kata_plus_api_token', static::$token );

            return true;
		}

        /**
		 * Authenticate the website for using kata-plus importer features
		 *
		 * @since   1.0.0
		 */
		public function ImportDone( $key ) {
            static::$key = $key;
            $data = [
				'key' => $key,
				'token' => static::$token
            ];

            $response = $this->get('Done', $data);

            if ( ! $response ) {
                return false;
            }

            if ( isset( $response->message ) ) {
                return $response;
            }

            return true;
        }

        /**
		 * Get Demo Data From API.
		 *
		 * @since   1.0.0
		 */
		public function demo( $action, $key = false ) {

            static::$key = $key;
			$data = false;
			switch ( $action ) {
				case 'List':
					$data = $this->get( $action );
					$data = isset( $data->list ) ? $data->list : $data;
				break;
				case 'Contents':
					$data = $this->get( $action );
				break;
				case 'Information':
					$data = $this->get( $action );
				break;
				case 'Plugins':
					$data = $this->get( $action );
				break;
				case 'Images':
					$data = $this->get( $action );
				break;
				case 'Categories':
					$data = $this->get( $action );
				break;
			}

			return $data;
		}

        /**
         * Send request to WebService and return received data
         *
         * @param string $action
         * @param array $data
         * @return object
         */
        private function get( $action, $data = false ) {

			if ( static::$token ) {
				$data['token'] = static::$token;
			} else {
				$data['token'] = get_option( 'kata_plus_api_token' );
			}

			try {
				$url = $this->generate_url( $action );
				$headers = array( 'Accept' => 'application/json' );
				$request = Requests::post( $url, $headers, $data );

				if ( $request->status_code !== 200 ) {
					return false;
				}
				return json_decode( $request->body );

			} catch ( Exception $e ) {

				try {
					$url = $this->generate_second_url( $action );
					$headers = array(
						'accept'		=> 'application/json',
						'user-agent'	=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36'
					);
					$request = Requests::post( $url, $headers, $data );

					if ( $request->status_code !== 200 ) {
						return false;
					}
					return json_decode( $request->body );
				} catch ( Exception $e ) {
					echo '<span class="kata-plus-importer-error-message">' . __( 'Connection closed!', 'kata-plus' ) . '</span>';
					return false;
				}

			}
        }

        /**
         * Send request to WebService and return received data
         *
         * @param string $action
         * @param array $data
         * @return URL
         */
        private function generate_url( $action ) {
            $url = false;
			switch ( $action ) {
				case 'Authentication':
					$url = static::$url . '/' . $action . '/';
				break;
				case 'List':
					$url = static::$url . '/Demo/' . $action . '/';
				break;
				case 'Contents':
					$url = static::$url . '/Demo/' . $action . '/' . static::$key . '/' . static::$token;
				break;
				case 'Information':
					$url = static::$url . '/Demo/' . $action . '/' . static::$key . '/' . static::$token;
				break;
				case 'Plugins':
					$url = static::$url . '/Demo/' . $action . '/' . static::$key . '/' . static::$token;
				break;
				case 'Images':
					$url = static::$url . '/Demo/' . $action . '/' . static::$key . '/' . static::$token;
				break;
				case 'Done':
					$url = static::$url . '/Import/Done/' . static::$key . '/' . static::$token;
				break;
			}

			return $url;
		}

		/**
		 * Send request to WebService and return received data
		 *
		 * @param string $action
		 * @param array $data
		 * @return URL
		 */
		private function generate_second_url( $action ) {
			$url = false;
			switch ( $action ) {
				case 'Authentication':
					$url = static::$second_url . '/' . $action . '/';
				break;
				case 'List':
					$url = static::$second_url . '/Demo/' . $action . '/';
				break;
				case 'Contents':
					$url = static::$second_url . '/Demo/' . $action . '/' . static::$key . '/' . static::$token;
				break;
				case 'Information':
					$url = static::$second_url . '/Demo/' . $action . '/' . static::$key . '/' . static::$token;
				break;
				case 'Plugins':
					$url = static::$second_url . '/Demo/' . $action . '/' . static::$key . '/' . static::$token;
				break;
				case 'Images':
					$url = static::$second_url . '/Demo/' . $action . '/' . static::$key . '/' . static::$token;
				break;
				case 'Done':
					$url = static::$second_url . '/Import/Done/' . static::$key . '/' . static::$token;
				break;
			}

			return $url;
		}
	}

	Kata_Plus_API::get_instance();
}
