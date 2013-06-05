<div class="row">
    <div class="widget big-statistics">
        <div class="widget-content">
            <div class="stat">
                <h3><?php echo Model_Category::count(); ?></h3>
                <span class="value"><?php echo Lang::get('Categories'); ?></span>
            </div>
            <div class="stat">
                <h3><?php echo Model_Item::count(); ?></h3>
                <span class="value"><?php echo Lang::get('Items'); ?></span>
            </div>
            <div class="stat">
                <h3><?php echo Model_Page::count(); ?></h3>
                <span class="value"><?php echo Lang::get('Pages'); ?></span>
            </div>
            <div class="stat">
                <h3><?php echo Model_Message::count(); ?></h3>
                <span class="value"><?php echo Lang::get('Messages'); ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="widget span4">
		<div class="widget-header">
            <h4><?php echo Lang::get('Newest messages'); ?></h4>
		</div>
        <div class="widget-content">
            <ul>
                <?php foreach ($messages as $message): ?>
                    <li><?php echo Html::anchor('admin/messages/view/' . $message->id, $message->name . ' (' . $message->email . ')'); ?><br> @ <?php echo Date::forge($message->created_at)->set_timezone('Europe/Riga')->format("%d/%m/%Y %H:%M"); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
	</div>
    <div class="widget span4">
        <div class="widget-header">
            <h4><?php echo Lang::get('Recently added items'); ?></h4>
        </div>
        <div class="widget-content">
            <ul>
                <?php foreach ($items as $item): ?>
                <li><?php echo Html::anchor('item/view/' . $item->slug, $item->title, array('target' => '_blank')); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
	<div class="widget span4">
        <div class="widget-header">
            <h4><?php echo Lang::get('Welcome'); ?>, <?php echo Html::anchor('admin/users/view/' . $current_user->id, $current_user->username); ?></h4>
        </div>
        <div class="widget-content">
            <ul>
                <li><?php echo Lang::get('Pages by you'); ?>: <?php echo count($current_user->pages); ?></li>
                <li><?php echo Lang::get('Items by you'); ?>: <?php echo count($current_user->items); ?></li>
            </ul>
        </div>
	</div>
</div>