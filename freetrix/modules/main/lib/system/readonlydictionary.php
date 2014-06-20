<?php
namespace Freetrix\Main\System;

class ReadonlyDictionary
	extends Dictionary
{
	/**
	 * Offset to set
	 */
	public function offsetSet($offset, $value)
	{
		throw new \Freetrix\Main\NotSupportedException("Can not set readonly value");
	}

	/**
	 * Offset to unset
	 */
	public function offsetUnset($offset)
	{
		throw new \Freetrix\Main\NotSupportedException("Can not unset readonly value");
	}
}