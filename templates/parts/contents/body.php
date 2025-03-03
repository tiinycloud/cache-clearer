<?php
global $cache_list;
if(function_exists('wpcc_sort'))$sorted_list = wpcc_sort($cache_list, 'button', 'SORT_DESC');
foreach($sorted_list as $key => $value){
	$is_inst = isset($value['installed']) && $value['installed'] ? ' is-installed' : '';
	$scheck = isset($value['active']) && $value['active'] == 1 ? '' : ' disabled="disabled"';
	$scheck = $value['premium'] ? ' disabled="disabled"' : $scheck;
	if(isset($_GET['filter']) && $value[$_GET['filter']] != '1') continue;
?>
    <tr id="post-1" class="<?=$is_inst?>">
      <th scope="row" class="check-column">
        <input id="cb-select-1" type="checkbox" name="post[]" value="1">
      </th>
      <td class="title column-title wpcc-body-title" data-colname="Title"><?=ucwords($value['title'])?></strong>
      </td>
      <td class="installed column-installed">
         <?=wpcc_status($value, 'installed')?>
      </td>
      <td class="active column-active">
         <?=wpcc_status($value, 'active')?>
      </td>
      <td class="disabled column-disabled">
         <?=wpcc_status($value, 'disabled')?>
      </td>
      <td class="dropdownmenu column-dropdownmenu">
         <?=wpcc_status($value, 'dropdown')?>
      </td>
      <td class="column-button wpcc-button"><a onclick="wpcc_clear_<?=$value['id']?>_cache(this)" class="wpcc-small"<?=$scheck?>><span data-wpnonce="<?=wp_create_nonce('wpcc_clear_cache_'.$value['id'])?>"><?php wpcc_e_thml('Clear Cache') ?></span></a></td>
    </tr>
<?php }?>
