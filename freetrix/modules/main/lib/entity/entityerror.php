<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */

namespace Freetrix\Main\Entity;

class EntityError
{
	/** @var int */
	protected $code;

	/** @var string */
	protected $message;

	public function __construct($message, $code=0)
	{
		$this->message = $message;
		$this->code = $code;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getMessage()
	{
		return $this->message;
	}
}
