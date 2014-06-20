<?php
namespace Freetrix\Iblock;

use Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class IblockRssTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> IBLOCK_ID int mandatory
 * <li> NODE string(50) mandatory
 * <li> NODE_VALUE string(250) optional
 * <li> IBLOCK reference to {@link \Freetrix\Iblock\IblockTable}
 * </ul>
 *
 * @package Freetrix\Iblock
 **/

class IblockRssTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_rss';
	}

	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('IBLOCK_RSS_ENTITY_ID_FIELD'),
			),
			'IBLOCK_ID' => array(
				'data_type' => 'integer',
				'required' => true,
				'title' => Loc::getMessage('IBLOCK_RSS_ENTITY_IBLOCK_ID_FIELD'),
			),
			'NODE' => array(
				'data_type' => 'string',
				'required' => true,
				'validation' => array(__CLASS__, 'validateNode'),
				'title' => Loc::getMessage('IBLOCK_RSS_ENTITY_NODE_FIELD'),
			),
			'NODE_VALUE' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateNodeValue'),
				'title' => Loc::getMessage('IBLOCK_ENTITY_NODE_VALUE_FIELD'),
			),
			'IBLOCK' => array(
				'data_type' => 'Freetrix\Iblock\Iblock',
				'reference' => array('=this.IBLOCK_ID' => 'ref.ID'),
			),
		);
	}
	public static function validateNode()
	{
		return array(
			new Entity\Validator\Length(null, 50),
		);
	}
	public static function validateNodeValue()
	{
		return array(
			new Entity\Validator\Length(null, 250),
		);
	}
}