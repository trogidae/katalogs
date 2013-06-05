<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Type'), 'type'); ?>

			<div class="input">
                <?php echo Form::select('type', Input::post('types', (isset($widget)) ? $widget->type : '1'),
                array (
                      '1' => Lang::get('Sidebar'),
                      '2' => Lang::get('Footer')
                ));?>
			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Title'), 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($widget) ? $widget->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label(Lang::get('Content'), 'content'); ?>

			<div class="input">
				<?php echo Form::textarea('content', Input::post('content', isset($widget) ? $widget->content : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
        <div class="clearfix">
            <?php echo Form::label(Lang::get('Position'), 'position'); ?>

            <div class="input">
                <?php echo Form::input('position', Input::post('position', isset($widget) ? $widget->position : ''), array('class' => 'span4')); ?>

            </div>
        </div>
		<div class="actions">
			<?php echo Form::submit('submit', Lang::get('Save'), array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>