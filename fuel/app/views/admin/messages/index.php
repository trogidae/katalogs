<?php if ($messages): ?>
<?php echo Form::open( array('action' => 'admin/messages/selected') ); ?>
<div class="widget widget-table">
    <div class="widget-header">
        <div class="widget-title">
            <h4>List of messages</h4>
        </div>
        <div class="pull-right">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete selected</button>
        </div>
    </div>
    <div class="widget-content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th></th>
                <th><a href="#" class="btn" onclick="selectAll($(this), $('.check-option'));">Select all</a></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>		<tr>

                <td><?php echo $message->email; ?></td>
                <td><?php echo $message->name; ?></td>
                <td>
                    <?php echo Html::anchor('admin/messages/view/'.$message->id, 'View'); ?> |
                    <?php echo Html::anchor('admin/messages/delete/'.$message->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

                </td>
                <td> <input type="checkbox" class="check-option" name="check[]" value="<?php echo $message->id ?>"></td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>
</div>

<?php echo Form::close(); ?>

<?php else: ?>
<p>No Messages.</p>

<?php endif; ?>
