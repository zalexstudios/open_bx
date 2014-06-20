<?php
namespace Freetrix\Iblock;

use Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class InheritedPropertyTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_iproperty';
	}

	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
			),
			'IBLOCK_ID' => array(
				'data_type' => 'integer',
			),
			'CODE' => array(
				'data_type' => 'string',
			),
			'ENTITY_TYPE' => array(
				'data_type' => 'string',
			),
			'ENTITY_ID' => array(
				'data_type' => 'string',
			),
			'TEMPLATE' => array(
				'data_type' => 'string',
			)
		);
	}
}
