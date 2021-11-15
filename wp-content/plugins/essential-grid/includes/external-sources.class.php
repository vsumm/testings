<?php
/**
 * External Sources Input Classes for Back and Front End
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 * @since: 2.0.9
 **/

if (!defined('ABSPATH')) die();

use EspressoDev\InstagramBasicDisplay as InstagramBasicDisplay;

/**
 * Facebook
 *
 * with help of the API this class delivers album images from Facebook
 *
 * @package    socialstreams
 * @subpackage socialstreams/facebook
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Facebook
{

	const URL_FB_AUTH = 'https://updates.themepunch.tools/fb/login.php';
	const URL_FB_API = 'https://updates.themepunch.tools/fb/api.php';

	const QUERY_SHOW = 'fb_show';
	const QUERY_TOKEN = 'fb_token';
	const QUERY_PAGE_ID = 'fb_page_id';
	const QUERY_CONNECTWITH = 'fb_page_name';
	const QUERY_ERROR = 'fb_error_message';

	/**
	 * @var number  Transient time in seconds
	 */
	private $transient_sec;

	public function __construct($transient_sec = 86400)
	{
		$this->transient_sec = $transient_sec;
	}

	public function add_actions()
	{
		add_action('init', array(&$this, 'do_init'), 5);
		add_action('admin_footer', array(&$this, 'footer_js'));
	}

	/**
	 * check if we have QUERY_ARG set
	 * try to login the user
	 */
	public function do_init()
	{
		// are we on essential-grid page?
		if (!isset($_GET['page']) || $_GET['page'] != 'essential-grid') return;

		//fb returned error
		if (isset($_GET[self::QUERY_ERROR])) return;

		//we need token and grid ID to proceed with saving token
		if (!isset($_GET[self::QUERY_TOKEN]) || !isset($_GET['create'])) return;

		$token = $_GET[self::QUERY_TOKEN];
		$connectwith = isset($_GET[self::QUERY_CONNECTWITH]) ? $_GET[self::QUERY_CONNECTWITH] : '';
		$page_id = isset($_GET[self::QUERY_PAGE_ID]) ? $_GET[self::QUERY_PAGE_ID] : '';
		$id = $_GET['create'];

		$grid = Essential_Grid::get_essential_grid_by_id(intval($id));
		if (empty($grid)) {
			$_GET[self::QUERY_ERROR] = esc_attr__('Grid could not be loaded', 'revslider');
			return;
		}

		$grid['postparams']['facebook-token-source'] = 'account';
		$grid['postparams']['facebook-access-token'] = $token;
		$grid['postparams']['facebook-page-id'] = $page_id;
		$grid['postparams']['facebook-connected-to'] = $connectwith;
		Essential_Grid_Admin::update_create_grid($grid);

		//clear cache
		$lang = array();
		if (Essential_Grid_Wpml::is_wpml_exists()) {
			$lang = icl_get_languages();
		}
		if (!empty($lang)) {
			foreach ($lang as $code => $val) {
				delete_transient('ess_grid_trans_query_' . $grid['id'] . $val['language_code']); //delete cache
				delete_transient('ess_grid_trans_full_grid_' . $grid['id'] . $val['language_code']); //delete cache
			}
		} else {
			delete_transient('ess_grid_trans_query_' . $grid['id']); //delete cache
			delete_transient('ess_grid_trans_full_grid_' . $grid['id']); //delete cache
		}

		//redirect
		$url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$url = add_query_arg([self::QUERY_TOKEN => false, self::QUERY_PAGE_ID => false, self::QUERY_CONNECTWITH => false, self::QUERY_SHOW => 1], $url);
		wp_redirect($url);
		exit();
	}

	public function footer_js()
	{
		// are we on essential-grid page?
		if (!isset($_GET['page']) || $_GET['page'] != 'essential-grid') return;

		if (isset($_GET[self::QUERY_SHOW]) || isset($_GET[self::QUERY_ERROR])) {
			echo "<script>jQuery(document).ready(function(){ setTimeout(function(){jQuery('.selected-source-setting').trigger('click');}, 500); });</script>";
		}

		if (isset($_GET[self::QUERY_ERROR])) {
			$err = esc_attr__('Facebook API error: ', 'revslider') . $_GET[self::QUERY_ERROR];
			echo '<script>jQuery(document).ready(function(){ AdminEssentials.showInfo({content: "' . $err . '", type: "warning", showdelay: 0, hidedelay: 0, hideon: "click", event: ""}) });</script>';
		}
	}

	public static function get_login_url()
	{
		$create = isset($_GET['create']) ? $_GET['create'] : '';
		$state = base64_encode(admin_url('admin.php?page=essential-grid&view=grid-create&create=' . $create));
		return self::URL_FB_AUTH . '?state=' . $state;
	}

	protected function _make_api_call($args = [])
	{
		global $wp_version;

		$response = wp_remote_post(self::URL_FB_API, array(
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url'),
			'body' => $args,
			'timeout' => 45
		));

		if (is_wp_error($response)) {
			return array(
				'error' => true,
				'message' => 'Facebook API error: ' . $response->get_error_message(),
			);
		}

		$responseData = json_decode($response['body'], true);
		if (empty($responseData)) {
			return array(
				'error' => true,
				'message' => 'Facebook API error: Empty response body or wrong data format',
			);
		}

		return $responseData;
	}

	protected function _get_transient_fb_data($requestData)
	{
		$requestData['transient_sec'] = $this->transient_sec;
		$transient_name = 'essgrid_' . md5(json_encode($requestData));
		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name))) {
			return $data;
		}

		$responseData = $this->_make_api_call($requestData);
		//code that use this function do not process errors
		//return empty array
		if ($responseData['error']) {
			return array();
		}

		if (isset($responseData['data'])) {
			$data = $this->facebook_output_array($responseData['data'], $requestData['action']);
			set_transient($transient_name, $data, $this->transient_sec);
			return $data;
		}

		return array();
	}

	/**
	 * Get Photosets List from User
	 *
	 * @param string $access_token page access token
	 * @param string $page_id page id
	 * @return    mixed
	 */
	public function get_photo_sets($access_token, $page_id)
	{
		return $this->_make_api_call(array(
			'token' => $access_token,
			'page_id' => $page_id,
			'action' => 'albums',
		));
	}

	/**
	 * Get Photosets List from User as Options for Selectbox
	 *
	 * @param string $access_token page access token
	 * @param string $page_id page id
	 * @return    mixed    options html string | array('error' => true, 'message' => '...');
	 */
	public function get_photo_set_photos_options($access_token, $page_id)
	{
		$photo_sets = $this->get_photo_sets($access_token, $page_id);

		if ($photo_sets['error']) {
			return $photo_sets;
		}

		$return = array();
		if (is_array($photo_sets['data'])) {
			foreach ($photo_sets['data'] as $photo_set) {
				$return[] = '<option title="' . $photo_set['name'] . '" value="' . $photo_set['id'] . '">' . $photo_set['name'] . '</option>"';
			}
		}
		return $return;
	}

	/**
	 * Get Photoset Photos
	 *
	 * @param string $access_token page access token
	 * @param string $album_id Album ID
	 * @param int $item_count items count
	 * @return    array
	 */
	public function get_photo_set_photos($access_token, $album_id, $item_count = 8)
	{
		$requestData = array(
			'token' => $access_token,
			'action' => 'photos',
			'album_id' => $album_id,
			'limit' => $item_count,
		);
		return $this->_get_transient_fb_data($requestData);
	}

	/**
	 * Get Feed
	 *
	 * @param string $access_token page access token
	 * @param string $page_id page id
	 * @param int $item_count items count
	 * @return    array
	 */
	public function get_photo_feed($access_token, $page_id, $item_count = 8)
	{
		$requestData = array(
			'token' => $access_token,
			'page_id' => $page_id,
			'action' => 'feed',
			'limit' => $item_count,
		);
		return $this->_get_transient_fb_data($requestData);
	}

	/**
	 * Prepare output array
	 *
	 * @param array $photos facebook data
	 * @param string $type data type ( album photos or feed)
	 * @return array
	 */
	private function facebook_output_array($photos, $type)
	{
		$return = array();

		foreach ($photos as $photo) {

			$stream = array();
			$stream['custom-image'] = '';
			$stream['id'] = $photo['id'];
			$stream['date'] = date_i18n(get_option('date_format'), strtotime($photo['created_time']));
			$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($photo['updated_time']));
			$stream['author_name'] = $photo['from']['name'];
			$stream['num_comments'] = $photo['comments']['summary']['total_count'];
			$stream['likes'] = $photo['likes']['summary']['total_count'];
			$stream['likes_short'] = Essential_Grid_Base::thousandsViewFormat($stream['likes']);

			switch ($type) {
				case 'photos':
					$stream['title'] = $photo['name'];
					$stream['content'] = $photo['name'];
					$stream['post-link'] = $photo['link'];
					$stream['custom-image-url'] = array(
						'thumbnail' => array(
							$photo['picture'],
							130,
							130,
						)
					);
					if (!empty($photo['images'][0]['source'])) {
						$stream['custom-image-url']['normal'] = array($photo['images'][0]['source']);
					} else {
						$stream['custom-image-url']['normal'] = array($photo['picture']);
					}
					$stream['custom-type'] = 'image';
					break;

				case 'feed' :
					$stream['title'] = $photo['message'];
					$stream['content'] = $photo['message'];
					$stream['post-link'] = $photo['permalink_url'];

					if (empty($photo['picture'])) {
						$stream['custom-type'] = 'html';
						$stream['custom-image-url'] = array();
					} else {
						$stream['custom-type'] = 'image';
						$stream['custom-image-url'] = array(
							'thumbnail' => array(
								$photo['picture'],
								130,
								130,
							),
							'normal' => array($photo['full_picture'])
						);
						if (isset($photo['attachments']['data'][0])) {
							$attach = $photo['attachments']['data'][0];
							switch ($attach['media_type']) {
								case 'link':
									$pattern = '/(?:.+?)?(?:\/v\/|watch\/|\?v=|\&v=|youtu\.be\/|\/v=|^youtu\.be\/|watch\%3Fv\%3D)([a-zA-Z0-9_-]{11})+/';
									preg_match($pattern, $attach['unshimmed_url'], $matches);
									if (isset($matches[1])) {
										$stream['custom-type'] = 'youtube';
										$stream['custom-youtube'] = $matches[1];
									}
									break;
								case 'video':
									$stream['custom-type'] = 'html5';
									$stream['custom-html5-mp4'] = $attach['media']['source'];
									break;
								default:
							}
						}
					}
					break;

				default:

			}

			$return[] = $stream;
		}

		return $return;
	}

}


