<?php  

error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR|E_PARSE); 
require_once($_SERVER["DOCUMENT_ROOT"].'/freetrix/modules/main/SetCorePath.php'); 
include_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/lib/loader.php"); 

\Freetrix\Main\Loader::registerAutoLoadClasses( "main", 
array( "freetrix\main\application" => "lib/application.php", 
"freetrix\main\httpapplication" => "lib/httpapplication.php", 
"freetrix\main\argumentexception" => "lib/exception.php",
 "freetrix\main\argumentnullexception" => "lib/exception.php",
"freetrix\main\argumentoutofrangeexception" => "lib/exception.php",
"freetrix\main\argumenttypeexception" => "lib/exception.php", 
"freetrix\main\notimplementedexception" => "lib/exception.php",
"freetrix\main\notsupportedexception" => "lib/exception.php",
"freetrix\main\objectpropertyexception" => "lib/exception.php", 
"freetrix\main\systemexception" => "lib/exception.php", 
"freetrix\main\context" => "lib/context.php",
"freetrix\main\httpcontext" => "lib/httpcontext.php", 
"freetrix\main\event" => "lib/event.php", 
"freetrix\main\eventmanager" => "lib/eventmanager.php",
 "freetrix\main\eventresult" => "lib/eventresult.php", 
"freetrix\main\request" => "lib/request.php", 
"freetrix\main\httprequest" => "lib/httprequest.php", 
"freetrix\main\response" => "lib/response.php", 
"freetrix\main\httpresponse" => "lib/httpresponse.php",
 "freetrix\main\modulemanager" => "lib/modulemanager.php", 
 "freetrix\main\server" => "lib/server.php",
"freetrix\main\config\configuration" => "lib/config/configuration.php",
 "freetrix\main\config\option" => "lib/config/option.php",
"freetrix\main\context\culture" => "lib/context/culture.php", 
"freetrix\main\context\site" => "lib/context/site.php", 
"freetrix\main\data\cache" => "lib/data/cache.php", 
"freetrix\main\data\cacheenginenone" => "lib/data/cacheenginenone.php", 
"freetrix\main\data\connection" => "lib/data/connection.php",
"freetrix\main\data\connectionpool" => "lib/data/connectionpool.php",
 "freetrix\main\data\icacheengine" => "lib/data/cache.php", 
"freetrix\main\data\hsphpreadconnection" => "lib/data/hsphpreadconnection.php", 
"freetrix\main\data\managedcache" => "lib/data/managedcache.php",
"freetrix\main\data\memcacheconnection" => "lib/data/memcacheconnection.php", 
"freetrix\main\data\memcachedconnection" => "lib/data/memcachedconnection.php",
"freetrix\main\data\nosqlconnection" => "lib/data/nosqlconnection.php",
"freetrix\main\db\arrayresult" => "lib/db/arrayresult.php", 
"freetrix\main\db\result" => "lib/db/result.php", 
"freetrix\main\db\connection" => "lib/db/connection.php",
"freetrix\main\db\sqlexception" => "lib/db/sqlexception.php", 
"freetrix\main\db\sqlqueryexception" => "lib/db/sqlexception.php", 
"freetrix\main\db\sqlexpression" => "lib/db/sqlexpression.php",
 "freetrix\main\db\sqlhelper" => "lib/db/sqlhelper.php", 
"freetrix\main\db\mysqlconnection" => "lib/db/mysqlconnection.php",
 "freetrix\main\db\mysqlresult" => "lib/db/mysqlresult.php",
"freetrix\main\db\mysqlsqlhelper" => "lib/db/mysqlsqlhelper.php", 
"freetrix\main\db\mysqliconnection" => "lib/db/mysqliconnection.php", 
"freetrix\main\db\mysqliresult" => "lib/db/mysqliresult.php",
 "freetrix\main\db\mysqlisqlhelper" => "lib/db/mysqlisqlhelper.php", 
"freetrix\main\db\mssqlconnection" => "lib/db/mssqlconnection.php",
 "freetrix\main\db\mssqlresult" => "lib/db/mssqlresult.php",
"freetrix\main\db\mssqlsqlhelper" => "lib/db/mssqlsqlhelper.php",
 "freetrix\main\db\oracleconnection" => "lib/db/oracleconnection.php", 
"freetrix\main\db\oracleresult" => "lib/db/oracleresult.php", 
"freetrix\main\db\oraclesqlhelper" => "lib/db/oraclesqlhelper.php", 
"freetrix\main\diag\httpexceptionhandleroutput" => "lib/diag/httpexceptionhandleroutput.php", 
"freetrix\main\diag\fileexceptionhandlerlog" => "lib/diag/fileexceptionhandlerlog.php", 
"freetrix\main\diag\exceptionhandler" => "lib/diag/exceptionhandler.php", 
"freetrix\main\diag\iexceptionhandleroutput" => "lib/diag/iexceptionhandleroutput.php", 
"freetrix\main\diag\exceptionhandlerlog" => "lib/diag/exceptionhandlerlog.php", 
"freetrix\main\io\file" => "lib/io/file.php",
"freetrix\main\io\fileentry" => "lib/io/fileentry.php", 
"freetrix\main\io\path" => "lib/io/path.php", 
"freetrix\main\io\filesystementry" => "lib/io/filesystementry.php", 
"freetrix\main\io\ifilestream" => "lib/io/ifilestream.php", 
"freetrix\main\localization\loc" => "lib/localization/loc.php", 
"freetrix\main\text\converter" => "lib/text/converter.php", 
"freetrix\main\text\emptyconverter" => "lib/text/emptyconverter.php",
"freetrix\main\text\encoding" => "lib/text/encoding.php", 
"freetrix\main\text\htmlconverter" => "lib/text/htmlconverter.php", 
"freetrix\main\text\string" => "lib/text/string.php",
"freetrix\main\text\xmlconverter" => "lib/text/xmlconverter.php",
 "freetrix\main\type\collection" => "lib/type/collection.php",
"freetrix\main\type\datetime" => "lib/type/datetime.php",
 "freetrix\main\type\dictionary" => "lib/type/dictionary.php", 
"freetrix\main\type\filterabledictionary" => "lib/type/filterabledictionary.php", 
"freetrix\main\type\parameterdictionary" => "lib/type/parameterdictionary.php", 
"freetrix\main\web\cookie" => "lib/web/cookie.php",
"freetrix\main\web\uri" => "lib/web/uri.php",
'CTimeZone' => 'classes/general/time.php')); 

