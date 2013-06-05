
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#image-list" id="image-list-link"><?php echo Lang::get('Images'); ?></a></li>
    <li><a href="#add-new-image"><?php echo Lang::get('Add a new Image'); ?></a></li>
</ul>


<div class="tab-container">
    <div class="tab-content">
        <div class="tab-pane active" id="image-list">
            <?php if ($images): ?>
            <?php echo Form::open(array('id' => 'delete-selected','action' => 'admin/images/deleteSelected')); ?>
            <div class="clearfix">
                <div class="well well-small span4"><em><?php echo Lang::get('Click on the image'); ?></em></div>
            </div>
            <div class="widget widget-table">
                <div class="widget-header">
                    <div class="widget-title">
                        <h4><?php echo Lang::get('List of images'); ?></h4>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="btn btn" id="select-all" onclick="selectAll($(this), $('.check-delete'), '<?php echo Lang::get('Select all'); ?>', '<?php echo Lang::get('Unselect all'); ?>');"><?php echo Lang::get('Select all'); ?></a>
                        <?php echo Form::submit('submit', Lang::get('Delete selected'), array('onclick' => "return confirm('" . Lang::get('Are you sure?') . "')", 'class' => 'btn btn-danger')); ?>
                    </div>
                </div>
                <div class="widget-content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?php echo Lang::get('Image'); ?></th>
                            <th><?php echo Lang::get('Info'); ?></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($images as $image): ?>
                            <?php if ($image->id!=1): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo Uri::base(false) . $image->thumb . '_medium.' . $image->extension; ?>" rel="lightbox">
                                        <img class="media-object" src="<?php echo Uri::base(false) . $image->thumb . '_100x100.' . $image->extension; ?>">
                                    </a>
                                </td>
                                <td>
                                    <p><?php echo Lang::get('Width'); ?>: <?php echo $image->width; ?></p>
                                    <p><?php echo Lang::get('Height'); ?>: <?php echo $image->height; ?></p>
                                    <p><?php echo Lang::get('Copy medium image link'); ?>:<input type='text' value='<?php echo Uri::base(false) . $image->thumb . '_medium.' . $image->extension; ?>'> </p>
                                    <p><?php echo Lang::get('Copy full image link'); ?>:<input type='text' value='<?php echo Uri::base(false) . $image->path . '/' . $image->name; ?>'></p>
                                </td>
                                <td> <input type="checkbox" class="check-delete" name="delete[]" value="<?php echo $image->id ?>"></td>
                                <td>
                                    <?php echo Html::anchor('admin/images/delete/'.$image->id, Lang::get('Delete'), array('onclick' => "return confirm('" . Lang::get('Are you sure?') . "')", 'class' => 'btn btn-danger')); ?>
                                </td>
                            </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php echo Form::close(); ?>

            <?php else: ?>
            <div class="well well-small alert-danger"><?php echo Lang::get('No images.'); ?></div>
            <?php endif; ?>
            <?php echo Pagination::instance('pagination')->render(); ?>
        </div>
        <div class="tab-pane" id="add-new-image">
            <div class="widget">
                <div class="widget-header">
                    <h4><?php echo Lang::get('Upload images'); ?></h4>
                </div>
                <div class="widget-content">
                    <?php echo render('admin\images/_form'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        /* Tabs */
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
    })
</script>