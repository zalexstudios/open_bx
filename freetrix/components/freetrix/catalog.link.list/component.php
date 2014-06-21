<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CFreetrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
global $DB;
/** @global CUser $USER */
global $USER;
/** @global CMain $APPLICATION */
global $APPLICATION;

$arParams["ELEMENT_ID"] = intval($arParams["ELEMENT_ID"]);
$arParams["LINK_PROPERTY_SID"] = trim($arParams["LINK_PROPERTY_SID"]);
if(strlen($arParams["FILTER_NAME"])<=0|| !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
	$arParams["FILTER_NAME"] = "arLINK_FILTER";

$FN = $arParams["FILTER_NAME"];
global ${$FN};
if(!is_array(${$FN}) || count(${$FN})<=0)
{
	${$FN} = array();
	$arParams["CACHE_FILTER"] = "Y";
}
${$FN}["PROPERTY_".$arParams["LINK_PROPERTY_SID"]] = $arParams["ELEMENT_ID"];

if (!isset($arParams['ELEMENT_SORT_FIELD2']))
	$arParams['ELEMENT_SORT_FIELD2'] = '';
if (!isset($arParams['ELEMENT_SORT_ORDER2']))
	$arParams['ELEMENT_SORT_ORDER2'] = '';
if (!isset($arParams['HIDE_NOT_AVAILABLE']))
	$arParams['HIDE_NOT_AVAILABLE'] = '';

$this->IncludeComponentTemplate();

?>