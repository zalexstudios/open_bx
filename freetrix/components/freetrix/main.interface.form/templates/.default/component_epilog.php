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

$APPLICATION->SetAdditionalCSS('/freetrix/themes/.default/pubstyles.css');
if($arResult["OPTIONS"]["theme"] <> '')
{
	$APPLICATION->SetAdditionalCSS($templateFolder.'/themes/'.$arResult["OPTIONS"]["theme"].'/style.css');
}
