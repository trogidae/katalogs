<div class="widget">
    <div class="widget-header">
        <h4>New User</h4>
    </div>
    <div class="widget-content">
        <?php echo Form::open() ?>
        <input type="text" name="username" placeholder="Username (>4)" required />
        <input type="password" name="password" placeholder="Password (>8)" required />
        <input type="password" name="password-repeat" placeholder="Password" required />
        <input type="text" name="email" placeholder="E-mail" required>
        <select name="group" required>
            <option value="100">Administrator</option>
            <option value="50">Moderator</option>
            <option value="-1">Banned</option>
        </select>
        <div class="actions"> <button type="submit" class="btn">Submit</button> </div>
        <?php echo Form::close() ?>
    </div>
</div>

<p><?php echo Html::anchor('admin/users', 'Back'); ?></p>
