<?php echo Form::open( array('action' => 'message/create') ); ?>

<fieldset>
    <div class="clearfix">
        <?php echo Form::label('Email', 'email'); ?>

        <div class="input">
            <?php echo Form::input('email', Input::post('email', ''), array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label('Phone', 'phone'); ?>

        <div class="input">
            <?php echo Form::input('phone', Input::post('phone', ''), array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label('Name', 'name'); ?>

        <div class="input">
            <?php echo Form::input('name', Input::post('name', ''), array('class' => 'span4')); ?>

        </div>
    </div>
    <div class="clearfix">
        <?php echo Form::label('Message', 'message'); ?>

        <div class="input">
            <?php echo Form::textarea('message', Input::post('message', ''), array('class' => 'span8', 'rows' => 8)); ?>

        </div>
    </div>
    <div class="actions">
        <?php echo Form::submit('submit', 'Send', array('class' => 'btn btn-primary')); ?>

    </div>
</fieldset>
<?php echo Form::close(); ?>