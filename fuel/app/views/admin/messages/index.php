<?php if ($messages): ?>
<?php echo Form::open( array('action' => 'admin/messages/selected') ); ?>
<div class="widget widget-table">
    <div class="widget-header">
        <div class="widget-title">
            <h4><?php echo Lang::get('List of messages')?></h4>
        </div>
        <div class="pull-right top-select">
            <button type="submit" class="btn btn-danger" onclick="return confirm('<?php echo Lang::get('Are you sure?')?>');"><?php echo Lang::get('Delete selected')?></button>
        </div>
    </div>
    <div class="widget-content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?php echo Lang::get('Email')?></th>
                <th><?php echo Lang::get('Name')?></th>
                <th></th>
                <th><a href="#" class="btn" onclick="selectAll($(this), $('.check-option'), '<?php echo Lang::get('Select all')?>', '<?php echo Lang::get('Unselect all')?>');"><?php echo Lang::get('Select all')?></a></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>		<tr>

                <td><?php echo $message->email; ?></td>
                <td><?php echo $message->name; ?></td>
                <td>
                    <?php echo Html::anchor('admin/messages/view/'.$message->id, Lang::get('View')); ?> |
                    <?php echo Html::anchor('admin/messages/delete/'.$message->id, Lang::get('Delete'), array('onclick' => "return confirm('" . Lang::get('Are you sure?') . "')")); ?>

                </td>
                <td> <input type="checkbox" class="check-option" name="check[]" value="<?php echo $message->id ?>"></td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>
</div>

<?php echo Form::close(); ?>
<?php echo Pagination::instance('pagination')->render(); ?>
<?php else: ?>
<p><?php echo Lang::get('No messages.')?></p>

<?php endif; ?>
