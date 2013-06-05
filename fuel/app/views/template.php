<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title . " | " . $settings['site_title']->value; ?></title>
    <?php echo Asset::js('jquery.js'); ?>
    <?php echo Asset::js('lightbox.js'); ?>
    <?php echo Asset::js('jquery.js'); ?>
    <?php echo Asset::js('functions.js'); ?>
    <?php echo Asset::js('bootstrap.js'); ?>
    <?php echo Asset::css('bootstrap.css'); ?>
    <?php echo Asset::css('lightbox.css'); ?>
    <?php echo Asset::css('custom.css'); ?>
    <script>
        $(function(){ $('.drowpdown').dropdown(); });
        $(window).load(function () {
            $(".header .topbar-lower .nav li:last-child").css('border-right', 'none');
            $("#items .row li:last-child").css('margin', '0');
            equalHeights($('#main-col'), $('#sidebar'));
        });
    </script>
    <!--[if lt IE 9]>
    <script>
        document.createElement('footer');
    </script>
    <![endif]-->
    <?php Config::set('language', $settings['language']->value);
    Lang::load('app_phrases'); ?>
</head>
<body>
<div class="header">
    <div class="topbar">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="main-nav-container">
                    <a class="brand" href="#"><?php echo $settings['site_title']->value; ?></a>
                    <ul class="nav">
                        <li class="<?php echo (Uri::segment(1) == '' || Uri::segment(1)=='homepage' ) ? 'active' : '' ?>"><?php echo Html::anchor('/', Lang::get('Home')); ?></li>
                        <?php foreach ($pages as $page): ?>
                        <li class="<?php echo (Uri::segment(1) == 'page' && Uri::segment(3) == $page['slug']) ? 'active' : '' ?>"><?php echo Html::anchor('page/view/' . $page['slug'], $page['title']); ?></li>
                        <? endforeach; ?>
                    </ul>
                    <div class="pull-right">
                        <form class="form-search" action="<?php echo Uri::base(false); ?>item/search" method="post">
                            <div class="input-append">
                                <input type="text" class="span2 search-query" name="search-query">
                                <button type="submit" class="btn"><?php echo Lang::get('Search'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="topbar-lower">
        <ul class="nav nav-pills">
            <?php $done = array();
            foreach ($categories as $category): ?>
            <?php if (isset($done[$category->id]) || (empty($category->items) && $settings['show_empty_cat']->value==0)): ?>
                <?php continue; ?>
            <?php else: ?>
                <?php if (isset($withChildren[$category->id])): ?>
                    <li class="<?php echo (Uri::segment(1) == 'category' && Uri::segment(3)== $category['slug'] ) ? 'active ' : '' ?>dropdown"><?php echo Html::anchor('category/view/' . $category['slug'], $category['title'] . '<b class="caret"></b>'); ?>
                    <ul class="dropdown-menu">
                        <?php if (is_array($withChildren[$category->id])):
                            foreach ($withChildren[$category->id] as $child): ?>
                            <?php if (isset($done[$child->id]) || (empty($child->items) && $settings['show_empty_cat']->value==0)): ?>
                                <?php continue; ?>
                            <?php else: ?>
                            <li class="<?php echo (Uri::segment(1) == 'category' && Uri::segment(3)== $child['slug'] ) ? 'active ' : '' ?>"><?php echo Html::anchor('category/view/' . $child['slug'], $child['title']); ?></li>
                                <?php $done += array ($child->id => $child->id); ?>
                            <?php endif; ?>
                        <?php endforeach;
                                else: ?>
                          <?php if (!isset($done[$category->id]) && (!empty($category->items) && $settings['show_empty_cat']->value!=0)): ?>
                              <li class="<?php echo (Uri::segment(1) == 'category' && Uri::segment(3)== $withChildren[$category->id]['slug'] ) ? 'active ' : '' ?>"><?php echo Html::anchor('category/view/' . $withChildren[$category->id]['slug'], $withChildren[$category->id]['title']); ?></li>
                              <?php $done += array ($withChildren[$category->id]->id => $withChildren[$category->id]->id); ?>
                          <?php endif; ?>
                      <?php endif; ?>
                    </ul>
                    </li>
                <?php else: ?>
                    <li class="<?php echo (Uri::segment(1) == 'category' && Uri::segment(3)== $category['slug'] ) ? 'active' : '' ?>"><?php echo Html::anchor('category/view/' . $category['slug'], $category['title']); ?></li>
                <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="container content">
    <div class="row">
        <div id="main-col" class="span8">
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
                <div class="main-content">
                    <?php echo $content; ?>
                </div>
        </div>
        <div id="sidebar" class="span4">
            <?php if (is_array($widgets['sidebar'])):
            foreach ($widgets['sidebar'] as $widget): ?>
                <div class="sidebar-widget">
                    <div class="sidebar-widget-header">
                        <h4><?php echo $widget->title; ?></h4>
                    </div>
                    <div class="sidebar-widget-content">
                        <?php echo $widget->content; ?>
                    </div>
                </div>
                <?php endforeach;
        else:
            if (!empty($widgets['sidebar'])): ?>
                <div class="sidebar-widget">
                    <div class="sidebar-widget-header">
                        <h4><?php echo $widgets['sidebar']->title; ?></h4>
                    </div>
                    <div class="sidebar-widget-content">
                        <?php echo $widgets['sidebar']->content; ?>
                    </div>
                </div>
                <?php endif; endif; ?>
        </div>
    </div>
</div>
<div class="footer-widgets">
    <div class="container">
        <?php if (is_array($widgets['footer'])):
        $counter = 0;?>
        <div class="row">
        <?php foreach ($widgets['footer'] as $widget):
            if ($counter==4) { echo "</div><div class='row'>"; $counter=0; } ?>
        <div class="footer-widget">
            <div class="footer-widget-header">
                <h4><?php echo $widget->title; ?></h4>
            </div>
            <div class="footer-widget-content">
                <?php echo $widget->content; ?>
            </div>
        </div>
        <?php $counter++; ?>
        <?php endforeach; ?>
        </div>
        <?php else:
            if (!empty($widgets['footer'])): ?>
            <div class="footer-widget">
                <div class="footer-widget-header">
                    <h4><?php echo $widgets['footer']->title; ?></h4>
                </div>
                <div class="footer-widget-content">
                    <?php echo $widgets['footer']->content; ?>
                </div>
            </div>
        <?php endif; endif; ?>
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