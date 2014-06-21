<?
/*
##############################################
# Freetrix Site Manager                        #
# Copyright (c) 2002-2007 Freetrix             #
# http://www.freetrixsoft.com                  #
# mailto:admin@freetrixsoft.com                #
##############################################
*/
require($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/event.php");

class CEvent extends CAllEvent
{
	function CheckEvents()
	{
		if((defined("DisableEventsCheck") && DisableEventsCheck===true) || (defined("FX_CRONTAB_SUPPORT") && FX_CRONTAB_SUPPORT===true && FX_CRONTAB!==true))
			return;

		global $DB, $CACHE_MANAGER;

		if(CACHED_b_event !== false && $CACHE_MANAGER->Read(CACHED_b_event, "events"))
			return "";

		return CEvent::ExecuteEvents();
	}

	function ExecuteEvents()
	{
		$err_mess = "<br>Class: CEvent<br>File: ".__FILE__."<br>Function: CheckEvents<br>Line: ";
		global $DB, $CACHE_MANAGER;

		if(defined("FX_FORK_AGENTS_AND_EVENTS_FUNCTION"))
		{
			if(CMain::ForkActions(array("CEvent", "ExecuteEvents")))
				return "";
		}
	}

	function CleanUpAgent()
	{
		return true;
	}
}

///////////////////////////////////////////////////////////////////
// Класс почтовых шаблонов
///////////////////////////////////////////////////////////////////

class CEventMessage extends CAllEventMessage
{
	function GetList(&$by, &$order, $arFilter=Array())
	{
		$err_mess = "<br>Class: CEventMessage<br>File: ".__FILE__."<br>Function: GetList<br>Line: ";
		global $DB, $USER;
		$arSqlSearch = Array();
		$strSqlSearch = "";
		$bIsLang = false;
		if (is_array($arFilter))
		{
			foreach ($arFilter as $key => $val)
			{
				if(is_array($val))
				{
					if(count($val) <= 0)
						continue;
				}
				else
				{
					if( (strlen($val) <= 0) || ($val === "NOT_REF") )
						continue;
				}
				$match_value_set = array_key_exists($key."_EXACT_MATCH", $arFilter);
				$key = strtoupper($key);
				switch($key)
				{
				case "ID":
					$match = ($arFilter[$key."_EXACT_MATCH"]=="N" && $match_value_set) ? "Y" : "N";
					$arSqlSearch[] = GetFilterQuery("M.ID", $val, $match);
					break;
				case "TYPE":
					$match = ($arFilter[$key."_EXACT_MATCH"]=="Y" && $match_value_set) ? "N" : "Y";
					$arSqlSearch[] = GetFilterQuery("M.EVENT_NAME, T.NAME", $val, $match);
					break;
				case "EVENT_NAME":
				case "TYPE_ID":
					$match = ($arFilter[$key."_EXACT_MATCH"]=="N" && $match_value_set) ? "Y" : "N";
					$arSqlSearch[] = GetFilterQuery("M.EVENT_NAME", $val, $match);
					break;
				case "TIMESTAMP_1":
					$arSqlSearch[] = "M.TIMESTAMP_X >= FROM_UNIXTIME('".MkDateTime(FmtDate($val,"D.M.Y"),"d.m.Y")."')";
					break;
				case "TIMESTAMP_2":
					$arSqlSearch[] = "M.TIMESTAMP_X <= FROM_UNIXTIME('".MkDateTime(FmtDate($val,"D.M.Y")." 23:59:59","d.m.Y")."')";
					break;
				case "LID":
				case "LANG":
				case "SITE_ID":
					if (is_array($val)) $val = implode(" | ",$val);
					$arSqlSearch[] = GetFilterQuery("MS.SITE_ID",$val,"N");
					$bIsLang = true;
					break;
				case "ACTIVE":
					$arSqlSearch[] = ($val=="Y") ? "M.ACTIVE = 'Y'" : "M.ACTIVE = 'N'";
					break;
				case "FROM":
					$match = ($arFilter[$key."_EXACT_MATCH"]=="Y" && $match_value_set) ? "N" : "Y";
					$arSqlSearch[] = GetFilterQuery("M.EMAIL_FROM", $val, $match);
					break;
				case "TO":
					$match = ($arFilter[$key."_EXACT_MATCH"]=="Y" && $match_value_set) ? "N" : "Y";
					$arSqlSearch[] = GetFilterQuery("M.EMAIL_TO", $val, $match);
					break;
				case "BCC":
					$match = ($arFilter[$key."_EXACT_MATCH"]=="Y" && $match_value_set) ? "N" : "Y";
					$arSqlSearch[] = GetFilterQuery("M.BCC", $val, $match);
					break;
				case "SUBJECT":
					$match = ($arFilter[$key."_EXACT_MATCH"]=="Y" && $match_value_set) ? "N" : "Y";
					$arSqlSearch[] = GetFilterQuery("M.SUBJECT", $val, $match);
					break;
				case "BODY_TYPE":
					$arSqlSearch[] = ($val=="text") ? "M.BODY_TYPE = 'text'" : "M.BODY_TYPE = 'html'";
					break;
				case "BODY":
					$match = ($arFilter[$key."_EXACT_MATCH"]=="Y" && $match_value_set) ? "N" : "Y";
					$arSqlSearch[] = GetFilterQuery("M.MESSAGE", $val, $match);
					break;
				}
			}
		}

		if ($by == "id") $strSqlOrder = " ORDER BY M.ID ";
		elseif ($by == "active") $strSqlOrder = " ORDER BY M.ACTIVE ";
		elseif ($by == "event_name") $strSqlOrder = " ORDER BY M.EVENT_NAME ";
		elseif ($by == "from") $strSqlOrder = " ORDER BY M.EMAIL_FROM ";
		elseif ($by == "to") $strSqlOrder = " ORDER BY M.EMAIL_TO ";
		elseif ($by == "bcc") $strSqlOrder = " ORDER BY M.BCC ";
		elseif ($by == "body_type") $strSqlOrder = " ORDER BY M.BODY_TYPE ";
		elseif ($by == "subject") $strSqlOrder = " ORDER BY M.SUBJECT ";
		else
		{
			$strSqlOrder = " ORDER BY M.ID ";
			$by = "id";
		}

		if ($order!="asc")
		{
			$strSqlOrder .= " desc ";
			$order = "desc";
		}

		$strSqlSearch = GetFilterSqlSearch($arSqlSearch);
		$strSql =
			"SELECT M.ID, M.EVENT_NAME, M.ACTIVE, M.LID, ".($bIsLang? "MS.SITE_ID":"M.LID AS SITE_ID").", M.EMAIL_FROM, M.EMAIL_TO, M.SUBJECT, M.MESSAGE, M.BODY_TYPE, M.BCC,
				M.REPLY_TO,
				M.CC,
				M.IN_REPLY_TO,
				M.PRIORITY,
				M.FIELD1_NAME,
				M.FIELD1_VALUE,
				M.FIELD2_NAME,
				M.FIELD2_VALUE,
			".
				$DB->DateToCharFunction("M.TIMESTAMP_X").
			" TIMESTAMP_X,	if(T.ID is null, M.EVENT_NAME, concat('[ ',T.EVENT_NAME,' ] ',ifnull(T.NAME,'')))	EVENT_TYPE ".
			"FROM b_event_message M ".
			($bIsLang?" LEFT JOIN b_event_message_site MS ON (M.ID = MS.EVENT_MESSAGE_ID)":"")." ".
			"	LEFT JOIN b_event_type T ON (T.EVENT_NAME = M.EVENT_NAME and T.LID = '".LANGUAGE_ID."') ".
			"WHERE ".
			$strSqlSearch.
			$strSqlOrder;

		$res = $DB->Query($strSql, false, $err_mess.__LINE__);
		$res->is_filtered = (IsFiltered($strSqlSearch));
		return $res;
	}
}
?>