<?php
/**
 * Klase, kas saņem/sūta datus no/uz datubāzes tabulas "widgets"
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Model_Widget extends \Orm\Model
{
    //Iestata tabulas laukus
    protected static $_properties = array(
		'id',
		'type',
		'title',
		'content',
        'position',
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

    /**
     * Validācijas funkcija, iestata validācijas noteikumus tabulas laukiem
     */
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('type', Lang::get('Type'), 'required|valid_string[numeric]');
		$val->add_field('title', Lang::get('Title'), 'required|max_length[255]');
		$val->add_field('content', Lang::get('Content'), 'required');
        $val->add_field('position', Lang::get('Position'), 'valid_string[numeric]');

		return $val;
	}

}
