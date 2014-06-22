<?

final Class FileManager extends CModule
{
	public $MODULE_ID = "FileManager";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $MODULE_CSS;
	public $MODULE_GROUP_RIGHTS = "Y";

	public function fileManager()
	{
		$this->MODULE_NAME = GetMessage("FILEMAN_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("FILEMAN_MODULE_DESCRIPTION");
	}

	function InstallDB()
	{
		global $DB, $DBType, $APPLICATION;

		if (!$DB->Query("SELECT 'x' FROM b_medialib_collection", true))
			$errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/db/".$DBType."/install.sql");

		if (!empty($errors))
		{
			$APPLICATION->ThrowException(implode("", $errors));
			return false;
		}

		RegisterModule("FileManager");
		return true;
	}

	function UnInstallDB()
	{
		global $DB, $DBType, $APPLICATION;

		$errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/db/".$DBType."/uninstall.sql");
		if (!empty($errors))
		{
			$APPLICATION->ThrowException(implode("", $errors));
			return false;
		}

	
	
		UnRegisterModuleDependences("main", "OnGroupDelete", "fileman", "CFileman", "OnGroupDelete");
		UnRegisterModuleDependences("main", "OnPanelCreate", "fileman", "CFileman", "OnPanelCreate");
		UnRegisterModuleDependences("main", "OnModuleUpdate", "fileman", "CFileman", "OnModuleUpdate");
		UnRegisterModuleDependences("main", "OnModuleInstalled", "fileman", "CFileman", "ClearComponentsListCache");
		UnRegisterModule("fileman");

		UnRegisterModuleDependences('iblock', 'OnIBlockPropertyBuildList', 'fileman', 'CIBlockPropertyMapGoogle', 'GetUserTypeDescription');
		UnRegisterModuleDependences('iblock', 'OnIBlockPropertyBuildList', 'fileman', 'CIBlockPropertyMapYandex', 'GetUserTypeDescription');
		UnRegisterModuleDependences('iblock', 'OnIBlockPropertyBuildList', 'fileman', 'CIBlockPropertyVideo', 'GetUserTypeDescription');
		UnRegisterModuleDependences("main", "OnUserTypeBuildList", "fileman", "CUserTypeVideo", "GetUserTypeDescription");
		UnRegisterModuleDependences("main", "OnEventLogGetAuditTypes", "fileman", "CEventFileman", "GetAuditTypes");
		UnRegisterModuleDependences("main", "OnEventLogGetAuditHandlers", "fileman", "CEventFileman", "MakeFilemanObject");

		require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/tasks/uninstall.php");

		return true;
	}


	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles()
	{
		if($_ENV["COMPUTERNAME"]!='BX')
		{
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true, true);
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/images", $_SERVER["DOCUMENT_ROOT"]."/bitrix/images", true, true);
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/images/1.gif", $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/");
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/themes", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes", true, true);
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js", true, true);
		}
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/themes/.default/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes/.default");//css
		DeleteDirFilesEx("/bitrix/themes/.default/icons/fileman/");//icons
		DeleteDirFilesEx("/bitrix/images/fileman/");//images
		DeleteDirFilesEx("/bitrix/js/fileman"); // JS
		return true;
	}

	function DoInstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION, $step;
		$FM_RIGHT = $APPLICATION->GetGroupRight("fileman");
		
		if ($FM_RIGHT!="D")
		{
			$this->InstallDB();
			$this->InstallFiles();
		
			$APPLICATION->IncludeAdminFile(GetMessage("FILEMAN_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/step1.php");
		}
	}
	function DoUninstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION, $step;
		$FM_RIGHT = $APPLICATION->GetGroupRight("fileman");
		if ($FM_RIGHT!="D")
		{
			$this->UnInstallDB();
			$this->UnInstallFiles();
		
			$APPLICATION->IncludeAdminFile(GetMessage("FILEMAN_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/fileman/install/unstep1.php");
		}
	}

	function GetModuleRightList()
	{
		$arr = array(
			"reference_id" => array("D","F","R"),
			"reference" => array(
				"[D] ".GetMessage("FILEMAN_DENIED"),
				"[F] ".GetMessage("FILEMAN_ACCESSABLE_FOLDERS"),
				"[R] ".GetMessage("FILEMAN_VIEW"))
			);
		return $arr;
	}
}
?>