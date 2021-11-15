<?php

/**
 * Kata Plus Pro Template Manager Presets Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Core\Common\Modules\Ajax\Module as AJAXModule;

class Kata_Plus_Pro_Template_Manager_Presets
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
     * The url of the assets folder.
     *
     * @access  public
     * @var     string
     */
    public static $assets;

    /**
     * The url of the WebService.
     *
     * @access  public
     * @var     string
     */
    public static $webservice;

    /**
     * Instance of this class.
     *
     * @since   1.0.0
     * @access  public
     * @var     Kata_Plus_Pro_Template_Manager_Presets
     */
    public static $instance;

    public function __construct()
    {
        $this->definitions();
        $this->actions();
    }

    /**
     * Global definitions
     *
     * @since     1.0.0
     */
    public function definitions()
    {
        self::$dir = plugin_dir_path(__FILE__);
        self::$url = plugin_dir_url(__FILE__);
        self::$assets = self::$url . 'assets/';
        self::$webservice = 'https://climaxthemes.com/kata/api/template-manager/presets/';
    }

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
     * Actions
     *
     * @since     1.0.0
     */
    public function actions()
    {
        add_action('wp_ajax_kata_plus_sync_libraries', [$this, 'sync_libraries']);
        add_action('wp_ajax_kata_plus_element_presets', [$this, 'get_element_presets']);
    }

    /**
     * Get Element Presets
     *
     * @since     1.0.0
     */
    public function get_element_presets () {
        check_ajax_referer('kata_plus_template_manager_element_presets_nonce');

        if ( empty($_POST['element']) ) {
            wp_send_json_error('element field is missing');
        }

        $element = sanitize_text_field(wp_unslash($_POST['element']));
        $presets = Kata_Plus_Pro_Template_Manager_WebService::get_element_presets($element);
        wp_send_json_success($presets);
    }

    /**
    * Sync Libraries
    *
    * @since     1.0.0
    */
    public function sync_libraries () {
        check_ajax_referer('kata_plus_sync_library_nonce');

        if ( empty($_POST['library']) ) {
            wp_send_json_error(__('library field is missing', 'kata-plus'));
        }

        $library = sanitize_text_field(wp_unslash($_POST['library']));

        if ( 'presets' === $library ) {
            $elements = Kata_Plus_Pro_Template_Manager_WebService::get_presets();

            if ( false === $elements ) {
                wp_send_json_success();
            }

            foreach ($elements as $element) {
                delete_transient('kata_plus_preset_' . $element);
            }

            delete_transient('kata_plus_presets');

            wp_send_json_success();
        }

        wp_send_json_error(__('Invalid library value received.', 'kata-plus'));
    }

}

Kata_Plus_Pro_Template_Manager_Presets::get_instance();
