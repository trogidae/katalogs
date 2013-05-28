<script>
    window.onload = function() {
        CKEDITOR.replace( 'content' );
    };
</script>

<?php echo Form::open(); ?>

	<fieldset>
        <div class="row">
            <div class="widget clearfix span8">
                <div class="widget-header">
                    <h4><?php echo Form::label('Title', 'title'); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::input('title', Input::post('title', isset($page) ? $page->title : ''), array('class' => 'span4')); ?>

                    </div>
                </div>
            </div>
            <div class="widget clearfix span4">
                <div class="widget-header">
                    <h4><?php echo Form::label('Slug', 'slug'); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::input('slug', Input::post('slug', isset($page) ? $page->slug : ''), array('class' => 'span4')); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix">
            <div class="input">
                <?php echo Form::textarea('content', Input::post('content', isset($page) ? $page->content : ''), array('class' => 'span8', 'rows' => 8)); ?>

            </div>
        </div>
        <div class="row">
            <div class="widget clearfix span8">
                <div class="widget-header">
                    <h4><?php echo Form::label('Summary', 'summary'); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::textarea('summary', Input::post('summary', isset($page) ? $page->summary : ''), array('class' => 'span8', 'rows' => 8)); ?>

                    </div>
                </div>
            </div>
            <div class="widget clearfix span4">
                <div class="widget-header">
                    <h4><?php echo Form::label('Status'); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::select('status', Input::post('status', (isset($page)) ? $page->status : '1'),
                        array (
                              '1' => 'Active',
                              '0' => 'Inactive'
                        ));?>
                    </div>
                </div>
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
	</fieldset>
<?php echo Form::close(); ?>