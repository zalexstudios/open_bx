<?php
namespace Freetrix\Iblock;

use Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class IblockMessageTable
 *
 * Fields:
 * <ul>
 * <li> IBLOCK_ID int mandatory
 * <li> MESSAGE_ID string(50) mandatory
 * <li> MESSAGE_TEXT string(255) optional
 * <li> IBLOCK reference to {@link \Freetrix\Iblock\IblockTable}
 * </ul>
 *
 * @package Freetrix\Iblock
 */
class IblockMessageTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_messages';
	}

	public static function getMap()
	{
		return array(
			'IBLOCK_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('IBLOCK_MESSAGE_ENTITY_IBLOCK_ID_FIELD'),
			),
			'MESSAGE_ID' => array(
				'data_type' => 'string',
				'primary' => true,
				'validation' => array(__CLASS__, 'validateMessageId'),
				'title' => Loc::getMessage('IBLOCK_MESSAGE_ENTITY_MESSAGE_ID_FIELD'),
			),
			'MESSAGE_TEXT' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateMessageText'),
				'title' => Loc::getMessage('IBLOCK_MESSAGE_ENTITY_MESSAGE_TEXT_FIELD'),
			),
			'IBLOCK' => array(
				'data_type' => 'Freetrix\Iblock\Iblock',
				'reference' => array('=this.IBLOCK_ID' => 'ref.ID')
			),
		);
	}
	public static function validateMessageId()
	{
		return array(
			new Entity\Validator\Length(null, 50),
		);
	}
	public static function validateMessageText()
	{
		return array(
			new Entity\Validator\Length(null, 255),
		);
	}
}
