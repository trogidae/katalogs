<?php
use Orm\Model;

class Model_User extends Model
{
	protected static $_properties = array(
		'id',
		'username',
		'password',
		'group',
		'email',
		'last_login',
		'login_hash',
		'profile_fields',
		'created_at',
		'updated_at',
	);

    protected static $_to_array_exclude = array(
        'password', 'login_hash'	// exclude these columns from being exported
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

    protected static $_has_many = array('pages', 'items');

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('username', 'Username', 'required|max_length[50]|min_length[4]');
		$val->add_field('password', 'Password', 'required|max_length[255]|min_length[6]');
		$val->add_field('group', 'Group', 'required|valid_string[numeric]');
		$val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
		$val->add_field('last_login', 'Last Login', 'valid_string[numeric]');
		$val->add_field('login_hash', 'Login Hash', 'max_length[255]');
		$val->add_field('profile_fields', 'Profile Fields', null);

		return $val;
	}

}
