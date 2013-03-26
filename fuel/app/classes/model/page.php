<?php
class Model_Page extends \Orm\Model
{
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

    protected static $_belongs_to = array('users');

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('slug', 'Slug', 'max_length[255]');
		$val->add_field('summary', 'Summary', '');
		$val->add_field('content', 'Content', 'required');
		$val->add_field('status', 'Status', 'required');
		$val->add_field('user_id', 'User Id', 'required|valid_string[numeric]');

		return $val;
	}

}
