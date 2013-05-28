<?php if ($items): ?>
<?php echo Form::open( array('action' => 'admin/items/selected') ); ?>
<div class="widget widget-table">
    <div class="widget-header">
        <div class="widget-title">
            <h4>List of items</h4>
        </div>
        <div class="pull-right">
            <select name="action">
                <option value="delete">Delete selected</option>
                <option value="deactivate">Deactivate selected</option>
                <option value="activate">Activate selected</option>
            </select>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Submit</button>
        </div>
    </div>
    <div class="widget-content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Price</th>
                <th>User id</th>
                <th>Status</th>
                <th></th>
                <th><a href="#" class="btn" onclick="selectAll($(this), $('.check-option'));">Select all</a></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>		<tr>

                <td><?php echo Html::anchor('admin/items/edit/'.$item->id, $item->title); ?></td>
                <td><?php echo $item->slug; ?></td>
                <td><?php echo "Ls " . $item->price; ?></td>
                <td><?php echo Html::anchor('admin/users/view/'.$item->users->id, $item->users->username); ?></td>
                <td><?php echo $item->status ? 'Active': 'Inactive'; ?></td>
                <td>
                    <?php echo Html::anchor('item/view/'.$item->slug, 'View', array('target' => '_blank')); ?> |
                    <?php echo Html::anchor('admin/items/edit/'.$item->id, 'Edit'); ?> |
                    <?php echo Html::anchor('admin/items/delete/'.$item->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

                </td>
                <td> <input type="checkbox" class="check-option" name="check[]" value="<?php echo $item->id ?>"></td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>
</div>

<?php echo Form::close(); ?>

<?php else: ?>
<p>No Items.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/items/create', 'Add new Item', array('class' => 'btn btn-success')); ?>

</p>
