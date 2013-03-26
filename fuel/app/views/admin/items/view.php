<h2>Viewing #<?php echo $item->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $item->title; ?></p>
<p>
	<strong>Slug:</strong>
	<?php echo $item->slug; ?></p>
<p>
	<strong>Summary:</strong>
	<?php echo $item->summary; ?></p>
<p>
	<strong>Content:</strong>
	<?php echo $item->content; ?></p>
<p>
	<strong>Price:</strong>
	<?php echo $item->price; ?></p>
<p>
	<strong>User id:</strong>
	<?php echo $item->user_id; ?></p>
<p>
	<strong>Status:</strong>
	<?php echo $item->status; ?></p>

<?php echo Html::anchor('admin/items/edit/'.$item->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/items', 'Back'); ?>