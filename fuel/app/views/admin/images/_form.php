<?php echo Form::open( array('id' => 'upload','action' => '', 'enctype' => 'multipart/form-data') ); ?>

	<fieldset>
        <div class="clearfix">
            <div class="input">
                <?php echo Form::file('files[]', array('id' => 'fileupload', 'multiple' => '')); ?>
            </div>
        </div>
        <div id="progress" class="progress progress-success progress-striped">
            <div class="bar"></div>
        </div>

		<div class="actions">
           <p></p>
		</div>
	</fieldset>
<?php echo Form::close(); ?>

<script src="<?php echo URI::base(false); ?>assets/upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo URI::base(false); ?>assets/upload/js/jquery.iframe-transport.js"></script>
<script src="<?php echo URI::base(false); ?>assets/upload/js/jquery.fileupload.js"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo URI::base(false); ?>admin/images/create';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                        'width',
                        progress + '%'
                );
               $('.actions p').text('<?php echo Lang::get('Done!'); ?>').addClass('well well-small alert-success');
                setTimeout(function(){ $('.actions p').hide(); $('#progress .bar').width(0); },5000);
            },
            progressall: function (e, data) {
            }
        });
    });
</script>
