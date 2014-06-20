<?php
/**
 * Freetrix Framework
 * @package    freetrix
 * @subpackage MODULE_NAME
 * @copyright  2001-2012 Freetrix
 */

namespace Freetrix\Main\Data;

abstract class NosqlConnection extends Connection
{
	abstract public function get($key);
	abstract public function set($key, $value);
}