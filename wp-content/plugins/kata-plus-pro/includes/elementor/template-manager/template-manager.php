<?php

/**
 * Elementor Template Mnager.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
    exit;
}

class Kata_Plus_Pro_Template_Manager
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
     * Instance of this class.
     *
     * @since   1.0.0
     * @access  public
     * @var     Kata_Plus_Pro_Template_Manager
     */
    public static $instance;

    /**
     * Constructor Function
     */
    public function __construct()
    {
        $this->definitions();
        $this->dependencies();
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
    }

    /**
     * Load dependencies.
     *
     * @since   1.0.0
     */
    public function dependencies()
    {
        Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes', 'webservice');
        Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes', 'templates');
        Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes', 'presets');
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
        add_action('elementor/editor/after_enqueue_styles', [$this, 'editor_enqueue_styles'], 0);
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'editor_enqueue_scripts'], 0);
        add_action('elementor/preview/enqueue_styles', [$this, 'preview_enqueue_styles']);
    }

    /**
     *
     * Elementor Editor Enqueue Required Styles
     *
     * @return string
     */
    public static function editor_enqueue_styles()
    {
        wp_enqueue_style('kata-plus-elementor-template-manager-editor-css', static::$assets . 'css/template-manager-editor.css', [], Kata_Plus_Pro::$version);
    }

    /**
     *
     * Elementor Editor Enqueue Required Scripts
     *
     * @return string
     */
    public static function editor_enqueue_scripts()
    {
        wp_enqueue_script('kata-plus-elementor-template-manager-editor', static::$assets . 'js/template-manager-editor.js', ['jquery'], Kata_Plus_Pro::$version);
        wp_localize_script(
            'kata-plus-elementor-template-manager-editor',
            'kata_plus_elementor',
            [
                'element_presets_nonce'          => wp_create_nonce('kata_plus_template_manager_element_presets_nonce'),
            ]
        );
    }

    /**
     *
     * Elementor Preview Enqueue Required Styles
     *
     * @return string
     */
    public static function preview_enqueue_styles()
    {
        wp_enqueue_style('kata-plus-elementor-template-manager-preview', static::$assets . 'css/template-manager-preview.css', [], Kata_Plus_Pro::$version);
    }
}

Kata_Plus_Pro_Template_Manager::get_instance();
