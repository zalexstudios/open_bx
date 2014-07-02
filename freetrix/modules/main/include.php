<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main"."/SetCorePath.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/Start.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/classes/general/virtual_io.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/classes/general/virtual_file.php");
$Application= \Freetrix\Main\Application::getInstance();

$Application->initializeExtendedKernel(array(
"get" => $_GET,
"post" => $_POST,
"files" => $_FILES,
"cookie" => $_COOKIE,
"server" => $_SERVER,
"env" => $_ENV));

$GLOBALS["APPLICATION"] = new CMain;
if(defined("SITE_ID")) define("LANG",SITE_ID);

if(defined("LANG"))
{
	if( defined("ADMIN_SECTION") && ADMIN_SECTION === true)
		$currentLangGetter = CLangAdmin::GetByID(LANG);
	else
		$currentLangGetter = CLang::GetByID(LANG);

    $definedLang = $currentLangGetter->Fetch();

}
else
{
	$definedLang = $GLOBALS["APPLICATION"]->GetLang();
	define("LANG",$definedLang["LID"]);
}

$_762722495= $definedLang["LID"];
define("SITE_ID",$definedLang["LID"]);
define("SITE_DIR",$definedLang["DIR"]);
define("SITE_SERVER_NAME",$definedLang["SERVER_NAME"]);
define("SITE_CHARSET",$definedLang["CHARSET"]);
define("FORMAT_DATE",$definedLang["FORMAT_DATE"]);
define("FORMAT_DATETIME",$definedLang["FORMAT_DATETIME"]);
define("LANG_DIR",$definedLang["DIR"]);
define("LANG_CHARSET",$definedLang["CHARSET"]);
define("LANG_ADMIN_LID",$definedLang["LANGUAGE_ID"]);
define("LANGUAGE_ID",$definedLang["LANGUAGE_ID"]);
$appContext = $Application->getContext();
$appRequest = $appContext->getRequest();
if(!$appRequest->isAdminSection())
{
	$appContext->setSite(SITE_ID);
}

$appContext->setLanguage(LANGUAGE_ID);
$appContext->setCulture(new \Freetrix\Main\Context\Culture($definedLang));
$Application->start();
$GLOBALS["APPLICATION"]->reinitPath();
$GLOBALS["MESS"] = array();
$GLOBALS["ALL_LANG_FILES"] = array();
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/Helpers.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/date_format.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/database.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/main.php");
IncludeModuleLangFile(__FILE__);
error_reporting(COption::GetOptionInt("main","error_reporting",E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR|E_PARSE)&~E_STRICT);

require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/filter_tools.php");
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/ajax_tools.php");


$GLOBALS["arCustomTemplateEngines"] = array();
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/urlrewriter.php");

