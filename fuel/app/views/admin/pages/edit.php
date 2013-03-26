<h2>Editing Page</h2>
<br>

<?php echo render('admin\pages/_form'); ?>
<p>
	<?php echo Html::anchor('/page/view/'.$page->slug, 'View', array('target'=>'_blank')); ?> |
	<?php echo Html::anchor('admin/pages', 'Back'); ?></p>
