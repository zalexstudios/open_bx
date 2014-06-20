<?php
namespace Freetrix\Main\Diag;

interface IExceptionHandlerOutput
{
	function renderExceptionMessage(\Exception $exception, $debug = false);
}
