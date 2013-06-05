
<div class="widget">
    <div class="widget-header">
        <h4><?php echo Lang::get('Message')?> #<?php echo $message->id; ?></h4>
    </div>
    <div class="widget-content">
        <p>
            <strong><?php echo Lang::get('Email')?>:</strong>
            <?php echo $message->email; ?></p>
        <p>
            <strong><?php echo Lang::get('Phone')?>:</strong>
            <?php echo $message->phone; ?></p>
        <p>
            <strong><?php echo Lang::get('Name')?>:</strong>
            <?php echo $message->name; ?></p>
        <p>
            <strong><?php echo Lang::get('Message')?>:</strong>
            <?php echo $message->message; ?></p>

        <p>
            <strong><?php echo Lang::get('Time sent')?>:</strong>
            <?php echo Date::forge($message->created_at)->set_timezone('Europe/Riga')->format("%d/%m/%Y %H:%M"); ?></p>
    </div>
</div>


<?php echo Html::anchor('admin/messages', Lang::get('Back')); ?>