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
 * Class Kata_Plus_Pro_GZIP.
 */
class Kata_Plus_Pro_GZIP {
	/**
	 * Instance of this class.
	 *
	 * @since   4.5.7
	 * @access  public
	 * @var     Kata_Plus_Pro_GZIP
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
        self::$id = 'KATA GZIP Compression';
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
		if ( false == get_theme_mod( 'kata_plus_pro_gzip', false ) ) {
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
				$pattern = '/#\s?BEGIN KATA GZIP Compression.*?END KATA GZIP Compression/s';
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
		$htaccess_content .= '# BEGIN KATA GZIP Compression' . "\n";
		$htaccess_content .= '<IfModule mod_deflate.c>' . "\n";
		$htaccess_content .= '# Compress HTML, CSS, JavaScript, Text, XML and fonts' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/javascript' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/rss+xml' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/vnd.ms-fontobject' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/x-font' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/x-font-opentype' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/x-font-otf' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/x-font-truetype' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/x-font-ttf' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/x-javascript"' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/xhtml+xml' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE application/xml' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE font/opentype' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE font/otf' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE font/ttf' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE image/svg+xml' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE image/x-icon' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE text/css' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE text/html' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE text/javascript' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE text/plain' . "\n";
		$htaccess_content .= 'AddOutputFilterByType DEFLATE text/xml' . "\n";
		$htaccess_content .= "\n";
		$htaccess_content .= '# Remove browser bugs (only needed for ancient browsers)' . "\n";
		$htaccess_content .= 'BrowserMatch ^Mozilla/4 gzip-only-text/html' . "\n";
		$htaccess_content .= 'BrowserMatch ^Mozilla/4\.0[678] no-gzip' . "\n";
		$htaccess_content .= 'BrowserMatch \bMSIE !no-gzip !gzip-only-text/html' . "\n";
		$htaccess_content .= 'Header append Vary User-Agent' . "\n";
		$htaccess_content .= '</IfModule>' . "\n";
		$htaccess_content .= '# END KATA GZIP Compression' . "\n";

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

Kata_Plus_Pro_GZIP::get_instance();
