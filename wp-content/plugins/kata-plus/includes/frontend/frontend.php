<?php

/**
 * Frontend Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}
if (!class_exists('Kata_Plus_Frontend')) {
	class Kata_Plus_Frontend
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
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Frontend
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
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions()
		{
			self::$dir = Kata_Plus::$dir . 'includes/frontend/';
			self::$url = Kata_Plus::$url . 'includes/frontend/';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action('wp_enqueue_scripts', [$this, 'dequeue_styles'], 99999);
			add_action('wp_enqueue_scripts', [$this, 'frontend_enqueue_styles'], 10 );
			add_action('elementor/css-file/post/enqueue', [$this, 'enqueue_dynamic_styles'], 99999);
			add_action('wp_enqueue_scripts', [$this, 'enqueue_customizer_styler'], 99999);
			add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts'], 99999);
			add_action('wp_ajax_live_search', [$this, 'live_search']);
			add_action('wp_ajax_nopriv_live_search', [$this, 'live_search']);
			add_action('wp_ajax_live_login', [$this, 'live_login']);
			add_action('wp_ajax_nopriv_live_login', [$this, 'live_login']);
			add_action('wp_ajax_posts_bookmark', [$this, 'posts_bookmark']);
			add_action('wp_ajax_nopriv_posts_bookmark', [$this, 'posts_bookmark']);
			add_action('wp_ajax_set_cookie', [$this, 'set_cookie']);
			add_action('wp_ajax_nopriv_set_cookie', [$this, 'set_cookie']);
			add_action('wp_ajax_post_share_count', [$this, 'post_share_count']);
			add_action('wp_ajax_nopriv_post_share_count', [$this, 'post_share_count']);
		}

		/**
		 * Dequeue styles.
		 *
		 * @since   1.0.0
		 */
		public function dequeue_styles()
		{
			wp_dequeue_style( 'kata-grid' );
			wp_dequeue_style( 'kata-theme-styles' );
			wp_dequeue_style( 'kata-dynamic-styles' );
			wp_dequeue_style( 'kata-menu-navigation' );
			wp_dequeue_style( 'xs-front-style' );
			wp_dequeue_script( 'kata-default-scripts' );
			if ( class_exists( 'Kata_Plus_Pro' ) ) {
				wp_deregister_style( 'kata-blog-posts' );
				wp_dequeue_style( 'kata-blog-posts' );
				wp_deregister_style( 'kata-single-post' );
				wp_dequeue_style( 'kata-single-post' );
			}
		}

		/**
		 * Frontend enqueue styles.
		 *
		 * @since   1.0.0
		 */
		public function frontend_enqueue_styles() {
			if ( ! isset( $_GET["elementor-preview"] ) && ! is_admin() ) {
				wp_enqueue_style( 'grid', Kata_Plus::$assets . 'css/libraries/grid.css', [], Kata_Plus::$version );
			}
			wp_enqueue_style('kata-plus-theme-styles', Kata_Plus::$assets . 'css/frontend/theme-styles.css', [], Kata_Plus::$version);
		}

		/**
		 * Enqueue styles.
		 *
		 * @since   1.0.0
		 */
		public function enqueue_dynamic_styles() {
			wp_enqueue_style( 'kata-plus-dynamic-styles', Kata_Plus::$upload_dir_url . '/css/dynamic-styles.css', [], rand(1, 999));
			wp_enqueue_style( 'kata-plus-animations', Kata_Plus::$assets . 'css/frontend/animations.css', [], Kata_Plus::$version );
		}

		/**
		 * Enqueue styles.
		 *
		 * @since   1.0.0
		 */
		public function enqueue_customizer_styler()
		{
			wp_enqueue_style( 'kata-plus-customizer-styler', Kata_Plus::$upload_dir_url . '/css/customizer-styler.css', [], rand(1, 999) );
		}

		/**
		 * Enqueue scripts.
		 *
		 * @since   1.0.0
		 */
		public function enqueue_scripts() {

			wp_enqueue_script('kata-plus-sticky-box', Kata_Plus::$assets . 'js/frontend/sticky-box.js', ['jquery'], Kata_Plus::$version, true);
			wp_enqueue_style('kata-plus-sticky-box', Kata_Plus::$assets . 'css/frontend/sticky-box.css', [], Kata_Plus::$version);

			wp_localize_script(
				'kata-plus-theme-scripts',
				'kata_plus_localize',
				[
					'ajax'        => [
						'url'      => admin_url('admin-ajax.php'),
						'nonce'    => wp_create_nonce('kata_plus_nonce'),
						'site_url' => $_SERVER['REQUEST_URI'],
					],
					'translation' => [
						'login' => [
							'loading' => __('Please wait...', 'kata-plus'),
							'success' => __('Login was successfully, Redirecting...', 'kata-plus'),
							'fail'    => __('Your username or password is wrong', 'kata-plus'),
						],
					],
				]
			);
		}

		/**
		 * Live Search.
		 *
		 * @since   1.0.0
		 */
		public static function live_search() {
			check_ajax_referer('kata_plus_nonce', 'nonce');
			do_action('kata_plus_before_livesearch');
			$posttype	= sanitize_text_field( $_POST['posttype'] );
			$taxonomy	= sanitize_text_field( $_POST['taxonomy'] );
			$keyword	= sanitize_text_field( $_POST['keyword'] );
			$term_id	= sanitize_text_field( $_POST['term_id'] );
			$posttype	= !empty( $posttype ) && $posttype != 'all' ? array( $posttype ) : get_post_types( array( 'public' => true ) );
			$keyword	= !empty( $keyword ) ? $keyword : '';
			if ( $taxonomy ) {
				$tax_query		= [ 'relation' => 'OR' ];
				$tax_query[]	= [
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => [ $term_id ],
				];
			}
			$args = [
				'posts_per_page'	=> 10,
				'post_type'			=> $posttype,
				's'					=> $keyword,
				'tax_query'			=> $tax_query,
			];
			$live_search = new WP_Query($args);
			if ($live_search->have_posts()) : ?>
				<div class="kata-plus-search-ajax-result">
					<p class="search-result-is"><?php echo esc_html__('Results for:', 'kata-plus') . ' ' . $keyword; ?></p>
					<ul>
						<?php
						while ($live_search->have_posts()) :
							$live_search->the_post();
						?>
							<li>
								<a href="<?php echo esc_url(the_permalink()); ?>">
									<?php the_post_thumbnail(array('80', '80')); ?>
									<h4><?php the_title(); ?></h4>
								</a>
							</li>
						<?php
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			<?php
			else :
			?>
				<div class="kata-plus-search-ajax-result">
					<li>
						<h4><?php echo esc_html__('No Results for:', 'kata-plus'); ?> <strong><?php echo esc_html( $keyword ); ?></strong></h4>
					</li>
				</div>
			<?php
			endif;
			do_action('kata_plus_before_livesearch');
			wp_die();
		}

		/**
		 * Live Search.
		 * @param livesearch activate the live search function
		 * @param posttype Highlighting the search range
		 * @param placeholder search field placeholder
		 * @param button search form button value
		 * @param icon search form button icon
		 * @since   1.0.0
		 */
		public static function search( $livesearch = false, $posttype = null, $taxonomy = null, $placeholder = '', $button = '', $icon = '' ) {
			$livesearch  = $livesearch == true ? 'kata-plus-live-search' : '';
			if ( $taxonomy && $livesearch ) {
				$terms = get_terms( array(
					'taxonomy'		=> $taxonomy,
					'hide_empty'	=> false,
				) );
				$search_terms = '<select class="kt-search-term">';
				$search_terms .= '<option value="" selected>' . __( 'Select', 'kata-plus' ) . '</option>';
				foreach ( $terms as $key => $term ) {
					if ( $term->term_id && $term->name ) {
						$search_terms .= '<option value="' . esc_attr( $term->term_id ) . '">'. $term->name .'</option>';
					}
				}
				$search_terms .= '</select>';
			}
			$search_terms_status = isset( $search_terms ) ? 'kata-plus-search-by-taxonomy ' : '';
			?>
			<form role="search" method="get" class="kata-plus-search-form search-form <?php echo esc_attr( $search_terms_status . $livesearch ); ?>" action="<?php echo home_url( '/' ); ?>">
				<?php
				if ( ! empty( $icon ) || ! empty( $button ) ) {
					echo '<div class="kata-search-icon">';
					if ( isset( $search_terms ) ) {
						echo wp_kses( $search_terms, [ 'select' => [ 'class' => true ], 'option' => [ 'value' => true, 'selected' => true ] ] );
					}
					echo '<input type="search" class="search-field" data-posttype="' . esc_attr( $posttype ) . '" data-taxonomy="' . esc_attr( $taxonomy ) . '" placeholder="' . esc_attr( $placeholder ) . '" value="" name="s">' . $icon;
					if ( $button ) {
						echo '<input type="submit" class="search-submit dbg-color" value="' . esc_attr( $button ) . '">';
					}
					echo '</div>';
				} else {
					if ( isset( $search_terms ) ) {
						echo wp_kses( $search_terms, [ 'select' => [ 'class' => true ], 'option' => [ 'value' => true ] ] );
					}
					echo '<input type="search" class="search-field" data-posttype="' . esc_attr( $posttype ) . '" data-taxonomy="' . esc_attr( $taxonomy ) . '" placeholder="' . esc_attr( $placeholder ) . '" value="" name="s">';
					if( $button ) {
						echo '<input type="submit" class="search-submit dbg-color" value="' . esc_attr( $button ) . '">';
					}
				}
				?>
			</form>
			<?php if ($livesearch) { ?>
				<div class="kata-plus-search-ajax-result-wrap"></div>
			<?php }
		}


		/**
		 * Login.
		 *
		 * @since   1.0.0
		 */
		public static function login( $livelogin = false ,$custom_dashboard_link = '' , $custom_profile_link = '', $class = '' ) {
			$livelogin = $livelogin == true ? 'kata-plus-live-login' : '';
			global $wp;
			$user = wp_get_current_user();
			$current_url 	= home_url( add_query_arg( array(), $wp->request ) );
			$form_action 	= $livelogin == true ? $current_url : home_url() . '/wp-login.php';
			$dashboard_link = !empty( $custom_dashboard_link ) ? $custom_dashboard_link : get_dashboard_url( $user->ID );
			$profile_link	= !empty( $custom_profile_link ) ? $custom_profile_link : get_edit_profile_url( $user->ID );
			$username_unique = wp_unique_id( 'kata-plus' );
			$password_unique = wp_unique_id( 'kata-plus' );
			?>
			<div class="kata-login-wrap<?php echo $class ? ' ' . esc_attr( $class ) : ''; ?>">
				<?php if (!is_user_logged_in()) : ?>
					<form name="loginform" id="login-<?php echo esc_attr( wp_unique_id( 'kata-plus' ) ); ?>" class="kata-login <?php echo esc_attr($livelogin); ?>" action="<?php echo esc_url($form_action, Kata_Plus_Helpers::ssl_url()); ?>" method="post">
						<div class="status" style="display: none;"></div>
						<div class="wrap-input username">
							<label for="username-<?php echo esc_attr( $username_unique ); ?>"><?php echo __('Username', 'kata-plus'); ?></label>
							<input type="text" id="username-<?php echo esc_attr( $username_unique ); ?>" name="log" class="input" value="" size="20" placeholder="<?php echo esc_attr__( 'Username or Email', 'kata-plus' ); ?>">
						</div>
						<div class="wrap-input password">
							<label for="password-<?php echo esc_attr( $password_unique ); ?>"><?php echo __('Password', 'kata-plus'); ?></label>
							<input type="password" id="password-<?php echo esc_attr( $password_unique ); ?>" name="pwd" class="input" value="" size="20" placeholder="<?php echo esc_attr__( 'Password', 'kata-plus' ); ?>">
						</div>
						<?php echo apply_filters( 'gglcptch_display_recaptcha', '' ); ?>
						<div class="submit-lost">
							<input class="kata-button dbg-color submit_button" type="submit" value="Login" name="submit">
							<a href="<?php echo wp_lostpassword_url(); ?>" class="lost"><?php echo __('Lost your password?', 'kata-plus'); ?></a>
						</div>
					</form>
					<?php
				else :
					?>
					<div class="avatar">
						<?php echo get_avatar( $user->ID ); ?>
						<p class="user-name"><?php echo esc_html( $user->display_name ); ?></p>
					</div>
					<div class="login-btns">
						<a href="<?php echo esc_url( $profile_link, Kata_Plus_Helpers::ssl_url() ); ?>" class="kata-button dbg-color profile df-color-h"><?php echo __('Profile', 'kata-plus'); ?></a>
						<a href="<?php echo esc_url( $dashboard_link, Kata_Plus_Helpers::ssl_url() ); ?>" class="kata-button dbg-color profile df-color-h"><?php echo __('Dashboard', 'kata-plus'); ?></a>
						<a href="<?php echo wp_logout_url(esc_url($current_url, Kata_Plus_Helpers::ssl_url())); ?>" class="kata-button dbg-color login_button df-color-h"><?php echo __('Logout', 'kata-plus'); ?></a>
					</div>
					<?php
				endif; ?>
			</div>
			<?php
		}


		/**
		 * Posts Book Mark.
		 *
		 * @since   1.0.0
		 */

		public static function posts_bookmark() {
			check_ajax_referer('kata_plus_nonce', 'nonce');
			if ( ! is_user_logged_in() ) {
				return wp_send_json_error( 'Please log in to be able to use Bookmark.', 403 );
			}
			$bookmarked_posts = get_user_meta( get_current_user_id(), '_kata_bookmark_posts', true );
			$status = sanitize_text_field( $_POST['status'] );
			$post_id = sanitize_text_field( $_POST['post_id'] );

			switch ($status) {
				case 'add':
					if ( ! $bookmarked_posts ) {
						add_user_meta( get_current_user_id(), '_kata_bookmark_posts', [$post_id => $post_id] );
					} else {
						$bookmarked_posts[$post_id] = $post_id;
						update_user_meta( get_current_user_id(), '_kata_bookmark_posts', $bookmarked_posts );
					}
					return wp_send_json_success( [
						'message' => __( 'The post was successfully added to your Bookmark list.', 'kata-plus' ),
						'status' => 'remove'
					] , 200 );
				break;
				case 'remove':
					if ( $bookmarked_posts ) {
						unset( $bookmarked_posts[$post_id] );
						update_user_meta( get_current_user_id(), '_kata_bookmark_posts', $bookmarked_posts );
						return wp_send_json_success( [
							'message' => __( 'The post was successfully removed from your Bookmark list.', 'kata-plus' ),
							'status' => 'add'
						] , 200 );
					}
				break;
			}
			wp_die();
		}

		/**
		 * Live Login.
		 *
		 * @since   1.0.0
		 */
		public function live_login() {
			// Check nonce
			check_ajax_referer('kata_plus_nonce', 'nonce');

			$info                  = array();
			$info['user_login']    = sanitize_text_field( $_POST['username'] );
			$info['user_password'] = sanitize_text_field( $_POST['password'] );
			$info['remember']      = true;
			$user_signon           = wp_signon( $info, true );

			// Return necessary data
			if (is_wp_error($user_signon)) :
				echo json_encode(
					array(
						'loggedin' => false,
						'status'   => false,
					)
				);
			else :
				echo json_encode(
					array(
						'loggedin' => true,
						'status'   => true,
					)
				);
			endif;

			wp_die();
		}

		/**
		 * Set Cookie.
		 *
		 * @since   1.0.0
		 */
		public function set_cookie()
		{
			check_ajax_referer('kata_plus_nonce', 'nonce');
			$path = parse_url(get_option('siteurl'), PHP_URL_PATH);
			$host = parse_url(get_option('siteurl'), PHP_URL_HOST);
			setcookie('KataCookieGDPR', 'GDPR_Value', strtotime('+1 month'), $path, $host);
			wp_die();
		}

		/**
		 * post share count.
		 *
		 * @since   1.0.0
		 */
		public function post_share_count()
		{
			check_ajax_referer('kata_plus_nonce', 'nonce');
			if ( isset( $_POST ) ) {
				if ( ! get_post_meta( sanitize_text_field( $_POST['post_id'] ), 'post_share_count', true ) ) {
					add_post_meta( sanitize_text_field( $_POST['post_id'] ), 'post_share_count', 1 );
				} else {
					$post_meta = get_post_meta( sanitize_text_field( $_POST['post_id'] ), 'post_share_count', true ) + 1;
					update_post_meta( sanitize_text_field( $_POST['post_id'] ), 'post_share_count', $post_meta );
				}
			}
			echo get_post_meta( sanitize_text_field( $_POST['post_id'] ), 'post_share_count', true );
			wp_die();
		}

		/**
		 * Social Share.
		 *
		 * @since   1.0.0
		 */
		public static function kata_plus_social_share($socials = array(), $socials_icon = array(), $socials_image = array(), $icon_image = '', $image_size = array()) {
			$size = $image_size['width'] == '' || $image_size['height'] == '' ? 'full' : array($image_size['width'], $image_size['height']);
			echo '<div class="kata-plus-socials-icon-wrapper">';
			foreach ($socials as $social) {
				switch ($social) {
					case 'facebook':
						if ($icon_image == 'icon') {
							echo '<a href="http://www.facebook.com/sharer.php?u=' . get_the_permalink(get_the_ID()) . '" target="_blank" class="kata-social-share-facebook">
					    		' . Kata_Plus_Helpers::get_icon('', $socials_icon['facebook']) . '
								</a>';
						} else {
							echo '<span class="kata-social-share-facebook">';
							if (Kata_Plus_Helpers::string_is_contain($socials_image['facebook']['url'], 'svg')) {
								Kata_Plus_Helpers::get_attachment_svg_path($socials_image['facebook']['id'], $socials_image['facebook']['url']);
							} else {
								echo Kata_Plus_Helpers::get_image_srcset($socials_image['facebook']['id'], $size, '', array('alt' => 'facebook'));
							}
							echo '</span>';
						}
					break;
					case 'twitter':
						if ($icon_image == 'icon') {
							echo '<a href="https://twitter.com/share?url=' . get_the_permalink(get_the_ID()) . '" target="_blank" class="kata-social-share-twitter">
								' . Kata_Plus_Helpers::get_icon('', $socials_icon['twitter']) . '
								</a>';
						} else {
							echo '<span class="kata-social-share-twitter">';
							if (Kata_Plus_Helpers::string_is_contain($socials_image['twitter']['url'], 'svg')) {
								Kata_Plus_Helpers::get_attachment_svg_path($socials_image['twitter']['id'], $socials_image['twitter']['url']);
							} else {
								echo Kata_Plus_Helpers::get_image_srcset($socials_image['twitter']['id'], $size, '', array('alt' => 'twitter'));
							}
							echo '</span>';
						}
					break;
					case 'linkedin':
						if ($icon_image == 'icon') {
							echo '<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' . get_the_permalink(get_the_ID()) . '" target="_blank" class="kata-social-share-linkedin">
        							' . Kata_Plus_Helpers::get_icon('', $socials_icon['linkedin']) . '
								</a>';
						} else {
							echo '<span class="kata-social-share-linkedin">';
							if (Kata_Plus_Helpers::string_is_contain($socials_image['linkedin']['url'], 'svg')) {
								Kata_Plus_Helpers::get_attachment_svg_path($socials_image['linkedin']['id'], $socials_image['linkedin']['url']);
							} else {
								echo Kata_Plus_Helpers::get_image_srcset($socials_image['linkedin']['id'], $size, '', array('alt' => 'linkedin'));
							}
							echo '</span>';
						}
					break;
					case 'email':
						if ($icon_image == 'icon') {
							echo '<a href="mailto:? ' . get_the_permalink(get_the_ID()) . '" class="kata-social-share-email">
        						' . Kata_Plus_Helpers::get_icon('', $socials_icon['email']) . '
								</a>';
						} else {
							echo '<span class="kata-social-share-email">';
							if (Kata_Plus_Helpers::string_is_contain($socials_image['email']['url'], 'svg')) {
								Kata_Plus_Helpers::get_attachment_svg_path($socials_image['email']['id'], $socials_image['email']['url']);
							} else {
								echo Kata_Plus_Helpers::get_image_srcset($socials_image['email']['id'], $size, '', array('alt' => 'email'));
							}
							echo '</span';
						}
					break;
					case 'pinterest':
						if ($icon_image == 'icon') {
							echo '<a href="' . esc_url( 'http://pinterest.com/pin/create/button/?url=' . esc_url( get_the_permalink( get_the_ID() ) ) ) . '" target="_blank" class="kata-social-share-pinterest">
        							' . Kata_Plus_Helpers::get_icon('', $socials_icon['pinterest']) . '
								</a>';
						} else {
							echo '<span class="kata-social-share-pinterest">';
							if (Kata_Plus_Helpers::string_is_contain($socials_image['pinterest']['url'], 'svg')) {
								Kata_Plus_Helpers::get_attachment_svg_path($socials_image['pinterest']['id'], $socials_image['pinterest']['url']);
							} else {
								echo Kata_Plus_Helpers::get_image_srcset($socials_image['pinterest']['id'], $size, '', array('alt' => 'pinterest'));
							}
							echo '</span>';
						}
					break;
					case 'reddit':
						if ($icon_image == 'icon') {
							echo '<a href="' . esc_url( 'https://reddit.com/submit?url=' . esc_url ( get_the_permalink( get_the_ID() ) ) . '/&title=' . get_the_title( get_the_ID() ) ) . '" target="_blank" class="kata-social-share-reddit">
        							' . Kata_Plus_Helpers::get_icon('', $socials_icon['reddit']) . '
								</a>';
						} else {
							echo '<span class="kata-social-share-reddit">';
							if (Kata_Plus_Helpers::string_is_contain($socials_image['reddit']['url'], 'svg')) {
								Kata_Plus_Helpers::get_attachment_svg_path($socials_image['reddit']['id'], $socials_image['reddit']['url']);
							} else {
								echo Kata_Plus_Helpers::get_image_srcset($socials_image['reddit']['id'], $size, '', array('alt' => 'reddit'));
							}
							echo '</span>';
						}
					break;
				}
			}
			echo '</div>';
		}
	}
	Kata_Plus_Frontend::get_instance();
}
