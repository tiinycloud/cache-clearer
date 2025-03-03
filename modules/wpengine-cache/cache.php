<?php
if(!class_exists('WPCC_wpengine_cache')){
	class WPCC_wpengine_cache extends wpcc_base{
		private $title = 'WPEngine Cache';
		private $id = 'wpengine-cache';
		private $plugin = '';
		function __construct() {
			global $cache_list;
			$this->plugin = $this->id.'/'.$this->id.'.php';
			$cache_list[$this->id] = $this->_render();
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
			return 3;
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
	new WPCC_wpengine_cache();
}