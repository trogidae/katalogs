<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#images-list" id="image-list-link">Images</a></li>
    <li><a href="#add-new-image">Add a new Image</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="images-list">
        <?php if ($images): ?>
        <div class="clearfix">
            <div class="well well-small span4"><em>Click on the image to see it bigger.</em></div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Image</th>
                <th>Info</th>
                <th>Add to product gallery</th>
                <th>Add as featured image</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($images as $image): ?>
                <?php if ($image->id!=1): ?>
                <tr>
                    <td>
                        <a href="<?php echo Uri::base(false) . $image->thumb . '_medium.' . $image->extension; ?>" rel="lightbox">
                            <img class="media-object" id="image-<?php echo $image->id ?>" src="<?php echo Uri::base(false) . $image->thumb . '_100x100.' . $image->extension; ?>">
                        </a>
                    </td>
                    <td>
                        <p>Width: <?php echo $image->width; ?></p>
                        <p>Height: <?php echo $image->height; ?></p>
                        <p>Alt text: <?php echo $image->alt_text; ?></p>
                        <p>Copy medium image link:<input type='text' value='<?php echo Uri::base(false) . $image->thumb . '_medium.' . $image->extension; ?>'> </p>
                        <p>Copy full image link:<input type='text' value='<?php echo Uri::base(false) . $image->path . '/' . $image->name; ?>'></p>
                    </td>
                    <td> <input type="checkbox" class="check-gallery" name="gallery[]" id="<?php echo $image->id ?>" value="<?php echo $image->id ?>" onchange="addGalleryCheck($(this), $('#form_gallery'));"></td>
                    <td>
                        <a href="#" class="btn btn-primary add-featured-image" id="featured-<?php echo $image->id ?>" onclick="addFeaturedImage($(this), $('.add-featured-image'), $('#form_image_id'));">Add as featured image</a>
                    </td>
                </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>


        <?php else: ?>
        <div class="well well-small alert-danger">No Images.</div>
        <?php endif; ?>

    </div>
    <div class="tab-pane" id="add-new-image">
        <?php echo render('admin\images/_form'); ?>
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