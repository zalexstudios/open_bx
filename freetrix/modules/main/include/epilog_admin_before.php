<?
define("START_EXEC_EPILOG_BEFORE_1", microtime());
$GLOBALS["FX_STATE"] = "EB";

if($USER->IsAuthorized() && (!defined("FX_AUTH_FORM") || !FX_AUTH_FORM))
{


}

if (!defined('FX_PUBLIC_MODE') || FX_PUBLIC_MODE != 1)
{
	if (!defined("FX_AUTH_FORM") || !FX_AUTH_FORM)
		require($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/epilog_main_admin.php");
	else
		require($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/epilog_auth_admin.php");
}
else
	require($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/epilog_jspopup_admin.php");

?>
