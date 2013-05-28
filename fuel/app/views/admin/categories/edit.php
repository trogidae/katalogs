<div class="widget">
    <div class="widget-header">
        <div class="widget-title">
            <h4>Edit a category</h4>
        </div>
    </div>
    <div class="widget-content">
<?php echo render('admin\categories/_form', $categories); ?>
    </div>
</div>

<p>
	<?php echo Html::anchor('admin/categories/view/'.$category->id, 'View'); ?> |
	<?php echo Html::anchor('admin/categories', 'Back'); ?></p>
