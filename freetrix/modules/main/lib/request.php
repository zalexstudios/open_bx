<?php
namespace Freetrix\Main;

use Freetrix\Main\Type;
use Freetrix\Main\Text;
use Freetrix\Main\IO;

/**
 * Class Request contains current request
 * @package Freetrix\Main
 */
abstract class Request
	extends Type\ParameterDictionary
{
	/**
	 * @var Server
	 */
	protected $server;

	protected $requestedFile = null;
	protected $requestedFileDirectory = null;

	public function __construct(Server $server, array $request)
	{
		parent::__construct($request);

		$this->server = $server;
	}

	public function addFilter(Type\IRequestFilter $filter)
	{
		$filteredValues = $filter->filter($this->values);

		if ($filteredValues != null)
			$this->setValuesNoDemand($filteredValues);
	}

	public function getPhpSelf()
	{
		return $this->server->getPhpSelf();
	}

	public function getScriptName()
	{
		return $this->server->getScriptName();
	}

	public function getRequestedPage()
	{
		if ($this->requestedFile !== null)
			return $this->requestedFile;

		$page = $this->getScriptName();
		if (empty($page))
		{
			return $this->requestedFile = $page;
		}

		$page = IO\Path::normalize($page);

		if (substr($page, 0, 1) !== "/" && !preg_match("#^[a-z]:[/\\\\]#i", $page))
			$page = "/".$page;

		return $this->requestedFile = $page;
	}

	public function getRequestedPageDirectory()
	{
		if ($this->requestedFileDirectory != null)
			return $this->requestedFileDirectory;

		$requestedFile = $this->getRequestedPage();

		return $this->requestedFileDirectory = IO\Path::getDirectory($requestedFile);
	}

	public function isAdminSection()
	{
		$requestedDir = $this->getRequestedPageDirectory();
		return (substr($requestedDir, 0, strlen("/freetrix/admin/")) == "/freetrix/admin/"
			|| substr($requestedDir, 0, strlen("/freetrix/updates/")) == "/freetrix/updates/"
			|| (defined("ADMIN_SECTION") &&  ADMIN_SECTION == true)
			|| (defined("FX_PUBLIC_TOOLS") && FX_PUBLIC_TOOLS === true)
		);
	}
}
