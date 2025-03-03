<?php
if(!class_exists('WPCC_local_cache')){
	class WPCC_local_cache extends wpcc_base{
		private $title = 'Local Storage Cache';
		private $id = 'local';
		function __construct() {
			global $cache_list;
			$cache_list[$this->id] = $this->_data();
			wp_register_script('wpcc-local', plugin_dir_url(__FILE__) . 'local.js', array('jquery'));
			wp_enqueue_script( 'wpcc-local' );
		}
		function _premium() {
			return false;
		}
		function _installed() {
			return 1;
		}
		function _active() {
			if(!$this->_installed()) delete_option($this->id); 
			return (!$this->_installed()) ? '' : 1;
		}
		function _disabled() {
			return (!$this->_installed()) ? '' : ($this->_installed() && !$this->_active() ? 1 : 0);
		}
		function _dropdown() {
			$dropdown = !$this->_installed() ? '' : ($this->_disabled() ? '' : 0);
			return (get_option($this->id) !== false && !$this->_disabled()) ? get_option($this->id) : $dropdown;
		}
		function _button() {
			return (!$this->_installed()) ? '' : ($this->_installed() && !$this->_disabled() ? 1 : 0);
		}
		function _order() {
			return 0;
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
				'button' => $this->_button()
			);
			return $render;		
		}
	}
	new WPCC_local_cache();
}