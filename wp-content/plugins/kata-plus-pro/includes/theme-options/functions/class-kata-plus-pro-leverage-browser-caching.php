<?php
/**
 * Leverage browser caching.
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Kata_Plus_Pro_Leverage_Browser_Caching.
 */
class Kata_Plus_Pro_Leverage_Browser_Caching {
	/**
	 * Instance of this class.
	 *
	 * @since   4.5.7
	 * @access  public
	 * @var     Kata_Plus_Pro_Leverage_Browser_Caching
	 */
	public static $instance;

	/**
	 * Unique ID for kata.
	 *
	 * @var string
	 */
	private static $id;

    /**
	 * htaccess path.
	 *
	 * @var string
	 */
	private static $htaccess;

	/**
	 * htaccess content.
	 *
	 * @var string
	 */
	private static $htaccess_content;

	/**
	 * Check if the code has already been added.
	 *
	 * @var string
	 */
	private static $has_code;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   4.5.7
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
	 * @since 4.5.7
	 * @access private
	 */
	private function __construct() {
        $this->definition();
        $this->hooks();
	}

    /**
	 * Definition.
	 *
	 * @since 4.5.7
	 * @access private
	 */
	private function definition() {
        self::$id = 'KATA Leverage Browser Caching';
		self::$htaccess = wp_normalize_path( ABSPATH . '.htaccess' );

		if ( self::has_htaccess() ) {
			self::$htaccess_content = file_get_contents( self::$htaccess );
		}
	}

    /**
	 * Hooks.
	 *
	 * @since 4.5.7
	 * @access private
	 */
    private function hooks() {
		if ( false == get_theme_mod( 'kata_plus_pro_leverage_browser_caching', false ) ) {
			self::delete();

            return;
        }

		self::write();
    }

    /**
	 * Write codes htaccess file.
	 *
	 * @since 4.5.7
	 * @access private
	 */
    private static function write() {
		if ( self::has_htaccess() ) {
			if ( strpos( self::$htaccess_content, self::$id ) !== false ) {
				self::$has_code = true;
			}

			if ( ! self::$has_code ) {
				self::$htaccess_content = self::$htaccess_content . self::codes();

				file_put_contents( self::$htaccess, self::$htaccess_content );
			}

		}
    }

    /**
	 * Delete codes htaccess file.
	 *
	 * @since 4.5.7
	 * @access private
	 */
    private static function delete() {
		if ( self::has_htaccess() ) {
			if ( strpos( self::$htaccess_content, self::$id ) !== false ) {
				self::$has_code = true;
			}

			if ( self::$has_code ) {
				$pattern = '/#\s?BEGIN KATA Leverage Browser Caching.*?END KATA Leverage Browser Caching/s';
				self::$htaccess_content = preg_replace( $pattern, '', self::$htaccess_content );
				self::$htaccess_content = preg_replace( "/\n+/","\n", self::$htaccess_content );

				file_put_contents( self::$htaccess, self::$htaccess_content );
			}
		}
    }

	/**
	 * htaccess codes.
	 *
	 * @since 4.5.7
	 * @access private
	 */
    private static function codes() {
		$htaccess_content  = "\n";
		$htaccess_content .= '# BEGIN KATA Leverage Browser Caching' . "\n";
		$htaccess_content .= '<IfModule mod_expires.c>' . "\n";
		$htaccess_content .= 'ExpiresActive On' . "\n";
		$htaccess_content .= 'ExpiresByType image/gif "access 1 year"' . "\n";
		$htaccess_content .= 'ExpiresByType image/jpg "access 1 year"' . "\n";
		$htaccess_content .= 'ExpiresByType image/jpeg "access 1 year"' . "\n";
		$htaccess_content .= 'ExpiresByType image/png "access 1 year"' . "\n";
		$htaccess_content .= 'ExpiresByType image/x-icon "access 1 year"' . "\n";
		$htaccess_content .= 'ExpiresByType text/css "access 1 month"' . "\n";
		$htaccess_content .= 'ExpiresByType text/javascript "access 1 month"' . "\n";
		$htaccess_content .= 'ExpiresByType text/html "access 1 month"' . "\n";
		$htaccess_content .= 'ExpiresByType application/javascript "access 1 month"' . "\n";
		$htaccess_content .= 'ExpiresByType application/x-javascript "access 1 month"' . "\n";
		$htaccess_content .= 'ExpiresByType application/xhtml-xml "access 1 month"' . "\n";
		$htaccess_content .= 'ExpiresByType application/pdf "access 1 month"' . "\n";
		$htaccess_content .= 'ExpiresByType application/x-shockwave-flash "access 1 month"' . "\n";
		$htaccess_content .= 'ExpiresDefault "access 1 month"' . "\n";
		$htaccess_content .= '</IfModule>' . "\n";
		$htaccess_content .= '# END KATA Leverage Browser Caching' . "\n";

		return $htaccess_content;
    }

	/**
	 * Check the htaccess file.
	 *
	 * @since 4.5.7
	 * @access private
	 */
    private static function has_htaccess() {
		if ( file_exists( self::$htaccess ) && is_readable( self::$htaccess ) && is_writable( self::$htaccess ) ) {
			return true;
		}
	}
}

Kata_Plus_Pro_Leverage_Browser_Caching::get_instance();