/**
 * Twitter
 *
 * with help of the API this class delivers all kind of tweeted images from twitter
 *
 * @package    socialstreams
 * @subpackage socialstreams/twitter
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Twitter
{

	/**
	 * Consumer Key
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $consumer_key Consumer Key
	 */
	private $consumer_key;

	/**
	 * Consumer Secret
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $consumer_secret Consumer Secret
	 */
	private $consumer_secret;

	/**
	 * Access Token
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $access_token Access Token
	 */
	private $access_token;

	/**
	 * Access Token Secret
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $access_token_secret Access Token Secret
	 */
	private $access_token_secret;

	/**
	 * Twitter Account
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $twitter_account Account User Name
	 */
	private $twitter_account;

	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	/**
	 * Transient seconds
	 *
	 * @since    3.0
	 * @access   private
	 * @var      number $transient Transient time in seconds
	 */
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $consumer_key Twitter App Registration Consomer Key
	 * @param string $consumer_secret Twitter App Registration Consomer Secret
	 * @param string $access_token Twitter App Registration Access Token
	 * @param string $access_token_secret Twitter App Registration Access Token Secret
	 * @since    3.0
	 */
	public function __construct($consumer_key, $consumer_secret, $access_token, $access_token_secret, $transient_sec = 86400)
	{
		$this->consumer_key = $consumer_key;
		$this->consumer_secret = $consumer_secret;
		$this->access_token = $access_token;
		$this->access_token_secret = $access_token_secret;
		$this->transient_sec = 0;
	}

	/**
	 * Get Tweets
	 *
	 * @param string $twitter_account Twitter account without trailing @ char
	 * @since    3.0
	 */
	public function get_public_photos($twitter_account, $include_rts, $exclude_replies, $count, $imageonly)
	{
		$credentials = array(
			'consumer_key' => $this->consumer_key,
			'consumer_secret' => $this->consumer_secret
		);

		$this->twitter_account = $twitter_account;

		// Let's instantiate our class with our credentials
		$twitter_api = new EssGridTwitterApi($credentials, $this->transient_sec);

		$include_rts = $include_rts == "on" ? "true" : "false";
		$exclude_replies = $exclude_replies == "on" ? "true" : "false";

		$query = '&tweet_mode=extended&count=150&include_entities=true&include_rts=' . $include_rts . '&exclude_replies=' . $exclude_replies . '&screen_name=' . $twitter_account;
		$security = 50;
		$supervisor_count = 0;

		while ($count > 0 && $security > 0 && $supervisor_count < 20) {

			//get last stream array element and insert ID with max_id parameter
			$supervisor_count++;

			if (is_array($this->stream)) {
				$current_query = $query . "&max_id=" . $this->stream[sizeof($this->stream) - 1]["tweet_id"];
			} else {
				$current_query = $query;
			}

			$tweets = $twitter_api->query($current_query);
			$count = $this->twitter_output_array($tweets, $count, $imageonly);

			$security--;
		}

		return $this->stream;
	}

	/**
	 * Find Key in array and return value (multidim array possible)
	 *
	 * @param string $key Needle
	 * @param array $form Haystack
	 * @since    3.0
	 */
	public function array_find_element_by_key($key, $form)
	{
		if (is_array($form) && array_key_exists($key, $form)) {
			$ret = $form[$key];
			return $ret;
		}
		if (is_array($form))
			foreach ($form as $k => $v) {
				if (is_array($v)) {
					$ret = $this->array_find_element_by_key($key, $form[$k]);
					if ($ret) {
						return $ret;
					}
				}
			}
		return FALSE;
	}

	/**
	 * Prepare output array $stream
	 *
	 * @param string $tweets Twitter Output Data
	 * @since    3.0
	 */
	private function twitter_output_array($tweets, $count, $imageonly)
	{
		if (is_array($tweets)) {

			foreach ($tweets as $tweet) {

				$stream = array();
				$image_url = array();
				if ($count < 1) break;

				$image_url_array = $this->array_find_element_by_key("media", $tweet);
				$image_url_large = $this->array_find_element_by_key("large", $image_url_array);

				if (isset($tweet->entities->media[0])) {
					$image_url = array($tweet->entities->media[0]->media_url_https, $tweet->entities->media[0]->sizes->large->w, $tweet->entities->media[0]->sizes->large->h);
				}

				$stream['custom-image-url'] = $image_url; //image for entry
				$stream['custom-image-url-full'] = $image_url; //image for entry
				$stream['custom-type'] = isset($image_url[0]) ? 'image' : 'html';
				if ($imageonly == "true" && $stream['custom-type'] == 'html') continue;
				$stream['custom-type'] = 'image';

				$content_array = explode("https://t.co", $tweet->full_text);
				if (sizeof($content_array) > 1) array_pop($content_array);
				$content = implode("https://t.co", $content_array);

				$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
				$content = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $content);


				$stream['title'] = $content;
				$stream['content'] = $content;
				$stream['date'] = date_i18n(get_option('date_format'), strtotime($tweet->created_at));
				$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($tweet->created_at));
				$stream['author_name'] = $tweet->user->screen_name;
				$stream['post-link'] = 'https://twitter.com/' . $this->twitter_account . '/status/' . $tweet->id_str;

				$stream['retweets'] = $tweet->retweet_count;
				$stream['retweets_short'] = Essential_Grid_Base::thousandsViewFormat($tweet->retweet_count);
				$stream['likes'] = $tweet->favorite_count;
				$stream['likes_short'] = Essential_Grid_Base::thousandsViewFormat($tweet->favorite_count);
				$stream['tweet_id'] = $tweet->id;
				$stream['id'] = $tweet->id;
				$this->stream[] = $stream;
				$count--;
			}
			return $count;
		} else {
			return false;
		}
	}
}

/**
 * Class WordPress Twitter API
 *
 * https://github.com/micc83/Twitter-API-1.1-Client-for-Wordpress/blob/master/class-wp-twitter-api.php
 * @version 1.0.0
 * @since   3.0
 */
class EssGridTwitterApi
{

	var $bearer_token,
		// Default credentials
		$args = array(
			'consumer_key' => 'default_consumer_key',
			'consumer_secret' => 'default_consumer_secret'
		),
		// Default type of the resource and cache duration
		$query_args = array(
			'type' => 'statuses/user_timeline',
			'cache' => 1800
		),
		$has_error = false;

	/**
	 * WordPress Twitter API Constructor
	 *
	 * @param array $args
	 */
	public function __construct($args = array(), $transient_sec = 0)
	{
		if (is_array($args) && !empty($args))
			$this->args = array_merge($this->args, $args);

		if (!$this->bearer_token = get_option('twitter_bearer_token'))
			$this->bearer_token = $this->get_bearer_token();

		$this->query_args['cache'] = $transient_sec;
	}

	/**
	 * Get the token from oauth Twitter API
	 *
	 * @return string Oauth Token
	 */
	private function get_bearer_token()
	{
		$bearer_token_credentials = $this->args['consumer_key'] . ':' . $this->args['consumer_secret'];
		$bearer_token_credentials_64 = base64_encode($bearer_token_credentials);

		$args = array(
			'method' => 'POST',
			'timeout' => 5,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(
				'Authorization' => 'Basic ' . $bearer_token_credentials_64,
				'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
				'Accept-Encoding' => 'gzip'
			),
			'body' => array('grant_type' => 'client_credentials'),
			'cookies' => array()
		);

		$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
		if (is_wp_error($response) || 200 != $response['response']['code']) {
			return 'esg_stream_failure';
		}
		$result = json_decode($response['body']);

		update_option('twitter_bearer_token', $result->access_token);

		return $result->access_token;
	}

