<h2><em><?php echo $info->title;?></em></h2>
<?php
$itemsInRow = 3;
?>
<ul id="items" class="thumbnails">
    <div class="row">
<?php $counter=0; foreach ($items as $item): ?>
    <?php $itemHtml=null;
    if ($counter == 4):
        $counter=0; ?>
    </div>
    <div class="row">
    <?php endif; ?>
    <li class="span4">
            <?php $itemHtml = '<img src=' . Uri::base(false) . $item->images->thumb . '_150x200.' . $item->images->extension . ' alt=' . $item->images->name . '>' ;?>
            <?php $itemHtml = $itemHtml . '<h4>' . $item->title  . '</h4>' . '<p>' . $item->summary . '</p>'; ?>
            <?php if ($item->price): ?>
            <?php $itemHtml = $itemHtml . '<button class="btn disabled new-price">' . $settings['currency']->value . ' ' . $item->price . '</button>'; ?>
            <?php endif; ?>
            <?php echo Html::anchor('item/view/' . $item->slug, $itemHtml, array('class' => 'thumbnail')); ?>
    </li>
    <?php $counter++; ?>

<?php endforeach; ?>
    </div>
</ul>
<?php echo Pagination::instance('pagination')->render(); ?>
<script>
    $(window).load(function() {
        sameHeight($('#items .row'), $('li a'));
    });
</script>