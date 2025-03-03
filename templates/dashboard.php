<div class="wpcc-admin">
	<?php (new wpcc('templates'))->inc('header', 'parts');?>
    <h1 id="wpcc-heading" class="wp-heading-inline"><?php wpcc_e_thml('Dashboard'); ?></h1>
    <div class="wrap">
        <?php (new wpcc('templates'))->inc('list', 'parts');?>
        <?php (new wpcc('templates'))->inc('top', 'parts/filter');?>
        <?php (new wpcc('templates'))->inc('content', 'parts');?>
        <div class="bottom"><?php (new wpcc('templates'))->inc('bottom', 'parts/filter');?></div>
    </div>    
</div>