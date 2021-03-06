<?php
namespace Freetrix\Main\IO;

use Freetrix\Main\Localization\Loc;

class FileNotFoundException
	extends IoException
{
	public function __construct($path, \Exception $previous = null)
	{
		$message = sprintf("Path '%s' is not found", $path);
		parent::__construct($message, $path, $previous);
	}
}
