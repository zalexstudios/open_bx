<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

define("START_EXEC_PROLOG_AFTER_1", microtime());
$GLOBALS["FX_STATE"] = "PA";

if(!defined("FX_ROOT"))
	define("FX_ROOT", "/freetrix");

require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/init_admin.php");

if (!defined('FX_PUBLIC_MODE') || FX_PUBLIC_MODE != 1)
{
	if (!defined('FX_AUTH_FORM') || !FX_AUTH_FORM)
		require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/prolog_main_admin.php");
	else
		require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/prolog_auth_admin.php");
}
else
	require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/prolog_jspopup_admin.php");

define("START_EXEC_PROLOG_AFTER_2", microtime());
$GLOBALS["FX_STATE"] = "WA";
?>