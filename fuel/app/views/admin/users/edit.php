<div class="widget">
    <div class="widget-header">
        <h4><?php echo Lang::get('Editing user'); ?></h4>
    </div>
    <div class="widget-content">
        <?php echo render('admin/users/_form'); ?>
    </div>
</div>


<p>	<?php echo Html::anchor('admin/users', Lang::get('Back')); ?></p>
