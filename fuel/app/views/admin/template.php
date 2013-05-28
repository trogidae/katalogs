<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
    <?php echo Asset::js('ckeditor/ckeditor.js'); ?>
    <?php echo Asset::js('jquery.js'); ?>
    <?php echo Asset::js('jquery-ui-1.8.18.custom.min.js'); ?>
    <?php echo Asset::js('bootstrap.js'); ?>
    <?php echo Asset::js('jquery.smooth-scroll.min.js'); ?>
    <?php echo Asset::js('lightbox.js'); ?>
    <?php echo Asset::js('functions.js'); ?>
    <?php echo Asset::css('bootstrap.css'); ?>
    <?php echo Asset::css('lightbox.css'); ?>
    <?php echo Asset::css('admin.css'); ?>
	<script>
		$(function(){ $('.topbar').dropdown(); });
	</script>
</head>
<body>

	<?php if ($current_user): ?>
    <div class="navbar navbar-inverse navbar-fixed-top" id="top-navbar">
        <div class="navbar-inner">
            <div class="container">
                <?php echo Html::anchor('/', 'My Site', array ('class'=> 'brand', 'title'=> 'Click to go to main site')) ?>
                <ul class="nav pull-right">
                    <li class="settings-link">
                        <?php echo Html::anchor('admin/settings', 'Settings') ?>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $current_user->username ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?php echo Html::anchor('admin/logout', 'Logout') ?></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
	<div class="subnavbar" id="top-segments-bar">
	    <div class="subnavbar-inner">
	        <div class="container">
	            <ul class="nav">
	                <li class="<?php echo Uri::segment(2) == '' ? 'active' : '' ?>">
						<?php echo Html::anchor('admin', '<i class="icon-home icon-white"></i><span>Dashboard</span>') ?>
					</li>

					<?php foreach (glob(APPPATH.'classes/controller/admin/*.php') as $controller): ?>

						<?php
						$section_segment = basename($controller, '.php');
						$section_title = Inflector::humanize($section_segment);
						?>
	                <li class="<?php echo Uri::segment(2) == $section_segment ? 'active' : '' ?>">
                        <?php if ($section_segment=='messages') $iconHtml = '<i class="icon-envelope icon-white"></i>';
                              else if ($section_segment=='users') $iconHtml = '<i class="icon-user icon-white"></i>';
                              else if ($section_segment=='settings') $iconHtml = '<i class="icon-cog icon-white"></i>';
                              else if ($section_segment=='items') $iconHtml = '<i class="icon-shopping-cart icon-white"></i>';
                              else if ($section_segment=='images') $iconHtml = '<i class="icon-picture icon-white"></i>';
                              else $iconHtml = '<i class="icon-book icon-white"></i>';
                        ?>
						<?php echo Html::anchor('admin/'.$section_segment, $iconHtml . '<span>' . $section_title . '</span><span class="caret"></span>') ?>
					</li>
					<?php endforeach; ?>
	          </ul>
            <div class="pull-left">
                <h1><?php echo $title; ?></h1>
            </div>
	        </div>
	    </div>
	</div>
	<?php endif; ?>

	<div class="main container">
		<div class="row">
			<div class="span12">
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
			</div>
			<div class="span12">
<?php echo $content; ?>
			</div>
		</div>
	</div>
    <footer>
        <p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
        <p>
            <a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
            <small>Version: <?php echo e(Fuel::VERSION); ?></small>
        </p>
    </footer>
</body>
</html>