$_1624779850= \Freetrix\Main\HttpApplication::getInstance(); 

$_1624779850->initializeBasicKernel(); 
function getmicrotime(){ 
    list($_169768817, $_585900161) = explode(" ", microtime()); 
    return((float)$_169768817+ (float)$_585900161);
} 
define("START_EXEC_TIME", getmicrotime()); 
define("B_PROLOG_INCLUDED", true); 

require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/Helpers.php"); 
if(version_compare(PHP_VERSION, "5.0.0") >= 0  &&@ini_get_bool("register_long_arrays") != true)
    { 
        $HTTP_POST_FILES= $_FILES; 
        $HTTP_SERVER_VARS= $_SERVER; 
        $HTTP_GET_VARS= $_GET; 
        $HTTP_POST_VARS= $_POST; 
        $HTTP_COOKIE_VARS= $_COOKIE;
         $HTTP_ENV_VARS= $_ENV;
     } 
     
 UnQuoteAll(); 
 FormDecode(); 
 require_once($_SERVER["DOCUMENT_ROOT"].FX_PERSONAL_ROOT."/php_interface/dbconn.php"); 
 if(defined("FX_UTF")) 
     define("FX_UTF_PCRE_MODIFIER", "u"); 
 else 
     define("FX_UTF_PCRE_MODIFIER", ""); 
 
 
 if(!defined("CACHED_b_user_access_check")) 
     define("CACHED_b_user_access_check", false ); 
 
 
 require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/".$DBType."/database.php"); 
 $GLOBALS["DB"]= new CDatabase; 
 $GLOBALS["DB"]->debug= $DBDebug; 
 $GLOBALS["DB"]->DebugToFile= $DBDebugToFile; 
 $_1120501212= ""; if(array_key_exists("show_sql_stat", $_GET))
 {
  $_1120501212=(strtoupper($_GET["show_sql_stat"]) == "Y"? "Y":""); 
  setcookie("show_sql_stat", $_1120501212, false, "/");
 } 
 elseif(array_key_exists("show_sql_stat", $_COOKIE))
     { 
         $_1120501212= $_COOKIE["show_sql_stat"];
     } 
 $GLOBALS["DB"]->ShowSqlStat = ($_1120501212 == "Y"); 
 
 if(!defined("POST_FORM_ACTION_URI")) 
     define("POST_FORM_ACTION_URI", htmlspecialcharsbx("/".ltrim($_SERVER["REQUEST_URI"], "/"))); 
 
if(!($GLOBALS["DB"]->Connect($DBHost, $DBName, $DBLogin, $DBPassword)))
{ 
         if(file_exists(($_1269873926= $_SERVER["DOCUMENT_ROOT"].FX_PERSONAL_ROOT."/php_interface/dbconn_error.php"))) 
             include($_1269873926); 
         else 
             include($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/include/dbconn_error.php"); 
         die();
} 
     
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/classes/general/punycode.php"); 
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/classes/general/charset_converter.php"); 
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/".$DBType."/main.php"); 
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/".$DBType."/option.php"); 
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/cache.php"); 
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/cache_html.php"); 
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/module.php"); 
error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR|E_PARSE); 

//Uncomment for update
// if(file_exists(($_1269873926= $_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/update_db_updater.php")))
// { 
//     $US_HOST_PROCESS_MAIN= True; 
//     include($_1269873926);
// } 