	/**
	 * Query twitter's API
	 *
	 * @param string $query Insert the query in the format "count=1&include_entities=true&include_rts=true&screen_name=micc1983!
	 * @param array $query_args Array of arguments: Resource type (string) and cache duration (int)
	 * @param bool $stop Stop the query to avoid infinite loop
	 *
	 * @return bool|object Return an object containing the result
	 * @uses $this->get_bearer_token() to retrieve token if not working
	 *
	 */
	public function query($query, $query_args = array(), $stop = false)
	{
		if ($this->has_error)
			return false;

		if (is_array($query_args) && !empty($query_args))
			$this->query_args = array_merge($this->query_args, $query_args);

		$transient_name = 'wta_' . md5($query);

		if ($this->query_args['cache'] > 0 && false !== ($data = get_transient($transient_name)))
			return json_decode($data);

		$args = array(
			'method' => 'GET',
			'timeout' => 5,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->bearer_token,
				'Accept-Encoding' => 'gzip'
			),
			'body' => null,
			'cookies' => array()
		);

		$response = wp_remote_get('https://api.twitter.com/1.1/' . $this->query_args['type'] . '.json?' . $query, $args);
		if (is_wp_error($response) || 200 != $response['response']['code']) {

			if (!$stop) {
				$this->bearer_token = $this->get_bearer_token();
				return $this->query($query, $this->query_args, true);
			} else {
				return 'esg_stream_failure';
			}

		}
		set_transient($transient_name, $response['body'], $this->query_args['cache']);

		return json_decode($response['body']);
	}

	/**
	 * Let's manage errors
	 *
	 * WP_DEBUG has to be set to true to show errors
	 *
	 * @param string $error_text Error message
	 * @param string $error_object Server response or wp_error
	 */
	private function bail($error_text, $error_object = '')
	{
		$this->has_error = true;

		if (is_wp_error($error_object)) {
			$error_text .= ' - Wp Error: ' . $error_object->get_error_message();
		} elseif (!empty($error_object) && isset($error_object['response']['message'])) {
			$error_text .= ' ( Response: ' . $error_object['response']['message'] . ' )';
		}

		return false;
	}

}

if (!function_exists('instagram_autoloader')) {
	function instagram_autoloader($class)
	{
		if (strpos($class, 'InstagramBasicDisplay') !== false) {
			$filename = realpath(dirname(__FILE__)) . '/' . str_replace('\\', '/', $class) . '.php';
			include_once($filename);
		}
	}
}

/**
 * Instagram
 *
 * with help of the API this class delivers all kind of Images from instagram
 *
 * @package    socialstreams
 * @subpackage socialstreams/instagram
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Instagram
{

	const QUERY_SHOW = 'ig_esg_show';
	const QUERY_TOKEN = 'ig_token';
	const QUERY_CONNECTWITH = 'ig_user';
	const QUERY_ERROR = 'ig_error_message';
	const QUERY_ESG_ERROR = 'ig_esg_error';

	/**
	 * API key
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $api_key Instagram API key
	 */
	private $api_key;

	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	/**
	 * Transient seconds
	 *
	 * @since    3.0
	 * @access   private
	 * @var      number $transient Transient time in seconds
	 */
	private $transient_sec;

	/**
	 * @var array of InstagramBasicDisplay objects
	 */
	private $instagram;

	/**
	 * Transient for token refresh in seconds
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      number $transient_token_sec Transient time in seconds
	 */
	private $transient_token_sec;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $api_key Instagram API key.
	 * @since    3.0
	 */
	public function __construct($transient_sec = 86400)
	{
		spl_autoload_register('instagram_autoloader');
		$this->transient_sec = $transient_sec;
		$this->transient_token_sec = 86400 * 30; // 30 days
	}

	public function add_actions()
	{
		add_action('init', array(&$this, 'do_init'), 4);
		add_action('admin_footer', array(&$this, 'footer_js'));
	}

	/**
	 * check if we have QUERY_TOKEN set
	 */
	public function do_init()
	{
		// we are not on esg page
		if (!isset($_GET['page']) || $_GET['page'] != 'essential-grid') return;

		//rename error var to avoid conflict with revslider
		if (isset($_GET[self::QUERY_ERROR])) {
			$url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
			$url = add_query_arg([self::QUERY_ERROR => false, self::QUERY_ESG_ERROR => $_GET[self::QUERY_ERROR]], $url);
			wp_redirect($url);
			exit();
		}

		if (
			!isset($_GET['page']) || $_GET['page'] != 'essential-grid' // we are not on esg page
			|| isset($_GET[self::QUERY_ERROR]) //instagram api error
			|| !isset($_GET[self::QUERY_TOKEN]) // no token
			|| !isset($_GET['create']) // no grid id
		)
			return;

		$token = $_GET[self::QUERY_TOKEN];
		$connectwith = $_GET[self::QUERY_CONNECTWITH];
		$id = $_GET['create'];

		$grid = Essential_Grid::get_essential_grid_by_id(intval($id));
		if (empty($grid)) {
			$_GET[self::QUERY_ERROR] = esc_attr__('Grid could not be loaded', 'revslider');
			return;
		}

		//update grid
		$grid['postparams']['instagram-api-key'] = $token;
		$grid['postparams']['instagram-connected-to'] = $connectwith;
		Essential_Grid_Admin::update_create_grid($grid);

		//clear cache
		$lang = array();
		if (Essential_Grid_Wpml::is_wpml_exists()) {
			$lang = icl_get_languages();
		}
		if (!empty($lang)) {
			foreach ($lang as $code => $val) {
				delete_transient('ess_grid_trans_query_' . $grid['id'] . $val['language_code']); //delete cache
				delete_transient('ess_grid_trans_full_grid_' . $grid['id'] . $val['language_code']); //delete cache
			}
		} else {
			delete_transient('ess_grid_trans_query_' . $grid['id']); //delete cache
			delete_transient('ess_grid_trans_full_grid_' . $grid['id']); //delete cache
		}

		//redirect
		$url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$url = add_query_arg([self::QUERY_TOKEN => false, self::QUERY_SHOW => 1], $url);
		wp_redirect($url);
		exit();
	}

	public function footer_js()
	{
		// we are not on esg page
		if (!isset($_GET['page']) || $_GET['page'] != 'essential-grid') return;

		//switch to source tab
		if (isset($_GET[self::QUERY_SHOW])) {
			echo "<script>jQuery(document).ready(function(){ setTimeout(function(){jQuery('.selected-source-setting').trigger('click');}, 500); });</script>";
		}

		//show error
		if (isset($_GET[self::QUERY_ESG_ERROR])) {
			$err = esc_attr__('Instagram Reports: ', 'revslider') . $_GET[self::QUERY_ESG_ERROR];
			echo '<script>jQuery(document).ready(function(){ AdminEssentials.showInfo({content: "' . $err . '", type: "warning", showdelay: 0, hidedelay: 0, hideon: "click", event: ""}) });</script>';
		}
	}

	public static function get_login_url()
	{
		$app_id = '677807423170942';
		$redirect = 'https://updates.themepunch.tools/ig/auth.php';
		$create = isset($_GET['create']) ? $_GET['create'] : '';
		$state = base64_encode(admin_url('admin.php?page=essential-grid&view=grid-create&create=' . $create));
		return sprintf(
			'https://api.instagram.com/oauth/authorize?app_id=%s&redirect_uri=%s&response_type=code&scope=user_profile,user_media&state=%s',
			$app_id,
			$redirect,
			$state
		);
	}

	/**
	 * return instagram api object
	 *
	 * @param string $token
	 * @return InstagramBasicDisplay
	 */
	public function getInstagram($token)
	{
		if (empty($this->instagram[$token])) {
			$this->instagram[$token] = new InstagramBasicDisplay($token);
		}
		return $this->instagram[$token];
	}

	/**
	 * refresh Instagram token if needed
	 *
	 * @param string $token Instagram Access Token
	 * @return mixed
	 */
	protected function _refresh_token($token)
	{
		$transient_token_name = 'revslider_insta_token_' . md5($token);
		if ($this->transient_token_sec > 0 && false !== ($data = get_transient($transient_token_name))) {
			return;
		}

		$instagram = $this->getInstagram($token);
		//$refresh contain new token, however old token expiry date also updated, so we could still use it
		$refresh = $instagram->refreshToken($token);
		set_transient($transient_token_name, $token, $this->transient_token_sec);
	}

	/**
	 * get grid transient name
	 *
	 * @param int $grid_handle grid handle
	 * @param string $token
	 * @param int $count
	 */
	public function get_esg_transient_name($grid_handle, $token, $count)
	{
		$cacheKey = 'instagram' . '-' . $grid_handle . '-' . $token . '-' . $count;
		return 'essgrid_' . md5($cacheKey);
	}

	/**
	 * clear grid transient
	 *
	 * @param int $grid_handle grid handle
	 * @param string $token
	 * @param int $count
	 */
	public function clear_esg_transient($grid_handle, $token, $count)
	{
		$transient_name = $this->get_esg_transient_name($grid_handle, $token, $count);
		delete_transient($transient_name);
	}

	/**
	 * Get Instagram User Pictures
	 *
	 * @param int $grid_handle grid handle
	 * @param string $token Instagram Access Token
	 * @param string $count media count
	 * @param string $orig_image
	 * @return mixed
	 * @since    3.0
	 */
	public function get_public_photos($grid_handle, $token, $count, $orig_image)
	{

		if (empty($token)) {
			return 'esg_stream_failure';
		}

		//Getting instragram images
		$this->_refresh_token($token);
		$instagram = $this->getInstagram($token);

		$transient_name = $this->get_esg_transient_name($grid_handle, $token, $count);
		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name))) {
			$this->stream = $data;
			return $this->stream;
		} else {
			delete_transient($transient_name);
		}

		//Getting instagram images
		$medias = $instagram->getUserMedia('me', $count);

		if (isset($medias->data)) {
			$this->instagram_output_array($medias->data, $count, $orig_image);
		}
		if (!empty($this->stream)) {
			set_transient($transient_name, $this->stream, $this->transient_sec);
			return $this->stream;
		} else {
			return 'esg_stream_failure';
		}

	}

	/**
	 * Prepare output array $stream
	 *
	 * @param string $photos Instagram Output Data
	 * @since    3.0
	 */
	private function instagram_output_array($photos, $count, $orig_image)
	{
		foreach ($photos as $photo) {
			$text = empty($photo->caption) ? '' : $photo->caption;

			$stream['id'] = $photo->id;

			if ($photo->media_type != "VIDEO") {
				$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				$stream['custom-image-url'] = $photo->media_url; //image for entry
				$stream['custom-html5-mp4'] = '';
			} else {
				$stream['custom-type'] = 'html5'; //image, vimeo, youtube, soundcloud, html
				$stream['custom-html5-mp4'] = $photo->media_url;
				$stream['custom-image-url'] = $photo->thumbnail_url; //image for entry
			}

			$stream['post-link'] = $photo->permalink;
			$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
			$text = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $text);
			$stream['title'] = $text;
			$stream['content'] = $text;
			$stream['date_modified'] = $photo->timestamp;
			$stream['date'] = date_i18n(get_option('date_format'), strtotime($photo->timestamp));
			$stream['author_name'] = $photo->username;

			$this->stream[] = $stream;
		}
		return $count;
	}

}


