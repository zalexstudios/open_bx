<?
/*patchlimitationmutatormark1*/
CModule::AddAutoloadClasses(
	"fileman",
	array(
		"CLightHTMLEditor" => "classes/general/light_editor.php",
		"CEditorUtils" => "classes/general/editor_utils.php",
		"CMedialib" => "classes/general/medialib.php",
		"CEventFileman" => "classes/general/fileman_event_list.php",
		"CCodeEditor" => "classes/general/code_editor.php",
		"CFileInput" => "classes/general/file_input.php",
		"CMedialibTabControl" => "classes/general/medialib.php",
		"CSticker" => "classes/general/sticker.php",
		"CSnippets" => "classes/general/snippets.php",
		"CAdminContextMenuML" => "classes/general/medialib_admin.php",
		"CHTMLEditor" => "classes/general/html_editor.php",
		"CComponentParamsManager" => "classes/general/component_params_manager.php"
	)
);

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/fileman/lang.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/admin_tools.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/fileman/fileman.php");
include_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/".$GLOBALS["DBType"]."/favorites.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/fileman/properties.php");
/*patchlimitationmutatormark2*/

CJSCore::RegisterExt('file_input', array(
	'js' => '/freetrix/js/fileman/core_file_input.js',
	'lang' => '/freetrix/modules/fileman/lang/'.LANGUAGE_ID.'/classes/general/file_input.php'
));

//on update method still not exist
if(method_exists($GLOBALS["APPLICATION"], 'AddJSKernelInfo'))
{
	$GLOBALS["APPLICATION"]->AddJSKernelInfo(
		'fileman',
		array(
			'/freetrix/js/fileman/light_editor/le_dialogs.js', '/freetrix/js/fileman/light_editor/le_controls.js',
			'/freetrix/js/fileman/light_editor/le_toolbarbuttons.js', '/freetrix/js/fileman/light_editor/le_core.js'
		)
	);

	$GLOBALS["APPLICATION"]->AddCSSKernelInfo('fileman',array('/freetrix/js/fileman/light_editor/light_editor.css'));
}
