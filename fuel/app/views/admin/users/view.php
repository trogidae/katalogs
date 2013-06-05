<div class="widget">
    <div class="widget-header">
        <h4><?php echo Lang::get('User'); ?> #<?php echo $user->id; ?></h4>
    </div>
    <div class="widget-content">
        <p>
            <strong><?php echo Lang::get('Username'); ?>:</strong>
            <?php echo $user->username; ?></p>
        <p>
            <strong><?php echo Lang::get('Group'); ?>:</strong>
            <?php echo $user->group; ?></p>
        <p>
            <strong><?php echo Lang::get('Email'); ?>:</strong>
            <a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></p>
        <p>
            <strong><?php echo Lang::get('Last login'); ?>:</strong>
            <?php echo $user->last_login; ?></p>
    </div>
</div>

<?php if (Auth::has_access('users.write')) echo Html::anchor('admin/users/edit/'.$user->id, Lang::get('Edit')); ?> |
<?php echo Html::anchor('admin/users', Lang::get('Back')); ?>