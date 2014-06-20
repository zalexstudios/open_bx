<?php
namespace Freetrix\Main\Diag;

use Freetrix\Main;

Main\Localization\Loc::loadMessages(__FILE__);

class HttpExceptionHandlerOutput
	implements IExceptionHandlerOutput
{
	function renderExceptionMessage(\Exception $exception, $debug = false)
	{
		if ($debug)
		{
			echo ExceptionHandlerFormatter::format($exception, true);
		}
		else
		{
			$p = Main\IO\Path::convertRelativeToAbsolute("/error.php");
			if (Main\IO\File::isFileExists($p))
			{
				include($p);
			}
			else
			{
				$context = Main\Application::getInstance();
				if ($context)
					echo Main\Localization\Loc::getMessage("eho_render_exception_message");
				else
					echo "A error occurred during execution of this script. You can turn on extended error reporting in .settings.php file.";
			}
		}
	}
}
