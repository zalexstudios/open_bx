<?
IncludeModuleLangFile(__FILE__);

class CSocServLiveIDOAuth extends CSocServAuth
{
	const ID = "LiveIDOAuth";
	const CONTROLLER_URL = "https://www.freetrix24.ru/controller";

	/** @var CLiveIDOAuthInterface null  */
	protected $entityOAuth = null;

	protected $userId = null;

	function __construct($userId = null)
	{
		$this->userId = $userId;
	}

	public function getEntityOAuth()
	{
		return $this->entityOAuth;
	}

	public function GetSettings()
	{
		return array(
			array("liveid_appid", GetMessage("socserv_liveid_client_id"), "", Array("text", 40)),
			array("liveid_appsecret", GetMessage("socserv_liveid_client_secret"), "", Array("text", 40)),
			array("note"=>GetMessage("socserv_liveid_form_note", array('#URL#'=>CSocServUtil::ServerName()))),
		);
	}

	public function GetFormHtml($arParams)
	{
		$url = self::getUrl();
		if($arParams["FOR_INTRANET"])
			return array("ON_CLICK" => 'onclick="BX.util.popup(\''.htmlspecialcharsbx(CUtil::JSEscape($url)).'\', 580, 400)"');
		return '<a href="javascript:void(0)" onclick="BX.util.popup(\''.htmlspecialcharsbx(CUtil::JSEscape($url)).'\', 580, 400)" class="bx-ss-button liveid-button"></a><span class="bx-spacer"></span><span>'.GetMessage("MAIN_OPTION_COMMENT").'</span>';
	}

	public function getUrl($location = 'opener', $addScope = null)
	{
		$appID = trim(self::GetOption("liveid_appid"));
		$appSecret = trim(self::GetOption("liveid_appsecret"));

		$this->entityOAuth = new CLiveIDOAuthInterface($appID, $appSecret);
		if($this->userId == null)
			$this->entityOAuth->setRefreshToken("skip");
		if($addScope !== null)
			$this->entityOAuth->addScope($addScope);

		if(IsModuleInstalled('freetrix24') && defined('BX24_HOST_NAME'))
		{
			$redirect_uri = self::CONTROLLER_URL."/redirect.php";
			$state = CSocServUtil::ServerName()."/freetrix/tools/oauth/liveid.php?state=";
			$backurl = urlencode($GLOBALS["APPLICATION"]->GetCurPageParam('check_key='.$_SESSION["UNIQUE_KEY"], array("logout", "auth_service_error", "auth_service_id", "backurl"))).'&mode='.$location;
			$state .= urlencode(urlencode("backurl=".$backurl));
		}
		else
		{
			$redirect_uri = CSocServUtil::ServerName()."/freetrix/tools/oauth/liveid.php";
			$state = 'site_id='.SITE_ID.'&backurl='.urlencode($GLOBALS["APPLICATION"]->GetCurPageParam('check_key='.$_SESSION["UNIQUE_KEY"], array("logout", "auth_service_error", "auth_service_id", "backurl"))).'&mode='.$location;
		}

		return $this->entityOAuth->GetAuthUrl($redirect_uri, $state);
	}

	public function getStorageToken()
	{
		$accessToken = null;
		$userId = intval($this->userId);
		if($userId > 0)
		{
			$dbSocservUser = CSocServAuthDB::GetList(array(), array('USER_ID' => $userId, "EXTERNAL_AUTH_ID" => "LiveIDOAuth"), false, false, array("OATOKEN", "REFRESH_TOKEN", "OATOKEN_EXPIRES"));
			if($arOauth = $dbSocservUser->Fetch())
			{
				$accessToken = $arOauth["OATOKEN"];

				if(empty($accessToken) || ((intval($arOauth["OATOKEN_EXPIRES"]) > 0) && (intval($arOauth["OATOKEN_EXPIRES"] < intval(time())))))
				{
					if(isset($arOauth['REFRESH_TOKEN']))
						$this->entityOAuth->getNewAccessToken($arOauth['REFRESH_TOKEN'], $userId, true);
					if(($accessToken = $this->entityOAuth->getToken()) === false)
						return null;
				}
			}
		}

		return $accessToken;
	}

