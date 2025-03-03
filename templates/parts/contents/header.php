<?php
$url = admin_url('admin.php');
$title = ' sortable desc';
$installed = ' sortable desc';
$active = ' sortable desc';
$disabled = ' sortable desc';
$dropdown = ' sortable desc';
$button = ' sortable desc';

$_title = 'desc';
$_installed = 'desc';
$_active = 'desc';
$_disabled = 'desc';
$_dropdown = 'desc';
$_button = 'desc';
			
if(isset($_GET['orderby'])){
	switch($_GET['orderby']){
		case 'title':
			$_title = $_GET['order'] == 'asc' ? 'desc' : 'asc';
			$title = $_GET['order'] == 'asc' ? ' sorted desc' : ' sorted asc';
			break;
		case 'installed':
			$_installed = $_GET['order'] == 'asc' ? 'desc' : 'asc';
			$installed = $_GET['order'] == 'asc' ? ' sorted desc' : ' sorted asc';
			break;
		case 'active':
			$_active = $_GET['order'] == 'asc' ? 'desc' : 'asc';
			$active = $_GET['order'] == 'asc' ? ' sorted desc' : ' sorted asc';
			break;
		case 'disabled':
			$_disabled = $_GET['order'] == 'asc' ? 'desc' : 'asc';
			$disabled = $_GET['order'] == 'asc' ? ' sorted desc' : ' sorted asc';
			break;
		case 'dropdown':
			$_dropdown = $_GET['order'] == 'asc' ? 'desc' : 'asc';
			$dropdown = $_GET['order'] == 'asc' ? ' sorted desc' : ' sorted asc';
			break;
		case 'button':
			$_button = $_GET['order'] == 'asc' ? 'desc' : 'asc';
			$button = $_GET['order'] == 'asc' ? ' sorted desc' : ' sorted asc';
			break;
		default:
			break;
	}
}else{
	$button = ' sorted desc';
	$_button = 'desc';
}
?>
<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label>
  <input id="cb-select-all-1" type="checkbox"></td>
<th scope="col" id="title" class="manage-column column-title column-primary<?=$title?>">
	<?php 
		$args = array('page' => $_GET['page'], 'orderby' => 'title', 'order' => $_title);
		if(isset($_GET['filter'])) $args['filter'] = $_GET['filter'];
	?>
	<a href="<?php echo esc_url(add_query_arg( $args, $url ));?>">
    	<span>Cache Title</span>
        <span class="sorting-indicators">
        	<span class="sorting-indicator asc" aria-hidden="true"></span>
            <span class="sorting-indicator desc" aria-hidden="true"></span>
        </span>
    </a>    
</th>
<th scope="col" id="author" class="manage-column column-installed<?=$installed?>">
	<?php 
		$args = array('page' => $_GET['page'], 'orderby' => 'installed', 'order' => $_installed);
		if(isset($_GET['filter'])) $args['filter'] = $_GET['filter'];
	?>
	<a href="<?php echo esc_url(add_query_arg( $args, $url ));?>">
    	<span>Installed</span>
        <span class="sorting-indicators">
        	<span class="sorting-indicator asc" aria-hidden="true"></span>
            <span class="sorting-indicator desc" aria-hidden="true"></span>
        </span>
    </a>    
</th>
<th scope="col" id="categories" class="manage-column column-active<?=$active?>">
	<?php 
		$args = array('page' => $_GET['page'], 'orderby' => 'active', 'order' => $_active);
		if(isset($_GET['filter'])) $args['filter'] = $_GET['filter'];
	?>
	<a href="<?php echo esc_url(add_query_arg( $args, $url ));?>">
    	<span>Active</span>
        <span class="sorting-indicators">
        	<span class="sorting-indicator asc" aria-hidden="true"></span>
            <span class="sorting-indicator desc" aria-hidden="true"></span>
        </span>
    </a>    
</th>
<th scope="col" id="tags" class="manage-column column-desable<?=$disabled?>">
	<?php 
		$args = array('page' => $_GET['page'], 'orderby' => 'disabled', 'order' => $_disabled);
		if(isset($_GET['filter'])) $args['filter'] = $_GET['filter'];
	?>
	<a href="<?php echo esc_url(add_query_arg( $args, $url ));?>">
    	<span>Disabled</span>
        <span class="sorting-indicators">
        	<span class="sorting-indicator asc" aria-hidden="true"></span>
            <span class="sorting-indicator desc" aria-hidden="true"></span>
        </span>
    </a>    
</th>
<th scope="col" id="comments" class="manage-column column-dropdownmenu<?=$dropdown?>">
	<?php 
		$args = array('page' => $_GET['page'], 'orderby' => 'dropdown', 'order' => $_dropdown);
		if(isset($_GET['filter'])) $args['filter'] = $_GET['filter'];
	?>
	<a href="<?php echo esc_url(add_query_arg( $args, $url ));?>">
    	<span>Dropdown Menu</span>
        <span class="sorting-indicators">
        	<span class="sorting-indicator asc" aria-hidden="true"></span>
            <span class="sorting-indicator desc" aria-hidden="true"></span>
        </span>
    </a>    
</th>
<th scope="col" id="date" class="manage-column column-clearcache<?=$button?>">
	<?php 
		$args = array('page' => $_GET['page'], 'orderby' => 'button', 'order' => $_button);
		if(isset($_GET['filter'])) $args['filter'] = $_GET['filter'];
	?>
    <a href="<?php echo esc_url(add_query_arg( $args, $url ));?>">
        <span>Clear Cache</span>
        <span class="sorting-indicators">
        	<span class="sorting-indicator asc" aria-hidden="true"></span>
            <span class="sorting-indicator desc" aria-hidden="true"></span>
        </span>
    </a> 
</th>
