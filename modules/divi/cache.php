<?php
if(!class_exists('WPCC_divi_cache')){
	class WPCC_divi_cache extends wpcc_base{
		private $title = 'Divi Cache';
		private $id = 'divi';
		private $name = 'Divi';
		private $extension = 'plugin';
		function __construct() {
			global $cache_list;
			$themes = wp_get_themes();
			$plugins = get_plugins();
			if(array_key_exists( $this->name, $themes )) $this->extension = 'theme';
			elseif(array_key_exists( $this->name, $plugins )) $this->extension = 'plugin';
			if($this->extension == 'plugin') $this->name = 'divi/divi.php';
			$cache_list[$this->id] = $this->_data();
			add_action('wp_ajax_wpcc_clear_cache', array($this, 'wpcc_clear_static_css'));
			add_action("wp_ajax_nopriv_wpcc_clear_cache", array($this, "wpcc_clear_static_css"));
			wp_register_script('wpcc-divi', plugin_dir_url(__FILE__) . 'divi.js', array('jquery'));
			wp_enqueue_script( 'wpcc-divi' );
		}
		function wpcc_clear_static_css(){
			if ((isset($_POST['action']) && 'wpcc_clear_cache' === sanitize_text_field($_POST['action'])) && (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'wpcc_clear_cache_'.$this->id))) {
				ET_Core_PageResource::remove_static_resources('all', 'all');
				wp_send_json_success(esc_html('The static CSS file generation has been cleared!'), 200);
			}
		}
		function _premium() {
			return false;
		}
		function _installed() {
			$theme = wp_get_themes();
			$plugin = get_plugins();
			$theme = (array_key_exists( $this->name, $theme )) ? true : false;
			$plugin = (array_key_exists( $this->name, $plugin )) ? true : false; 
			return ($theme || $plugin) ? 1 : 0;
		}
		function _active() {
			if(!$this->_installed()) delete_option($this->id);
			return ($this->_installed() && wpcc_is_active($this->name, $this->extension)) ? 1 : ($this->_installed() && !wpcc_is_active($this->name, $this->extension) ? 0 : '');
		}
		function _disabled() {
			return ($this->_installed() && !wpcc_is_active($this->name, $this->extension)) ? 1 : ($this->_installed() && wpcc_is_active($this->name, $this->extension) ? 0 : '');	
		}
		function _dropdown() {
			$dropdown = !$this->_installed() ? '' : ($this->_disabled() ? '' : 0);
			return (get_option($this->id) !== false && !$this->_disabled()) ? get_option($this->id) : $dropdown;
		}
		function _button() {
			return (!$this->_installed()) ? '' : ($this->_installed() && !$this->_disabled() ? 1 : 0);
		}
		function _order() {
			return 1;
		}
		function _data() {
			$render = array(
				'id' => $this->id,
				'title' => $this->title,
				'installed' => $this->_installed(),
				'active' => $this->_active(),
				'disabled' => $this->_disabled(),
				'dropdown' => $this->_dropdown(),
				'order' => $this->_order(),
				'premium' => $this->_premium(),
				'button' => $this->_button(),
			);
			return $render;		
		}
	}
	new WPCC_divi_cache();
}