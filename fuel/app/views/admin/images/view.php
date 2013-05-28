<h2>Viewing #<?php echo $image->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $image->name; ?></p>
<p>
	<strong>Path:</strong>
	<?php echo $image->path; ?></p>
<p>
	<strong>Width:</strong>
	<?php echo $image->width; ?></p>
<p>
	<strong>Height:</strong>
	<?php echo $image->height; ?></p>
<p>
	<strong>Alt Text:</strong>
	<?php echo $image->alt_text; ?></p>

<?php echo Html::anchor('admin/images/edit/'.$image->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/images', 'Back'); ?>