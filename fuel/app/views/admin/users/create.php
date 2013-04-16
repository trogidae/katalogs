<h2>New User</h2>
<br>

<?php //echo render('admin/users/_form'); ?>

<?php echo Form::open() ?>

<div> <input type="text" name="username" placeholder="Username (>4)" required> </div>
<div> <input type="password" name="password" placeholder="Password (>8)" required> </div>
<div> <input type="password" name="password-repeat" placeholder="Password" required> </div>
<div> <input type="text" name="email" placeholder="E-mail" required> </div>
<div>
    <select name="group" required>
        <option value="100">Administrator</option>
        <option value="50">Moderator</option>
        <option value="-1">Banned</option>
    </select>
</div>
<div> <button type="submit" class="btn">Submit</button> </div>
<?php echo Form::close() ?>


<p><?php echo Html::anchor('admin/users', 'Back'); ?></p>
