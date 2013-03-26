<h2>Viewing #<?php echo $category->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $category->title; ?></p>
<p>
	<strong>Slug:</strong>
	<?php echo $category->slug; ?></p>

<?php echo Html::anchor('admin/categories/edit/'.$category->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/categories', 'Back'); ?>