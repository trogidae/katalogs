<?php
class Model_Category extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'slug',
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
            'key_through_from' => 'category_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'items_categories', // both models plural without prefix in alphabetical order
            'key_through_to' => 'item_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Item',
            'key_to' => 'id',
        )
    );

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('slug', 'Slug', 'required|max_length[255]');

		return $val;
	}

}
