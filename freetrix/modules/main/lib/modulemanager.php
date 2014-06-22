<?php
namespace Freetrix\Main;

final class ModuleManager
{
	private static $installedModules = array();

	public static function getInstalledModules()
	{
		if (empty(self::$installedModules))
		{
			if (empty(self::$installedModules))
			{
				self::$installedModules = array();
				$con = Application::getConnection();
				$rs = $con->query("SELECT ID FROM b_module ORDER BY ID");
				while ($ar = $rs->fetch())
					self::$installedModules[$ar['ID']] = $ar;
			}
		}

		return self::$installedModules;
	}

	public static function isModuleInstalled($moduleName)
	{
		$arInstalledModules = self::getInstalledModules();
		return isset($arInstalledModules[$moduleName]);
	}

	public static function delete($moduleName)
	{
		$con = Application::getConnection();
		$con->queryExecute("DELETE FROM b_module WHERE ID = '".$con->getSqlHelper()->forSql($moduleName)."'");

		self::$installedModules = array();
		Loader::clearModuleCache($moduleName);

	}

	public static function add($moduleName)
	{
		$con = Application::getConnection();
		$con->queryExecute("INSERT INTO b_module(ID) VALUES('".$con->getSqlHelper()->forSql($moduleName)."')");

		self::$installedModules = array();
		Loader::clearModuleCache($moduleName);
	}

	public static function registerModule($moduleName)
	{
		static::add($moduleName);

		$event = new Event("main", "OnAfterRegisterModule", array($moduleName));
		$event->send();
	}

	public static function unRegisterModule($moduleName)
	{
		\CMain::DelGroupRight($moduleName);

		static::delete($moduleName);

		$event = new Event("main", "OnAfterUnRegisterModule", array($moduleName));
		$event->send();
	}
}
