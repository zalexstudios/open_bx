<?php
/**
 * Freetrix Framework
 * @package    freetrix
 * @subpackage main
 * @copyright  2001-2013 Freetrix
 */

namespace Freetrix\Main\Entity;

interface IValidator
{
	/**
	 * @param       $value
	 * @param       $primary
	 * @param array $row
	 * @param Field $field
	 *
	 * @return string|boolean
	 */
	public function validate($value, $primary, array $row, Field $field);
}
