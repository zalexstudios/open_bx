<?
IncludeModuleLangFile(__FILE__);

define ('FX_AJAX_PARAM_ID', 'bxajaxid');

class CAjax
{
	function Init()
	{
		// old version should be here because of compatibility
		global $APPLICATION;

		$APPLICATION->SetTemplateCSS('ajax/ajax.css');
		$APPLICATION->AddHeadScript('/freetrix/js/main/ajax.js');
	}

	function GetComponentID($componentName, $componentTemplate, $additionalID)
	{
		$aTrace = Freetrix\Main\Diag\Helper::getBackTrace(0, DEBUG_BACKTRACE_IGNORE_ARGS);

		$trace_count = count($aTrace);
		$trace_current = $trace_count-1;
		for ($i = 0; $i<$trace_count; $i++)
		{
			if (strtolower($aTrace[$i]['function']) == 'includecomponent' && (($c = strtolower($aTrace[$i]['class'])) == 'callmain' || $c == 'cmain'))
			{
				$trace_current = $i;
				break;
			}
		}

		$sSrcFile = strtolower(str_replace("\\", "/", $aTrace[$trace_current]["file"]));
		$iSrcLine = intval($aTrace[$trace_current]["line"]);

		$bSrcFound = false;

		if($iSrcLine > 0 && $sSrcFile <> "")
		{
			// try to covert absolute path to file within DOCUMENT_ROOT
			$doc_root = rtrim(str_replace(Array("\\\\", "//", "\\"), Array("\\", "/", "/"), realpath($_SERVER["DOCUMENT_ROOT"])), "\\/");
			$doc_root = strtolower($doc_root);

			if(strpos($sSrcFile, $doc_root."/") === 0)
			{
				//within
				$sSrcFile = substr($sSrcFile, strlen($doc_root));
				$bSrcFound = true;
			}
			else
			{
				//outside
				$sRealFreetrix = strtolower(str_replace("\\", "/", realpath($_SERVER["DOCUMENT_ROOT"]."/freetrix")));

				if(strpos($sSrcFile, substr($sRealFreetrix, 0, -6)) === 0)
				{
					$sSrcFile = substr($sSrcFile, strlen($sRealFreetrix) - 7);
					$bSrcFound = true;
				}
				else
				{
					// special hack
					$sRealFreetrixModules = strtolower(str_replace("\\", "/", realpath($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules")));
					if(strpos($sSrcFile, $sRealFreetrixModules) === 0)
					{
						$sSrcFile = "/freetrix/modules".substr($sSrcFile, strlen($sRealFreetrixModules));
						$bSrcFound = true;
					}
				}
			}
		}

		if (!$bSrcFound)
			return false;

		$session_string = $sSrcFile.'|'.$iSrcLine.'|'.$componentName;

		if (strlen($componentTemplate) > 0)
			$session_string .= '|'.$componentTemplate;
		else
			$session_string .= '|.default';

		$session_string .= '|'.$additionalID;

		return md5($session_string);
	}

	function GetSession()
	{
		if (is_set($_REQUEST, FX_AJAX_PARAM_ID))
			return $_REQUEST[FX_AJAX_PARAM_ID];
		else
			return false;
	}

	function GetSessionParam($ajax_id = false)
	{
		if (!$ajax_id) $ajax_id = CAjax::GetSession();
		if (!$ajax_id) return '';
		else return FX_AJAX_PARAM_ID.'='.$ajax_id;
	}

	function AddSessionParam($url, $ajax_id = false)
	{
		$url_anchor = strstr($url, '#');
		if ($url_anchor !== false)
			$url = substr($url, 0, -strlen($url_anchor));

		$url .= strpos($url, "?") === false ? '?' : '&';
		$url .= CAjax::GetSessionParam($ajax_id);

		if (is_set($_REQUEST['AJAX_CALL'])) $url .= '&AJAX_CALL=Y';

		if ($url_anchor !== false)
			$url .= $url_anchor;

		return $url;
	}

	// $text = htmlspecialchar
	function GetLinkEx($real_url, $public_url, $text, $container_id, $additional = '')
	{
		if (!$public_url) $public_url = $real_url;

		return sprintf(
			'<a href="%s" onclick="BX.ajax.insertToNode(\'%s\', \'%s\'); return false;" %s>%s</a>',

			$public_url,
			$real_url,
			$container_id,
			$additional,
			$text
		);
	}

	// $text - no htmlspecialchar
	function GetLink($url, $text, $container_id, $additional = '')
	{
		return CAjax::GetLinkEx($url, false, htmlspecialcharsbx($text), htmlspecialcharsbx($container_id), $additional);
	}

	function GetForm($form_params, $container_id, $ajax_id, $bReplace = true, $bShadow = true)
	{
		static $rndGenerator = null;
		if (!$rndGenerator)
			$rndGenerator = new \Freetrix\Main\Type\RandomSequence("FX_AJAX");
		$rnd = $rndGenerator->randString(6);
		return '
<form '.trim($form_params).'><input type="hidden" name="'.FX_AJAX_PARAM_ID.'" id="'.FX_AJAX_PARAM_ID.'_'.$ajax_id.'_'.$rnd.'" value="'.$ajax_id.'" /><input type="hidden" name="AJAX_CALL" value="Y" /><script type="text/javascript">
function _processform_'.$rnd.'(){
	var obForm = top.BX(\''.FX_AJAX_PARAM_ID.'_'.$ajax_id.'_'.$rnd.'\').form;
	top.BX.bind(obForm, \'submit\', function() {'.CAjax::GetFormEventValue($container_id, $bReplace, $bShadow, '"').'});
	top.BX.removeCustomEvent(\'onAjaxSuccess\', _processform_'.$rnd.');
}
if (top.BX(\''.FX_AJAX_PARAM_ID.'_'.$ajax_id.'_'.$rnd.'\'))
	_processform_'.$rnd.'();
else
	top.BX.addCustomEvent(\'onAjaxSuccess\', _processform_'.$rnd.');
</script>';
	}

	function ClearForm($form_params, $ajax_id = false)
	{
		$form_params = str_replace(CAjax::GetSessionParam($ajax_id), '', $form_params);

		return '<form '.trim($form_params).'>';
	}

	function GetFormEvent($container_id)
	{
		return 'onsubmit="BX.ajax.submitComponentForm(this, \''.htmlspecialcharsbx(CUtil::JSEscape($container_id)).'\', true);"';
	}

	function GetFormEventValue($container_id, $bReplace = true, $bShadow = true, $event_delimiter = '\'')
	{
		$delimiter = $event_delimiter == '\'' ? '"' : '\'';
		return 'BX.ajax.submitComponentForm(this, '.$delimiter.CUtil::JSEscape($container_id).$delimiter.', true)';
		//return 'jsAjaxUtil.'.($bReplace ? 'Insert' : 'Append').'FormDataToNode(this, '.$delimiter.$container_id.$delimiter.', '.($bShadow ? 'true' : 'false').')';
	}

	function encodeURI($str)
	{
		//$str = 'view'.$str;
		return $str;
	}

	function decodeURI($str)
	{
		global $APPLICATION;

		$pos = strpos($str, 'view');
		if ($pos !== 0)
		{
			$APPLICATION->ThrowException(GetMessage('AJAX_REDIRECTOR_BAD_URL'));
			return false;
		}

		$str = str_replace(array("\r", "\n"), "", substr($str, 4));

		if (preg_match("'^(/freetrix/|http://|https://|ftp://)'i", $str))
		{
			$APPLICATION->ThrowException(GetMessage('AJAX_REDIRECTOR_BAD_URL'));
			return false;
		}

		return $str;
	}
}
?>