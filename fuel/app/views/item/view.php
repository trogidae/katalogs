<div id="product-page">
    <h2><?php echo $info->title; ?></h2>

    <div class="product-images">

        <div class="main-image">
            <?php if ($info->images->id!=1): ?>
            <a href="<?php echo Uri::base(false) . $info->images->thumb . '_medium.' . $info->images->extension; ?>" class="thumbnail" rel="lightbox" id="mainImage">
                <img src="<?php echo Uri::base(false) . $info->images->thumb . '_medium.' . $info->images->extension; ?>">
            </a>
            <?php elseif (!empty($info->gallery)): ?>
            <a href="<?php echo Uri::base(false) . $info->images->thumb . '_medium.' . $info->images->extension; ?>" class="thumbnail" rel="lightbox" id="mainImage">
                <img src="<?php echo Uri::base(false) . $info->images->thumb . '_medium.' . $info->images->extension; ?>">
            </a>
            <?php endif; ?>
        </div>
        <div class="product-short-info">
            <div class="product-summary">
                <?php echo $info->summary; ?>
            </div>
            <?php if($info->price): ?>
            <div class="product-price">
                <a href="#" onclick="return false;" class="btn btn-primary btn-large disabled"><?php echo Lang::get('Price');?>: <?php echo ($info->price ? $settings['currency']->value . " " . $info->price : '');?></a>
            </div>
            <?php endif;?>
            <div class="contact-us">
                <?php echo Html::anchor('page/view/' . $contact_page, Lang::get('Order'), array('class' => 'btn btn-large')); ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>

        <div class="gallery-thumbs thumbnails">
            <?php if ($info->images->id!=1 && !empty($info->gallery)): ?>
            <li>
                <a onclick="changeMainImage($(this), $('#mainImage')); return false;" href="<?php echo Uri::base(false) . $info->images->thumb . '_medium.' . $info->images->extension; ?>" class="span2 thumbnail">
                    <img src="<?php echo Uri::base(false) . $info->images->thumb . '_150x200.' . $info->images->extension; ?>">
                </a>
            </li>
            <?php endif; ?>
            <?php if (!empty($info->gallery)): ?>
            <?php foreach ($info->gallery as $img) : ?>
                <?php if ($img->id!=$info->images->id): ?>
                    <li>
                        <a onclick="changeMainImage($(this), $('#mainImage')); return false;" href="<?php echo Uri::base(false) . $img->thumb . '_medium.' . $img->extension; ?>" class="span2 thumbnail">
                            <img src="<?php echo Uri::base(false) . $img->thumb . '_150x200.' . $img->extension; ?>">
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="product-info">
        <?php echo $info->content; ?>
    </div>
</div>


