<?php
/*
Plugin Name: Cache Clearer
Description: Clear any cache on WordPress with one click. Manage all Theme and Plugin caches.
Plugin URI:  https://cacheclearer.com/?utm_source=wp-plugins&utm_campaign=plugin-uri&utm_medium=wp-dash
Version:     1.0.0
Author:      TiinyCloud
License:     GPLv3
Author URI:  https://tiinycloud.com/?utm_source=wp-plugins&utm_campaign=author-uri&utm_medium=wp-dash
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cache-clearer
*/

// DO NOT ALLOW DIRECT ACCESS
if ( !defined( 'ABSPATH' ) ) exit;

define( 'WPCC_CLEANER_PATH', plugin_dir_path( __FILE__ ) );	// Defining plugin dir path
define( 'WPCC_CLEANER_VERSION', 'v1.0.0');						// Defining plugin version
define( 'WPCC_CLEANER_NAME', 'Cache Cleaner');		// Defining plugin name

// initialize the plugin 
final class WPCC_Init {

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		register_activation_hook(__FILE__, array( $this, 'wpcc_cleaner_activation'));
		register_deactivation_hook(__FILE__, array( $this, 'wpcc_cleaner_deactivation'));
		add_action('admin_enqueue_scripts', array( $this, 'wpcc_enqueue_script'));
		add_action('wp_enqueue_scripts', array( $this, 'wpcc_enqueue_script'));
	}
	public function init() {
		global $cache_list;
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		require_once( 'core/load.php' );
	}
	
	public function wpcc_cleaner_activation() {

	}
	
	public function wpcc_cleaner_deactivation() {
		delete_option('wpcc-cache' );
	}
	public function wpcc_enqueue_script() {
		wp_register_script('wpcc-script', plugin_dir_url(__FILE__) . 'assets/js/wpcc-cleaner.js', array('jquery'));
		wp_enqueue_style('wpcc-cleaner', plugin_dir_url(__FILE__) . 'assets/css/wpcc-cleaner.css', array(), '1.0');
		wp_localize_script( 'wpcc-script', 'wpcc', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		wp_enqueue_script( 'wpcc-script' );
	}
}
new WPCC_Init();
