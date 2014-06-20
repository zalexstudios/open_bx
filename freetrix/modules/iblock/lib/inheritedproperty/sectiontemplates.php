<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage iblock
 */
namespace Freetrix\Iblock\InheritedProperty;

class SectionTemplates extends BaseTemplate
{
	function __construct($iblock_id, $section_id)
	{
		$entity = new SectionValues($iblock_id, $section_id);
		parent::__construct($entity);
	}
}