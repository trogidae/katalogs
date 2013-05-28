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
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/katalogs/public/assets/upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/katalogs/public/assets/upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/katalogs/public/assets/upload/js/jquery.fileupload.js"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '/katalogs/public/admin/images/create';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
               $('.actions p').text('Done!').addClass('well well-small alert-success');
                setTimeout(function(){ $('.actions p').hide(); $('#progress .bar').width(0); },5000);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                        'width',
                        progress + '%'
                );
            }
        });
    });
</script>
