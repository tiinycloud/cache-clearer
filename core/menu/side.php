<?php
if(!class_exists('WPCC_sideMenu')){
	class WPCC_sideMenu{
		
		//public $menu_id = 'cache-cleaner';
		public $menu_id = 'cache-dashboard';

		function __construct() {
			// Create Top Admin Bar Menu
			add_action( 'admin_menu', array($this, 'admin_menu_items') );
		}
		function admin_menu_items() {
			if ( ! current_user_can( 'manage_options' ) ) return;
			$this->parent_menu();
			$this->child_menus();
		}
		function child_menus() {
			$this->clear_all_cache();
			$this->dashboard();
			$this->settings();
			$this->premium();
			$this->support();
		}
		function parent_menu(){
			add_menu_page(
				__( 'Cache Clearer', WPCC_CLEANER_NAME),   // Page title
				__( 'Cache Clearer', WPCC_CLEANER_NAME),         // Menu title
				'manage_options',      // Capability required to access the page
				$this->menu_id,   // Unique menu slug
				array($this, 'render_cache_clear_dashboard'),  // Callback function to render the page content
				'dashicons-dashboard', // Icon for the menu item (you can change it)
				2                     // Position in the menu
			);
		}
		function dashboard() {
			add_submenu_page(
				$this->menu_id,   // Parent menu slug (should match the menu slug from Step 1)
				__( 'Cache clear dashboard', WPCC_CLEANER_NAME),      // Page title
				__( 'Dashboard', WPCC_CLEANER_NAME),             // Menu title
				'manage_options',      // Capability required to access the page
				$this->menu_id,// Unique submenu slug
				array($this, 'render_cache_clear_dashboard')// Callback function to render the page content
			);
		}
		function render_clear_all_cache(){
			//(new wpcc('templates'))->inc('cache');
			(new wpcc('templates'))->inc('premium');
		}
		function clear_all_cache() {
			add_submenu_page(
				$this->menu_id,   // Parent menu slug (should match the menu slug from Step 1)
				__( 'Cache cleaner', WPCC_CLEANER_NAME),      // Page title
				__( 'Clear All Caches', WPCC_CLEANER_NAME),             // Menu title
				'manage_options',      // Capability required to access the page
				'cache-cleaner',// Unique submenu slug
				array($this, 'render_clear_all_cache')// Callback function to render the page content
			);
		}
		function render_cache_clear_dashboard(){
			if(isset($_REQUEST['cache'])){
				(new wpcc('modules'))->inc($_REQUEST['cache'].'/template');
			}else{
				(new wpcc('templates'))->inc('dashboard');
			}
		}
		function settings() {
			add_submenu_page(
				$this->menu_id,   // Parent menu slug (should match the menu slug from Step 1)
				__( 'Cache clear settings', WPCC_CLEANER_NAME),      // Page title
				__( 'Settings', WPCC_CLEANER_NAME),             // Menu title
				'manage_options',      // Capability required to access the page
				'cache-settings',// Unique submenu slug
				array($this, 'render_cache_clear_settings')// Callback function to render the page content
			);
		}
		function render_cache_clear_settings(){
			(new wpcc('templates'))->inc('settings');
		}
		function premium() {
			add_submenu_page(
				$this->menu_id,   // Parent menu slug (should match the menu slug from Step 1)
				__( 'Cache clear premium', WPCC_CLEANER_NAME),      // Page title
				__( 'Premium', WPCC_CLEANER_NAME),             // Menu title
				'manage_options',      // Capability required to access the page
				'cache-premium',// Unique submenu slug
				array($this, 'render_cache_clear_premium')// Callback function to render the page content
			);
		}
		function render_cache_clear_premium(){
			(new wpcc('templates'))->inc('premium');
		}
		function support() {
			add_submenu_page(
				$this->menu_id,   // Parent menu slug (should match the menu slug from Step 1)
				__( 'Cache clear support', WPCC_CLEANER_NAME),      // Page title
				__( 'Support', WPCC_CLEANER_NAME),             // Menu title
				'manage_options',      // Capability required to access the page
				'cache-support',// Unique submenu slug
				array($this, 'render_cache_clear_support')// Callback function to render the page content
			);
		}
		function render_cache_clear_support(){
			(new wpcc('templates'))->inc('support');
		}
	}
	new WPCC_sideMenu();
}