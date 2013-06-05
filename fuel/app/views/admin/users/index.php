<?php if (Auth::has_access('users.write')):?>
<p>
    <?php echo Html::anchor('admin/users/create', Lang::get('Add new User'), array('class' => 'btn btn-info')); ?>
</p>
<?php endif; ?>
<?php if ($users): ?>
<div class="widget widget-table">
    <div class="widget-header">
        <h4><?php echo Lang::get('List of users'); ?></h4>
    </div>
    <div class="widget-content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?php echo Lang::get('Username'); ?></th>
                <th><?php echo Lang::get('Group'); ?></th>
                <th><?php echo Lang::get('Last login'); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>		<tr>

                <td><?php echo $user->username; ?></td>
                <td><?php echo ($user->group==100 ? Lang::get('Administrator') : ( $user->group==50 ? Lang::get('Moderator') : Lang::get('Banned'))); ?></td>
                <td><?php echo Date::forge($user->last_login)->format("%Y/%m/%d %H:%M", true); ?></td>
                <td>
                    <?php echo Html::anchor('admin/users/view/'.$user->id, Lang::get('View')); ?> |
                    <?php if (Auth::has_access('users.write')):?>
                    <?php echo Html::anchor('admin/users/edit/'.$user->id, Lang::get('Edit')); ?> |
                    <?php echo Html::anchor('admin/users/delete/'.$user->id, Lang::get('Delete'), array('onclick' => "return confirm('" . Lang::get('Are you sure?') . "')")); ?>
                    <?php endif;?>
                </td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>
</div>
<?php echo Pagination::instance('pagination')->render(); ?>
<?php else: ?>
<p><?php echo Lang::get('No users.'); ?></p>

<?php endif; ?>
