<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title *', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($page) ? $page->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Slug', 'slug'); ?>

			<div class="input">
				<?php echo Form::input('slug', Input::post('slug', isset($page) ? $page->slug : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Summary', 'summary'); ?>

			<div class="input">
				<?php echo Form::textarea('summary', Input::post('summary', isset($page) ? $page->summary : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Content *', 'content'); ?>

			<div class="input">
				<?php echo Form::textarea('content', Input::post('content', isset($page) ? $page->content : ''), array('class' => 'span8', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Status *'); ?>

			<div class="input">
                <?php echo Form::select('status', Input::post('status', (isset($page)) ? $page->status : '1'),
                array (
                      '1' => 'Active',
                      '0' => 'Inactive'
                ));?>
            </div>

		</div>
		<div class="clearfix">
			<div class="input">
				<?php echo Form::hidden('user_id', Input::post('user_id', isset($page) ? $page->user_id : $current_user->id), array('class' => 'span4')); ?>
			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
        <div class="footnote">
            <p>* - required fields</p>
        </div>
	</fieldset>
<?php echo Form::close(); ?>