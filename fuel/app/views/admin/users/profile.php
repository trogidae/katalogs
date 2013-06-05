<div class="widget">
    <div class="widget-header">
        <h4><?php echo Lang::get('My profile'); ?></h4>
    </div>
    <div class="widget-content">
        <?php echo Form::open(); ?>

        <fieldset>
            <div class="clearfix">
                <?php echo Form::label(Lang::get('Email'), 'email'); ?>

                <div class="input">
                    <?php echo Form::input('email', Input::post('email', isset($user) ? $user->email : ''), array('class' => 'span4')); ?>

                </div>
            </div>
            <div class="clearfix">
                <div class="input">
                    <label class="checkbox">
                        <?php echo Form::checkbox('change_password', 'yes', false); ?>
                        <?php echo Lang::get('Change password'); ?>
                    </label>
                </div>
            </div>
            <div class="clearfix">
                <?php echo Form::label(Lang::get('Old password'), 'old_password'); ?>

                <div class="input">
                    <?php echo Form::password('old_password', Input::post('old_password', ''), array('class' => 'span4')); ?>
                </div>
            </div>
            <div class="clearfix">
                <?php echo Form::label(Lang::get('New password') . ' (>6)', 'new_password'); ?>

                <div class="input">
                    <?php echo Form::password('new_password', Input::post('new_password', ''), array('class' => 'span4')); ?>
                    <?php echo Form::password('new_password_repeat', Input::post('new_password_repeat', ''), array('class' => 'span4')); ?>
                </div>
            </div>
            <div class="actions">
                <?php echo Form::submit('submit', Lang::get('Save'), array('class' => 'btn btn-primary')); ?>

            </div>
        </fieldset>
        <?php echo Form::close(); ?>
    </div>
</div>

<p><?php echo Html::anchor('admin/users', Lang::get('Back')); ?></p>