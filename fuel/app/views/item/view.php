<h2>Item <em><?php echo $info->title; ?></em></h2>

<p><strong><?php echo ($info->price ? $settings->currency . " " . $info->price : '');?></strong></p>

<?php if ($info->images->id!=1): ?>

<p>
    <a href="<?php echo Uri::base(false) . $info->images->path . $info->images->name; ?>" class="span4 thumbnail">
        <img src="<?php echo Uri::base(false) . $info->images->thumb . '_medium.' . $info->images->extension; ?>">
    </a>
</p>

<?php endif; ?>

<div class="gallery-thumbs">
    <?php if ($info->images->id!=1): ?>
    <a href="<?php echo Uri::base(false) . $info->images->path . $info->images->name; ?>" class="span2 thumbnail">
        <img src="<?php echo Uri::base(false) . $info->images->thumb . '_150x200.' . $info->images->extension; ?>">
    </a>
    <?php endif; ?>
    <?php if (isset($info->gallery)): ?>
    <?php foreach ($info->gallery as $img) : ?>
        <?php if ($img->id!=$info->images->id): ?>
        <a href="<?php echo Uri::base(false) . $img->path . $img->name; ?>" class="span2 thumbnail">
            <img src="<?php echo Uri::base(false) . $img->thumb . '_150x200.' . $img->extension; ?>">
        </a>
        <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>



<p><?php echo $info->content; ?></p>