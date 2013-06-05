<p>
    <?php echo Html::anchor('admin/pages/create', Lang::get('Add new Page'), array('class' => 'btn btn-info')); ?>
</p>
<?php if ($pages): ?>
<?php echo Form::open( array('action' => 'admin/pages/selected') ); ?>
<div class="widget widget-table">
    <div class="widget-header">
        <div class="widget-title">
            <h4><?php echo Lang::get('List of pages'); ?></h4>
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
                <th><?php echo Lang::get('Added by'); ?></th>
                <th></th>
                <th><a href="#" class="btn btn-primary" onclick="selectAll($(this), $('.check-option'), '<?php echo Lang::get('Select all'); ?>', '<?php echo Lang::get('Unselect all'); ?>');"><?php echo Lang::get('Select all'); ?></a></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $page): ?>		<tr>

                <td><?php echo Html::anchor('admin/pages/edit/'.$page->id, $page->title); ?></td>
                <td><?php echo $page->slug; ?></td>
                <td><?php echo $page->status ? Lang::get('Active'): Lang::get('Inactive'); ?></td>
                <td><?php echo Html::anchor('admin/users/view/'.$page->users->id, $page->users->username); ?></td>
                <td>
                    <?php echo Html::anchor('/page/view/'.$page->slug, Lang::get('View'), array('target'=>'_blank')); ?> |
                    <?php echo Html::anchor('admin/pages/edit/'.$page->id, Lang::get('Edit')); ?> |
                    <?php echo Html::anchor('admin/pages/delete/'.$page->id, Lang::get('Delete'), array('onclick' => "return confirm('" . Lang::get('Are you sure?') . "')")); ?>

                </td>
                <td> <input type="checkbox" class="check-option" name="check[]" value="<?php echo $page->id ?>"></td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>
</div>

<?php echo Form::close(); ?>
<?php echo Pagination::instance('pagination')->render(); ?>
<?php else: ?>
<p><?php echo Lang::get('No pages.'); ?></p>

<?php endif; ?>
