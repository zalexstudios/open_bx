<?php
namespace Freetrix\Iblock;

use Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class PropertyEnumerationTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> PROPERTY_ID int mandatory
 * <li> VALUE string(255) mandatory
 * <li> DEF bool optional default 'N'
 * <li> SORT int optional default 500
 * <li> XML_ID string(200) mandatory
 * <li> TMP_ID string(40) optional
 * <li> PROPERTY reference to {@link \Freetrix\Iblock\PropertyTable}
 * </ul>
 *
 * @package Freetrix\Iblock
 **/

class PropertyEnumerationTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_property_enum';
	}

	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('IBLOCK_PROPERTY_ENUM_ENTITY_ID_FIELD'),
			),
			'PROPERTY_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('IBLOCK_PROPERTY_ENUM_ENTITY_PROPERTY_ID_FIELD'),
			),
			'VALUE' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateValue'),
				'title' => Loc::getMessage('IBLOCK_PROPERTY_ENUM_ENTITY_VALUE_FIELD'),
			),
			'DEF' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y'),
				'title' => Loc::getMessage('IBLOCK_PROPERTY_ENUM_ENTITY_DEF_FIELD'),
			),
			'SORT' => array(
				'data_type' => 'integer',
				'title' => Loc::getMessage('IBLOCK_PROPERTY_ENUM_ENTITY_SORT_FIELD'),
			),
			'XML_ID' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateXmlId'),
				'title' => Loc::getMessage('IBLOCK_PROPERTY_ENUM_ENTITY_XML_ID_FIELD'),
			),
			'TMP_ID' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateTmpId'),
				'title' => Loc::getMessage('IBLOCK_PROPERTY_ENUM_ENTITY_TMP_ID_FIELD'),
			),
			'PROPERTY' => array(
				'data_type' => 'Freetrix\Iblock\Property',
				'reference' => array('=this.PROPERTY_ID' => 'ref.ID'),
			),
		);
	}
	public static function validateValue()
	{
		return array(
			new Entity\Validator\Length(null, 255),
		);
	}
	public static function validateXmlId()
	{
		return array(
			new Entity\Validator\Unique(),
			new Entity\Validator\Length(null, 200),
		);
	}
	public static function validateTmpId()
	{
		return array(
			new Entity\Validator\Length(null, 40),
		);
	}
}
