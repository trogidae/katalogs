<h2>Editing Category</h2>
<br>
<?php echo render('admin\categories/_form'); ?>
<p>
	<?php echo Html::anchor('admin/categories/view/'.$category->id, 'View'); ?> |
	<?php echo Html::anchor('admin/categories', 'Back'); ?></p>