/**
 * Flickr
 *
 * with help of the API this class delivers all kind of Images from flickr
 *
 * @package    socialstreams
 * @subpackage socialstreams/flickr
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Flickr
{

	/**
	 * API key
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $api_key flickr API key
	 */
	private $api_key;

	/**
	 * API params
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $api_param_defaults Basic params to call with API
	 */
	private $api_param_defaults;

	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	/**
	 * Basic URL
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $flickr_url Url to fetch user from
	 */
	private $flickr_url;

	/**
	 * Transient seconds
	 *
	 * @since    3.0
	 * @access   private
	 * @var      number $transient Transient time in seconds
	 */
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $api_key flickr API key.
	 * @since    3.0
	 */
	public function __construct($api_key, $transient_sec = 86400)
	{
		$this->api_key = $api_key;
		$this->api_param_defaults = array(
			'api_key' => $this->api_key,
			'format' => 'json',
			'nojsoncallback' => 1,
		);
		$this->transient_sec = $transient_sec;
	}

	/**
	 * Calls Flicker API with set of params, returns json
	 *
	 * @param array $params Parameter build for API request
	 * @since    3.0
	 */
	private function call_flickr_api($params)
	{
		//build url
		$encoded_params = array();
		foreach ($params as $k => $v) {
			$encoded_params[] = urlencode($k) . '=' . urlencode($v);
		}

		//call the API and decode the response
		$url = "https://api.flickr.com/services/rest/?" . implode('&', $encoded_params);

		$transient_name = 'revslider_' . md5($url);

		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			// return ($data);

			$rsp = json_decode(wp_remote_fopen($url));

		if (isset($rsp->stat) && $rsp->stat == "fail") {
			return 'esg_stream_failure';
		} else {
			set_transient($transient_name, $rsp, $this->transient_sec);
			return $rsp;
		}
	}

	/**
	 * Get User ID from its URL
	 *
	 * @param string $user_url URL of the Gallery
	 * @since    3.0
	 */
	public function get_user_from_url($user_url)
	{
		//gallery params
		$user_params = $this->api_param_defaults + array(
				'method' => 'flickr.urls.lookupUser',
				'url' => $user_url,
			);

		//set User Url
		$this->flickr_url = $user_url;

		//get gallery info
		$user_info = $this->call_flickr_api($user_params);
		if (isset($user_info->user->id))
			return $user_info->user->id;
		else
			return false;
	}

	/**
	 * Get Group ID from its URL
	 *
	 * @param string $group_url URL of the Gallery
	 * @since    3.0
	 */
	public function get_group_from_url($group_url)
	{
		//gallery params
		$group_params = $this->api_param_defaults + array(
				'method' => 'flickr.urls.lookupGroup',
				'url' => $group_url,
			);

		//set User Url
		$this->flickr_url = $group_url;

		//get gallery info
		$group_info = $this->call_flickr_api($group_params);
		if (isset($group_info->group->id))
			return $group_info->group->id;
		else
			return false;
	}

	/**
	 * Get Public Photos
	 *
	 * @param string $user_id flicker User id (not name)
	 * @param int $item_count number of photos to pull
	 * @since    3.0
	 */
	public function get_public_photos($user_id, $item_count = 10)
	{
		//public photos params
		$public_photo_params = $this->api_param_defaults + array(
				'method' => 'flickr.people.getPublicPhotos',
				'user_id' => $user_id,
				'extras' => 'description, license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o',
				'per_page' => $item_count,
				'page' => 1
			);

		//get photo list
		$public_photos_list = $this->call_flickr_api($public_photo_params);
		if (isset($public_photos_list->photos->photo))
			$this->flickr_output_array($public_photos_list->photos->photo);

		return $this->stream;
	}

	/**
	 * Get Photosets List from User
	 *
	 * @param string $user_id flicker User id (not name)
	 * @param int $item_count number of photos to pull
	 * @since    3.0
	 */
	public function get_photo_sets($user_id, $item_count, $current_photoset)
	{ 
		$photo_set_params = $this->api_param_defaults + array(
				'method' => 'flickr.photosets.getList',
				'user_id' => $user_id,
				'per_page' => $item_count,
				'page' => 1
			);

		//get photoset list
		$photo_sets_list = $this->call_flickr_api($photo_set_params);

		foreach ($photo_sets_list->photosets->photoset as $photo_set) {
			if (empty($photo_set->title->_content)) $photo_set->title->_content = "";
			if (empty($photo_set->photos)) $photo_set->photos = 0;
			$return[] = '<option title="' . $photo_set->description->_content . '" ' . selected($photo_set->id, $current_photoset, false) . ' value="' . $photo_set->id . '">' . $photo_set->title->_content . ' (' . $photo_set->photos . ' photos)</option>';
		}

		return $return;
	}

	/**
	 * Get Photoset Photos
	 *
	 * @param string $photo_set_id Photoset ID
	 * @param int $item_count number of photos to pull
	 * @since    3.0
	 */
	public function get_photo_set_photos($photo_set_id, $item_count = 10)
	{
		$this->stream = array();
		$photo_set_params = $this->api_param_defaults + array(
				'method' => 'flickr.photosets.getPhotos',
				'photoset_id' => $photo_set_id,
				'per_page' => $item_count,
				'page' => 1,
				'extras' => 'license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o'
			);

		//get photo list
		$photo_set_photos = $this->call_flickr_api($photo_set_params);
		$this->flickr_output_array($photo_set_photos->photoset->photo);

		return $this->stream;
	}

	/**
	 * Get Groop Pool Photos
	 *
	 * @param string $group_id Photoset ID
	 * @param int $item_count number of photos to pull
	 * @since    3.0
	 */
	public function get_group_photos($group_id, $item_count = 10)
	{
		//photoset photos params
		$group_pool_params = $this->api_param_defaults + array(
				'method' => 'flickr.groups.pools.getPhotos',
				'group_id' => $group_id,
				'per_page' => $item_count,
				'page' => 1,
				'extras' => 'license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o'
			);

		//get photo list
		$group_pool_photos = $this->call_flickr_api($group_pool_params);
		if (isset($group_pool_photos->photos->photo))
			$this->flickr_output_array($group_pool_photos->photos->photo);

		return $this->stream;
	}

	/**
	 * Get Gallery ID from its URL
	 *
	 * @param string $gallery_url URL of the Gallery
	 * @param int $item_count number of photos to pull
	 * @since    3.0
	 */
	public function get_gallery_from_url($gallery_url)
	{
		$gallery_params = $this->api_param_defaults + array(
				'method' => 'flickr.urls.lookupGallery',
				'url' => $gallery_url,
			);

		//get gallery info
		$gallery_info = $this->call_flickr_api($gallery_params);
		if (isset($gallery_info->gallery->id))
			return $gallery_info->gallery->id;
	}

	/**
	 * Get Gallery Photos
	 *
	 * @param string $gallery_id flicker Gallery id (not name)
	 * @param int $item_count number of photos to pull
	 * @since    3.0
	 */
	public function get_gallery_photos($gallery_id, $item_count = 10)
	{
		$gallery_photo_params = $this->api_param_defaults + array(
				'method' => 'flickr.galleries.getPhotos',
				'gallery_id' => $gallery_id,
				'extras' => 'description, license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o',
				'per_page' => $item_count,
				'page' => 1
			);

		//get photo list
		$gallery_photos_list = $this->call_flickr_api($gallery_photo_params);
		if (isset($gallery_photos_list->photos->photo))
			$this->flickr_output_array($gallery_photos_list->photos->photo);

		return $this->stream;
	}

	/**
	 * Prepare output array $stream
	 *
	 * @param string $photos flickr Output Data
	 * @since    3.0
	 */
	private function flickr_output_array($photos)
	{
		foreach ($photos as $photo) {
			$stream = array();

			$image_url = @array(
				'Square' => array($photo->url_sq, $photo->width_sq, $photo->height_sq),
				'Large Square' => array($photo->url_q, $photo->width_q, $photo->height_q),
				'Thumbnail' => array($photo->url_t, $photo->width_t, $photo->height_t),
				'Small' => array($photo->url_s, $photo->width_s, $photo->height_s),
				'Small 320' => array($photo->url_n, $photo->width_n, $photo->height_n),
				'Medium' => array($photo->url_m, $photo->width_m, $photo->height_m),
				'Medium 640' => array($photo->url_z, $photo->width_z, $photo->height_z),
				'Medium 800' => array($photo->url_c, $photo->width_c, $photo->height_c),
				'Large' => array($photo->url_l, $photo->width_l, $photo->height_l),
				'Original' => array($photo->url_o, $photo->width_o, $photo->height_o),
			);

			$stream['id'] = $photo->id;
			$stream['custom-image-url'] = $image_url; //image for entry
			$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
			$stream['title'] = $photo->title;
			if (!empty($photo->description->_content)) {
				$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
				$text = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $photo->description->_content);
				$stream['content'] = $text;
			}

			$stream['date'] = date_i18n(get_option('date_format'), strtotime($photo->datetaken));
			$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($photo->datetaken));
			$stream['author_name'] = $photo->ownername;

			$stream['views'] = $photo->views;
			$stream['views_short'] = Essential_Grid_Base::thousandsViewFormat($photo->views);
			$stream['tag_list'] = str_replace(" ", ",", $photo->tags);

			$stream['post-link'] = 'http://flic.kr/p/' . $this->base_encode($photo->id);

			//get favorites
			$photo_fovorites_params = $this->api_param_defaults + array(
					'method' => 'flickr.photos.getFavorites',
					'photo_id' => $photo->id,
					'per_page' => 1,
					'page' => 1
				);
			$photo_favorites = $this->call_flickr_api($photo_fovorites_params);
			if (!empty($photo_favorites->photo->total)) {
				$stream['favorites'] = $photo_favorites->photo->total;
				$stream['favorites_short'] = Essential_Grid_Base::thousandsViewFormat($photo_favorites->photo->total);
			}

			//get comments
			$photo_info_params = $this->api_param_defaults + array(
					'method' => 'flickr.photos.getInfo',
					'photo_id' => $photo->id,
					'per_page' => 1,
					'page' => 1
				);
			$photo_infos = $this->call_flickr_api($photo_info_params);

			$stream['num_comments'] = $photo_infos->photo->comments->_content;

			$this->stream[] = $stream;
		}
	}

	/**
	 * Encode the flickr ID for URL (base58)
	 *
	 * @param string $num flickr photo id
	 * @since    3.0
	 */
	private function base_encode($num, $alphabet = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ')
	{
		$base_count = strlen($alphabet);
		$encoded = '';
		while ($num >= $base_count) {
			$div = $num / $base_count;
			$mod = ($num - ($base_count * intval($div)));

			/* 2.1.5 */
			$mod = intval($mod);
			$encoded = $alphabet[$mod] . $encoded;

			$num = intval($div);
		}
		if ($num) $encoded = $alphabet[$num] . $encoded;
		return $encoded;
	}
}

