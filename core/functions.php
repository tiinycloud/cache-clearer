<?php
function wpcc_e_thml($txt){
	esc_html_e( $txt, WPCC_CLEANER_NAME );
}
function wpcc_print($ary){
	echo __( '<pre>', WPCC_CLEANER_NAME );
	print_r($ary);
	echo __( '</pre>', WPCC_CLEANER_NAME );
}
function wpcc_url($qstr) {
    $admin_url = admin_url();
    $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $backend_url = str_replace( $admin_url, '', $current_url );
	$sep = strpos($backend_url, '?') !== false ? '&' : '?';
    return $backend_url.$sep.$qstr;
}
function wpcc_sort($cache_list, $order_by = 'order', $order = 'SORT_DESC'){
	$order_by = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : $order_by;
	$order = isset($_REQUEST['order']) ? 'SORT_'.strtoupper($_REQUEST['order']) : $order;
	if(!empty($order) && !empty($order_by) && is_array($cache_list)){
		$keys = array_column($cache_list, $order_by);
		if($order == 'SORT_ASC') array_multisort($keys, SORT_ASC, $cache_list);
		else array_multisort($keys, SORT_DESC, $cache_list);
	}
	return $cache_list;	
}
function wpcc_status($data, $field){
	$check = 'wpcc-checked';
	switch($data[$field]){
		case '1':
			$disabled = $field == 'dropdown' ? '' : 'disabled="disabled"';
			$status = '<input type="checkbox" data-nonce="'.wp_create_nonce("ajax_nonce").'" data-id="'.$data['id'].'" class="'.$field.'" checked="checked"'.$disabled.' value="1">';
			$status .= $field == 'dropdown' ? '<span class="wpcc-slider round"></span>' : '<span class="checkmark"></span>';
			break;	
		case '0':
			$disabled = $field == 'dropdown' ? '' : 'disabled="disabled"';
			$status = '<input type="checkbox"'.$disabled.' data-nonce="'.wp_create_nonce("ajax_nonce").'" data-id="'.$data['id'].'" class="'.$field.'" value="1">';
			$status .= $field == 'dropdown' ? '<span class="wpcc-slider round"></span>' : '<span class="checkmark"></span>';
			break;	
		default:
			$check = 'wpcc-unchecked';
			$disabled = $field == 'dropdown' ? 'disabled="disabled"' : 'disabled="disabled"';
			$status = '<input type="checkbox"'.$disabled.' data-nonce="'.wp_create_nonce("ajax_nonce").'" data-id="'.$data['id'].'" class="'.$field.'" value="1">';
			$status .= $field == 'dropdown' ? '<span class="wpcc-slider round"></span>' : '<span class="uncheckmark"></span>';
			break;	
	}
	$status = '<label class="wpcc-check '.$check.$field.'">'.$status.'</label>';
	return $status;
}
function wpcc_is_active($name, $extenion='plugin'){
	$status = false;
	switch($extenion){
		case 'plugin':
			$status = is_plugin_active($name);
			break;	
		case 'theme':
			if( $name == get_option( 'template' ) )$status = true;
			break;	
		default:
			$status = false;
			break;	
	}
	return $status;
}