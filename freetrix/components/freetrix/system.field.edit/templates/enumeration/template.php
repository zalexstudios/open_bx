<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2013 Freetrix
 */

/**
 * Freetrix vars
 *
 * @var array $arParams
 * @var array $arResult
 */

$bWasSelect = false;

?><input type="hidden" name="<?=$arParams["arUserField"]["FIELD_NAME"]?>" value=""><?

if ($arParams["arUserField"]["SETTINGS"]["DISPLAY"] == "CHECKBOX")
{
	foreach ($arParams["arUserField"]["USER_TYPE"]["FIELDS"] as $key => $val)
	{
		$bSelected = in_array($key, $arResult["VALUE"]) && (
			(!$bWasSelect) ||
			($arParams["arUserField"]["MULTIPLE"] == "Y")
		);
		$bWasSelect = $bWasSelect || $bSelected;

		?><?if($arParams["arUserField"]["MULTIPLE"]=="Y"):?>
			<label><input
				type="checkbox"
				value="<?echo $key?>"
				name="<?echo $arParams["arUserField"]["FIELD_NAME"]?>"
				<?echo ($bSelected? "checked" : "")?>
			><?=$val?></label><br />
		<?else:?>
			<label><input
				type="radio"
				value="<?echo $key?>"
				name="<?echo $arParams["arUserField"]["FIELD_NAME"]?>"
				<?echo ($bSelected? "checked" : "")?>
			><?=$val?></label><br />
		<?endif;?><?
	}
}
else
{
	?><select
		class="bx-user-field-enum"
		name="<?=$arParams["arUserField"]["FIELD_NAME"]?>"
		<?if($arParams["arUserField"]["SETTINGS"]["LIST_HEIGHT"] > 1):?>
			size="<?=$arParams["arUserField"]["SETTINGS"]["LIST_HEIGHT"]?>"
		<?endif;?>
		<?if ($arParams["arUserField"]["MULTIPLE"]=="Y"):?>
			multiple="multiple"
		<?endif;?>
	>
	<?
	foreach ($arParams["arUserField"]["USER_TYPE"]["FIELDS"] as $key => $val)
	{
		$bSelected = in_array(strval($key), $arResult["VALUE"], true) && (
			(!$bWasSelect) ||
			($arParams["arUserField"]["MULTIPLE"] == "Y")
		);
		$bWasSelect = $bWasSelect || $bSelected;

		?><option value="<?echo $key?>"<?echo ($bSelected? " selected" : "")?>><?echo $val?></option><?
	}
	?></select><?
}
