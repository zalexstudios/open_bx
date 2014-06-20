<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage iblock
 */
namespace Freetrix\Iblock\InheritedProperty;

class IblockTemplates extends BaseTemplate
{
	function __construct($iblock_id)
	{
		$entity = new IblockValues($iblock_id);
		parent::__construct($entity);
	}
}