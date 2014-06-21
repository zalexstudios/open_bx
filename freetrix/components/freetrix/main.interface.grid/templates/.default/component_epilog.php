<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/**
 * Freetrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

CUtil::InitJSCore(array('window', 'ajax'));
$APPLICATION->AddHeadScript('/freetrix/js/main/utils.js');
$APPLICATION->AddHeadScript('/freetrix/js/main/popup_menu.js');
$APPLICATION->AddHeadScript('/freetrix/js/main/dd.js');

$APPLICATION->SetAdditionalCSS('/freetrix/themes/.default/pubstyles.css');

$theme = '';
if(isset($arResult["OPTIONS"]))
{
	$theme = $arResult["OPTIONS"]["theme"];
}
elseif(CPageOption::GetOptionString("main.interface", "use_themes", "Y") !== "N")
{
	$theme = CGridOptions::GetTheme($arParams["GRID_ID"]);
}

if($theme <> '')
{
	$APPLICATION->SetAdditionalCSS($templateFolder.'/themes/'.$theme.'/style.css');
}

$currentBodyClass = $APPLICATION->GetPageProperty("BodyClass", false);
$APPLICATION->SetPageProperty("BodyClass", ($currentBodyClass ? $currentBodyClass." " : "")."flexible-layout");
