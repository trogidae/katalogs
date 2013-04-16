<?php
class Model_Item extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'slug',
		'summary',
		'content',
		'price',
		'user_id',
		'status',
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
        'categories' => array(
            'key_from' => 'id',
            'key_through_from' => 'item_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'items_categories', // both models plural without prefix in alphabetical order
            'key_through_to' => 'category_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Category',
            'key_to' => 'id',
        )
    );

    protected static $_belongs_to = array('users');

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('slug', 'Slug', 'max_length[255]');
		$val->add_field('summary', 'Summary', '');
		$val->add_field('content', 'Content', 'required');
		$val->add_field('price', 'Price', 'max_length[255]');
		$val->add_field('user_id', 'User Id', 'required|valid_string[numeric]');
		$val->add_field('status', 'Status', 'required|valid_string[numeric]');

		return $val;
	}

}
