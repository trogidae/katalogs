<?php
/**
 * Klase, kas saņem/sūta datus no/uz datubāzes tabulas "pages"
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Model_Page extends \Orm\Model
{
    //Iestata tabulas laukus
    protected static $_properties = array(
		'id',
		'title',
		'slug',
		'summary',
		'content',
		'status',
		'user_id',
		'created_at',
		'updated_at',
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

    //Izveido "pieder" (belongs-to) attiecību ar tabulu "users"
    protected static $_belongs_to = array('users');

    /**
     * Validācijas funkcija, iestata validācijas noteikumus tabulas laukiem
     */
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', Lang::get('Title'), 'required|max_length[255]');
		$val->add_field('slug', Lang::get('Slug'), 'max_length[255]');
		$val->add_field('content', Lang::get('Content'), 'required');
		$val->add_field('status', Lang::get('Status'), 'required');
		$val->add_field('user_id', 'User Id', 'required|valid_string[numeric]');

		return $val;
	}

}
