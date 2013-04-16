<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Username', 'username'); ?>

            <?php echo Form::hidden('username', $user->username); ?>

			<div class="well well-small span3">
				<?php echo $user->username; ?>
			</div>
		</div>

        <div class="clearfix">
            <?php echo Form::label('Group'); ?>

            <div class="input">
                <?php echo Form::select('group', Input::post('group', (isset($user)) ? $user->group : '50'),
                array (
                      '100' => 'Administrator',
                      '50' => 'Moderator',
                      '-1' => 'Banned'
                ));?>
            </div>
        </div>
		<div class="clearfix">
			<?php echo Form::label('Email', 'email'); ?>

			<div class="input">
				<?php echo Form::input('email', Input::post('email', isset($user) ? $user->email : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>