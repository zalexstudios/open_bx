<?
##############################################
# Freetrix Site Manager                        #
# Copyright (c) 2002-2007 Freetrix             #
# http://www.freetrixsoft.com                  #
# mailto:admin@freetrixsoft.com                #
##############################################

require($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/prolog_admin_before.php");

if(!$USER->CanDoOperation('edit_php'))
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

IncludeModuleLangFile(__FILE__);

$from = $_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/admin/restore.php";
$to = $_SERVER["DOCUMENT_ROOT"]."/restore.php";
$path = _normalizePath($f_id);

if(check_freetrix_sessid()
	&& copy($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/backup/".$path, $_SERVER["DOCUMENT_ROOT"]."/".$path)
	&& file_put_contents($to, str_replace("%DEFAULT_LANG_ID%", LANG, file_get_contents($from))))
	LocalRedirect("/restore.php?lang=".LANG);

require($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/prolog_admin_after.php");

CAdminMessage::ShowMessage(array(
	"MESSAGE" => GetMessage("MAIN_EXEC_RESTORE_MSG"),
	"DETAILS" => GetMessage("MAIN_EXEC_RESTORE_TEXT").' '.htmlspecialcharsbx($path),
	"HTML" => true));

require($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/epilog_admin.php");
?>
