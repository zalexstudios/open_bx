<?php
namespace Freetrix\Main\Security\Sign;

use Freetrix\Main\SystemException;

/**
 * Class BadSignatureException
 * @since 14.0.7
 * @package Freetrix\Main\Security\Sign
 */
class BadSignatureException
	extends SystemException
{
	/**
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct($message = "", \Exception $previous = null)
	{
		parent::__construct($message, 140, '', 0, $previous);
	}
}