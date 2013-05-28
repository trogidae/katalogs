<?php

namespace Fuel\Migrations;

class Create_settings
{
	public function up()
	{
		\DBUtil::create_table('settings', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'frontpage_category' => array('constraint' => 11, 'type' => 'int'),
			'show_empty_cat' => array('constraint' => 11, 'type' => 'int'),
			'currency' => array('constraint' => 255, 'type' => 'varchar'),
			'language' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('settings');
	}
}