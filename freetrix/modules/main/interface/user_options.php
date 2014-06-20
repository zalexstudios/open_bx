<?
##############################################
# Freetrix Site Manager                        #
# Copyright (c) 2002-2007 Freetrix             #
# http://www.freetrixsoft.com                  #
# mailto:admin@freetrixsoft.com                #
##############################################

define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/prolog_admin_before.php");

if($USER->IsAuthorized() && check_freetrix_sessid())
{
	if($_GET["action"] == "delete" && $_GET["c"] <> "" && $_GET["n"] <> "")
		CUserOptions::DeleteOption($_GET["c"], $_GET["n"], ($_GET["common"]=="Y" && $GLOBALS["USER"]->CanDoOperation('edit_other_settings')));
	if(is_array($_REQUEST["p"]))
	{
		$arOptions = $_REQUEST["p"];
		CUtil::decodeURIComponent($arOptions);
		CUserOptions::SetOptionsFromArray($arOptions);
	}
}
echo "OK";
require($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/include/epilog_admin_after.php");
?>
