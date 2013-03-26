<h2>Listing Pages</h2>
<br>
<?php if ($pages): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Slug</th>
			<th>Status</th>
			<th>Author</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($pages as $page): ?>		<tr>

			<td><?php echo Html::anchor('admin/pages/edit/'.$page->id, $page->title); ?></td>
			<td><?php echo $page->slug; ?></td>
			<td><?php echo $page->status ? 'Active': 'Inactive'; ?></td>
			<td><?php echo Html::anchor('admin/users/view/'.$page->users->id, $page->users->username); ?></td>
			<td>
				<?php echo Html::anchor('/page/view/'.$page->slug, 'View', array('target'=>'_blank')); ?> |
				<?php echo Html::anchor('admin/pages/edit/'.$page->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/pages/delete/'.$page->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Pages.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/pages/create', 'Add new Page', array('class' => 'btn btn-success')); ?>

</p>
