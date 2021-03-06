<p>
    <?php echo Html::anchor('admin/categories/create', Lang::get('Add new Category'), array('class' => 'btn btn-info')); ?>
</p>
<?php if ($categories): ?>
    <?php echo Form::open( array('action' => 'admin/categories/selected') ); ?>
<div class="widget widget-table">
    <div class="widget-header">
        <div class="widget-title">
            <h4><?php echo Lang::get('List of Categories'); ?></h4>
        </div>
        <div class="pull-right top-select">
            <select name="action">
                <option value="delete"><?php echo Lang::get('Delete selected'); ?></option>
                <option value="deactivate"><?php echo Lang::get('Deactivate selected'); ?></option>
                <option value="activate"><?php echo Lang::get('Activate selected'); ?></option>
            </select>
            <button type="submit" class="btn btn-danger" onclick="return confirm('<?php echo Lang::get('Are you sure?'); ?>');"><?php echo Lang::get('Submit'); ?></button>
        </div>
    </div>
    <div class="widget-content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?php echo Lang::get('Title'); ?></th>
                <th><?php echo Lang::get('Slug'); ?></th>
                <th><?php echo Lang::get('Status'); ?></th>
                <th></th>
                <th><a href="#" class="btn" onclick="selectAll($(this), $('.check-option'), '<?php echo Lang::get('Select all'); ?>', '<?php echo Lang::get('Unselect all'); ?>');"><?php echo Lang::get('Select all'); ?></a></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>		<tr>

                <td><?php echo Html::anchor('admin/categories/edit/'.$category->id, $category->title) . ' (' . count($category->items) . ')' ?></td>
                <td><?php echo $category->slug; ?></td>
                <td><?php echo $category->status ? Lang::get('Active') : Lang::get('Inactive'); ?></td>
                <td>
                    <?php echo Html::anchor('/category/view/'.$category->slug, Lang::get('View'), array('target' => '_blank')); ?> |
                    <?php echo Html::anchor('admin/categories/edit/'.$category->id, Lang::get('Edit')); ?> |
                    <?php echo Html::anchor('admin/categories/delete/'.$category->id, Lang::get('Delete'), array('onclick' => "return confirm('" . Lang::get('Are you sure?') . "')")); ?>

                </td>
                <td> <input type="checkbox" class="check-option" name="check[]" value="<?php echo $category->id ?>"></td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>

</div>

<?php echo Form::close(); ?>
<?php echo Pagination::instance('pagination')->render(); ?>
<?php else: ?>
<p><?php echo Lang::get('No Categories.'); ?></p>

<?php endif; ?>