<?php
class Model_Setting extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'frontpage_category',
		'show_empty_cat',
		'currency',
		'language',
        'contact_page',
        'contact_email',
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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('frontpage_category', 'Frontpage Category', 'required|valid_string[numeric]');
		$val->add_field('show_empty_cat', 'Show Empty Cat', 'required|valid_string[numeric]');
		$val->add_field('currency', 'Currency', 'required|max_length[255]');
		$val->add_field('language', 'Language', 'required|valid_string[numeric]');
        $val->add_field('contact_page', 'Contact page', 'valid_string[numeric]');
        $val->add_field('contact_email', 'Contact Email', 'required|valid_email|max_length[255]');

		return $val;
	}

}
