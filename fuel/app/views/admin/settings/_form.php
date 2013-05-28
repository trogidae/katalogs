<?php echo Form::open(); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Frontpage category', 'frontpage_category'); ?>

			<div class="input">
                <?php $categories_arr = array();
                foreach ($categories as $cat) {
                    $categories_arr = $categories_arr + array($cat->id => $cat->title);
                }
                ?>
                <?php echo Form::select('frontpage_category', Input::post('frontpage_category', isset($setting) ? $setting->frontpage_category : '1'), $categories_arr); ?>
            </div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Show empty categories', 'show_empty_cat'); ?>

			<div class="input">
				<?php echo Form::select('show_empty_cat', Input::post('show_empty_cat', isset($setting) ? $setting->show_empty_cat : '0'), array('0' => 'No', '1' => 'Yes'), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Currency', 'currency'); ?>

			<div class="input">
				<?php echo Form::input('currency', Input::post('currency', isset($setting) ? $setting->currency : ''), array('class' => 'span4')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Language', 'language'); ?>

			<div class="input">
				<?php echo Form::input('language', Input::post('language', isset($setting) ? $setting->language : ''), array('class' => 'span4')); ?>

			</div>
		</div>
        <div class="clearfix">
            <?php echo Form::label('Contact page', 'contact_page'); ?>

            <div class="input">
                <?php $pages_arr = array( null => 'None' );
                foreach ($pages as $page) {
                    $pages_arr = $pages_arr + array($page->id => $page->title);
                }
                ?>
                <?php echo Form::select('contact_page', Input::post('contact_page', isset($setting) ? $setting->contact_page : 'None'), $pages_arr); ?>
            </div>
        </div>
        <div class="clearfix">
            <?php echo Form::label('Contact e-mail', 'contact_email'); ?>

            <div class="input">
                <?php echo Form::input('contact_email', Input::post('contact_email', isset($setting) ? $setting->contact_email : ''), array('class' => 'span4')); ?>

            </div>
        </div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>