<p>
    <?php echo Html::anchor('admin/widgets/create', Lang::get('Add new Widget'), array('class' => 'btn btn-info')); ?>
</p>
<?php if ($widgets): ?>
<div class="widget widget-table">
    <div class="widget-header">
        <h4><?php echo Lang::get('Widgets'); ?></h4>
    </div>
    <div class="widget-content">
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?php echo Lang::get('Type'); ?></th>
                <th><?php echo Lang::get('Title'); ?></th>
                <th><?php echo Lang::get('Position'); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($widgets as $widget): ?>		<tr>

                <td><?php echo $widget->type==1 ? Lang::get("Sidebar") : Lang::get("Footer"); ?></td>
                <td><?php echo $widget->title; ?></td>
                <td><?php echo $widget->position; ?></td>
                <td>
                    <?php echo Html::anchor('admin/widgets/edit/'.$widget->id, Lang::get('Edit')); ?> |
                    <?php echo Html::anchor('admin/widgets/delete/'.$widget->id, Lang::get('Delete'), array('onclick' => "return confirm('" . Lang::get('Are you sure?') . "')")); ?>

                </td>
            </tr>
                <?php endforeach; ?>	</tbody>
        </table>
    </div>
</div>
<?php echo Pagination::instance('pagination')->render(); ?>
<?php else: ?>
<div class="widget">
    <div class="widget-header">
        <?php echo Lang::get('No widgets'); ?>
    </div>
    <div class="widget-content">
        <p><?php echo Lang::get('No widgets.'); ?></p>
    </div>
</div>

<?php endif; ?>
