
<div class="widget">
    <div class="widget-header">
        <h4>Viewing #<?php echo $message->id; ?></h4>
    </div>
    <div class="widget-content">
        <p>
            <strong>Email:</strong>
            <?php echo $message->email; ?></p>
        <p>
            <strong>Phone:</strong>
            <?php echo $message->phone; ?></p>
        <p>
            <strong>Name:</strong>
            <?php echo $message->name; ?></p>
        <p>
            <strong>Message:</strong>
            <?php echo $message->message; ?></p>

        <p>
            <strong>Time sent:</strong>
            <?php echo Date::forge($message->created_at)->set_timezone('Europe/Riga')->format("%d/%m/%Y %H:%M"); ?></p>
    </div>
</div>


<?php echo Html::anchor('admin/messages', 'Back'); ?>