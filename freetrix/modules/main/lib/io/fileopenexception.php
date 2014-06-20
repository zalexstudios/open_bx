<?php
namespace Freetrix\Main\IO;

use Freetrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class FileOpenException
	extends IoException
{
	public function __construct($path, \Exception $previous = null)
	{
		$message = Loc::getMessage(
			"file_open_exception_message",
			array("#PATH#" => $path)
		);
		parent::__construct($message, $path, $previous);
	}
}
