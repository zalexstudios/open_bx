<?php
namespace Freetrix\Iblock;

use Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class SectionPropertyTable
 *
 * Fields:
 * <ul>
 * <li> IBLOCK_ID int mandatory
 * <li> SECTION_ID int mandatory
 * <li> PROPERTY_ID int mandatory
 * <li> SMART_FILTER bool optional default 'N'
 * <li> IBLOCK reference to {@link \Freetrix\Iblock\IblockTable}
 * <li> PROPERTY reference to {@link \Freetrix\Iblock\PropertyTable}
 * <li> SECTION reference to {@link \Freetrix\Iblock\SectionTable}
 * </ul>
 *
 * @package Freetrix\Iblock
 **/

class SectionPropertyTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_section_property';
	}

	public static function getMap()
	{
		return array(
			'IBLOCK_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('IBLOCK_SECTION_PROPERTY_ENTITY_IBLOCK_ID_FIELD'),
			),
			'SECTION_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('IBLOCK_SECTION_PROPERTY_ENTITY_SECTION_ID_FIELD'),
			),
			'PROPERTY_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('IBLOCK_SECTION_PROPERTY_ENTITY_PROPERTY_ID_FIELD'),
			),
			'SMART_FILTER' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y'),
				'title' => Loc::getMessage('IBLOCK_SECTION_PROPERTY_ENTITY_SMART_FILTER_FIELD'),
			),
			'IBLOCK' => array(
				'data_type' => 'Freetrix\Iblock\Iblock',
				'reference' => array('=this.IBLOCK_ID' => 'ref.ID'),
			),
			'PROPERTY' => array(
				'data_type' => 'Freetrix\Iblock\Property',
				'reference' => array('=this.PROPERTY_ID' => 'ref.ID'),
			),
			'SECTION' => array(
				'data_type' => 'Freetrix\Iblock\Section',
				'reference' => array('=this.SECTION_ID' => 'ref.ID'),
			),
		);
	}
}