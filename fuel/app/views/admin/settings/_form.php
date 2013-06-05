<?php echo Form::open(); ?>

<fieldset>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Site title'), 'site_title'); ?>

        <div class="input">
            <?php echo Form::input('site_title', Input::post('site_title', isset($settings) ? $settings['site_title']->value : ''), array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Site description'), 'site_description'); ?>

        <div class="input">
            <?php echo Form::input('site_description', Input::post('site_description', isset($settings) ? $settings['site_description']->value : ''), array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Frontpage category'), 'frontpage_category'); ?>

        <div class="input">
            <?php $categories_arr = array();
            foreach ($categories as $cat) {
                $categories_arr = $categories_arr + array($cat->id => $cat->title);
            }
            ?>
            <?php echo Form::select('frontpage_category', Input::post('frontpage_category', isset($settings) ? $settings['frontpage_category']->value : '1'), $categories_arr); ?>
        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Default category'), 'default_category'); ?>

        <div class="input">
            <?php $categories_arr = array();
            foreach ($categories as $cat) {
                $categories_arr = $categories_arr + array($cat->id => $cat->title);
            }
            ?>
            <?php echo Form::select('default_category', Input::post('default_category', isset($settings) ? $settings['default_category']->value : '1'), $categories_arr); ?>
        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Show empty categories'), 'show_empty_cat'); ?>

        <div class="input">
            <?php echo Form::select('show_empty_cat', Input::post('show_empty_cat', isset($settings) ? $settings['show_empty_cat']->value : '0'), array('0' => Lang::get('No'), '1' => Lang::get('Yes')), array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Items per page'), 'items_per_page'); ?>

        <div class="input">
            <?php echo Form::select('items_per_page', Input::post('items_per_page', isset($settings) ? $settings['items_per_page']->value : '16'),
            array('8' => '8',
                  '12' => '12',
                  '16' => '16',
                  '20' => '20',
                  '24' => '24',
                  '28' => '28',),
            array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Currency'), 'currency'); ?>

        <div class="input">
            <?php echo Form::input('currency', Input::post('currency', isset($settings) ? $settings['currency']->value : ''), array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Language'), 'language'); ?>

        <div class="input">
            <?php echo Form::select('language', Input::post('language', isset($settings) ? $settings['language']->value : '0'), $languages, array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Contact page'), 'contact_page'); ?>

        <div class="input">
            <?php $pages_arr = array( null => Lang::get('None') );
            foreach ($pages as $page) {
                $pages_arr = $pages_arr + array($page->id => $page->title);
            }
            ?>
            <?php echo Form::select('contact_page', Input::post('contact_page', isset($settings) ? $settings['contact_page']->value : 'None'), $pages_arr); ?>
        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label(Lang::get('Contact e-mail'), 'contact_email'); ?>

        <div class="input">
            <?php echo Form::input('contact_email', Input::post('contact_email', isset($settings) ? $settings['contact_email']->value : ''), array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="actions">
        <?php echo Form::submit('submit', Lang::get('Save'), array('class' => 'btn btn-primary')); ?>

    </div>
</fieldset>
<?php echo Form::close(); ?>