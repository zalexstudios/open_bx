<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2014 Freetrix
 */

IncludeModuleLangFile(__FILE__);

class CUserTypeDate
{
	function GetUserTypeDescription()
	{
		return array(
			"USER_TYPE_ID" => "date",
			"CLASS_NAME" => "CUserTypeDate",
			"DESCRIPTION" => GetMessage("USER_TYPE_D_DESCRIPTION"),
			"BASE_TYPE" => "datetime",
		);
	}

	function GetDBColumnType()
	{
		return "date";
	}

	function PrepareSettings($arUserField)
	{
		$def = $arUserField["SETTINGS"]["DEFAULT_VALUE"];
		if(!is_array($def))
		{
			$def = array("TYPE"=>"NONE","VALUE"=>"");
		}
		else
		{
			if($def["TYPE"]=="FIXED")
				$def["VALUE"] = CDatabase::FormatDate($def["VALUE"], CLang::GetDateFormat("SHORT"), "YYYY-MM-DD");
			elseif($def["TYPE"]=="NOW")
				$def["VALUE"] = "";
			else
				$def = array("TYPE"=>"NONE","VALUE"=>"");
		}
		return array(
			"DEFAULT_VALUE" => array("TYPE"=>$def["TYPE"], "VALUE"=>$def["VALUE"]),
		);
	}

	function GetSettingsHTML($arUserField = false, $arHtmlControl, $bVarsFromForm)
	{
		$result = '';
		if($bVarsFromForm)
			$type = $GLOBALS[$arHtmlControl["NAME"]]["DEFAULT_VALUE"]["TYPE"];
		elseif(is_array($arUserField) && is_array($arUserField["SETTINGS"]["DEFAULT_VALUE"]))
			$type = $arUserField["SETTINGS"]["DEFAULT_VALUE"]["TYPE"];
		else
			$type = "NONE";
		if($bVarsFromForm)
			$value = $GLOBALS[$arHtmlControl["NAME"]]["DEFAULT_VALUE"]["VALUE"];
		elseif(is_array($arUserField) && is_array($arUserField["SETTINGS"]["DEFAULT_VALUE"]))
			$value = CDatabase::FormatDate($arUserField["SETTINGS"]["DEFAULT_VALUE"]["VALUE"], "YYYY-MM-DD", CLang::GetDateFormat("SHORT"));
		else
			$value = "";
		$result .= '
		<tr>
			<td class="adm-detail-valign-top">'.GetMessage("USER_TYPE_D_DEFAULT_VALUE").':</td>
			<td>
				<label><input type="radio" name="'.$arHtmlControl["NAME"].'[DEFAULT_VALUE][TYPE]" value="NONE" '.("NONE"==$type? 'checked="checked"': '').'>'.GetMessage("USER_TYPE_D_NONE").'</label><br>
				<label><input type="radio" name="'.$arHtmlControl["NAME"].'[DEFAULT_VALUE][TYPE]" value="NOW" '.("NOW"==$type? 'checked="checked"': '').'>'.GetMessage("USER_TYPE_D_NOW").'</label><br>
				<label><input type="radio" name="'.$arHtmlControl["NAME"].'[DEFAULT_VALUE][TYPE]" value="FIXED" '.("FIXED"==$type? 'checked="checked"': '').'>'.CAdminCalendar::CalendarDate($arHtmlControl["NAME"].'[DEFAULT_VALUE][VALUE]', $value).'</label><br>
			</td>
		</tr>
		';
		return $result;
	}

	function GetEditFormHTML($arUserField, $arHtmlControl)
	{
		$arHtmlControl["VALIGN"] = "middle";
		if($arUserField["EDIT_IN_LIST"]=="Y")
		{
			if($arUserField["ENTITY_VALUE_ID"]<1 && $arUserField["SETTINGS"]["DEFAULT_VALUE"]["TYPE"]!="NONE")
			{
				if($arUserField["SETTINGS"]["DEFAULT_VALUE"]["TYPE"]=="NOW")
					$arHtmlControl["VALUE"] = ConvertTimeStamp(time(), "SHORT");
				else
					$arHtmlControl["VALUE"] = CDatabase::FormatDate($arUserField["SETTINGS"]["DEFAULT_VALUE"]["VALUE"], "YYYY-MM-DD", CLang::GetDateFormat("SHORT"));
			}
			return CAdminCalendar::CalendarDate($arHtmlControl["NAME"], $arHtmlControl["VALUE"]);
		}
		elseif(strlen($arHtmlControl["VALUE"])>0)
			return $arHtmlControl["VALUE"];
		else
			return '&nbsp;';
	}

	function GetFilterHTML($arUserField, $arHtmlControl)
	{
		return CAdminCalendar::CalendarDate($arHtmlControl["NAME"], $arHtmlControl["VALUE"]);
	}

	function GetAdminListViewHTML($arUserField, $arHtmlControl)
	{
		if(strlen($arHtmlControl["VALUE"])>0)
			return $arHtmlControl["VALUE"];
		else
			return '&nbsp;';
	}

	function GetAdminListEditHTML($arUserField, $arHtmlControl)
	{
		if($arUserField["EDIT_IN_LIST"]=="Y")
			return CAdminCalendar::CalendarDate($arHtmlControl["NAME"], $arHtmlControl["VALUE"]);
		elseif(strlen($arHtmlControl["VALUE"])>0)
			return $arHtmlControl["VALUE"];
		else
			return '&nbsp;';
	}

	function CheckFields($arUserField, $value)
	{
		$aMsg = array();
		if(is_string($value) && !empty($value) && !CheckDateTime($value, FORMAT_DATE))
		{
			$aMsg[] = array(
				"id" => $arUserField["FIELD_NAME"],
				"text" => GetMessage("USER_TYPE_D_ERROR",
					array(
						"#FIELD_NAME#"=>($arUserField["EDIT_FORM_LABEL"] <> ''? $arUserField["EDIT_FORM_LABEL"] : $arUserField["FIELD_NAME"]),
					)
				),
			);
		}
		return $aMsg;
	}
}
