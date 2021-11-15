<?php

// don't load directly.
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

if (!class_exists('Kata_plus_FontsManager_Settings_Helper')) :
    /**
     * Kata_plus_FontsManager_Settings_Helper.
     *
     * @author	ClimaxThemes
     * @package	Kata Plus
     * @since	1.0.0
     */
    class Kata_plus_FontsManager_Settings_Helper
    {

        /**
         * Instance of this class.
         *
         * @since     1.0.0
         * @access     private
         * @var     Kata_plus_FontsManager_Settings_Helper
         */
        private static $instance;

        /**
         * Provides access to a single instance of a module using the singleton pattern.
         *
         * @since   1.0.0
         * @return	object
         */
        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Define the core functionality of the FontsManager_Add_New_Page_Presenter.
         *
         * Load the dependencies.
         *
         * @since     1.0.0
         */
        function __construct()
        {
            $this->request_parser();
            $this->scripts();
        }

        /**
         * Scripts
         *
         * @since     1.0.0
         */
        public function scripts()
        {
            wp_add_inline_script(
                'postbox',
                'jQuery(function(){
					postboxes.add_postbox_toggles();
				});'
            );
            wp_enqueue_script('postbox');
        }


        /**
         * Request Parser
         *
         * @since     1.0.0
         */
        public function request_parser()
        {

            if ($_POST) {
                if (isset($_POST['font_preview_text'])) {
                    update_option('kata.plus.fonts_manager.font.preview.text', $_REQUEST['font_preview_text']);
                }
                if (isset($_POST['font_alternative_text'])) {
                    update_option('kata.plus.fonts_manager.alternative.fonts', $_REQUEST['font_alternative_text']);
                }
                if (isset($_POST['font_preview_font_size'])) {
                    update_option('kata.plus.fonts_manager.font.preview.size', $_REQUEST['font_preview_font_size']);
                }
                if (isset($_POST['settingsAction']) && $_POST['settingsAction'] == 'clearCache') {
                    $path = Kata_Plus_Pro::$upload_dir . '/temp/';
                    foreach (glob($path . '*.html') as $file) {
                        @unlink($file);
                    }
                }
                if (isset($_POST['settingsAction']) && $_POST['settingsAction'] == 'import' && isset($_POST['fonts_manager_import_settings']) && !empty($_POST['fonts_manager_import_settings'])) {
                    global $wpdb;

                    $importData = $_POST['fonts_manager_import_settings'];
                    $importData = str_replace('\"', '"', $importData);
                    $importData = str_replace('\\"', '"', $importData);
                    $importData = json_decode($importData, true);
                    if (!$importData) {
                        return;
                    }
                    foreach ($importData as $font) {
                        $wpdb->insert(
                            $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name,
                            array(
                                'name'          => $font['name'],
                                'source'        => $font['source'],
                                'selectors'     => $font['selectors'],
                                'subsets'       => $font['subsets'],
                                'variants'      => $font['variants'],
                                'url'           => $font['url'],
                                'place'         => $font['place'],
                                'status'        => $font['status'],
                                'created_at'    => $font['created_at'],
                                'updated_at'    => $font['updated_at'],
                            )
                        );
                    }
                    echo '<script>jQuery(document).ready(function() {
                        alert("Import Done!");
                    });
                    </script>';
                    update_option('kata-fonts-manager-last-update', time());
                }

                if (isset($_POST['settingsAction']) && $_POST['settingsAction'] == 'export') {
                    global $wpdb;
                    $sql = "SELECT * FROM " . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name;
                    $result = $wpdb->get_results($sql, 'ARRAY_A');
                    $json = json_encode($result, true);
                    header('Content-disposition: attachment; filename=fonts-manager-export.json');
                    echo $json;
                    die();
                }
            }
        }
    } //Class
    Kata_plus_FontsManager_Settings_Helper::get_instance();
endif;
