<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */

namespace Freetrix\Main\Entity;

class FieldError extends EntityError
{
	const EMPTY_REQUIRED = 1;
	const INVALID_VALUE = 2;

	/** @var Field */
	protected $field;

	public function __construct(Field $field, $message, $code=0)
	{
		parent::__construct($message, $code);
		$this->field = $field;
	}

	public function getField()
	{
		return $this->field;
	}
}