	public function Authorize()
	{
		global $APPLICATION;

		$APPLICATION->RestartBuffer();
		$bSuccess = SOCSERV_AUTHORISATION_ERROR;

		if(isset($_REQUEST["code"]) && $_REQUEST["code"] != '' && CSocServAuthManager::CheckUniqueKey())
		{
			if(IsModuleInstalled('freetrix24') && defined('BX24_HOST_NAME'))
				$redirect_uri = self::CONTROLLER_URL."/redirect.php";
			else
				$redirect_uri = CSocServUtil::ServerName()."/freetrix/tools/oauth/liveid.php";

			$appID = trim(self::GetOption("liveid_appid"));
			$appSecret = trim(self::GetOption("liveid_appsecret"));

			$gAuth = new CLiveIDOAuthInterface($appID, $appSecret, $_REQUEST["code"]);

			if($gAuth->GetAccessToken($redirect_uri) !== false)
			{
				$arLiveIDUser = $gAuth->GetCurrentUser();

				if(is_array($arLiveIDUser) &&  ($arLiveIDUser['id'] <> ''))
				{
					$email = $first_name = $last_name = "";
					$login = "LiveID".$arLiveIDUser['id'];
					$uId = $arLiveIDUser['id'];
					if($arLiveIDUser['first_name'] <> '')
						$first_name = $arLiveIDUser['first_name'];
					if($arLiveIDUser['last_name'] <> '')
						$last_name = $arLiveIDUser['last_name'];
					if($arLiveIDUser['emails']['preferred'] <> '')
					{
						$email = $arLiveIDUser['emails']['preferred'];
						$login = $arLiveIDUser['emails']['preferred'];
						$uId = $arLiveIDUser['emails']['preferred'];
					}
					$arFields = array(
						'EXTERNAL_AUTH_ID' => self::ID,
						'XML_ID' => $uId,
						'LOGIN' => $login,
						'EMAIL' => $email,
						'NAME'=> $first_name,
						'LAST_NAME'=> $last_name,
					);
					$arFields["PERSONAL_WWW"] = $arLiveIDUser["link"];
					if(isset($arLiveIDUser['access_token']))
						$arFields["OATOKEN"] = $arLiveIDUser['access_token'];

					if(isset($arLiveIDUser['refresh_token']))
						$arFields["REFRESH_TOKEN"] = $arLiveIDUser['refresh_token'];

					if(isset($arLiveIDUser['expires_in']))
						$arFields["OATOKEN_EXPIRES"] = time() + $arLiveIDUser['expires_in'];
					if(strlen(SITE_ID) > 0)
						$arFields["SITE_ID"] = SITE_ID;
					$bSuccess = $this->AuthorizeUser($arFields);

				}
			}
		}
		$url = ($APPLICATION->GetCurDir() == "/login/") ? "" : $APPLICATION->GetCurDir();
		$aRemove = array("logout", "auth_service_error", "auth_service_id", "code", "error_reason", "error", "error_description", "check_key", "current_fieldset");

		$mode = 'opener';
		if(isset($_REQUEST["state"]))
		{
			$arState = array();
			parse_str($_REQUEST["state"], $arState);
			if(isset($arState['backurl']))
			{
				$parseUrl = parse_url($arState['backurl']);
				$urlPath = $parseUrl["path"];
				$arUrlQuery = explode('&', $parseUrl["query"]);

				foreach($arUrlQuery as $key => $value)
				{
					foreach($aRemove as $param)
					{
						if(strpos($value, $param."=") === 0)
						{
							unset($arUrlQuery[$key]);
							break;
						}
					}
				}

				$url = (!empty($arUrlQuery)) ? $urlPath.'?'.implode("&", $arUrlQuery) : $urlPath;
			}

			if(isset($arState['mode']))
			{
				$mode = $arState['mode'];
			}
		}
		if($bSuccess === SOCSERV_REGISTRATION_DENY)
		{
			$url = (preg_match("/\?/", $url)) ? $url.'&' : $url.'?';
			$url .= 'auth_service_id='.self::ID.'&auth_service_error='.SOCSERV_REGISTRATION_DENY;
		}
		elseif($bSuccess !== true)
			$url = (isset($parseUrl)) ? $parseUrl.'?auth_service_id='.self::ID.'&auth_service_error='.$bSuccess : $APPLICATION->GetCurPageParam(('auth_service_id='.self::ID.'&auth_service_error='.$bSuccess), $aRemove);
		if(CModule::IncludeModule("socialnetwork") && strpos($url, "current_fieldset=") === false)
			$url = (preg_match("/\?/", $url)) ? $url."&current_fieldset=SOCSERV" : $url."?current_fieldset=SOCSERV";

		$url = CUtil::JSEscape($url);
		$location = ($mode == "opener") ? 'if(window.opener) window.opener.location = \''.$url.'\'; window.close();' : ' window.location = \''.$url.'\';';

		$JSScript = '
		<script type="text/javascript">
		'.$location.'
		</script>
		';

		echo $JSScript;

		die();
	}
}

class CLiveIDOAuthInterface
{
	const AUTH_URL = "https://login.live.com/oauth20_authorize.srf";
	const TOKEN_URL = "https://login.live.com/oauth20_token.srf";
	const CONTACTS_URL = "https://apis.live.net/v5.0/me/";

	protected $appID;
	protected $appSecret;
	protected $code = false;
	protected $access_token = false;
	protected $accessTokenExpires = 0;
	protected $refresh_token = '';
	protected $scope = array(
		'wl.signin',
		'wl.basic',
		'wl.offline_access',
		'wl.emails',
	);

	public function getAccessTokenExpires()
	{
		return $this->accessTokenExpires;
	}

	public function getAppID()
	{
		return $this->appID;
	}

	public function getAppSecret()
	{
		return $this->appSecret;
	}

	public function getToken()
	{
		return $this->access_token;
	}