/**
 * Youtube
 *
 * with help of the API this class delivers all kind of Images/Videos from youtube
 *
 * @package    socialstreams
 * @subpackage socialstreams/youtube
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Youtube
{

	/**
	 * API key
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $api_key Youtube API key
	 */
	private $api_key;

	/**
	 * Channel ID
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $channel_id Youtube Channel ID
	 */
	private $channel_id;

	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	/**
	 * Transient seconds
	 *
	 * @since    3.0
	 * @access   private
	 * @var      number $transient Transient time in seconds
	 */
	private $transient_sec;

	/**
	 * Next page ID
	 *
	 * @since    3.2.6
	 * @access   private
	 * @var      string $nextpage give ID where the next page starts
	 */
	private $nextpage;

	/**
	 * No Cookie URL
	 *
	 * @since    3.0
	 * @access   private
	 * @var      boolean $enable_youtube_nocookie Enable no cookie URL
	 */
	private $enable_youtube_nocookie;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $api_key Youtube API key.
	 * @since    3.0
	 */
	public function __construct($api_key, $channel_id, $transient_sec = 86400)
	{
		$this->api_key = $api_key;
		$this->channel_id = $channel_id;
		$this->transient_sec = $transient_sec;
		$this->enable_youtube_nocookie = get_option('tp_eg_enable_youtube_nocookie', 'false');
		$this->nextpage = "";
	}


	/**
	 * Get Youtube Playlists
	 *
	 * @since    3.0
	 */
	public function get_playlists()
	{
		//call the API and decode the response
		$playlists = array();
		//first call to get playlists
		$url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId=" . $this->channel_id . "&maxResults=50&key=" . $this->api_key;
		$rsp = json_decode(wp_remote_fopen($url));
		$playlists = $rsp->items;
		//generate as many calls as playlist pages are available
		$supervisor_count = 10;
		$nextpage = empty($rsp->nextPageToken) ? '' : $rsp->nextPageToken;
		while (!empty($rsp->nextPageToken) && $supervisor_count) {
			$url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId=" . $this->channel_id . "&maxResults=50&key=" . $this->api_key . "&page_token=" . $rsp->nextPageToken;
			$rsp = json_decode(wp_remote_fopen($url));
			$playlists = array_merge($playlists, $rsp->items);
			$nextpage = empty($rsp->nextPageToken) ? '' : $rsp->nextPageToken;
			$supervisor_count--;
		}

		return $playlists;
	}

	/**
	 * Get Youtube Playlist Items
	 *
	 * @param string $playlist_id Youtube Playlist ID
	 * @param integer $count Max videos count
	 * @since    3.0
	 */
	public function show_playlist_videos($playlist_id, $count = 50)
	{
		$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" . $playlist_id . "&key=" . $this->api_key;
		$transient_name = 'essgrid_' . md5($url) . '&count=' . $count;
		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return ($data);

		$fetch_result = $this->_fetch_videos($url, $count, 'youtube_playlist_output_array');
		if ($fetch_result != true) return $fetch_result;

		set_transient($transient_name, $this->stream, $this->transient_sec);
		return $this->stream;
	}

	public function show_playlist_overview($count = 50)
	{
		$url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&channelId=" . $this->channel_id . "&key=" . $this->api_key;
		$transient_name = 'essgrid_' . md5($url) . '&count=' . $count;
		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name))) {
			return ($data);
		}

		$fetch_result = $this->_fetch_videos($url, $count, 'youtube_playlist_overview_output_array');
		if ($fetch_result != true) return $fetch_result;

		set_transient($transient_name, $this->stream, $this->transient_sec);

		return $this->stream;
	}

	/**
	 * Get Youtube Channel Items
	 *
	 * @param integer $count Max videos count
	 * @since    3.0
	 */
	public function show_channel_videos($count = 50)
	{
		$url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=" . $this->channel_id . "&key=" . $this->api_key . "&order=date";
		$transient_name = 'essgrid_' . md5($url) . '&count=' . $count;
		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return ($data);

		$fetch_result = $this->_fetch_videos($url, $count, 'youtube_channel_output_array');
		if ($fetch_result != true) return $fetch_result;

		set_transient($transient_name, $this->stream, $this->transient_sec);
		
		return $this->stream;
	}
	
	protected function _fetch_videos($url, $count = 50, $fill_output_array)
	{
		$original_count = $count;
		$supervisor_count = 0;
		do {
			if ($original_count == -1) $count = 50;
			$nextpage = empty($page_rsp->nextPageToken) ? '' : "&pageToken=" . $page_rsp->nextPageToken;
			$supervisor_count++;
			$maxResults = $original_count > 50 || $original_count == -1 ? 50 : $original_count;
			
			$page_rsp = json_decode(wp_remote_fopen($url . "&maxResults=" . $maxResults . $nextpage));
			if (!empty($page_rsp) && !isset($page_rsp->error->message)) {
				$count = $this->$fill_output_array($page_rsp->items, $count);
			} else {
				return 'esg_stream_failure';
			}
		} while (
			($original_count == -1 || sizeof($this->stream) < $original_count)
			&& $supervisor_count < 20 
			&& !empty($page_rsp->nextPageToken)
		);
		
		return true;
	}

	/**
	 * Get Playlists from Channel as Options for Selectbox
	 *
	 * @since    3.0
	 */
	public function get_playlist_options($current_playlist = "")
	{
		$return = array();
		$playlists = $this->get_playlists();
		$count = 1;
		if (!empty($playlists)) {
			foreach ($playlists as $playlist) {
				$return[] = '<option data-count="' . $count++ . '" title="' . $playlist->snippet->description . '" ' . selected($playlist->id, $current_playlist, false) . ' value="' . $playlist->id . '">' . $playlist->snippet->title . '</option>"';
			}
		}
		
		return $return;
	}

	/**
	 * Prepare output array $stream for Youtube Playlist Overview
	 *
	 * @param string $videos Youtube Output Data
	 * @since    3.0
	 */
	private function youtube_playlist_overview_output_array($videos, $count)
	{
		foreach ($videos as $video) {
			$stream = array();
			if ($count > 0) {
				$count--;
				$image_url = @array(
					'default' => array($video->snippet->thumbnails->default->url, $video->snippet->thumbnails->default->width, $video->snippet->thumbnails->default->height),
					'medium' => array($video->snippet->thumbnails->medium->url, $video->snippet->thumbnails->medium->width, $video->snippet->thumbnails->medium->height),
					'high' => array($video->snippet->thumbnails->high->url, $video->snippet->thumbnails->high->width, $video->snippet->thumbnails->high->height),
					'standard' => array($video->snippet->thumbnails->standard->url, $video->snippet->thumbnails->standard->width, $video->snippet->thumbnails->standard->height),
					'maxres' => array(str_replace('hqdefault', 'maxresdefault', $video->snippet->thumbnails->high->url), 1500, 900)
				);

				$stream['id'] = $video->id;
				$stream['custom-image-url'] = $image_url; //image for entry
				$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				$stream['post-link'] = 'https://www.youtube.com/playlist?list=' . $video->id;
				$stream['title'] = $video->snippet->title;
				$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
				$text = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $video->snippet->description);
				$stream['content'] = $text;

				$stream['date'] = date_i18n(get_option('date_format'), strtotime($video->snippet->publishedAt));
				$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($video->snippet->publishedAt));

				$stream['author_name'] = $video->snippet->channelTitle;

				$stream['itemCount'] = $video->contentDetails->itemCount;

				$this->stream[] = $stream;
			}
		}
		return $count;
	}

	/**
	 * Prepare output array $stream for Youtube Playlist
	 *
	 * @param string $videos Youtube Output Data
	 * @since    3.0
	 */
	private function youtube_playlist_output_array($videos, $count)
	{
		foreach ($videos as $video) {
			$stream = array();

			if ($count > 0) {
				$count--;
				$image_url = @array(
					'default' => array($video->snippet->thumbnails->default->url, $video->snippet->thumbnails->default->width, $video->snippet->thumbnails->default->height),
					'medium' => array($video->snippet->thumbnails->medium->url, $video->snippet->thumbnails->medium->width, $video->snippet->thumbnails->medium->height),
					'high' => array($video->snippet->thumbnails->high->url, $video->snippet->thumbnails->high->width, $video->snippet->thumbnails->high->height),
					'standard' => array($video->snippet->thumbnails->standard->url, $video->snippet->thumbnails->standard->width, $video->snippet->thumbnails->standard->height),
					'maxres' => array(str_replace('hqdefault', 'maxresdefault', $video->snippet->thumbnails->high->url), 1500, 900)
				);

				$stream['id'] = $video->snippet->resourceId->videoId;
				$stream['custom-image-url'] = $image_url; //image for entry
				$stream['custom-type'] = 'youtube'; //image, vimeo, youtube, soundcloud, html
				$stream['custom-youtube'] = $video->snippet->resourceId->videoId;
				$stream['post-link'] = 'https://www.youtube.com/watch?v=' . $video->snippet->resourceId->videoId;
				if ($this->enable_youtube_nocookie != "false") $stream['post-link'] = 'https://www.youtube-nocookie.com/embed/' . $video->snippet->resourceId->videoId;
				$stream['title'] = $video->snippet->title;
				$stream['channel_title'] = $video->snippet->channelTitle;
				$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
				$text = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $video->snippet->description);
				$stream['content'] = $text;

				$stream['date'] = $video->snippet->publishedAt;
				$stream['date_modified'] = $video->snippet->publishedAt;
				$stream['author_name'] = $video->snippet->channelTitle;

				$video_stats = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $video->snippet->resourceId->videoId . "&key=" . $this->api_key);
				$video_stats = json_decode($video_stats);
				$stream['views'] = $video_stats->items[0]->statistics->viewCount;
				$stream['views_short'] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->viewCount);
				$stream["likes"] = $video_stats->items[0]->statistics->likeCount;
				$stream["likes_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->likeCount);
				$stream["dislikes"] = $video_stats->items[0]->statistics->dislikeCount;
				$stream["dislikes_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->dislikeCount);
				$stream["favorites"] = $video_stats->items[0]->statistics->favoriteCount;
				$stream["favorites_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->favoriteCount);
				$stream["num_comments"] = $video_stats->items[0]->statistics->commentCount;
				$stream["num_comments_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->commentCount);

				$this->stream[] = $stream;
			}
		}
		return $count;
	}

	/**
	 * Prepare output array $stream for Youtube channel
	 *
	 * @param string $videos Youtube Output Data
	 * @since    3.0
	 */
	private function youtube_channel_output_array($videos, $count)
	{
		foreach ($videos as $video) {
			if (!empty($video->id->videoId) && $count > 0) {
				$stream = array();
				$count--;
				$image_url = @array(
					'default' => array($video->snippet->thumbnails->default->url, $video->snippet->thumbnails->default->width, $video->snippet->thumbnails->default->height),
					'medium' => array($video->snippet->thumbnails->medium->url, $video->snippet->thumbnails->medium->width, $video->snippet->thumbnails->medium->height),
					'high' => array($video->snippet->thumbnails->high->url, $video->snippet->thumbnails->high->width, $video->snippet->thumbnails->high->height),
					'standard' => array($video->snippet->thumbnails->standard->url, $video->snippet->thumbnails->standard->width, $video->snippet->thumbnails->standard->height),
					'maxres' => array(str_replace('hqdefault', 'maxresdefault', $video->snippet->thumbnails->high->url), 1500, 900),
				);

				$stream['id'] = $video->id->videoId;
				$stream['custom-image-url'] = $image_url; //image for entry
				$stream['custom-type'] = 'youtube'; //image, vimeo, youtube, soundcloud, html
				$stream['custom-youtube'] = $video->id->videoId;
				$stream['post-link'] = 'https://www.youtube.com/watch?v=' . $video->id->videoId;
				if ($this->enable_youtube_nocookie != "false") $stream['post-link'] = 'https://www.youtube-nocookie.com/embed/' . $video->id->videoId;
				$stream['title'] = $video->snippet->title;
				$stream['channel_title'] = $video->snippet->channelTitle;
				$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
				$text = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $video->snippet->description);
				$stream['content'] = $text;
				$stream['date'] = date_i18n(get_option('date_format'), strtotime($video->snippet->publishedAt));
				$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($video->snippet->publishedAt));
				$stream['author_name'] = $video->snippet->channelTitle;

				$video_stats = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $video->id->videoId . "&key=" . $this->api_key);
				$video_stats = json_decode($video_stats);
				$stream['views'] = $video_stats->items[0]->statistics->viewCount;
				$stream['views_short'] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->viewCount);
				$stream["likes"] = $video_stats->items[0]->statistics->likeCount;
				$stream["likes_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->likeCount);
				$stream["dislikes"] = $video_stats->items[0]->statistics->dislikeCount;
				$stream["dislikes_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->dislikeCount);
				$stream["favorites"] = $video_stats->items[0]->statistics->favoriteCount;
				$stream["favorites_short"] = Essential_Grid_Base::thousandsViewFormat($video_stats->items[0]->statistics->favoriteCount);
				$stream["num_comments"] = $video_stats->items[0]->statistics->commentCount;

				$this->stream[] = $stream;
			}
		}
		return $count;
	}
}

