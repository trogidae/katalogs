<?php echo render('admin\items/_form', $data); ?>
<p>
	<?php echo Html::anchor('admin/items/view/'.$item->id, 'View'); ?> |
	<?php echo Html::anchor('admin/items', 'Back'); ?></p>
