<?php
/**
 * Freetrix Framework
 * @package    freetrix
 * @subpackage main
 * @copyright  2001-2013 Freetrix
 */

namespace Freetrix\Main\Entity;

interface INosqlPrimarySelector
{
	public function getEntityByPrimary(\Freetrix\Main\Entity\Base $entity, $primary, $select);
}
