<?php
/**
 * Klase, kas saņem/sūta datus no/uz datubāzes tabulas "messages"
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Model_Message extends \Orm\Model
{
    //Iestata tabulas laukus
    protected static $_properties = array(
		'id',
		'email',
		'phone',
		'name',
		'message',
		'created_at',
	);

    //Izveido novērotājus (observers), kas izpilda automātiskas darbības
    protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
	);

    /**
     * Validācijas funkcija, iestata validācijas noteikumus tabulas laukiem
     */
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('email', Lang::get('Email'), 'required|valid_email|max_length[255]');
		$val->add_field('phone', Lang::get('Phone'), 'required|max_length[255]');
		$val->add_field('name', Lang::get('Name'), 'required|max_length[255]');
		$val->add_field('message', Lang::get('Message'), 'required');

		return $val;
	}

}
