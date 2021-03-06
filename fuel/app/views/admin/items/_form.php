<script>
    window.onload = function() {
        CKEDITOR.replace( 'content', {language: 'lv'});
    };
</script>

<?php echo Form::open(); ?>

	<fieldset>
        <div class="row">
            <div class="widget clearfix span8">
                <div class="widget-header">
                    <h4><?php echo Form::label(Lang::get('Title'), 'title'); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::input('title', Input::post('title', isset($item) ? $item->title : ''), array('class' => 'span4')); ?>

                    </div>
                </div>
            </div>
            <div class="widget clearfix span4">
                <div class="widget-header">
                    <h4><?php echo Form::label(Lang::get('Slug'), 'slug'); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::input('slug', Input::post('slug', isset($item) ? $item->slug : ''), array('class' => 'span4')); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">
                <div class="input">
                    <?php echo Form::textarea('content', Input::post('content', isset($item) ? $item->content : ''), array('class' => 'span8', 'rows' => 8)); ?>

                </div>
        </div>
        <div class="row">
            <div class="widget clearfix span8">
                <div class="widget-header">
                    <h4><?php echo Form::label(Lang::get('Summary'), 'summary'); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::textarea('summary', Input::post('summary', isset($item) ? $item->summary : ''), array('class' => 'span8', 'rows' => 7)); ?>

                    </div>
                </div>
            </div>
            <div class="widget clearfix span4">
                <div class="widget-header">
                    <h4><?php echo Form::label(Lang::get('Price'), 'price'); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::input('price', Input::post('price', isset($item) ? $item->price : ''), array('class' => 'span4')); ?>

                    </div>
                </div>
            </div>
            <div class="widget clearfix span4">
                <div class="widget-header">
                    <h4><?php echo Form::label(Lang::get('Status')); ?></h4>
                </div>
                <div class="widget-content">
                    <div class="input">
                        <?php echo Form::select('status', Input::post('status', (isset($item)) ? $item->status : '1'),
                        array (
                              '1' => Lang::get('Active'),
                              '0' => Lang::get('Inactive')
                        ));?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="widget clearfix span3">
                <div class="widget-header">
                    <h4><?php echo Lang::get('Categories'); ?></h4>
                </div>
                <div class="widget-content">
                    <?php foreach ($categories as $category):?>
                    <div class="input">
                        <label class="checkbox"><?php echo Form::checkbox('categories[]', $category->id, (isset($item->categories[$category->id])) ? true : false);?><?php echo $category->title;?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="clearfix">
                <div class="widget featured-image-info span3">
                    <div class="widget-header">
                        <h4><?php echo Lang::get('Featured image')?>: </h4>
                    </div>
                    <div class="widget-content">
                        <p><?php echo Lang::get('No image chosen')?></p>
                        <div class="input">
                            <a href="#chooseAnImage" id="choose-image" class="btn btn-info" data-toggle="modal"><?php echo Lang::get('Choose image')?></a>
                        </div>
                    </div>
                </div>
                <div class="widget gallery-info span6">
                    <div class="widget-header">
                        <h4><?php echo Lang::get('Gallery images')?>: </h4>
                    </div>
                    <div class="widget-content">
                        <p><?php echo Lang::get('No images chosen')?></p>
                        <div class="input">
                            <a href="#chooseAnImage" id="choose-image" class="btn btn-info" data-toggle="modal"><?php echo Lang::get('Choose images')?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">
            <div class="input">
                <?php echo Form::hidden('user_id', Input::post('user_id', isset($item) ? $item->user_id : $current_user->id), array('class' => 'span4')); ?>
                <?php echo Form::hidden('image_id', Input::post('image_id', isset($item) ? $item->image_id : '1')) ?>
                <?php if (isset($item)) {
                $gallery = null;
                foreach($item->gallery as $img) {
                    $gallery = $gallery . "," . $img->id;
                }}
                ?>
                <?php echo Form::hidden('gallery', Input::post('gallery', isset($item) ? $gallery : null)) ?>
            </div>
        </div>
		<div class="actions">
			<?php echo Form::submit('submit', Lang::get('Save'), array('class' => 'btn btn-primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>

<!-- Modal -->
<div id="chooseAnImage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="chooseAnImage" aria-hidden="true">
    <div class="modal-header clearfix">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?php echo Lang::get('Choose an image')?></h3>
    </div>
    <div class="modal-body">
        <?php echo render('admin\items/images', $images); ?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success btn-large span4 pull-right" data-dismiss="modal" aria-hidden="true"><?php echo Lang::get('Save')?></button>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#image-list-link').on('click', function(){
            $('#images-list').load('<?php echo Finder::search('items', 'images/index'); ?> #images-list', function(){
                fillGalleryCheck($('#form_gallery'), '<?php echo Lang::get('No images chosen')?>');
                fillFeaturedImage($('#form_image_id'), '<?php echo Lang::get('Remove as featured image')?>');
            });
        });

        fillGalleryCheck($('#form_gallery'), '<?php echo Lang::get('No images chosen')?>');
        fillFeaturedImage($('#form_image_id'), '<?php echo Lang::get('Remove as featured image')?>');
    });
</script>