<?php
/**
 * Klase, kas saņem/sūta datus no/uz datubāzes tabulas "items"
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Model_Item extends \Orm\Model
{
    //Iestata tabulas laukus
	protected static $_properties = array(
		'id',
		'title',
		'slug',
		'summary',
		'content',
		'price',
		'user_id',
		'status',
        'image_id',
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

    //Izveido daudz-daudz (many-many) attiecību ar tabulu "categories" un ar tabulu "images"
    protected static $_many_many = array(
        'categories' => array(
            'key_from' => 'id',
            'key_through_from' => 'item_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'items_categories', // both models plural without prefix in alphabetical order
            'key_through_to' => 'category_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Category',
            'key_to' => 'id',
        ),
        'gallery' => array(
            'key_from' => 'id',
            'key_through_from' => 'item_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'items_images', // both models plural without prefix in alphabetical order
            'key_through_to' => 'image_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Image',
            'key_to' => 'id',
        )
    );

    //Izveido "pieder" (belongs-to) attiecību ar tabulu "images" un "users"
    protected static $_belongs_to = array('users', 'images');

    /**
     * Validācijas funkcija, iestata validācijas noteikumus tabulas laukiem
     */
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', Lang::get('Title'), 'required|max_length[255]');
		$val->add_field('slug', Lang::get('Slug'), 'max_length[255]');
		$val->add_field('content', Lang::get('Content'), 'required');
		$val->add_field('price', Lang::get('Price'), 'max_length[255]');
		$val->add_field('user_id', 'User Id', 'required|valid_string[numeric]');
		$val->add_field('status', Lang::get('Status'), 'required|valid_string[numeric]');
        $val->add_field('image_id', 'Image Id', 'valid_string[numeric]');

		return $val;
	}

}
