<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($category) ? $category->title : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Slug', 'slug'); ?>

			<div class="input">
				<?php echo Form::input('slug', Input::post('slug', isset($category) ? $category->slug : ''), array('class' => 'span4')); ?>

			</div>
		</div>
        <div class="clearfix">
            <?php echo Form::label('Parent', 'parent_id'); ?>

            <div class="input">
                <?php $parent_arr = array('0' => 'None');
                foreach ($categories as $cat)
                    {
                        if (isset($category)) {
                            if ($cat->id != $category->id && $cat->parent_id != $category->id) {
                                $parent_arr = $parent_arr + array($cat->id => $cat->title);
                            }
                        }
                        else {
                            $parent_arr = $parent_arr + array($cat->id => $cat->title);
                        }
                    }
                ?>
                <?php echo Form::select('parent_id', Input::post('parent_id', isset($category) ? $category->parent_id : '0'), $parent_arr); ?>

            </div>
        </div>
        <div class="clearfix">
            <?php echo Form::label('Status'); ?>

            <div class="input">
                <?php echo Form::select('status', Input::post('status', (isset($category)) ? $category->status : '1'),
                array (
                      '1' => 'Active',
                      '0' => 'Inactive'
                ));?>
            </div>
        </div>

		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>