<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */
namespace Freetrix\Main;

abstract class Page
	implements \Freetrix\Main\Diag\IExceptionHandlerOutput
{
	/** @var \Freetrix\Main\HttpApplication */
	protected $application;

	public function __construct()
	{
	}

	public function setApplication(HttpApplication $application)
	{
		$this->application = $application;
	}

	public function startRequest()
	{
		$this->initializeRequest();

		ob_start();
	}

	protected function initializeRequest()
	{
	}

	public function render()
	{
		$text = ob_get_clean();
		/* TODO: filters to output befor tag </body> */
		return /*$this->title."<br>".*/$text/*."<br>"*/;
	}

	/**
	 * @return Context
	 */
	public function getContext()
	{
		return $this->application->getContext();
	}

	/**
	 * @return HttpRequest
	 */
	public function getRequest()
	{
		$context = $this->application->getContext();
		return $context->getRequest();
	}

	/**
	 * @return HttpResponse
	 */
	public function getResponse()
	{
		$context = $this->application->getContext();
		return $context->getResponse();
	}

	public function renderExceptionMessage(\Exception $exception, $debug = false)
	{
		if ($debug)
			echo Diag\ExceptionHandlerFormatter::format($exception, true);
		else
			include(IO\Path::convertRelativeToAbsolute("/error.php"));
	}

	protected function setContextCulture(\Freetrix\Main\Context\Culture $culture, $language = null)
	{
		$context = $this->getContext();
		$context->setCulture($culture);
		if ($language !== null)
			$context->setLanguage($language);
	}

}