/**
 * Vimeo
 *
 * with help of the API this class delivers all kind of Images/Videos from Vimeo
 *
 * @package    socialstreams
 * @subpackage socialstreams/vimeo
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Vimeo
{
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	/**
	 * Transient seconds
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      number $transient Transient time in seconds
	 */
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $api_key Youtube API key.
	 * @since    3.0
	 */
	public function __construct($transient_sec = 86400)
	{
		$this->transient_sec = $transient_sec;
	}

	/**
	 * Get Vimeo User Videos
	 *
	 * @since    3.0
	 */
	public function get_vimeo_videos($type, $value, $count)
	{
		//call the API and decode the response
		if ($type == "user") {
			$url = "https://vimeo.com/api/v2/" . $value . "/videos.json?count=" . $count;
		} else {
			$url = "https://vimeo.com/api/v2/" . $type . "/" . $value . "/videos.json?count=" . $count;
		}

		$transient_name = 'essgrid_' . md5($url);
		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return ($data);

		if ($count > 20) {
			$runs = ceil($count / 20);
			$supervisor_count = 0;
			for ($i = 0; $i < $runs && $supervisor_count < 20; $i++) {
				$page_rsp = json_decode(wp_remote_fopen($url . "&page=" . ($i + 1)));
				$supervisor_count++;
				if (!empty($page_rsp)) {
					$count = $count - 20;
					$this->vimeo_output_array($page_rsp, $count);
				} else {
					if ($i == 0) {
						return 'esg_stream_failure';
					}
				}
			}
		} else {
			$rsp = json_decode(wp_remote_fopen($url));

			if (!empty($rsp)) {
				$this->vimeo_output_array($rsp, $count);
			} else {
				return 'esg_stream_failure';
			}
		}
		set_transient($transient_name, $this->stream, $this->transient_sec);

		return $this->stream;
	}

	/**
	 * Prepare output array $stream for Vimeo videos
	 *
	 * @param string $videos Vimeo Output Data
	 * @since    3.0
	 */
	private function vimeo_output_array($videos, $count)
	{
		if (is_array($videos))
			foreach ($videos as $video) {
				if ($count-- == 0) break;

				$stream = array();
				$image_url = @array(
					'thumbnail_small' => array($video->thumbnail_small),
					'thumbnail_medium' => array($video->thumbnail_medium),
					'thumbnail_large' => array($video->thumbnail_large),
				);

				$stream['custom-image-url'] = $image_url; //image for entry
				$stream['custom-type'] = 'vimeo'; //image, vimeo, youtube, soundcloud, html
				$stream['custom-vimeo'] = $video->id;
				$stream['id'] = $video->id;
				$stream['post-link'] = $video->url;
				$stream['title'] = $video->title;
				$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
				$text = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', $video->description);
				$stream['content'] = $text;
				$stream['date'] = date_i18n(get_option('date_format'), strtotime($video->upload_date));
				$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($video->upload_date));
				$stream['author_name'] = $video->user_name;
				$minutes = floor($video->duration / 60);
				$seconds = $video->duration % 60;
				$seconds = $seconds < 10 ? '0' . $seconds : $seconds;
				$stream['duration'] = $minutes . ':' . $seconds;
				$stream['tag_list'] = $video->tags;
				$stream["likes"] = isset($video->stats_number_of_likes) ? $video->stats_number_of_likes : 0;
				$stream["likes_short"] = isset($video->stats_number_of_likes) ? Essential_Grid_Base::thousandsViewFormat($video->stats_number_of_likes) : 0;
				$stream["views"] = isset($video->stats_number_of_plays) ? $video->stats_number_of_plays : 0;
				$stream["views_short"] = isset($video->stats_number_of_plays) ? Essential_Grid_Base::thousandsViewFormat($video->stats_number_of_plays) : 0;
				$stream["num_comments"] = isset($video->stats_number_of_comments) ? $video->stats_number_of_comments : 0;

				$this->stream[] = $stream;
			}
	}
}

