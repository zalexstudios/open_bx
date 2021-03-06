<?php
namespace Freetrix\Iblock;

use Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
/**
 * Class TypeTable
 *
 * Fields:
 * <ul>
 * <li> ID string(50) mandatory
 * <li> SECTIONS bool optional default 'Y'
 * <li> EDIT_FILE_BEFORE string(255) optional
 * <li> EDIT_FILE_AFTER string(255) optional
 * <li> IN_RSS bool optional default 'N'
 * <li> SORT int optional default 500
 * <li> LANG_MESSAGE reference to {@link \Freetrix\Iblock\TypeLanguageTable}
 * </ul>
 *
 * @package Freetrix\Iblock
 */
class TypeTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_iblock_type';
	}

	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'string',
				'primary' => true,
				'validation' => array(__CLASS__, 'validateId'),
				'title' => Loc::getMessage('IBLOCK_TYPE_ENTITY_ID_FIELD'),
			),
			'SECTIONS' => array(
				'data_type' => 'boolean',
				'values' => array('N','Y'),
				'title' => Loc::getMessage('IBLOCK_TYPE_ENTITY_SECTIONS_FIELD'),
			),
			'EDIT_FILE_BEFORE' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateEditFileBefore'),
				'title' => Loc::getMessage('IBLOCK_TYPE_ENTITY_EDIT_FILE_BEFORE_FIELD'),
			),
			'EDIT_FILE_AFTER' => array(
				'data_type' => 'string',
				'validation' => array(__CLASS__, 'validateEditFileAfter'),
				'title' => Loc::getMessage('IBLOCK_TYPE_ENTITY_EDIT_FILE_AFTER_FIELD'),
			),
			'IN_RSS' => array(
				'data_type' => 'boolean',
				'values' => array('N','Y'),
				'title' => Loc::getMessage('IBLOCK_TYPE_ENTITY_IN_RSS_FIELD'),
			),
			'SORT' => array(
				'data_type' => 'integer',
				'title' => Loc::getMessage('IBLOCK_TYPE_ENTITY_SORT_FIELD'),
			),
			'LANG_MESSAGE' => array(
				'data_type' => 'Freetrix\Iblock\TypeLanguage',
				'reference' => array('=this.ID' => 'ref.IBLOCK_TYPE_ID'),
			),
		);
	}

	public static function validateId()
	{
		return array(
			new Entity\Validator\Length(null, 50),
		);
	}
	public static function validateEditFileBefore()
	{
		return array(
			new Entity\Validator\Length(null, 255),
		);
	}
	public static function validateEditFileAfter()
	{
		return array(
			new Entity\Validator\Length(null, 255),
		);
	}
}
