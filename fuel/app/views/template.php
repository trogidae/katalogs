<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <?php echo Asset::js('jquery.js'); ?>
    <?php echo Asset::js('lightbox.js'); ?>
    <?php echo Asset::css('bootstrap.css'); ?>
    <?php echo Asset::css('lightbox.css'); ?>
    <?php echo Asset::css('custom.css'); ?>
</head>
<body>
<div class="header">
    <div class="topbar">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="main-nav-container">
                    <a class="brand" href="#">Katalogs.lv</a>
                    <ul class="nav">
                        <li class="<?php echo (Uri::segment(1) == '' || Uri::segment(1)=='homepage' ) ? 'active' : '' ?>"><?php echo Html::anchor('/', 'Sākums'); ?></li>
                        <?php foreach ($pages as $page): ?>
                        <li class="<?php echo (Uri::segment(1) == 'page' && Uri::segment(3) == $page['slug']) ? 'active' : '' ?>"><?php echo Html::anchor('page/view/' . $page['slug'], $page['title']); ?></li>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="topbar-lower">
        <ul class="nav nav-pills">
            <?php foreach ($categories as $category): ?>
            <?php if (empty($category->items) && $settings->show_empty_cat==0): ?>
                <?php continue; ?>
                <?php else: ?>
                <?php if ($category->status): ?>
                    <li class="<?php echo (Uri::segment(1) == 'category' && Uri::segment(3)== $category['slug'] ) ? 'active' : '' ?>"><?php echo Html::anchor('category/view/' . $category['slug'], $category['title']); ?></li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="container-fluid content">
    <div id="main-col">
        <div class="row-fluid">
            <?php if (Session::get_flash('success')): ?>
            <div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                <p><?php echo implode('</p><p>', (array) Session::get_flash('success')); ?></p>
            </div>
            <?php endif; ?>
            <?php if (Session::get_flash('error')): ?>
            <div class="alert alert-error">
                <button class="close" data-dismiss="alert">×</button>
                <p><?php echo implode('</p><p>', (array) Session::get_flash('error')); ?></p>
            </div>
            <?php endif; ?>
            <div class="span12">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    <div id="sidebar">
        <div class="sidebar-widget">
            <div class="sidebar-widget-header">
                <h4>Text widget</h4>
            </div>
            <div class="sidebar-widget-content">
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo ligula eget dolor. Aenean massa.
                    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                    Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                </p>
            </div>
        </div>
        <div class="sidebar-widget">
            <div class="sidebar-widget-header">
                <h4>Text widget</h4>
            </div>
            <div class="sidebar-widget-content">
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo ligula eget dolor. Aenean massa.
                    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                    Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                </p>
            </div>
        </div>
        <div class="sidebar-widget">
            <div class="sidebar-widget-header">
                <h4>List widget</h4>
            </div>
            <div class="sidebar-widget-content">
                <ul>
                    <li>One two three</li>
                    <li>One</li>
                    <li><a href="#">One hehe</a></li>
                    <li>One</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="footer-widgets">
    <div class="container">
        <div class="footer-widget">
            <div class="footer-widget-header">
                <h4>List widget</h4>
            </div>
            <div class="footer-widget-content">
                <ul>
                    <li>One two three</li>
                    <li>One</li>
                    <li><a href="#">One hehe</a></li>
                    <li>One</li>
                </ul>
            </div>
        </div>
        <div class="footer-widget">
            <div class="footer-widget-header">
                <h4>Text widget</h4>
            </div>
            <div class="footer-widget-content">
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo ligula eget dolor. Aenean massa.
                    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                    Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                </p>
            </div>
        </div>
        <div class="footer-widget">
            <div class="footer-widget-header">
                <h4>What</h4>
            </div>
            <div class="footer-widget-content">
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo ligula eget dolor. Aenean massa.
                    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                    Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                </p>
            </div>
        </div>
        <div class="footer-widget">
            <div class="footer-widget-header">
                <h4>What</h4>
            </div>
            <div class="footer-widget-content">
                <p>
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Aenean commodo ligula eget dolor. Aenean massa.
                    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                    Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                </p>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="footer-copyright pull-left">
            <p>Copyright 2013</p>
        </div>
        <div class="footer-info pull-right">
            <p>A part of <a href="http://drukasapasaule.lv">Drukas Pasaule</a><br></p>
        </div>
    </div>
</footer>
</body>
</html>