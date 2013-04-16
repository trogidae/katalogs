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
            <?php echo Form::label('Status'); ?>

            <div class="input">
                <?php echo Form::select('status', Input::post('status', (isset($item)) ? $item->status : '1'),
                array (
                      '1' => 'Active',
                      '0' => 'Inactive'
                ));?>
            </div>
        </div>
        <div class="clearfix">
            <?php echo 'Categories'; ?>
            <?php foreach ($categories as $category):?>
            <div class="input">
                <?php echo Form::checkbox('categories[]', $category->id, (isset($item->categories[$category->id])) ? true : false);?><label><?php echo $category->title;?></label>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="clearfix">
            <div class="input">
                <?php echo Form::hidden('user_id', Input::post('user_id', isset($item) ? $item->user_id : $current_user->id), array('class' => 'span4')); ?>
            </div>
        </div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>