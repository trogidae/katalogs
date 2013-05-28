<div class="widget">
    <div class="widget-header">
        <h4>Viewing #<?php echo $user->id; ?></h4>
    </div>
    <div class="widget-content">
        <p>
            <strong>Username:</strong>
            <?php echo $user->username; ?></p>
        <p>
            <strong>Group:</strong>
            <?php echo $user->group; ?></p>
        <p>
            <strong>Email:</strong>
            <a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></p>
        <p>
            <strong>Last login:</strong>
            <?php echo $user->last_login; ?></p>
        <p>
            <strong>Profile fields:</strong>
            <?php $user->profile_fields; ?></p>
    </div>
</div>

<?php echo Html::anchor('admin/users/edit/'.$user->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/users', 'Back'); ?>