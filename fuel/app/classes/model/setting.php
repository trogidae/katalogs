<?php
/**
 * Klase, kas saņem/sūta datus no/uz datubāzes tabulas "settings"
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Model_Setting extends \Orm\Model
{
    //Iestata tabulas laukus
	protected static $_properties = array(
		'id',
		'name',
        'value',
	);

    /**
     * Validācijas funkcija, iestata validācijas noteikumus tabulas laukiem
     */
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');
        $val->add_field('value', 'Value', 'required|max_length[255]');

		return $val;
	}

}
