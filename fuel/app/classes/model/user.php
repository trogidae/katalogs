<?php
/**
 * Klase, kas saņem/sūta datus no/uz datubāzes tabulas "users"
 *
 * Autors: Dana Kukaine
 * Izveidots: 04.03.2013.
 * Pēdējo reizi mainīts: 01.06.2013.
 */
use Orm\Model;

class Model_User extends Model
{
    //Iestata tabulas laukus
	protected static $_properties = array(
		'id',
		'username',
		'password',
		'group',
		'email',
		'last_login',
		'login_hash',
		'created_at',
		'updated_at',
	);

    //Iestata laukus, kurus nekad nesaņemt no datubāzes
    protected static $_to_array_exclude = array(
        'password', 'login_hash'
    );

    //Izveido novērotājus (observers), kas izpilda automātiskas darbības
    protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

    //Izveido "ir daudz" (has-many) attiecību ar tabulu "pages" un "items"
    protected static $_has_many = array('pages', 'items');

    /**
     * Validācijas funkcija, iestata validācijas noteikumus tabulas laukiem
     */
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('username', Lang::get('Username'), 'required|max_length[50]|min_length[4]');
		$val->add_field('password', Lang::get('Password'), 'required|max_length[255]|min_length[6]');
		$val->add_field('group', Lang::get('Group'), 'required|valid_string[numeric]');
		$val->add_field('email', Lang::get('Email'), 'required|valid_email|max_length[255]');
		$val->add_field('last_login', Lang::get('Last Login'), 'valid_string[numeric]');
		$val->add_field('login_hash', 'Login Hash', 'max_length[255]');
		return $val;
	}

}
