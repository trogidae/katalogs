<h2><?php echo Lang::get('Message from :sitename contact form', array( 'sitename' => $settings['site_title']->value))?></h2>

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

<p><?php echo Lang::get('Message sent from')?> <a href="<?php Uri::base(false) ?>"><?php echo $settings['site_title']->value; ?></a></p>