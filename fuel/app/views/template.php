<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <?php echo Asset::css('bootstrap.css'); ?>
    <?php echo Asset::css('custom.css'); ?>
    <style>
        body { margin: 40px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="#">Katalogs.lv</a>
            <ul class="nav">
                <li class="<?php echo (Uri::segment(1) == '' || Uri::segment(1)=='homepage' ) ? 'active' : '' ?>"><?php echo Html::anchor('/', 'Sākums'); ?></li>
                <?php foreach ($pages as $page): ?>
                <li class="<?php echo (Uri::segment(1) == 'page' && Uri::segment(3) == $page['slug']) ? 'active' : '' ?>"><?php echo Html::anchor('page/view/' . $page['slug'], $page['title']); ?></li>
                <? endforeach; ?>
            </ul>
        </div>
    </div>
    <ul class="nav nav-pills">
        <?php foreach ($categories as $category): ?>
        <li class="<?php echo (Uri::segment(1) == 'category' && Uri::segment(3)== $category['slug'] ) ? 'active' : '' ?>"><?php echo Html::anchor('category/view/' . $category['slug'], $category['title']); ?></li>
        <? endforeach; ?>
    </ul>
    <hr>
    <div class="row-fluid">
        <?php if (Session::get_flash('success')): ?>
        <div class="alert-message success">
            <p>
                <?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
            </p>
        </div>
        <?php endif; ?>
        <?php if (Session::get_flash('error')): ?>
        <div class="alert-message error">
            <p>
                <?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
            </p>
        </div>
        <?php endif; ?>
        <div class="span12">
            <?php echo $content; ?>
        </div>
    </div>
    <footer>
        <hr>
        <p class="pull-right">Copyright 2013</p>
        <p>
            A part of <a href="http://drukasapasaule.lv">Drukas Pasaule</a><br>
        </p>
    </footer>
</div>
</body>
</html>