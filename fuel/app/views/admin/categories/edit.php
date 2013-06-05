<div class="widget">
    <div class="widget-header">
        <div class="widget-title">
            <h4><?php echo Lang::get('Edit A Category'); ?></h4>
        </div>
    </div>
    <div class="widget-content">
<?php echo render('admin\categories/_form', $categories); ?>
    </div>
</div>

<p>
	<?php echo Html::anchor('admin/categories', Lang::get('Back')); ?></p>
