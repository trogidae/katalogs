<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Email'), 'email'); ?>

			<div class="input">
				<?php echo Form::input('email', Input::post('email', isset($message) ? $message->email : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Phone'), 'phone'); ?>

			<div class="input">
				<?php echo Form::input('phone', Input::post('phone', isset($message) ? $message->phone : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Name'), 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($message) ? $message->name : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Message'), 'message'); ?>

			<div class="input">
				<?php echo Form::textarea('message', Input::post('message', isset($message) ? $message->message : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', Lang::get('Save'), array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>