<h2>Message from DrukasPasaule.lv contact form</h2>

<p>
    <strong>Your email:</strong>
    <?php echo $message->email; ?></p>
<p>
    <strong>Your phone:</strong>
    <?php echo $message->phone; ?></p>
<p>
    <strong>Your name:</strong>
    <?php echo $message->name; ?></p>
<p>
    <strong>Message:</strong>
    <?php echo $message->message; ?></p>

<p>
    <strong>Time sent:</strong>
    <?php echo Date::forge($message->created_at)->set_timezone('Europe/Riga')->format("%d/%m/%Y %H:%M"); ?></p>

<p>Message sent from <a href="http://drukaspasaule.lv" target="_blank" title="DrukasPasaule.lv">DrukasPasaule.lv</a></p>