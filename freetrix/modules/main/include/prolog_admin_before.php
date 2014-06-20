<?
require_once(dirname(__FILE__)."/../SetCorePath.php");

define("START_EXEC_PROLOG_BEFORE_1", microtime());
$GLOBALS["FX_STATE"] = "PB";
unset($_REQUEST["FX_STATE"]);
unset($_GET["FX_STATE"]);
unset($_POST["FX_STATE"]);
unset($_COOKIE["FX_STATE"]);
unset($_FILES["FX_STATE"]);

define("NEED_AUTH", true);
define("ADMIN_SECTION", true);

if (isset($_REQUEST['bxpublic']) && $_REQUEST['bxpublic'] == 'Y' && !defined('FX_PUBLIC_MODE'))
	define('FX_PUBLIC_MODE', 1);

require_once(dirname(__FILE__)."/../include.php");
if(!headers_sent())
	header("Content-type: text/html; charset=".LANG_CHARSET);

if (defined('FX_PUBLIC_MODE') && FX_PUBLIC_MODE == 1)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
		require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/init_jspopup.php");
}

require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/admin_tools.php");
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/interface/init_admin.php");

CMain::PrologActions();
?>