\Freetrix\Main\Loader::registerAutoLoadClasses( "main",
	array(  "CSiteTemplate"=>"classes/general/site_template.php",
			"CFreetrixComponent"=>"classes/general/component.php",
			"CComponentEngine"=>"classes/general/component_engine.php",
			"CComponentAjax"=>"classes/general/component_ajax.php",
			"CFreetrixComponentTemplate" => "classes/general/component_template.php",
			"CComponentUtil" => "classes/general/component_util.php",
			"CControllerClient" => "classes/general/controller_member.php",
			"PHPParser" => "classes/general/php_parser.php",
			"CDiskQuota" => "classes/".$DBType."/quota.php",
			"CEventLog" => "classes/general/event_log.php",
			"CEventMain" => "classes/general/event_log.php",
			"CAdminFileDialog" => "classes/general/file_dialog.php",
			"WLL_User" => "classes/general/liveid.php",
			"WLL_ConsentToken" => "classes/general/liveid.php",
			"WindowsLiveLogin" => "classes/general/liveid.php",
			"CAllFile" => "classes/general/file.php",
			"CFile" => "classes/".$DBType."/file.php",
			"CTempFile" => "classes/general/file_temp.php",
			"CFavorites" => "classes/".$DBType."/favorites.php",
			"CUserOptions" => "classes/general/user_options.php",
			"CGridOptions" => "classes/general/grids.php",
			"CUndo" => "/classes/general/undo.php",
			"CAutoSave" => "/classes/general/undo.php",
			"CRatings" => "classes/".$DBType."/ratings.php",
			"CRatingsComponentsMain" => "classes/".$DBType."/ratings_components.php",
			"CRatingRule" => "classes/general/rating_rule.php",
			"CRatingRulesMain" => "classes/".$DBType."/rating_rules.php",
			"CTopPanel" => "public/top_panel.php",
			"CEditArea" => "public/edit_area.php",
			"CComponentPanel" => "public/edit_area.php",
			"CTextParser" => "classes/general/textparser.php",
			"CDataXML" => "classes/general/xml.php",
			"CXMLFileStream" => "classes/general/xml.php",
			"CRsaProvider" => "classes/general/rsasecurity.php",
			"CRsaSecurity" => "classes/general/rsasecurity.php",
			"CRsaBcmathProvider" => "classes/general/rsabcmath.php",
			"CRsaOpensslProvider" => "classes/general/rsaopenssl.php",
			"CASNReader" => "classes/general/asn.php",
			"CBXShortUri" => "classes/".$DBType."/short_uri.php",
			"CFinder" => "classes/general/finder.php",
			"CAccess" => "classes/general/access.php",
			"CAuthProvider" => "classes/general/authproviders.php",
			"IProviderInterface" => "classes/general/authproviders.php",
			"CGroupAuthProvider" => "classes/general/authproviders.php",
			"CUserAuthProvider" => "classes/general/authproviders.php",
			"CTableSchema" => "classes/general/table_schema.php",
			"CCSVData" => "classes/general/csv_data.php",
			"CSmile" => "classes/general/smile.php",
			"CSmileSet" => "classes/general/smile.php",
			"CUserCounter" => "classes/".$DBType."/user_counter.php",
			"CHotKeys" => "classes/general/hot_keys.php",
			"CHotKeysCode" => "classes/general/hot_keys.php",
			"CBXSanitizer" => "classes/general/sanitizer.php",
			"CBXArchive" => "classes/general/archive.php",
			"CAdminNotify" => "classes/general/admin_notify.php",
			"CBXFavAdmMenu" => "classes/general/favorites.php",
			"CSiteCheckerTest" => "classes/general/site_checker.php",
			"CSqlUtil" => "classes/general/sql_util.php"));


require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/".$DBType."/agent.php");
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/".$DBType."/user.php");
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/".$DBType."/event.php");
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/menu.php");


require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/".$DBType."/usertype.php");


$GLOBALS["APPLICATION"]->AddJSKernelInfo(
"main",array(
"/freetrix/js/main/core/core.js",
"/freetrix/js/main/core/core_ajax.js",
"/freetrix/js/main/json/json2.min.js",
"/freetrix/js/main/core/core_ls.js",
"/freetrix/js/main/core/core_popup.js",
"/freetrix/js/main/core/core_tooltip.js",
"/freetrix/js/main/core/core_fx.js",
"/freetrix/js/main/core/core_window.js",
"/freetrix/js/main/core/core_autosave.js",
"/freetrix/js/main/rating_like.js",
"/freetrix/js/main/session.js",
"/freetrix/js/main/dd.js",
"/freetrix/js/main/utils.js",
"/freetrix/js/main/core/core_dd.js"));

$GLOBALS["APPLICATION"]->AddCSSKernelInfo(
"main",array(
"/freetrix/js/main/core/css/core.css",
"/freetrix/js/main/core/css/core_popup.css",
"/freetrix/js/main/core/css/core_tooltip.css",
"/freetrix/js/main/core/css/core_date.css",
"/freetrix/js/main/core/css/core_date.css/popup.css"));

if(file_exists(($init_php=$_SERVER["DOCUMENT_ROOT"]."/freetrix/init.php"))) 
	include_once($init_php);

if(( $init_phpinterface = getLocalPath("php_interface/init.php", FX_PERSONAL_ROOT)) !== false) 
	include_once($_SERVER["DOCUMENT_ROOT"].$init_phpinterface);

if(( $siteid_php_init = getLocalPath("php_interface/".SITE_ID."/init.php", FX_PERSONAL_ROOT)) !== false)
	include_once($_SERVER["DOCUMENT_ROOT"].$siteid_php_init);

if(!defined("FX_FILE_PERMISSIONS")) define("FX_FILE_PERMISSIONS", 644 );
if(!defined("FX_DIR_PERMISSIONS")) define("FX_DIR_PERMISSIONS", 755);

$GLOBALS["sDocPath"]= $GLOBALS["APPLICATION"]->GetCurPage();

