<?php
namespace Freetrix\Main\Security;

class SecurityException
	extends \Freetrix\Main\SystemException
{
	public function __construct($message = "", $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, '', '', $previous);
	}
}
