<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */
namespace Freetrix\Main;

use Freetrix\Main\Entity;

class GroupTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_group';
	}

	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
			),
			'TIMESTAMP_X' => array(
				'data_type' => 'datetime'
			),
			'ACTIVE' => array(
				'data_type' => 'boolean'
			),
			'C_SORT' => array(
				'data_type' => 'integer'
			),
			'ANONYMOUS' => array(
				'data_type' => 'boolean'
			),
			'NAME' => array(
				'data_type' => 'string'
			),
			'DESCRIPTION' => array(
				'data_type' => 'string'
			)
		);
	}
}