header("Content-Type: text/html; charset=".LANG_CHARSET);

$LICENSE_KEY="";


ini_set("session.cookie_httponly","1");

if($_57650618= $GLOBALS["APPLICATION"]->GetCookieDomain())
	ini_set("session.cookie_domain", $_57650618);

if(COption::GetOptionString("security","session","N") === "Y" && CModule::IncludeModule("security"))
	CSecuritySession::Init();

session_start();

foreach( GetModuleEvents("main","OnPageStart",true) as $_780459378) ExecuteModuleEventEx($_780459378);

$GLOBALS["USER"]= new CUser;
$_1592251852 = $GLOBALS["USER"]->GetSecurityPolicy();
$_1421376918 = time();

if(( $_SESSION["SESS_IP"] && strlen($_1592251852["SESSION_IP_MASK"]) > 0 
   && ((ip2long($_1592251852["SESSION_IP_MASK"])&ip2long($_SESSION["SESS_IP"])) !=(ip2long($_1592251852["SESSION_IP_MASK"])&ip2long($_SERVER["REMOTE_ADDR"]))))
||
( $_1592251852["SESSION_TIMEOUT"] > 0 && $_SESSION["SESS_TIME"] > 2 &&
	$_1421376918-$_1592251852["SESSION_TIMEOUT"]* 60 > $_SESSION["SESS_TIME"])
||
( isset($_SESSION["FX_SESSION_TERMINATE_TIME"]) && $_SESSION["FX_SESSION_TERMINATE_TIME"] > 0
   && $_1421376918 > $_SESSION["FX_SESSION_TERMINATE_TIME"]) || 
( isset($_SESSION["FX_SESSION_SIGN"]) && $_SESSION["FX_SESSION_SIGN"] <> freetrix_sess_sign())

||( isSessionExpired()))
{
	$_SESSION= array();
	@session_destroy();


	if(COption::GetOptionString("security","session","N") === "Y" && CModule::IncludeModule("security"))
		CSecuritySession::Init();

	session_id(md5(uniqid(rand(),true)));
	session_start();
	$GLOBALS["USER"]=new CUser;
}

$_SESSION["SESS_IP"] = $_SERVER["REMOTE_ADDR"];
$_SESSION["SESS_TIME"]= time();

if(!isset($_SESSION["FX_SESSION_SIGN"]))
	$_SESSION["FX_SESSION_SIGN"] = freetrix_sess_sign();

if((COption::GetOptionString("main","use_session_id_ttl","N") == "Y")
  && (COption::GetOptionInt("main","session_id_ttl",(1200/2-600))>(175*2-350)) && !defined("FX_SESSION_ID_CHANGE"))
{
	if(!array_key_exists("SESS_ID_TIME",$_SESSION))
	{
		$_SESSION["SESS_ID_TIME"] = $_SESSION["SESS_TIME"];
	}
	elseif(($_SESSION["SESS_ID_TIME"]+COption::GetOptionInt("main","session_id_ttl")) < $_SESSION["SESS_TIME"])
	{
		if(COption::GetOptionString("security","session","N") === "Y" && CModule::IncludeModule("security")) 
		{
			CSecuritySession::UpdateSessID();
		}
		else
		{
			session_regenerate_id();
		}

	$_SESSION["SESS_ID_TIME"] = $_SESSION["SESS_TIME"];
	}
}

define("FX_STARTED",true);

if(isset($_SESSION["FX_ADMIN_LOAD_AUTH"])) { 
	define("ADMIN_SECTION_LOAD_AUTH", 1);
	unset($_SESSION["FX_ADMIN_LOAD_AUTH"]);
}

