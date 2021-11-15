<?php

/**
 * Elementor Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Core\Kits\Documents\Tabs\Settings_Layout;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;
use Elementor\Plugin;
use Elementor\Core\Base\Base_Object;

class Kata_Plus_Setup_Devices {


    private $devices = [];

    /**
     * Instance of this class.
     *
     * @since   1.0.0
     * @access  public
     * @var     Kata_Plus_Elementor
     */
    public static $instance;

    /**
     * Provides access to a single instance of a module using the singleton pattern.
     *
     * @since   1.0.0
     * @return  object
     */
    public static function get_instance() {
        self::$instance = new self();
        return self::$instance;
    }


    /**
     * Constructor.
     *
     * @since   1.0.0
     */
    public function __construct() {

        $kit = Plugin::$instance->kits_manager->get_active_kit_for_frontend();
		$active_breakpoint_keys = $kit->get_settings( Settings_Layout::ACTIVE_BREAKPOINTS_CONTROL_ID );
        $new_active_breakpoint_keys = [];

        if( ! in_array( Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . Breakpoints_Manager::BREAKPOINT_KEY_MOBILE_EXTRA, $active_breakpoint_keys ) ) {
            $new_active_breakpoint_keys[] = Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . Breakpoints_Manager::BREAKPOINT_KEY_MOBILE_EXTRA;
        }
        if( ! in_array( Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . Breakpoints_Manager::BREAKPOINT_KEY_TABLET_EXTRA, $active_breakpoint_keys ) ) {
            $new_active_breakpoint_keys[] = Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . Breakpoints_Manager::BREAKPOINT_KEY_TABLET_EXTRA;
        }
        if( ! in_array( Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . Breakpoints_Manager::BREAKPOINT_KEY_LAPTOP, $active_breakpoint_keys ) ) {
            $new_active_breakpoint_keys[] = Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . Breakpoints_Manager::BREAKPOINT_KEY_LAPTOP;
        }
        if( ! in_array( Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . Breakpoints_Manager::BREAKPOINT_KEY_WIDESCREEN, $active_breakpoint_keys ) ) {
            $new_active_breakpoint_keys[] = Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . Breakpoints_Manager::BREAKPOINT_KEY_WIDESCREEN;
        }

		$kit->set_settings( Settings_Layout::ACTIVE_BREAKPOINTS_CONTROL_ID, array_merge( $active_breakpoint_keys, $new_active_breakpoint_keys ) );
    }
}

add_action('elementor/init', function() {
    Kata_Plus_Setup_Devices::get_instance();
}, -10);

add_action('wp_enqueue_scripts', function() {
    Kata_Plus_Setup_Devices::get_instance();
}, -10);

/**
 * Elementor Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class Kata_Plus_Small_Mobile extends Base_Object {

	private $name;
	private $label;
	private $default_value;
	private $db_key;
	private $value;
	private $is_custom;
	private $direction;
	private $is_enabled;
	private $config;

    public function __construct( $args ) {
		$this->name = $args['name'];
		$this->label = $args['label'];
		// Used for CSS generation
		$this->db_key = Breakpoints_Manager::BREAKPOINT_SETTING_PREFIX . $args['name'];
		$this->direction = $args['direction'];
		$this->is_enabled = $args['is_enabled'];
		$this->default_value = $args['default_value'];
	}

	/**
	 * Get Name
	 *
	 * @since 3.2.0
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Is Enabled
	 *
	 * Check if the breakpoint is enabled or not. The breakpoint instance receives this data from
	 * the Breakpoints Manager.
	 *
	 * @return bool $is_enabled class variable
	 */
	public function is_enabled() {
		return $this->is_enabled;
	}

	/**
	 * Get Label
	 *
	 * Retrieve the breakpoint label.
	 *
	 * @since 3.2.0
	 *
	 * @return string $label class variable
	 */
	public function get_label() {
		return $this->label;
	}

	/**
	 * Get Value
	 *
	 * Retrieve the saved breakpoint value.
	 *
	 * @since 3.2.0
	 *
	 * @return int $value class variable
	 */
	public function get_value() {
		if ( ! $this->value ) {
			$this->init_value();
		}

		return $this->value;
	}

	/**
	 * Is Custom
	 *
	 * Check if the breakpoint's value is a custom or default value.
	 *
	 * @since 3.2.0
	 *
	 * @return bool $is_custom class variable
	 */
	public function is_custom() {
		if ( ! $this->is_custom ) {
			$this->get_value();
		}

		return $this->is_custom;
	}

	/**
	 * Get Default Value
	 *
	 * Returns the Breakpoint's default value.
	 *
	 * @since 3.2.0
	 *
	 * @return int $default_value class variable
	 */
	public function get_default_value() {
		return $this->default_value;
	}

	/**
	 * Get Direction
	 *
	 * Returns the Breakpoint's direction ('min'/'max').
	 *
	 * @since 3.2.0
	 *
	 * @return string $direction class variable
	 */
	public function get_direction() {
		return $this->direction;
	}

}


add_action('wp_enqueue_scripts', function() {
    $args = [
        'name' => 'smallmobile',
        'label' => 'Small Mobile',
        'default_value' => 320,
        'db_key' => 'viewport_smallmobile',
        'value' => 320,
        'is_custom' => true,
        'direction' => 'max',
        'is_enabled' => true,
    ];
    new Kata_Plus_Small_Mobile($args);
}, -10);