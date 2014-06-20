<?php
namespace Freetrix\Main\Type;

use Freetrix\Main;

interface IRequestFilter
{
	/**
	 * @param array $values
	 * @return array
	 */
	function filter(array $values);
}