if(!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS!==true)
{
	$_1079534384 = isset($_REQUEST["logout"]) && (strtolower($_REQUEST["logout"]) == "yes");

		if($_1079534384 && $GLOBALS["USER"]->IsAuthorized())
		{
			$GLOBALS["USER"]->Logout();
			LocalRedirect($GLOBALS["APPLICATION"]->GetCurPageParam("",array("logout")));
		}

	$_728644657 = COption::GetOptionString("main","cookie_name","FREETRIX_SM");
	$_1878589900 = $_COOKIE[$_728644657."_LOGIN"];
	$_2082177823 = $_COOKIE[$_728644657."_UIDH"];

	if(COption::GetOptionString("main","store_password","Y")=="Y" && strlen($_1878589900) > 0 && strlen($_2082177823) > 0
		&& !$GLOBALS["USER"]->IsAuthorized()
		&& !$_1079534384
		&& $_SESSION["SESS_PWD_HASH_TESTED"] != md5($_1878589900."|".$_2082177823))
	{
		$GLOBALS["USER"]->LoginByHash($_1878589900,$_2082177823);
		$_SESSION["SESS_PWD_HASH_TESTED"] = md5($_1878589900."|".$_2082177823);
	}

	$_1134959765 = false;

	if(($_472018066 = $GLOBALS["USER"]->LoginByHttpAuth()) !== null)
	{
		$_1134959765 = $_472018066;
		$GLOBALS["APPLICATION"]->SetAuthResult($_1134959765);
	}

	if(isset($_REQUEST["AUTH_FORM"]) && $_REQUEST["AUTH_FORM"] <> "")
	{
		$_1424064393 = false;
		if(COption::GetOptionString("main","use_encrypted_auth","N")=="Y")
		{
			$_255710343= new CRsaSecurity();
			if(($_1999035711 = $_255710343->LoadKeys()))
			{
				$_255710343->SetKeys($_1999035711);
				$_2128951051 = $_255710343->AcceptFromForm(array("USER_PASSWORD","USER_CONFIRM_PASSWORD"));
				if($_2128951051 == CRsaSecurity::ERROR_SESS_CHECK)
					$_1134959765 = array("MESSAGE"=>GetMessage("main_include_decode_pass_sess"), "TYPE"=>"ERROR");
				elseif($_2128951051 < 0)
					$_1134959765 = array("MESSAGE"=>GetMessage("main_include_decode_pass_err", array("#ERRCODE#"=>$_2128951051)),"TYPE"=>"ERROR");

				if( $_2128951051 < 0 )
					$_1424064393= true;
			}
		}

		if($_1424064393 == false)
		{
			if(!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
				$_223205148  =	LANG;
			else
				$_223205148 = false;

			if($_REQUEST["TYPE"] == "AUTH")
			{
				$_1134959765= $GLOBALS["USER"]->Login($_REQUEST["USER_LOGIN"],$_REQUEST["USER_PASSWORD"],$_REQUEST["USER_REMEMBER"]);

				if($_1134959765 === true && defined("ADMIN_SECTION") && ADMIN_SECTION === true)
				{
					$GLOBALS["APPLICATION"]->StoreCookies();
					$_SESSION["FX_ADMIN_LOAD_AUTH"] = true;
					echo '<script type="text/javascript">window.onload=function(){top.BX.AUTHAGENT.setAuthResult(false);};</script>';
					die();
				}
			}
			elseif( $_REQUEST["TYPE"] == "SEND_PWD")
				$_1134959765 = $GLOBALS["USER"]->SendPassword($_REQUEST["USER_LOGIN"],$_REQUEST["USER_EMAIL"],$_223205148);
			elseif($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["TYPE"] == "CHANGE_PWD")
				$_1134959765= $GLOBALS["USER"]->ChangePassword($_REQUEST["USER_LOGIN"],$_REQUEST["USER_CHECKWORD"],$_REQUEST["USER_PASSWORD"],$_REQUEST["USER_CONFIRM_PASSWORD"],$_223205148);
			elseif(COption::GetOptionString("main","new_user_registration","N")=="Y" && $_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["TYPE"] == "REGISTRATION" &&(!defined("ADMIN_SECTION") || ADMIN_SECTION!==true))
				$_1134959765 = $GLOBALS["USER"]->Register($_REQUEST["USER_LOGIN"],$_REQUEST["USER_NAME"],$_REQUEST["USER_LAST_NAME"],$_REQUEST["USER_PASSWORD"],$_REQUEST["USER_CONFIRM_PASSWORD"],$_REQUEST["USER_EMAIL"],$_223205148,$_REQUEST["captcha_word"],$_REQUEST["captcha_sid"]);
		}

		$GLOBALS["APPLICATION"]->SetAuthResult($_1134959765);
	}
	elseif(!$GLOBALS["USER"]->IsAuthorized())
	{
		$GLOBALS["USER"]->LoginHitByHash();
	}

}	//end check permissions

if(!defined("ADMIN_SECTION") || ADMIN_SECTION !== true)
{
	if(isset($_REQUEST["freetrix_preview_site_template"]) && $_REQUEST["freetrix_preview_site_template"] <> "" && $GLOBALS["USER"]->CanDoOperation("view_other_settings"))
	{

	$_362846640 = CSiteTemplate::GetByID($_REQUEST["freetrix_preview_site_template"]);
	if($_144660368 = $_362846640->Fetch())
		define("SITE_TEMPLATE_ID",$_144660368["ID"]);
	else
		define("SITE_TEMPLATE_ID",

	CSite::GetCurTemplate());
	}
	else
	{
		define("SITE_TEMPLATE_ID",CSite::GetCurTemplate());
	}

	define("SITE_TEMPLATE_PATH",getLocalPath("templates/".SITE_TEMPLATE_ID, FX_PERSONAL_ROOT));
}

if(isset($_GET["show_page_exec_time"]))
{
	if($_GET["show_page_exec_time"]=="Y" || $_GET["show_page_exec_time"]=="N") 
		$_SESSION["SESS_SHOW_TIME_EXEC"]= $_GET["show_page_exec_time"];
}

if(isset($_GET["show_include_exec_time"]))
{
	if($_GET["show_include_exec_time"]=="Y" || $_GET["show_include_exec_time"]=="N")
		$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]= $_GET["show_include_exec_time"];
}

