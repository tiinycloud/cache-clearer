<?php
if(!class_exists('WPCC_topMenu')){
	class WPCC_topMenu{
		
		public $top_menu_id = 'wpcc-top-menu';

		function __construct() {
			global $cache_items;
			$cache_items = $this->top_menu_id;
			add_action( 'admin_bar_menu', array($this, 'admin_bar_items'), 500 );
		}
		function admin_bar_items(WP_Admin_Bar $admin_bar ) {
			if ( ! current_user_can( 'manage_options' ) ) return;
			$this->parent_menu($admin_bar);
			$this->child_menus($admin_bar);
		}
		function parent_menu($admin_bar){
			$admin_bar->add_menu( array(
				'id'    => $this->top_menu_id,
				'parent' => null,
				'title' => __( 'Cache Clearer', WPCC_CLEANER_NAME),
				'href'  => false
			) );
		}
		function child_menus($admin_bar) {
			$this->clear_all_cache($admin_bar);
			$this->dashboard($admin_bar);
			$this->premium($admin_bar);
			$this->spacer($admin_bar);
			$this->show_menu($admin_bar);
		}
		function clear_all_cache($admin_bar) {
			$admin_bar->add_menu(
				array(
					'parent' => $this->top_menu_id,
					'title'  => __( 'Clear All Caches', WPCC_CLEANER_NAME),
					'id'     => 'wpcc-clear-all-cache',
					'href'   => esc_url(admin_url( 'admin.php?page=cache-cleaner' )),
		
				)
			);
		}
		function dashboard($admin_bar) {
			$admin_bar->add_menu(
				array(
					'parent' => $this->top_menu_id,
					'title'  => __( 'Dashboard', WPCC_CLEANER_NAME),
					'id'     => 'wpcc-dashboard',
					'href'   => esc_url(admin_url( 'admin.php?page=cache-dashboard' )),
		
				)
			);
		}
		function premium($admin_bar) {
			$admin_bar->add_menu(
				array(
					'parent' => $this->top_menu_id,
					'title'  => __( 'Premium', WPCC_CLEANER_NAME),
					'id'     => 'wpcc-premium',
					'href'   => esc_url(admin_url( 'admin.php?page=cache-premium' )),
		
				)
			);
		}
		function spacer($admin_bar) {
			global $cache_list;
			if(!is_array($cache_list)) return;
			$dropdown = array_column($cache_list, 'dropdown');
			$key = in_array(1, array_column($cache_list, 'dropdown'));
			if($key){
				$admin_bar->add_menu(
					array(
						'parent' => $this->top_menu_id,
						'title'  => __( '-------------------', WPCC_CLEANER_NAME),
						'id'     => 'wpcc-spacer',
						'href'   => false,
			
					)
				);
			}
		}
		function show_menu($admin_bar) {
			global $cache_list;
			if(function_exists('wpcc_sort'))$sorted_list = wpcc_sort($cache_list, 'title', 'SORT_ASC');
			if(is_array($sorted_list)){
				foreach($sorted_list as $key => $value){
					if($value['dropdown'] != '1') continue;
					$premium = $value['premium'] ? false : '#';
					$title= strpos($value['title'], 'Clear') !== false ? '' : 'Clear '.$value['title'];
					$title.= strpos($title, 'Cache') !== false ? '' : 'Cache';
					$args = array(
						'parent' => $this->top_menu_id,
						'title'  => sprintf('<span data-wpnonce="%1$s">%2$s</span>', wp_create_nonce('wpcc_clear_cache_'.$value['id']), esc_html($title, WPCC_CLEANER_NAME)),						
						'id'     => $key,
						'href'   => $premium,//esc_url(admin_url( 'admin.php?page=cache-dashboard&cache='.$value['id'] )),
						'meta' => array(
						   'onclick' => 'wpcc_clear_'.$value['id'].'_cache(this)',
						   'class' => 'menu_cust_child'
						 )
			
					);
					$admin_bar->add_menu($args);
				}
			}
		}
	}
	new WPCC_topMenu();
}