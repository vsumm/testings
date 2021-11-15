<?php

/**
 * Kata Plus Pro Template Manager Templates Class.
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

class Kata_Plus_Pro_Template_Manager_Templates
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
     * The url of the WebService.
     *
     * @access  public
     * @var     string
     */
    public static $registered_sources = [];

    /**
     * The url of the WebService.
     *
     * @access  public
     * @var     string
     */
    public static $template_sources = [];

    /**
     * Instance of this class.
     *
     * @since   1.0.0
     * @access  public
     * @var     Kata_Plus_Pro_Template_Manager_Templates
     */
    public static $instance;

    public function __construct()
    {
        $this->definitions();
        $this->actions();
        $this->register_template_sources();
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
        self::$webservice = 'https://climaxthemes.com/kata/api/template-manager/v2/';
        self::$template_sources = [
            'Header',
            'Footer',
            'Blog',
            'Single',
            'About',
            'Hero',
            'Pricing',
            'Gallery',
            'Portfolio',
            'Icon',
            'Call_To_Action',
            'Slider',
            'Banner',
            'Accordion',
            'Carousel',
            'Client',
            'Counter',
            'Contact',
            'Content',
            'Team',
            'Mega Menu',
        ];
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
        add_action('elementor/ajax/register_actions', [$this, 'register_ajax_actions']);
        add_action('elementor/editor/footer', [$this, 'add_templates'], 1);
    }

    /**
     * Register Template Sources.
     *
     * @since   1.0.0
     * @access private
     */
    private function register_template_sources()
    {
        foreach (glob(Kata_Plus_Pro_Template_Manager::$dir . 'sources/*') as $file) {
            Kata_Plus_Pro_Autoloader::load(dirname($file), basename($file, '.php'));
        }

        foreach (static::$template_sources as $source) {
            $source = 'KataPlus_Template_Library_Source_' . $source;
            if (!class_exists($source)) {
                new \WP_Error('source_'. $source .'_is_not_exists');
                continue;
            }

            $source = new $source();
            if (!$source instanceof \Elementor\TemplateLibrary\Source_Base) {
                return new \WP_Error('wrong_instance_source');
            }

            if (isset(self::$registered_sources[$source->get_id()])) {
                new \WP_Error('source_exists');
                continue;
            }

            self::$registered_sources[$source->get_id()] = $source;

        }
    }


    /**
     * Register Ajax Actions.
     * @since   1.0.0
     * @access public
     *
     * @param Ajax $ajax
     */
    public function register_ajax_actions(AJAXModule $ajax)
    {
        $library_ajax_requests = [
            'kata_plus_elementor_get_library_data',
            'kata_plus_elementor_get_template_data',
        ];

        foreach ($library_ajax_requests as $ajax_request) {
            $ajax->register_ajax_action($ajax_request, function ($data) use ($ajax_request) {
                return $this->handle_ajax_request($ajax_request, $data);
            });
        }
    }

    /**
     * Handle Ajax Requests.
     * @since   1.0.0
     * @access public
     *
     * @param $ajax_request, (Array) $data
     */
    private function handle_ajax_request($ajax_request, array $data)
    {
        if (!empty($data['editor_post_id'])) {
            $editor_post_id = absint($data['editor_post_id']);

            if (!get_post($editor_post_id)) {
                throw new \Exception(__('Post not found.', 'kata-plus'));
            }

            \Elementor\Plugin::$instance->db->switch_to_post($editor_post_id);
        }

        $ajax_request = str_replace('kata_plus_elementor_', '', $ajax_request);

        $result = call_user_func([$this, $ajax_request], $data);

        if (is_wp_error($result)) {
            throw new \Exception($result->get_error_message());
        }

        return $result;
    }

    /**
    * Get Template Data
    *
    * @since     1.0.0
    */
    public function get_template_data (array $args) {

        if (isset($args['edit_mode'])) {
            \Elementor\Plugin::instance()->editor->set_edit_mode($args['edit_mode']);
        }

        $source = $this->get_source($args['source']);

        if (!$source) {
            return new \WP_Error('template_error', 'Template source not found.');
        }
        $data = $source->get_data($args);
        return $data;
    }

    /**
     * Get Source
     *
     * @since     1.0.0
     */
    public function get_source($id)
    {
        $sources = self::$registered_sources;

        if (isset($sources[$id])) {
            return $sources[$id];
        }

        return false;
    }

    /**
     * Get Library Data
     *
     * @since     1.0.0
     */
    public function get_library_data(array $args)
    {
        $library_data = [];
        $unprocessed_templates = (array) Kata_Plus_Pro_Template_Manager_WebService::get_templates(!empty($args['sync']));
        foreach ($unprocessed_templates as $template) {
            if(!isset($library_data[$template['subtype']])) {
                $library_data[$template['subtype']] = [];
            }
            $library_data[$template['subtype']][] = $template;
        }
        $library_data['categories'] = Kata_Plus_Pro_Template_Manager_WebService::get_categories(!empty($args['sync']));
        \Elementor\Plugin::$instance->documents->get_document_types();

        return [
            'templates' => $this->get_templates(),
            'config' => $library_data,
        ];
    }

    /**
     * Get Templates
     *
     * @since     1.0.0
     */
    public function get_templates()
    {
        $templates = [];
        $this->register_template_sources();
        foreach (self::$registered_sources as $source) {
            $templates = array_merge($templates, $source->get_items());
        }

        return $templates;
    }

    /**
     * Add Kata Plus Pro Template Manager as Elementor Template
     *
     * @since     1.0.0
     */
    public function add_templates()
    {
        \Elementor\Plugin::$instance->common->add_template(Kata_Plus_Pro_Template_Manager::$dir . 'view/templates.php');
    }

}

Kata_Plus_Pro_Template_Manager_Templates::get_instance();
