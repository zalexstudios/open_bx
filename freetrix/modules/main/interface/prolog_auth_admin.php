<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($_REQUEST['bxsender']))
{
	if ($_REQUEST['bxsender'] == 'core_window_cauthdialog')
		echo $APPLICATION->ShowHead();
	return;
}

IncludeModuleLangFile(__FILE__);
IncludeModuleLangFile(dirname(__FILE__)."/epilog_main_admin.php");
IncludeModuleLangFile(dirname(__FILE__)."/epilog_auth_admin.php");

if(strlen($APPLICATION->GetTitle())<=0)
	$APPLICATION->SetTitle(GetMessage("MAIN_PROLOG_ADMIN_AUTH_TITLE"));

$aUserOpt = CUserOptions::GetOption("admin_panel", "settings");

$direction = "";
$direct = CLanguage::GetByID(LANGUAGE_ID);
$arDirect = $direct->Fetch();
if($arDirect["DIRECTION"] == "N")
	$direction = ' dir="rtl"';

$arLangs = CLanguage::GetLangSwitcherArray();

$arLangButton = array();
$arLangMenu = array();

foreach($arLangs as $adminLang)
{
	if ($adminLang['SELECTED'])
	{
		$arLangButton = array(
			"TEXT"=>ToUpper($adminLang["LID"]),
			"TITLE"=>$adminLang["NAME"],
			"LINK"=>htmlspecialcharsback($adminLang["PATH"]),
			"SECTION" => 1,
			"ICON" => "adm-header-language",
		);
	}

	$arLangMenu[] = array(
		"TEXT" => '('.$adminLang["LID"].') '.$adminLang["NAME"],
		"LINK"=>htmlspecialcharsback($adminLang["PATH"]),
	);
}

if (count($arLangMenu) > 1)
{
	$arLangButton['MENU'] = $arLangMenu;
}


//Footer

$bxProductConfig = array();
if(file_exists($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/.config.php"))
	include($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/.config.php");

CJSCore::Init(array('admin_login'));
?>
<!DOCTYPE html>
<html<?=$direction?>>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="initial-scale=1.0, width=device-width">
<?$APPLICATION->ShowHead();?>
<title><?echo htmlspecialcharsex($APPLICATION->GetTitle(false, true))?> - <?echo COption::GetOptionString("main","site_name", $_SERVER["SERVER_NAME"])?></title>
</head>
<body id="bx-admin-prefix">
<!--[if lte IE 7]>
<style type="text/css">
#login_wrapper {display:none !important;}
</style>
<div id="bx-panel-error">
<?echo GetMessage("admin_panel_browser")?>
</div><![endif]-->
	<div id="login_wrapper" class="login-page login-page-bg login-main-wrapper">
