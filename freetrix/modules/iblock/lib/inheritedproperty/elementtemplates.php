<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage iblock
 */
namespace Freetrix\Iblock\InheritedProperty;

use Freetrix\Iblock\Template\Entity\Element;

class ElementTemplates extends BaseTemplate
{
	function __construct($iblock_id, $element_id)
	{
		$entity = new ElementValues($iblock_id, $element_id);
		parent::__construct($entity);
	}
}