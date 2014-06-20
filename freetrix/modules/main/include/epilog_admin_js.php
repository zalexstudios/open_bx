<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

define("START_EXEC_EPILOG_BEFORE_1", microtime());
$GLOBALS["FX_STATE"] = "EB";

define("ADMIN_AJAX_MODE", true);
require($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/include/epilog_admin_after.php");
die();
?>
