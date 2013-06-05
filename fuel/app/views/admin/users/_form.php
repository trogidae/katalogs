<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Username'), 'username'); ?>

            <?php echo Form::hidden('username', $user->username); ?>

			<div class="well well-small span3">
				<?php echo $user->username; ?>
			</div>
		</div>

        <div class="clearfix">
            <?php echo Form::label(Lang::get('Group')); ?>

            <div class="input">
                <?php echo Form::select('group', Input::post('group', (isset($user)) ? $user->group : '50'),
                array (
                      '100' => Lang::get('Administrator'),
                      '50' => Lang::get('Moderator'),
                      '-1' => Lang::get('Banned')
                ));?>
            </div>
        </div>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Email'), 'email'); ?>

			<div class="input">
				<?php echo Form::input('email', Input::post('email', isset($user) ? $user->email : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', Lang::get('Save'), array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>