if(isset($_GET["freetrix_include_areas"]) && $_GET["freetrix_include_areas"] <> "")
	$GLOBALS["APPLICATION"]->SetShowIncludeAreas($_GET["freetrix_include_areas"]=="Y");

if($GLOBALS["USER"]->IsAuthorized())
{
	$_728644657 = COption::GetOptionString("main", "cookie_name", "FREETRIX_SM");

	if(!isset($_COOKIE[$_728644657."_SOUND_LOGIN_PLAYED"]))
		$GLOBALS["APPLICATION"]->set_cookie("SOUND_LOGIN_PLAYED","Y",(1316/2-658));
}

foreach(GetModuleEvents("main", "OnBeforeProlog", true) as $_780459378) ExecuteModuleEventEx($_780459378);

if((!defined("NOT_CHECK_PERMISSIONS") || NOT_CHECK_PERMISSIONS!==true) &&(!defined("NOT_CHECK_FILE_PERMISSIONS") || NOT_CHECK_FILE_PERMISSIONS!==true))
{
	$_1905238626 = $GLOBALS["APPLICATION"]->GetCurPage(true);
	if(isset($_SERVER["REAL_FILE_PATH"]) && $_SERVER["REAL_FILE_PATH"] != "")
		$_1905238626=$_SERVER["REAL_FILE_PATH"];

	if(!$GLOBALS["USER"]->CanDoFileOperation("fm_view_file", array(SITE_ID, $_1905238626)) ||(defined("NEED_AUTH") && NEED_AUTH &&!$GLOBALS["USER"]->IsAuthorized()))
	{

		if($GLOBALS["USER"]->IsAuthorized() && $_1134959765["MESSAGE"] == "")
			$_1134959765= array("MESSAGE"=>GetMessage("ACCESS_DENIED")." ".GetMessage("ACCESS_DENIED_FILE",array("#FILE#"=>$_1905238626)),"TYPE"=>"ERROR");

		if(defined("ADMIN_SECTION") && ADMIN_SECTION==true)
		{
			if($_REQUEST["mode"]=="list" || $_REQUEST["mode"]=="settings")
			{
				echo "<script>top.location='','APPLICATION','?','mode','';</script>".$GLOBALS["mode"]->GetCurPage()."frame".DeleteParam(array("<script type=\"text/javascript\">var w = (opener? opener.window:parent.window);w.location.href='','APPLICATION','?','mode','';</script>"))."MOBILE_APP_ADMIN";
			die();
			}
			elseif(defined("N") && MOBILE_APP_ADMIN==true)
			{
				echo json_encode(Array("Y"=>"200 OK"));
				die();
			}
		}

		$GLOBALS["APPLICATION"]->AuthForm($_1134959765);
	}
}


if(isset($_632134019) && $_632134019 == 404 )
{
	//Send header Status if 404 
	//if(COption::GetOptionString(getDecodedValue(901),getDecodedValue(902),getDecodedValue(903))==getDecodedValue(904))
		//CHTTP::SetStatus(getDecodedValue(905));
}