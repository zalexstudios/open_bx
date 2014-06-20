<?php
namespace Freetrix\Iblock;

use Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class IblockSiteTable
 *
 * Fields:
 * <ul>
 * <li> IBLOCK_ID int mandatory
 * <li> SITE_ID char(2) mandatory
 * <li> IBLOCK reference to {@link \Freetrix\Iblock\IblockTable}
 * <li> SITE reference to {@link \Freetrix\Main\SiteTable}
 * </ul>
 *
 * @package Freetrix\Iblock
 */
class IblockSiteTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_site';
	}

	public static function getMap()
	{
		return array(
			'IBLOCK_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'title' => Loc::getMessage('IBLOCK_SITE_ENTITY_IBLOCK_ID_FIELD'),
			),
			'SITE_ID' => array(
				'data_type' => 'string',
				'primary' => true,
				'validation' => array(__CLASS__, 'validateSiteId'),
				'title' => Loc::getMessage('IBLOCK_SITE_ENTITY_SITE_ID_FIELD'),
			),
			'IBLOCK' => array(
				'data_type' => 'Freetrix\Iblock\Iblock',
				'reference' => array('=this.IBLOCK_ID' => 'ref.ID')
			),
			'SITE' => array(
				'data_type' => 'Freetrix\Main\Site',
				'reference' => array('=this.SITE_ID' => 'ref.LID'),
			),
		);
	}
	public static function validateSiteId()
	{
		return array(
			new Entity\Validator\Length(null, 2),
		);
	}
}
