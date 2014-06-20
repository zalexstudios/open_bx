<?
/*
##############################################
# Freetrix: SiteManager                        #
# Copyright (c) 2002-2006 Freetrix             #
# http://www.freetrixsoft.com                  #
# mailto:admin@freetrixsoft.com                #
##############################################
*/
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/fileman/prolog.php");
if (!$USER->CanDoOperation('fileman_view_file_structure') || !$USER->CanDoOperation('fileman_edit_existent_files'))
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

require_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/fileman/include.php");

if(CModule::IncludeModule("compression"))
	CCompress::Disable2048Spaces();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : false;

if (!check_freetrix_sessid())
	die('<!--FX_EDITOR_DUBLICATE_ACTION_REQUEST'.freetrix_sessid().'-->');	

if ($action == 'sitetemplateparams')
{
	$templateID = $_GET['templateID'];
	?>
	<script>
	window.bx_template_params = <?= CUtil::PhpToJSObject(CFileman::GetAllTemplateParams($templateID, $site))?>;
	</script>
	<?
}

define("ADMIN_AJAX_MODE", true);
require($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/epilog_admin_after.php");
?>
