<?php
/**
 * Plugin Name: Icon Starter
 * Plugin URI:  https://jewel.edbd-server.com/icon-starter
 * Description: Elementor custom widgets plugin.
 * Version:     1.0.0
 * Author:      Md Jewel Miah
 * Author URI:  https://jewel.edbd-server.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: icon-starter
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
/**
 * Main plugin Class
 *
 */

final class Icon_Starter {

    /**
     * Plugin version
     *
     * @var string
     */
    const VERSION = '1.0.0';
    
    /**
     * Class constructor.
     */

    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        
    }

    /**
     * Initialize singleton instance
     * 
     * @return \Icon_Starter
     */

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define constants
     */
    private function define_constants() {
        define( 'ICON_STARTER_VERSION', self::VERSION );
        define( 'ICON_STARTER_FILE', __FILE__ );
        define( 'ICON_STARTER_PATH', __DIR__ );
        define( 'ICON_STARTER_URL', plugins_url( '', ICON_STARTER_FILE ) );
        define( 'ICON_STARTER_ASSETS', ICON_STARTER_URL . '/assets' );        
    }

       
    /**
     * Initialize the plugin
     * 
     * This method is called when the plugin is loaded.
     */
    public function init_plugin() {
        new icon\starter\Admin\Menu();
    }

    /**
     * Activation hook
     * 
     * This method is called when the plugin is activated.
     * It sets up initial options and versioning.
     */
    public function activate() {        
        $installed = get_option( 'icon_starter_installed' );

        if ( ! $installed ) {
            update_option( 'icon_starter_installed', time() );
        }

        update_option( 'icon_starter_version', ICON_STARTER_VERSION );

    }
    
}

/**
 * Initialize the main plugin
 * 
 * @return \Icon_Starter
 */
function icon_starter() {
    return Icon_Starter::init();
}

// Initialize the plugin
icon_starter();