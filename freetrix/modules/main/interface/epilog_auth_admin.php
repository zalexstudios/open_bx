<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($_REQUEST['bxsender']))
	return;

include($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/interface/lang_files.php");
?>

	</div><?//login-main-wrapper?>

	<div style="display: none;" id="window_wrapper"></div>

<script type="text/javascript">
BX.ready(BX.defer(function(){
	BX.addClass(document.body, 'login-animate');
	BX.addClass(document.body, 'login-animate-popup');
<?
$arPreload = array(
	'CSS' => array('/freetrix/panel/main/admin.css', '/freetrix/panel/main/admin-public.css', '/freetrix/panel/main/adminstyles_fixed.css', '/freetrix/themes/.default/modules.css'),
	'JS' => array('/freetrix/js/main/utils.js', '/freetrix/js/main/admin_tools.js', '/freetrix/js/main/popup_menu.js', '/freetrix/js/main/admin_search.js', '/freetrix/js/main/dd.js', '/freetrix/js/main/core/core_popup.js','/freetrix/js/main/core/core_date.js', '/freetrix/js/main/core/core_admin_interface.js', '/freetrix/js/main/core/core_autosave.js', '/freetrix/js/main/core/core_fx.js'),
);
foreach ($arPreload['CSS'] as $key=>$file)
	$arPreload['CSS'][$key] = CUtil::GetAdditionalFileURL($file,true);
foreach ($arPreload['JS'] as $key=>$file)
	$arPreload['JS'][$key] = CUtil::GetAdditionalFileURL($file,true);
?>

	//preload admin scripts&styles
	setTimeout("BX.loadCSS(['<?=implode("','",$arPreload['CSS'])?>']); BX.ajax.loadScriptAjax(['<?=implode("','",$arPreload['JS'])?>'], null, true);", 2000);
}));

new BX.COpener({DIV: 'login_lang_button', ACTIVE_CLASS: 'login-language-btn-active', MENU: <?=CUtil::PhpToJsObject($arLangButton['MENU'])?>});
</script>
</body>
</html>
