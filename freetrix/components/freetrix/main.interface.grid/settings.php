<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/prolog_before.php");

if($USER->IsAuthorized() && check_freetrix_sessid())
{
	//get saved columns and sorting from user settings
	$gridOptions = new CGridOptions($_REQUEST["GRID_ID"]);
	
	if($_REQUEST["action"] == "showcolumns")
	{
		$gridOptions->SetColumns($_REQUEST["columns"]);
	}
	elseif($_REQUEST["action"] == "settheme")
	{
		$gridOptions->SetTheme($_REQUEST["theme"]);
	}
	elseif($_REQUEST["action"] == "savesettings")
	{
		CUtil::decodeURIComponent($_POST);
		$gridOptions->SetViewSettings($_POST['view_id'], $_POST);
	}
	elseif($_REQUEST["action"] == "delview")
	{
		$gridOptions->DeleteView($_REQUEST['view_id']);
	}
	elseif($_REQUEST["action"] == "setview")
	{
		$gridOptions->SetView($_REQUEST["view_id"]);
	}
	elseif($_REQUEST["action"] == "filterrows")
	{
		$gridOptions->SetFilterRows($_REQUEST["rows"], $_REQUEST['filter_id']);
	}
	elseif($_REQUEST["action"] == "savefilter")
	{
		CUtil::decodeURIComponent($_POST);
		$gridOptions->SetFilterSettings($_POST['filter_id'], $_POST);
	}
	elseif($_REQUEST["action"] == "delfilter")
	{
		$gridOptions->DeleteFilter($_REQUEST['filter_id']);
	}
	elseif($_REQUEST["action"] == "filterswitch")
	{
		$gridOptions->SetFilterSwitch($_REQUEST["show"]);
	}

	$gridOptions->Save();
}
echo "OK";
