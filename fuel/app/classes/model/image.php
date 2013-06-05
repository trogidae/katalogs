<?php
/**
 * Klase, kas saņem/sūta datus no/uz datubāzes tabulas "images"
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Model_Image extends \Orm\Model
{
    // Iestata tabulas laukus
	protected static $_properties = array(
		'id',
		'name',
        'thumb',
        'extension',
		'path',
		'width',
		'height',
		'created_at',
	);

    //Izveido novērotājus (observers), kas izpilda automātiskas darbības
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
	);

    //Izveido daudz-daudz (many-many) attiecību ar tabulu "items"
    protected static $_many_many = array(
        'items' => array(
            'key_from' => 'id',
            'key_through_from' => 'image_id',
            'table_through' => 'items_images',
            'key_through_to' => 'item_id',
            'model_to' => 'Model_Item',
            'key_to' => 'id',
        )
    );

    /**
     * Validācijas funkcija, iestata validācijas noteikumus tabulas laukiem
     */
    public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');
        $val->add_field('thumb', 'Thumb', 'required|max_length[255]');
        $val->add_field('extension', 'Extension', 'required|max_length[255]');
		$val->add_field('path', 'Path', 'required|max_length[255]');
		$val->add_field('width', 'Width', 'required|valid_string[numeric]');
		$val->add_field('height', 'Height', 'required|valid_string[numeric]');

		return $val;
	}

}
