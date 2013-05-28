<?php if ($users): ?>
<div class="widget widget-table">
    <div class="widget-header">
        <h4>List of users</h4>
    </div>
    <div class="widget-content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Username</th>
                <th>Group</th>
                <th>Last login</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>		<tr>

                <td><?php echo $user->username; ?></td>
                <td><?php echo ($user->group==100 ? 'Administrator' : ( $user->group==50 ? 'Moderator' : 'Banned')); ?></td>
                <td><?php echo Date::forge($user->last_login)->format("%Y/%m/%d %H:%M", true); ?></td>
                <td>
                    <?php echo Html::anchor('admin/users/view/'.$user->id, 'View'); ?> |
                    <?php if (Auth::has_access('users.write')):?>
                    <?php echo Html::anchor('admin/users/edit/'.$user->id, 'Edit'); ?> |
                    <?php echo Html::anchor('admin/users/delete/'.$user->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>
                    <?php endif;?>
                </td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>
</div>
<?php else: ?>
<p>No Users.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/users/create', 'Add new User', array('class' => 'btn btn-success')); ?>

</p>
