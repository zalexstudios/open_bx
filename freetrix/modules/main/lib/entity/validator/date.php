<?php
/**
 * Freetrix Framework
 * @package    freetrix
 * @subpackage main
 * @copyright  2001-2013 Freetrix
 */

namespace Freetrix\Main\Entity\Validator;

use Freetrix\Main\Entity;
use Freetrix\Main\Type;

class Date extends Base
{
	public function validate($value, $primary, array $row, Entity\Field $field)
	{
		if ($value instanceof Type\DateTime)
		{
			// self-validating object
			return true;
		}

		if (\CheckDateTime($value, FORMAT_DATE))
		{
			return true;
		}

		return $this->getErrorMessage($value, $field);
	}
}
