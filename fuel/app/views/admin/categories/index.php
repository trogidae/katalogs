<?php if ($categories): ?>
    <?php echo Form::open( array('action' => 'admin/categories/selected') ); ?>
<div class="widget widget-table">
    <div class="widget-header">
        <div class="widget-title">
            <h4>List of categories</h4>
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
                <th>Status</th>
                <th></th>
                <th><a href="#" class="btn" onclick="selectAll($(this), $('.check-option'));">Select all</a></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>		<tr>

                <td><?php echo Html::anchor('admin/categories/edit/'.$category->id, $category->title) . ' (' . count($category->items) . ')' ?></td>
                <td><?php echo $category->slug; ?></td>
                <td><?php echo $category->status ? "Active" : "Inactive"; ?></td>
                <td>
                    <?php echo Html::anchor('/category/view/'.$category->slug, 'View', array('target' => '_blank')); ?> |
                    <?php echo Html::anchor('admin/categories/edit/'.$category->id, 'Edit'); ?> |
                    <?php echo Html::anchor('admin/categories/delete/'.$category->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

                </td>
                <td> <input type="checkbox" class="check-option" name="check[]" value="<?php echo $category->id ?>"></td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>

</div>

<?php echo Form::close(); ?>

<?php else: ?>
<p>No Categories.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/categories/create', 'Add new Category', array('class' => 'btn btn-success')); ?>

</p>
