<?php
class Model_Image extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
        'thumb',
        'extension',
		'path',
		'width',
		'height',
		'alt_text',
		'created_at',
		'updated_at',
	);

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

    protected static $_many_many = array(
        'items' => array(
            'key_from' => 'id',
            'key_through_from' => 'image_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'items_images', // both models plural without prefix in alphabetical order
            'key_through_to' => 'item_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Item',
            'key_to' => 'id',
        )
    );

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');
        $val->add_field('thumb', 'Thumb', 'required|max_length[255]');
        $val->add_field('extension', 'Extension', 'required|max_length[255]');
		$val->add_field('path', 'Path', 'required|max_length[255]');
		$val->add_field('width', 'Width', 'required|valid_string[numeric]');
		$val->add_field('height', 'Height', 'required|valid_string[numeric]');
		$val->add_field('alt_text', 'Alt text', 'max_length[255]');

		return $val;
	}

}
