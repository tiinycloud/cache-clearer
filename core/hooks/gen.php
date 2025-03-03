<?php
function wpcc_init() {
	(new wpcc('modules'))->inc('base');
	$directory = WPCC_CLEANER_PATH.'modules';
	$dir = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST
		);
	foreach ($dir as $item) {
		if ($item->isDir()) {
			(new wpcc('modules'))->inc($item->getFilename().'/cache');
		}
	}
}
add_action('init', 'wpcc_init');
function wpcc_option_handler() {
	global $cache_list;
	$id = $_REQUEST['id'];
	$option = $_REQUEST['option'];
	$data = $cache_list[$id];
	$res = array();
	if ( !wp_verify_nonce( $_REQUEST['nonce'], "ajax_nonce")) return;
	if($option == '1'){
		if (get_option($id) !== false) {
			update_option($id, $option);
		} else {
			add_option($id, $option);
		}
		$cache_list[$id]['dropdown'] = 1;
		$title= strpos($data['title'], 'Clear') !== false ? '' : 'Clear '.$data['title'];
		$title.= strpos($title, 'Cache') !== false ? '' : 'Cache';
		$premium_s = $cache_list[$id]['premium'] ? '' : '<a onClick="wpcc_clear_'.$id.'_cache(this)" class="ab-item" href="#">';
		$premium_e = $cache_list[$id]['premium'] ? '' : '</a>';
		$res['add'] = '<li id="wp-admin-bar-'.$id.'" class="menu_cust_child">'.$premium_s.'<span data-wpnonce="'.wp_create_nonce('wpcc_clear_cache_'.$value['id']).'">'.$title.'</span>'.$premium_e.'</li>';
	}elseif($option == '0') {
		$cache_list[$id]['dropdown'] = 0;
		if (get_option($id) !== false) {
			update_option($id, 0);
		} else {
			add_option($id, 0);
		}
	}
	$key = array_search(1, array_column($cache_list, 'dropdown'));
	if(!$key){
		$res['remove'] = true;
	}
	$result = json_encode($res);
	echo $result;
	die();
}
add_action("wp_ajax_wpcc_option", "wpcc_option_handler");
add_action("wp_ajax_nopriv_wpcc_option", "wpcc_option_handler");
function wpcc_footer() {
    echo '<div style="display:none;" class="wpcc_cache_response"><p class="wpcc_success">Cache cleared successfully</p></div>';
}
add_action( 'wp_footer', 'wpcc_footer' );
add_action('admin_footer', 'wpcc_footer');