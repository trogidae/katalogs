<div class="widget span4 login offset3">
    <div class="widget-header">
        <?php echo Lang::get('Log in'); ?>
    </div>
    <div class="widget-content">
        <?php echo Form::open(array()); ?>

        <?php if (isset($_GET['destination'])): ?>
        <?php echo Form::hidden('destination',$_GET['destination']); ?>
        <?php endif; ?>

        <div class="row">
            <label for="email"><?php echo Lang::get('Email or username'); ?>:</label>
            <div class="input"><?php echo Form::input('email', Input::post('email')); ?></div>

        </div>

        <div class="row">
            <label for="password"><?php echo Lang::get('Password'); ?>:</label>
            <div class="input"><?php echo Form::password('password'); ?></div>

        </div>

        <div class="actions">
            <?php echo Form::submit(array('value'=>Lang::get('Log in'), 'name'=>'submit', 'class'=>'btn btn-primary')); ?>
        </div>

        <?php echo Form::close(); ?>
    </div>
    <div class="back-link">
        <?php echo Html::anchor('/homepage', '<-' .  Lang::get('Go back')); ?>
    </div>
</div>