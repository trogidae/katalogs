<?php
    $itemsInRow = 3;
?>
<ul id="items">
    <div class="row">
    <?php $counter=1; foreach ($items as $item): ?>
    <?php $itemHtml=0;
        if ($counter-1%$itemsInRow == 0): ?>
    </div>
    <div class="row">
    <?php endif; ?>
    <li class="span3">
        <?php if ($item->images->id!=1): ?>
        <?php $itemHtml = '<img src=' . Uri::base(false) . $item->images->thumb . '_150x200.' . $item->images->extension . ' alt=' . $item->images->alt_text . '>' ;?>
        <?php endif; ?>
        <?php $itemHtml = $itemHtml . '<h4>' . $item->title  . '</h4>' . '<p>' . $item->summary . '</p>'; ?>
        <?php if ($item->price != $item->price): ?>
        <?php $itemHtml = $itemHtml . '<div class="btn-group">
            <button class="btn disabled old-price">' . $settings->currency . ' ' . $item->price . '</button>
            <button class="btn disabled new-price">' . $settings->currency . ' ' . $item->price . '</button>
        </div>'; ?>
        <?php else: ?>
        <?php $itemHtml = $itemHtml . '<button class="btn disabled new-price">' . $settings->currency . ' ' . $item->price . '</button>'; ?>
        <?php endif; ?>
        <?php echo Html::anchor('item/view/' . $item->slug, $itemHtml); ?>
    </li>
    <?php $counter++; ?>
    <?php endforeach; ?>
    </div>
</ul>