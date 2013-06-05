<div class="widget">
    <div class="widget-header">
        <h4><?php echo Lang::get('New user'); ?></h4>
    </div>
    <div class="widget-content">
        <?php echo Form::open() ?>
        <div class="input">
            <input type="text" name="username" placeholder="<?php echo Lang::get('Username'); ?> >4" required />
        </div>
        <div class="input">
            <input type="password" name="password" placeholder="<?php echo Lang::get('Password'); ?> (>6)" required />
            <input type="password" name="password-repeat" placeholder="<?php echo Lang::get('Password'); ?>" required />
        </div>
        <div class="input">
            <input type="text" name="email" placeholder="<?php echo Lang::get('Email'); ?>" required>
        </div>
        <div class="input">
            <select name="group" required>
                <option value="100"><?php echo Lang::get('Administrator'); ?></option>
                <option value="50"><?php echo Lang::get('Moderator'); ?></option>
                <option value="-1"><?php echo Lang::get('Banned'); ?></option>
            </select>
        </div>
        <div class="actions"> <button type="submit" class="btn"><?php echo Lang::get('Save'); ?></button> </div>
        <?php echo Form::close() ?>
    </div>
</div>

<p><?php echo Html::anchor('admin/users', Lang::get('Back')); ?></p>