/**
 * Behance
 *
 * with help of the API this class delivers all kind of Images/Projects from Behance
 *
 * @package    socialstreams
 * @subpackage socialstreams/behance
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Behance
{
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	/**
	 * API key
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $api_key Youtube API key
	 */
	private $api_key;

	/**
	 * User ID
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $user_id Behance User ID
	 */
	private $user_id;

	/**
	 * Transient seconds
	 *
	 * @since    3.0
	 * @access   private
	 * @var      number $transient Transient time in seconds
	 */
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $api_key Youtube API key.
	 * @since    3.0
	 */
	public function __construct($api_key, $user_id, $transient_sec = 0)
	{
		$this->api_key = $api_key;
		$this->user_id = $user_id;
		$this->transient_sec = 0;//$transient_sec;
		$this->stream = array();
	}

	/**
	 * Get Behance User Projects
	 *
	 * @since    3.0
	 */
	public function get_behance_projects($count = 12)
	{
		//call the API and decode the response
		$url = "https://www.behance.net/v2/users/" . $this->user_id . "/projects?api_key=" . $this->api_key . "&per_page=" . $count;

		$transient_name = 'essgrid_' . md5($url);

		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return ($data);

		$rsp = json_decode(wp_remote_fopen($url));

		if (!empty($rsp)) {
			$this->behance_output_array($rsp);
			set_transient($transient_name, $this->stream, $this->transient_sec);
			return $this->stream;
		}
	}

	/**
	 * Get Playlists from Channel as Options for Selectbox
	 *
	 * @since    3.0
	 */
	public function get_behance_projects_options($current_project = "")
	{
		//call the API and decode the response
		$url = "https://www.behance.net/v2/users/" . $this->user_id . "/projects?api_key=" . $this->api_key;
		$rsp = json_decode(wp_remote_fopen($url));

		$return = array();
		if (isset($rsp->projects))
			foreach ($rsp->projects as $project) {
				$return[] = '<option ' . selected($project->id, $current_project, false) . ' value="' . $project->id . '">' . $project->name . '</option>"';
			}
		else
			$return = var_dump($rsp);
		
		return $return;
	}

	/**
	 * Get Images from single Project
	 *
	 * @since    3.0
	 */
	public function get_behance_project_images($project = "", $count = 100)
	{
		//call the API and decode the response
		if (!empty($project)) {
			$url = "https://www.behance.net/v2/projects/" . $project . "?api_key=" . $this->api_key . "&per_page=" . $count;

			$transient_name = 'essgrid_' . md5($url);
			if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
				return ($data);

			$rsp = json_decode(wp_remote_fopen($url));
			if (!empty($rsp)) {
				$this->behance_images_output_array($rsp, $count);
				set_transient($transient_name, $this->stream, $this->transient_sec);
				return $this->stream;
			}
		}
	}

	/**
	 * Prepare output array $stream for Behance images
	 *
	 * @param string $videos Behance Output Data
	 * @since    3.0
	 */
	private function behance_images_output_array($images, $count)
	{
		if (is_object($images)) {
			foreach ($images->project->modules as $image) {
				if (!$count--) break;
				$stream = array();

				$image_url = @array(
					'disp' => array($image->sizes->disp),
					'max_86400' => array($image->sizes->max_86400),
					'max_1240' => array($image->sizes->max_1240),
					'original' => array($image->sizes->original),
				);

				$stream['custom-image-url'] = $image_url;
				$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				$stream['post-link'] = $images->project->url;
				$stream['title'] = $images->project->name;
				$stream['content'] = $images->project->name;
				$stream['date'] = date_i18n(get_option('date_format'), strtotime($images->project->modified_on));
				$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($images->project->modified_on));
				$stream['author_name'] = $images->project->owners[0]->first_name;
				$this->stream[] = $stream;
			}
		}
	}

	/**
	 * Prepare output array $stream for Behance Projects
	 *
	 * @param string $videos Behance Output Data
	 * @since    3.0
	 */
	private function behance_output_array($images)
	{
		if (is_object($images) && isset($images->projects)) {
			foreach ($images->projects as $image) {
				$stream = array();

				$image_url = @array(
					'115' => array($image->covers->{'115'}),
					'202' => array($image->covers->{'202'}),
					'230' => array($image->covers->{'230'}),
					'404' => array($image->covers->{'404'}),
					'original' => array($image->covers->original),
				);
				$stream['custom-image-url'] = $image_url;

				$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				$stream['post-link'] = $image->url;
				$stream['title'] = $image->name;
				$stream['content'] = $image->name;
				$stream['date'] = $image->modified_on;
				$stream['date_modified'] = $image->modified_on;
				$stream['author_name'] = 'dude';
				$this->stream[] = $stream;
			}
		}
	}
}

/**
 * NextGen
 *
 * show images from NextGen Albums and Galleries
 *
 * @package    socialstreams
 * @subpackage socialstreams/nextgen
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Nextgen
{
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 */
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	public function __construct()
	{

	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_album_list($current_album)
	{
		global $nggdb; //nextgen basic class

		// Galleries in Albums
		$albums = $nggdb->find_all_album();

		// Build <option>s for <select>
		$return = array();
		foreach ($albums as $album) {
			$album_details = $nggdb->find_album($album->id);
			$return[] = '<option value="' . $album_details->id . '" ' . selected($album_details->id, $current_album, false) . '>' . $album_details->name . '</option> ';
		}

		return $return;
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_gallery_list($current_gallery)
	{
		global $nggdb; //nextgen basic class

		// Galleries
		$gallerys = $nggdb->find_all_galleries();

		// Build <option>s for <select>
		$return = array();
		foreach ($gallerys as $gallery) {
			$return[] = '<option value="' . $gallery->gid . '" ' . selected($gallery->gid, $current_gallery, false) . '>' . $gallery->title . '</option> ';
		}

		return $return;
	}

	/**
	 * Prepare list of Tags options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_tag_list($current_tags)
	{
		global $nggdb; //nextgen basic class

		// Tags
		$tags = nggTags::find_all_tags();

		// Build <option>s for <select>
		$return = array();
		$current_tags = explode(",", $current_tags);
		foreach ($tags as $tag) {
			$selected = in_array($tag->term_id, $current_tags) ? 'selected' : '';
			$return[] = '<option value="' . $tag->term_id . '" ' . $selected . '>' . $tag->name . '</option> ';
		}

		return $return;
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_album_images($album_id)
	{
		global $nggdb; //nextgen basic class
		
		$galleries = $nggdb->find_album($album_id);
		$return = $this->get_gallery_images($galleries->gallery_ids);
		
		return $return;
	}

	/**
	 * Prepare list of Albums options for selectbox
	 *
	 * @since    3.0
	 */
	public function get_tags_images($tags)
	{
		global $nggdb; //nextgen basic class

		$tags = explode(",", $tags);
		$picids = get_objects_in_term($tags, 'ngg_tag');
		$mapper = C_Image_Mapper::get_instance();
		$images = array();
		foreach ($picids as $image_id) {
			$images[] = $mapper->find($image_id);
		}

		foreach ($images as $image) {
			$image = nggdb::find_image($image->pid);
			$image_url = @array(
				'thumb' => array($image->thumbnailURL),
				'original' => array($image->imageURL),
			);
			$stream['custom-image-url'] = $image_url;

			$stream['custom-type'] = 'image';
			$stream['post-link'] = $image->imageURL;
			$stream['title'] = $image->alttext;
			$stream['content'] = $image->description;
			$stream['date'] = date_i18n(get_option('date_format'), strtotime($image->imagedate));
			$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($image->imagedate));
			$this->stream[] = $stream;
		}

		return $this->stream;
	}

	public function get_gallery_images($gallery_ids)
	{
		global $nggdb;
		$counter = 0;

		foreach ($gallery_ids as $gallery_id) {

			if (!is_numeric($gallery_id) && $counter < 25) {
				$counter++;
				$galleries_inside = $nggdb->find_album(preg_replace("/[^0-9]/", "", $gallery_id));
				$return = $this->get_gallery_images($galleries_inside->gallery_ids);
			} else {
				$this->nextgen_output_array($gallery_id);
			}
		}
		return $this->stream;
	}

	public function nextgen_output_array($gallery_id)
	{
		$images = nggdb::get_gallery($gallery_id);
		foreach ($images as $image) {
			if ($image->hidden) continue;
			$image_url = @array(
				'thumb' => array($image->thumbnailURL),
				'original' => array($image->imageURL),
			);
			$stream['custom-image-url'] = $image_url;

			$stream['custom-type'] = 'image';
			$stream['post-link'] = $image->imageURL;
			$stream['title'] = $image->alttext;
			$stream['content'] = $image->description;
			$stream['date'] = date_i18n(get_option('date_format'), strtotime($image->imagedate));
			$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($image->imagedate));
			$this->stream[] = $stream;
		}
	}

}

