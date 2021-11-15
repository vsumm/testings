<?php

/**
 * Kata Plus Pro Template Manager WebService Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
    exit;
}


class Kata_Plus_Pro_Template_Manager_WebService
{
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
    public static $http_webservice;

    /**
     * Instance of this class.
     *
     * @since   1.0.0
     * @access  public
     * @var     Kata_Plus_Pro
     */
    public static $instance;

    public function __construct()
    {
        $this->definitions();
    }

    /**
     * Global definitions
     *
     * @since     1.0.0
     */
    public function definitions()
    {
        self::$webservice = 'https://climaxthemes.com/kata/api/template-manager/v2/';
        self::$http_webservice = 'http://climaxthemes.com/kata/api/template-manager/v2/';
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
     *
     * Get the Templates Categories
     *
     * @return string
     */
    public static function get_presets()
    {
        $presets = get_transient('kata_plus_presets');

        if ( false !== $presets ) {
            return $presets;
        }

        $presets = [];

        $response = wp_safe_remote_get(
            self::$webservice . '/presets/presets.json',
            [
                'timeout' => 30,
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36'
            ]
        );

        if ( is_wp_error($response) ) {
            set_transient('kata_plus_presets', $presets, DAY_IN_SECONDS);

            return $presets;
        }

        $response_code = (int) wp_remote_retrieve_response_code($response);

        if ( 200 !== $response_code ) {
            set_transient('kata_plus_presets', $presets, DAY_IN_SECONDS);

            return $presets;
        }

        $body = wp_remote_retrieve_body($response);

        $presets = json_decode($body, true);

        set_transient('kata_plus_presets', $presets, DAY_IN_SECONDS);

        return $presets;
    }

    /**
     *
     * Get the Templates Categories
     *
     * @return string
     */
    public static function get_element_presets($element) {
        $presets = get_transient('kata_plus_preset_' . $element);

        if ( ! empty( $presets ) ) {
            return is_array($presets) ? wp_send_json_success($presets) : wp_send_json_success([]);
        }

        $response = wp_safe_remote_get(
            self::$webservice . 'presets/elements/' . $element . '.json',
            [
                'timeout' => 30,
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36'
            ]
        );

        if ( is_wp_error($response) ) {
            wp_send_json_error('Unable to fetch presets.');
        }

        $response_code = (int) wp_remote_retrieve_response_code($response);

        if ( 200 !== $response_code ) {
            wp_send_json_error('Unable to fetch presets.');
        }

        $body = wp_remote_retrieve_body($response);
        $body = json_encode(json_decode($body));
        $body = str_replace('\/', '/', $body);
        preg_match_all("/(http(s?):)([\/\/].*.(?:png|jpg|jpeg|gif|svg))/", $body, $matches);

        foreach ($matches[0] as $image) {
            if(strpos($image, self::$webservice) !== false) {
                continue;
            }

            if(strpos($image, self::$http_webservice) !== false) {
                continue;
            }

            if($src = get_transient('kata_plus_preset_image_src' . md5($image))) {
                $body = str_replace($image, $src, $body);
            } else {
                $src = static::media_sideload_image($image);
                set_transient('kata_plus_preset_image_src' . md5($image), $src, MONTH_IN_SECONDS);
                $body = str_replace($image, $src, $body);

            }
        }

        $presets = json_decode($body, true);
        set_transient('kata_plus_preset_' . $element, $presets, DAY_IN_SECONDS);

        return $presets;
    }

    private static function media_sideload_image($file)
    {
        if (!empty($file)) {

            // Set variables for storage, fix file filename for query strings.
            preg_match('/[^\?]+\.(jpe?g|jpe|gif|png|svg)\b/i', $file, $matches);

            if (!$matches) {
                return new WP_Error('image_sideload_failed', __('Invalid image URL.'));
            }

            $file_array         = array();
            $file_array['name'] = wp_basename($matches[0]);

            // Download file to temp location.
            $file_array['tmp_name'] = download_url($file);

            // If error storing temporarily, return the error.
            if (is_wp_error($file_array['tmp_name'])) {
                return $file_array['tmp_name'];
            }

            // Do the validation and storage stuff.
            $id = media_handle_sideload($file_array, 0, null);

            // If error storing permanently, unlink.
            if (is_wp_error($id)) {
                @unlink($file_array['tmp_name']);
                return $id;
            }

            $src = wp_get_attachment_url($id);
        }

        // Finally, check to make sure the file has been saved, then return the HTML.
        if (!empty($src)) {
            return $src;
        } else {
            return new WP_Error('image_sideload_failed');
        }
    }

    /**
     *
     * Get the Templates Categories
     *
     * @return string
     */
    public static function get_categories($sync = false)
    {
        $categories_data = get_option('kata-plus-templates-categories-data');
        if (!$categories_data || $sync) {

            $response = wp_safe_remote_get(
                self::$webservice . 'template-categories.json',
                [
                    'timeout' => 30,
                    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36'
                ]
            );

            $response_code = wp_remote_retrieve_response_code($response);

            if ($response_code !== 200) {
                return new \WP_Error('_response_code_error', esc_html__('Ooops, The Request Code :', 'kata-plus') . $response_code);
            }

            $categories_data = json_decode(wp_remote_retrieve_body($response), true);
            if (isset($categories_data['error'])) {
                return new \WP_Error('_response_error', esc_html($response['message']));
            }

            if (empty($categories_data)) {
                return new \WP_Error('_response_code_error', esc_html__('Ooops, Invalid Data', 'kata-plus'));
            }
            update_option('kata-plus-templates-categories-data', $categories_data['data']);
            return $categories_data['data'];
        }

        return $categories_data;
    }

    /**
     *
     * Get Templates
     *
     * @return string
     */
    public static function get_templates($sync = false)
    {
        $template_data = get_option('kata-plus-templates-data');
        if(!$template_data || $sync ) {
            $response = wp_safe_remote_get(
                self::$webservice . 'templates.json',
                [
                    'timeout' => 30,
                    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36'
                ]
            );

            $response_code = wp_remote_retrieve_response_code($response);
            if ($response_code !== 200) {
                return new \WP_Error('_response_code_error', esc_html__('Ooops, The Request Code :', 'kata-plus') . $response_code);
            }

            $template_data = json_decode(wp_remote_retrieve_body($response), true);
            if (isset($template_data['error'])) {
                return new \WP_Error('_response_error', esc_html($response['message']));
            }

            if (empty($template_data)) {
                return new \WP_Error('_response_code_error', esc_html__('Ooops, Invalid Data', 'kata-plus'));
            }
            update_option('kata-plus-templates-data', $template_data);
        }
        return $template_data;
    }

    /**
     * Get Kata Plus Pro Requested Template (AJAX)
     *
     * @since   1.0.0
     * @return  Array
     */
    public static function get_template($template_id)
    {
        if ($template_id === false) {
            return [];
        }

        $response    = wp_safe_remote_get(
            self::$webservice . 'template/template-' . $template_id . '.json',
            [
                'timeout' => 30,
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36'
            ]
        );

        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            return new \WP_Error('_response_code_error', esc_html__('Ooops, The Request Code :', 'kata-plus') . $response_code);
        }

        $ChildList    = wp_safe_remote_get(
            self::$webservice . 'child-template/' . $template_id . '/list.json',
            [
                'timeout' => 10,
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36'
            ]
        );

        if (wp_remote_retrieve_response_code($ChildList) === 200) {
            $templates = json_decode(wp_remote_retrieve_body($ChildList), true);
            foreach ($templates as $t) {

                $manager = new \Elementor\TemplateLibrary\Manager();
                $source = $manager->get_source('local');
                $source->import_template($t, self::$webservice . 'child-template/' . $template_id . '/' . $t);
            }
        }

        $template_data = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($template_data['error'])) {
            return new \WP_Error('_response_error', esc_html($response['message']));
        }

        if (empty($template_data)) {
            return new \WP_Error('_response_code_error', esc_html__('Ooops, Invalid Data', 'kata-plus'));
        }

        return $template_data;
    }
}

Kata_Plus_Pro_Template_Manager_WebService::get_instance();