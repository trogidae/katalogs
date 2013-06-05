<?php
/**
 * Klase, kas saņem/sūta datus no/uz datubāzes tabulas "categories"
 *
 * Autors: Dana Kukaine
 * Izveidots: 6.03.2013.
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Model_Category extends \Orm\Model
{
    // Deklarē visus tabulas laukus
	protected static $_properties = array(
		'id',
		'title',
		'slug',
        'status',
        'parent_id',
		'created_at',
		'updated_at',
	);

    // Izveido novērotājus (observers) datuma laukiem, lai automātiski aizpildītos ar tā brīža datumu.
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'), // Izpildās tikai, kad pirmoreizi ievieto ierakstu
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'), // Izpildās katru reizi, kad tiek papildināts/izlabots ieraksts
			'mysql_timestamp' => false,
		),
	);

    // Izveido attiecības ar citām tabulām
    // Tiek deklarēta many-many (daudz-daudz) attiecība ar tabulu "items"
    protected static $_many_many = array(
        'items' => array(
            'key_from' => 'id',
            'key_through_from' => 'category_id',
            'table_through' => 'items_categories',
            'key_through_to' => 'item_id', //
            'model_to' => 'Model_Item',
            'key_to' => 'id',
        )
    );

    // Tiek deklarētu belongs-to (pieder) attiecība ar pašu tabulu "categories",
    //  lai lauks parent_id varētu tikt izmantots kā ārējā atslēga
    protected static $_belongs_to = array(
        'categories' => array(
            'key_from' => 'parent_id',
            'model_to' => 'Model_Category',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );

    /*
     * Validācijas funkcija, kurā tiek deklarēti visi tabulas lauki
     * un to nosacījumi pareizai aizpildīšanai jebkurā formā
     */
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', Lang::get('Title'), 'required|max_length[255]');
		$val->add_field('slug', Lang::get('Slug'), 'max_length[255]');
        $val->add_field('status', Lang::get('Status'), 'required|valid_string[numeric]');
        $val->add_field('parent_id', Lang::get('Parent'), 'valid_string[numeric]');
		return $val;
	}

}
