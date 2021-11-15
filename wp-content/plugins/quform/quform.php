<?php

/**
 * Plugin Name: Quform
 * Plugin URI: https://www.quform.com
 * Description: The Quform form builder makes it easy to build forms in WordPress.
 * Version: 2.14.2
 * Author: ThemeCatcher
 * Author URI: https://www.themecatcher.net
 * Text Domain: quform
 */

// Prevent direct script access
if ( ! defined('ABSPATH')) {
    exit;
}

define('QUFORM_VERSION', '2.14.2');
define('QUFORM_PATH', dirname(__FILE__));
define('QUFORM_NAME', basename(QUFORM_PATH));
define('QUFORM_BASENAME', QUFORM_NAME . '/' . basename(__FILE__));
define('QUFORM_LIBRARY_PATH', QUFORM_PATH . '/library');
define('QUFORM_TEMPLATE_PATH', QUFORM_PATH . '/library/templates');
define('QUFORM_ADMIN_PATH', QUFORM_PATH . '/admin');

if ( ! class_exists('JuiceContainer')) {
    require_once QUFORM_LIBRARY_PATH . '/JuiceContainer.php';
}

require_once QUFORM_LIBRARY_PATH . '/Quform/ClassLoader.php';
Quform_ClassLoader::register();

add_action('plugins_loaded', array('Quform', 'bootstrap'), 5);
register_activation_hook(QUFORM_BASENAME, array('Quform', 'onActivation'));

/**
 * Get a service from the container
 *
 * @param   string  $service  The service name
 * @return  mixed             The service instance
 */
function quform($service)
{
    return Quform::getService($service);
}