/**
 * Real Media Library
 *
 * show images from Real Media Library Folders and Galleries
 *
 * @package    socialstreams
 * @subpackage socialstreams/nextgen
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Rml
{
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 */
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	public function __construct()
	{

	}

	public function get_images($folder_id = -1)
	{
		$query = new WP_Query(array(
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'rml_folder' => $folder_id,
			'orderby' => "rml",
			'posts_per_page' => 9999
		));

		$posts = $this->rml_output_array($query->posts);
		return $this->stream;
	}

	public static function option_list_image_sizes($selected = "")
	{
		$image_sizes = Essential_Grid_Rml::get_image_sizes();
		$options = "";
		foreach ($image_sizes as $image_name => $image_size) {
			$options .= '<option value="' . $image_name . '" ' . selected($selected, $image_name, false) . '>' . $image_name . '</option>';
		}
		$options .= '<option value="original" ' . selected($selected, "original", false) . '>original</option>';
		return $options;
	}

	public static function get_image_sizes()
	{
		global $_wp_additional_image_sizes;

		$sizes = array();
		foreach (get_intermediate_image_sizes() as $_size) {
			if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
				$sizes[$_size]['width'] = get_option("{$_size}_size_w");
				$sizes[$_size]['height'] = get_option("{$_size}_size_h");
				$sizes[$_size]['crop'] = (bool)get_option("{$_size}_crop");
			} elseif (isset($_wp_additional_image_sizes[$_size])) {
				$sizes[$_size] = array(
					'width' => $_wp_additional_image_sizes[$_size]['width'],
					'height' => $_wp_additional_image_sizes[$_size]['height'],
					'crop' => $_wp_additional_image_sizes[$_size]['crop'],
				);
			}
		}

		return $sizes;
	}

	public function rml_output_array($images)
	{
		$this->stream = array();
		$image_sizes = $this->get_image_sizes();
		foreach ($images as $image) {
			foreach ($image_sizes as $slug => $details) {
				$image_url[$slug] = wp_get_attachment_image_src($image->ID, $slug);
			}
			$image_url['original'] = array($image->guid);
			$stream['custom-image-url'] = $image_url;
			$stream['custom-type'] = 'image';
			$stream['post-link'] = $image->guid;
			$stream['title'] = $image->post_title;
			$stream['content'] = $image->post_content;
			$stream['date'] = date_i18n(get_option('date_format'), strtotime($image->post_date));
			$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($image->post_modified));

			$this->stream[] = $stream;
		}
	}
}


/**
 * Dribbble
 *
 * with help of the API this class delivers all kind of Images/Projects from Dribbble
 *
 * @package    socialstreams
 * @subpackage socialstreams/dribbble
 * @author     ThemePunch <info@themepunch.com>
 */
class Essential_Grid_Dribbble
{
	/**
	 * Stream Array
	 *
	 * @since    3.0
	 * @access   private
	 * @var      array $stream Stream Data Array
	 */
	private $stream;

	/**
	 * Client Access Token
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $client_access_token dribbble API Client Access Token
	 */
	private $client_access_token;

	/**
	 * User ID
	 *
	 * @since    3.0
	 * @access   private
	 * @var      string $user_id dribbble User ID
	 */
	private $user_id;

	/**
	 * Transient seconds
	 *
	 * @since    3.0
	 * @access   private
	 * @var      number $transient Transient time in seconds
	 */
	private $transient_sec;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0
	 */
	public function __construct($client_access_token, $user_id, $transient_sec = 0)
	{
		$this->user_id = $user_id;
		$this->client_access_token = $client_access_token;
		$this->transient_sec = 0;
		$this->stream = array();
	}

	/**
	 * Get Behance User Projects
	 *
	 * @since    3.0
	 */
	public function get_dribbble_projects($count = 100)
	{
		//call the API and decode the response
		$url = "https://www.behance.net/v2/users/" . $this->user_id . "/projects?api_key=" . $this->api_key . "&per_page=" . $count;

		$transient_name = 'essgrid_' . md5($url);
		if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
			return ($data);

		$rsp = json_decode(wp_remote_fopen($url));
		if (!empty($rsp)) {
			$this->behance_output_array($rsp);
			set_transient($transient_name, $this->stream, $this->transient_sec);
			return $this->stream;
		}
	}

	/**
	 * Get Projects from Channel as Options for Selectbox
	 *
	 * @since    3.0
	 */
	public function get_dribbble_projects_options($current_project = "")
	{
		//call the API and decode the response
		$url = 'https://api.dribbble.com/v1/users/' . $this->user_id . '/projects?access_token=' . $this->client_access_token;
		$rsp = json_decode(wp_remote_fopen($url));

		$return = array();
		if (is_array($rsp))
			foreach ($rsp as $project) {
				$return[] = '<option ' . selected($project->id, $current_project, false) . ' value="' . $project->id . '">' . $project->name . '</option>"';
			}
		else
			$return = "";
		
		return $return;
	}

	/**
	 * Get Buckets from Channel as Options for Selectbox
	 *
	 * @since    3.0
	 */
	public function get_dribbble_buckets_options($current_project = "")
	{
		//call the API and decode the response
		$url = 'https://api.dribbble.com/v1/users/' . $this->user_id . '/buckets?access_token=' . $this->client_access_token;
		$rsp = json_decode(wp_remote_fopen($url));

		$return = array();
		if (is_array($rsp))
			foreach ($rsp as $bucket) {
				$return[] = '<option ' . selected($bucket->id, $current_bucket, false) . ' value="' . $bucket->id . '">' . $bucket->name . '</option>"';
			}
		else
			$return = "";
		
		return $return;
	}

	/**
	 * Get Images from single Project
	 *
	 * @since    3.0
	 */
	public function get_dribbble_project_images($project = "", $count = 100)
	{
		//call the API and decode the response
		if (!empty($project)) {
			$url = "https://www.behance.net/v2/projects/" . $project . "?api_key=" . $this->api_key . "&per_page=" . $count;

			$transient_name = 'essgrid_' . md5($url);
			if ($this->transient_sec > 0 && false !== ($data = get_transient($transient_name)))
				return ($data);

			$rsp = json_decode(wp_remote_fopen($url));
			if (!empty($rsp)) {
				$this->behance_images_output_array($rsp, $count);
				set_transient($transient_name, $this->stream, $this->transient_sec);
				return $this->stream;
			}
		}
	}

	/**
	 * Prepare output array $stream for Behance images
	 *
	 * @param string $videos Behance Output Data
	 * @since    3.0
	 */
	private function dribbble_images_output_array($images, $count)
	{
		if (is_object($images)) {
			foreach ($images->project->modules as $image) {
				if (!$count--) break;
				$stream = array();

				if ($image->type == "image") {
					$image_url = @array(
						'disp' => array($image->sizes->disp),
						'max_86400' => array($image->sizes->max_86400),
						'max_1240' => array($image->sizes->max_1240),
						'original' => array($image->sizes->original),
					);

					$stream['custom-image-url'] = $image_url;
					$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
					$stream['post-link'] = $images->project->url;
					$stream['title'] = $images->project->name;
					$stream['content'] = $images->project->name;
					$stream['date'] = date_i18n(get_option('date_format'), strtotime($images->project->modified_on));
					$stream['date_modified'] = date_i18n(get_option('date_format'), strtotime($images->project->modified_on));
					$stream['author_name'] = $images->project->owners[0]->first_name;
					$this->stream[] = $stream;
				}
			}
		}
	}

	/**
	 * Prepare output array $stream for Behance Projects
	 *
	 * @param string $videos Behance Output Data
	 * @since    3.0
	 */
	private function dribbble_output_array($images)
	{
		if (is_object($images)) {
			foreach ($images->projects as $image) {
				$stream = array();

				$image_url = @array(
					'115' => array($image->covers->{'115'}),
					'202' => array($image->covers->{'202'}),
					'230' => array($image->covers->{'230'}),
					'404' => array($image->covers->{'404'}),
					'original' => array($image->covers->original),
				);
				$stream['custom-image-url'] = $image_url;

				$stream['custom-type'] = 'image'; //image, vimeo, youtube, soundcloud, html
				$stream['post-link'] = $image->url;
				$stream['title'] = $image->name;
				$stream['content'] = $image->name;
				$stream['date'] = $image->modified_on;
				$stream['date_modified'] = $image->modified_on;
				$stream['author_name'] = 'dude';
				$this->stream[] = $stream;
			}
		}
	}
}