	/**
	 * @param string $refresh_token
	 */
	public function setRefreshToken($refresh_token)
	{
		$this->refresh_token = $refresh_token;
	}

	public function setScope($scope)
	{
		$this->scope = $scope;
	}

	public function getScope()
	{
		return $this->scope;
	}

	public function addScope($scope)
	{
		if(is_array($scope))
			$this->scope = array_merge($this->scope, $scope);
		else
			$this->scope[] = $scope;
		return $this;
	}

	public function getScopeEncode()
	{
		return implode('+', array_map('urlencode', array_unique($this->getScope())));
	}

	public function __construct($appID, $appSecret, $code=false)
	{
		$this->httpTimeout = SOCSERV_DEFAULT_HTTP_TIMEOUT;
		$this->appID = $appID;
		$this->appSecret = $appSecret;
		$this->code = $code;
	}

	public function GetAuthUrl($redirect_uri, $state='')
	{
		return self::AUTH_URL.
			"?client_id=".urlencode($this->appID).
			"&redirect_uri=".urlencode($redirect_uri).
			"&scope=".$this->getScopeEncode().
			"&response_type=code".
			($state <> ''? '&state='.urlencode($state):'');
	}
	
	public function GetAccessToken($redirect_uri)
	{
		if(($tokens = $this->getStorageTokens()) && is_array($tokens))
		{
			$this->access_token = $tokens["OATOKEN"];
			if($this->checkAccessToken())
			{
				return true;
			}
			elseif(isset($tokens["REFRESH_TOKEN"]))
			{
				if($this->getNewAccessToken($tokens["REFRESH_TOKEN"]))
				{
					return true;
				}
			}
		}

		if($this->code === false)
			return false;

		$result = CHTTP::sPostHeader(self::TOKEN_URL, array(
			"code"=>$this->code,
			"client_id"=>$this->appID,
			"client_secret"=>$this->appSecret,
			"redirect_uri"=>$redirect_uri,
			"grant_type"=>"authorization_code",
		), array(), $this->httpTimeout);

		$arResult = CUtil::JsObjectToPhp($result);

		if(isset($arResult["access_token"]) && $arResult["access_token"] <> '')
		{
			$this->access_token = $arResult["access_token"];
			$this->accessTokenExpires = $arResult["expires_in"];
			if(isset($arResult["refresh_token"]) && $arResult["refresh_token"] <> '')
			{
				$this->refresh_token = $arResult["refresh_token"];
			}
			$_SESSION["OAUTH_DATA"] = array("OATOKEN" => $this->access_token);
			return true;
		}
		return false;
	}
	
	public function GetCurrentUser()
	{
		if($this->access_token === false)
			return false;

		$result = CHTTP::sGetHeader(self::CONTACTS_URL."?access_token=".urlencode($this->access_token), array(), $this->httpTimeout);
		if(!defined("FX_UTF"))
			$result = CharsetConverter::ConvertCharset($result, "utf-8", LANG_CHARSET);

		$result = CUtil::JsObjectToPhp($result);

		if(is_array($result))
		{
			$result["access_token"] = $this->access_token;
			$result["refresh_token"] = $this->refresh_token;
			$result["expires_in"] = $this->accessTokenExpires;
		}
		return $result;
	}

	private function getStorageTokens()
	{
		global $USER;

		$accessToken = '';
		if(is_object($USER))
		{
			$dbSocservUser = CSocServAuthDB::GetList(array(), array('USER_ID' => $USER->GetID(), "EXTERNAL_AUTH_ID" => "LiveIDOAuth"), false, false, array("OATOKEN", "REFRESH_TOKEN"));
			if($arOauth = $dbSocservUser->Fetch())
				$accessToken = $arOauth["OATOKEN"];
		}
		return $accessToken;
	}

	private function checkAccessToken()
	{
		return (($this->access_token - 30) < time()) ? false : true;
	}

	public function getNewAccessToken($refreshToken, $userId = 0, $save = false)
	{
		if($this->appID == false || $this->appSecret == false)
			return false;

		$result = CHTTP::sPostHeader(self::TOKEN_URL, array(
			"refresh_token"=>$refreshToken,
			"client_id"=>$this->appID,
			"client_secret"=>$this->appSecret,
			"grant_type"=>"refresh_token",
		), array(), $this->httpTimeout);

		$arResult = CUtil::JsObjectToPhp($result);

		if(isset($arResult["access_token"]) && $arResult["access_token"] <> '')
		{
			$this->access_token = $arResult["access_token"];
			$this->accessTokenExpires = $arResult["expires_in"];
			if($save && intval($userId) > 0)
			{
				$dbSocservUser = CSocServAuthDB::GetList(array(), array('USER_ID' => intval($userId), "EXTERNAL_AUTH_ID" => "LiveIDOAuth"), false, false, array("ID"));
				if($arOauth = $dbSocservUser->Fetch())
					CSocServAuthDB::Update($arOauth["ID"], array("OATOKEN" => $this->access_token,"OATOKEN_EXPIRES" => time() + $this->accessTokenExpires));
			}
			return true;
		}
		return false;
	}
}
?>