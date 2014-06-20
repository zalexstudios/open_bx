<?php
namespace Freetrix\Iblock;

use Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class IblockFieldTable
 *
 * Fields:
 * <ul>
 * <li> IBLOCK_ID int mandatory
 * <li> FIELD_ID string(50) mandatory
 * <li> IS_REQUIRED bool optional default 'N'
 * <li> DEFAULT_VALUE string optional
 * <li> IBLOCK reference to {@link \Freetrix\Iblock\IblockTable}
 * </ul>
 *
 * @package Freetrix\Iblock
 */
class IblockFieldTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_fields';
	}

	public static function getMap()
	{
		return array(
			'IBLOCK_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('IBLOCK_FIELD_ENTITY_IBLOCK_ID_FIELD'),
			),
			'FIELD_ID' => array(
				'data_type' => 'string',
				'primary' => true,
				'validation' => array(__CLASS__, 'validateFieldId'),
				'title' => Loc::getMessage('IBLOCK_FIELD_ENTITY_FIELD_ID_FIELD'),
			),
			'IS_REQUIRED' => array(
				'data_type' => 'boolean',
				'values' => array('N','Y'),
				'title' => Loc::getMessage('IBLOCK_FIELD_ENTITY_IS_REQUIRED_FIELD'),
			),
			'DEFAULT_VALUE' => array(
				'data_type' => 'string',
				'title' => Loc::getMessage('IBLOCK_FIELD_ENTITY_DEFAULT_VALUE_FIELD'),
			),
			'IBLOCK' => array(
				'data_type' => 'Freetrix\Iblock\Iblock',
				'reference' => array('=this.IBLOCK_ID' => 'ref.ID')
			),
		);
	}
	public static function validateFieldId()
	{
		return array(
			new Entity\Validator\Length(null, 50),
		);
	}
}
