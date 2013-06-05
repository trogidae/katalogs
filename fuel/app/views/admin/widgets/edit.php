<div class="widget">
    <div class="widget-header">
        <h4><?php echo Lang::get('Editing widget'); ?></h4>
    </div>
    <div class="widget-content">
        <?php echo render('admin\widgets/_form'); ?>
    </div>
</div>

<p>
	<?php echo Html::anchor('admin/widgets', Lang::get('Back')); ?></p>
