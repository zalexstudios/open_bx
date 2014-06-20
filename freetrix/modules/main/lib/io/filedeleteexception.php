<?php
namespace Freetrix\Main\IO;

use Freetrix\Main\Localization\Loc;

class FileDeleteException
	extends IoException
{
	public function __construct($path, \Exception $previous = null)
	{
		$message = sprintf("Error occurred during deleting file '%s'", $path);
		parent::__construct($message, $path, $previous);
	}
}
