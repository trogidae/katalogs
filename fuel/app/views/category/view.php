<h2>Category <em><?php echo $info->title;?></em></h2>

<ul class="thumbnails">
<?php foreach ($info->items as $item): ?>

    <li class="span2">
        <div class="thumbnail">
            <img src="/katalogs/public/media/thumb_IMG_0194.jpg" alt="">
            <h3><?php echo $item->title; ?></h3>
            <p><?php echo $item->summary; ?></p>
            <?php echo Html::anchor('item/view/' . $item->slug, 'Read More', array('class' => 'btn btn-primary')); ?>
        </div>
    </li>


<?php endforeach; ?>
</ul>
