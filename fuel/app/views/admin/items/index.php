<h2>Listing Items</h2>
<br>
<?php if ($items): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Slug</th>
			<th>Summary</th>
			<th>Content</th>
			<th>Price</th>
			<th>User id</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($items as $item): ?>		<tr>

			<td><?php echo $item->title; ?></td>
			<td><?php echo $item->slug; ?></td>
			<td><?php echo $item->summary; ?></td>
			<td><?php echo $item->content; ?></td>
			<td><?php echo $item->price; ?></td>
			<td><?php echo $item->user_id; ?></td>
			<td><?php echo $item->status; ?></td>
			<td>
				<?php echo Html::anchor('admin/items/view/'.$item->id, 'View'); ?> |
				<?php echo Html::anchor('admin/items/edit/'.$item->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/items/delete/'.$item->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Items.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/items/create', 'Add new Item', array('class' => 'btn btn-success')); ?>

</p>