<h2>Listing Categories</h2>
<br>
<?php if ($categories): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Slug</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($categories as $category): ?>		<tr>

			<td><?php echo Html::anchor('admin/categories/edit/'.$category->id, $category->title) . ' (' . count($category->items) . ')' ?></td>
			<td><?php echo $category->slug; ?></td>
			<td>
				<?php echo Html::anchor('admin/categories/view/'.$category->id, 'View'); ?> |
				<?php echo Html::anchor('admin/categories/edit/'.$category->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/categories/delete/'.$category->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Categories.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/categories/create', 'Add new Category', array('class' => 'btn btn-success')); ?>

</p>
