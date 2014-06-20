<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */
namespace Freetrix\Main;

use Freetrix\Main\Entity;

class SiteDomainTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'b_lang_domain';
	}

	public static function getMap()
	{
		return array(
			'LID' => array(
				'data_type' => 'string',
				'primary' => true,
			),
			'DOMAIN' => array(
				'data_type' => 'string'
			),
			'SITE' => array(
				'data_type' => 'Freetrix\Main\Site',
				'reference' => array('=this.LID' => 'ref.LID'),
			),
		);
	}
}
