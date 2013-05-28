
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#image-list" id="image-list-link">Images</a></li>
    <li><a href="#add-new-image">Add a new Image</a></li>
</ul>


<div class="tab-container">
    <div class="tab-content">
        <div class="tab-pane active" id="image-list">
            <?php if ($images): ?>
            <?php echo Form::open(array('id' => 'delete-selected','action' => 'admin/images/deleteSelected')); ?>
            <div class="clearfix">
                <div class="well well-small span4"><em>Click on the image to see it bigger.</em></div>
            </div>
            <div class="widget widget-table">
                <div class="widget-header">
                    <div class="widget-title">
                        <h4>List of images</h4>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="btn btn" id="select-all" onclick="selectAll($(this), $('.check-delete'));">Select all</a>
                        <?php echo Form::submit('submit', 'Delete selected', array('onclick' => "return confirm('Are you sure?')", 'class' => 'btn btn-danger')); ?>
                    </div>
                </div>
                <div class="widget-content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Info</th>
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
                                    <p>Width: <?php echo $image->width; ?></p>
                                    <p>Height: <?php echo $image->height; ?></p>
                                    <p>Copy medium image link:<input type='text' value='<?php echo Uri::base(false) . $image->thumb . '_medium.' . $image->extension; ?>'> </p>
                                    <p>Copy full image link:<input type='text' value='<?php echo Uri::base(false) . $image->path . '/' . $image->name; ?>'></p>
                                </td>
                                <td> <input type="checkbox" class="check-delete" name="delete[]" value="<?php echo $image->id ?>"></td>
                                <td>
                                    <?php echo Html::anchor('admin/images/delete/'.$image->id, 'Delete', array('onclick' => "return confirm('Are you sure?')", 'class' => 'btn btn-danger')); ?>
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
            <div class="well well-small alert-danger">No Images.</div>
            <?php endif; ?>

        </div>
        <div class="tab-pane" id="add-new-image">
            <div class="widget">
                <div class="widget-header">
                    <h4>Upload images</h4>
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