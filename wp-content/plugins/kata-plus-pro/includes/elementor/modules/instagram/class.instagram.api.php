<?php
/**
 * Get Instagram API.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Kata_Plus_Pro_Instagram_API')) {
	class Kata_Plus_Pro_Instagram_API
	{
		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro
		 */
		public static $instance;

		/**
		 * Client ID.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $api_url;

		/**
		 * Client ID.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $client_id;

		/**
		 * Client App Secret.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $app_secret;

		/**
		 * Redirect URL.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $redirect_uri;

		/**
		 * Permission scope.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $scope;

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
		 * Define the core functionality of the plugin.
		 *
		 * @since   1.0.0
		 */
		public function __construct()
		{
			$this->definitions();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$client_id	= get_theme_mod('kata_instagram_app_id', '');
			self::$app_secret	= get_theme_mod('kata_instagram_app_secret', '');
			self::$redirect_uri	= 'https://www.climaxthemes.com/kata/api/instagram/instagram.php';
			self::$scope		= 'user_profile,user_media';
			self::$api_url		= 'https://api.instagram.com/oauth/authorize?client_id=' . self::$client_id . '&redirect_uri=' . self::$redirect_uri . '&scope='.self::$scope.'&response_type=code';
			self::$api_url		= 'https://api.instagram.com/oauth/authorize?client_id=308846596960329&redirect_uri=https://www.climaxthemes.com/kata/api/instagram/instagram.php&scope=user_profile,user_media&response_type=code';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() { }

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public static function get_media_data( $access_token ) {
			if ( ! $access_token ) {
				return;
			}
			$media_data = 'https://graph.instagram.com/me/media?fields=id,caption,media_url,permalink,username,media_type,timestamp&access_token=' . $access_token;
			$response = wp_safe_remote_get(
				$media_data,
				[
					'timeout'		=> 30,
					'user-agent'	=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36'
				]
			);
			if ( is_wp_error( $response ) ) {
				return false;
			}
			return $response['body'];
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {}


	} // class
	Kata_Plus_Pro_Instagram_API::get_instance();
}
