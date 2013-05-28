<?php if ($pages): ?>
<?php echo Form::open( array('action' => 'admin/pages/selected') ); ?>
<div class="widget widget-table">
    <div class="widget-header">
        <div class="widget-title">
            <h4>List of pages</h4>
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
                <th>Author</th>
                <th></th>
                <th><a href="#" class="btn btn-primary" onclick="selectAll($(this), $('.check-option'));">Select all</a></th>
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
                <td> <input type="checkbox" class="check-option" name="check[]" value="<?php echo $page->id ?>"></td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>
</div>

<?php echo Form::close(); ?>

<?php else: ?>
<p>No Pages.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/pages/create', 'Add new Page', array('class' => 'btn btn-success')); ?>

</p>
