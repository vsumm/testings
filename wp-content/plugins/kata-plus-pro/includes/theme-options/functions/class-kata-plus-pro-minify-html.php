<?php
/**
 * Html Minify Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.1.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Kata_Plus_Pro_Minify_HTML.
 */
class Kata_Plus_Pro_Minify_HTML {
	/**
	 * Instance of this class.
	 *
	 * @since   1.1.0
	 * @access  public
	 * @var     Kata_Plus_Pro_Minify_HTML
	 */
	public static $instance;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   1.1.0
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
	 * @since 1.1.0
	 * @access private
	 */
	private function __construct() {
        add_action( 'init', [$this, 'init_minify_html'] );
	}

    /**
	 * Minify HTML.
	 *
	 * @since 1.1.0
	 * @access public
	 */
    public function minify_html( $buffer ) {
        if ( substr( ltrim( $buffer ), 0, 5) == '<?xml' ) {
            return ( $buffer );
        }

        if ( mb_detect_encoding($buffer, 'UTF-8', true) ) {
            $mod = '/u';
        } else {
            $mod = '/s';
        }

        $buffer = str_replace(array (chr(13) . chr(10), chr(9)), array (chr(10), ''), $buffer);
        $buffer = str_ireplace(array ('<script', '/script>', '<pre', '/pre>', '<textarea', '/textarea>', '<style', '/style>'), array ('M1N1FY-ST4RT<script', '/script>M1N1FY-3ND', 'M1N1FY-ST4RT<pre', '/pre>M1N1FY-3ND', 'M1N1FY-ST4RT<textarea', '/textarea>M1N1FY-3ND', 'M1N1FY-ST4RT<style', '/style>M1N1FY-3ND'), $buffer);
        $split = explode('M1N1FY-3ND', $buffer);
        $buffer = '';

        for ($i=0; $i<count($split); $i++) {
            $ii = strpos($split[$i], 'M1N1FY-ST4RT');
            if ($ii !== false) {
                $process = substr($split[$i], 0, $ii);
                $asis = substr($split[$i], $ii + 12);
                if (substr($asis, 0, 7) == '<script') {
                    $split2 = explode(chr(10), $asis);
                    $asis = '';
                    for ($iii = 0; $iii < count($split2); $iii ++) {
                        if ($split2[$iii])
                            $asis .= trim($split2[$iii]) . chr(10);
                            if (strpos($split2[$iii], '//') !== false && substr(trim($split2[$iii]), -1) == ';' )
                                $asis .= chr(10);
                    }
                    if ($asis)
                        $asis = substr($asis, 0, -1);
                        $asis = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $asis);
                        $asis = str_replace(array (';' . chr(10), '>' . chr(10), '{' . chr(10), '}' . chr(10), ',' . chr(10)), array(';', '>', '{', '}', ','), $asis);
                } else if (substr($asis, 0, 6) == '<style') {
                    $asis = preg_replace(array ('/\>[^\S ]+' . $mod, '/[^\S ]+\<' . $mod, '/(\s)+' . $mod), array('>', '<', '\\1'), $asis);
                        $asis = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $asis);
                    $asis = str_replace(array (chr(10), ' {', '{ ', ' }', '} ', '( ', ' )', ' :', ': ', ' ;', '; ', ' ,', ', ', ';}'), array('', '{', '{', '}', '}', '(', ')', ':', ':', ';', ';', ',', ',', '}'), $asis);
                }
            } else {
                $process = $split[$i];
                $asis = '';
            }
            $process = preg_replace(array ('/\>[^\S ]+' . $mod, '/[^\S ]+\<' . $mod, '/(\s)+' . $mod), array('>', '<', '\\1'), $process);
            $process = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->' . $mod, '', $process);
            $buffer .= $process.$asis;
        }

        $buffer = str_replace(array (chr(10) . '<script', chr(10) . '<style', '*/' . chr(10), 'M1N1FY-ST4RT'), array('<script', '<style', '*/', ''), $buffer);

        return ($buffer);
	}

    /**
	 * Initialize Minify HTML.
	 *
	 * @since 1.1.0
	 * @access public
	 */
    public function init_minify_html() {
        ob_start([$this, 'minify_html']);
    }
}

Kata_Plus_Pro_Minify_HTML::get_instance();
