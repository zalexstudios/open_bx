<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */

namespace Freetrix\Main\Entity;

/**
 * Entity field class for date data type
 * @package freetrix
 * @subpackage main
 */
class DateField extends DatetimeField
{
	public function getValidators()
	{
		$validators = parent::getValidators();

		if ($this->validation === null)
		{
			$validators[] = new Validator\Date;
		}

		return $validators;
	}
}