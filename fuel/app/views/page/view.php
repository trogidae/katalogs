<h2><?php echo $info->title ?></h2>

<p><?php echo $info->content;?></p>

<?php if ($info->id==$settings->contact_page) echo render('page/_form'); ?>