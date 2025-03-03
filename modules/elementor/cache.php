<?php
if(!class_exists('WPCC_elementor_cache')){
	class WPCC_elementor_cache extends wpcc_base{
		private $title = 'Elementor Cache';
		private $id = 'elementor';
		private $plugin = 'elementor/elementor.php';
		function __construct() {
			global $cache_list;
			$cache_list[$this->id] = $this->_render();
			add_action('wp_ajax_wpcc_clear_cache', array($this, 'wpcc_clear_elementor_cache_ajax'));
			add_action("wp_ajax_nopriv_wpcc_clear_cache", array($this, "wpcc_clear_elementor_cache_ajax"));
			wp_register_script('wpcc-elem', plugin_dir_url(__FILE__) . 'elementor.js', array('jquery'));
			wp_enqueue_script( 'wpcc-elem' );
		}
		function wpcc_clear_elementor_cache_ajax() {
			if ((isset($_POST['action']) && 'wpcc_clear_cache' === sanitize_text_field($_POST['action'])) && (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'wpcc_clear_cache_'.$this->id))) {
				\Elementor\Plugin::instance()->files_manager->clear_cache();
				wp_send_json_success(esc_html('Elementor cache cleared.'), 200);
			}
		}
		function _installed() {
			$all_plugins = get_plugins();
			return array_key_exists( $this->plugin, $all_plugins ) ? 1 : 0;
		}
		function _active() {
			if(!$this->_installed()) delete_option($this->id);
			return ($this->_installed() && wpcc_is_active($this->plugin)) ? 1 : ($this->_installed() && !wpcc_is_active($this->plugin) ? 0 : '');
		}
		function _disabled() {
			return ($this->_installed() && !wpcc_is_active($this->plugin)) ? 1 : ($this->_installed() && wpcc_is_active($this->plugin) ? 0 : '');	
		}
		function _dropdown() {
			$dropdown = !$this->_installed() ? '' : ($this->_disabled() ? '' : 0);
			return (get_option($this->id) !== false && !$this->_disabled()) ? get_option($this->id) : $dropdown;
		}
		function _button() {
			return (!$this->_installed()) ? '' : ($this->_installed() && !$this->_disabled() ? 1 : 0);
		}
		function _order() {
			return 2;
		}
		function _premium() {
			return false;
		}
		function _render() {
			$render = array(
				'id' => $this->id,
				'title' => $this->title,
				'installed' => $this->_installed(),
				'active' => $this->_active(),
				'disabled' => $this->_disabled(),
				'dropdown' => $this->_dropdown(),
				'order' => $this->_order(),
				'premium' => $this->_premium(),
				'button' => $this->_button()
			);
			return $render;		
		}
	}
	new WPCC_elementor_cache();
}