<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($item) ? $item->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Slug', 'slug'); ?>

			<div class="input">
				<?php echo Form::input('slug', Input::post('slug', isset($item) ? $item->slug : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Summary', 'summary'); ?>

			<div class="input">
				<?php echo Form::textarea('summary', Input::post('summary', isset($item) ? $item->summary : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Content', 'content'); ?>

			<div class="input">
				<?php echo Form::textarea('content', Input::post('content', isset($item) ? $item->content : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Price', 'price'); ?>

			<div class="input">
				<?php echo Form::input('price', Input::post('price', isset($item) ? $item->price : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('User id', 'user_id'); ?>

			<div class="input">
				<?php echo Form::input('user_id', Input::post('user_id', isset($item) ? $item->user_id : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Status', 'status'); ?>

			<div class="input">
				<?php echo Form::input('status', Input::post('status', isset($item) ? $item->status : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>