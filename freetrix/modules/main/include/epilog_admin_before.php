<?
define("START_EXEC_EPILOG_BEFORE_1", microtime());
$GLOBALS["FX_STATE"] = "EB";

if($USER->IsAuthorized() && (!defined("FX_AUTH_FORM") || !FX_AUTH_FORM))
{
	$hkInstance = CHotKeys::getInstance();

	$Execs=$hkInstance->GetCodeByClassName("Global");
	echo $hkInstance->PrintJSExecs($Execs);
	echo $hkInstance->SetTitle("Global");

	$Execs=$hkInstance->GetCodeByUrl($_SERVER["REQUEST_URI"]);

	echo $hkInstance->PrintJSExecs($Execs);
	echo $hkInstance->PrintPhpToJSVars();

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
