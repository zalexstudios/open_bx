<?
require($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/prolog.php");

if (!$USER->CanDoOperation('seo_tools'))
	die(GetMessage("ACCESS_DENIED"));

use Freetrix\Seo\Engine;
use Freetrix\Main\IO\Path;

IncludeModuleLangFile(__FILE__);
\Freetrix\Main\Loader::includeModule('seo');
\Freetrix\Main\Loader::includeModule('socialservices');

CUtil::JSPostUnescape();

$engine = new Engine\Google();

if(isset($_REQUEST['action']) && check_freetrix_sessid())
{
	$res = array();

	$arDomain = null;
	if(isset($_REQUEST['domain']) && strlen($_REQUEST['domain']) > 0)
	{
		$bFound = false;
		$arDomains = \CSeoUtils::getDomainsList();
		foreach($arDomains as $arDomain)
		{
			if($arDomain['DOMAIN'] == $_REQUEST['domain'] && rtrim($arDomain['SITE_DIR'], '/') == rtrim($_REQUEST['dir'], '/'))
			{
				$bFound = true;
				break;
			}
		}

		if(!$bFound)
		{
			$res = array('error' => 'Unknown site!');
		}
	}

	if(!$res['error'])
	{
		try
		{
			switch($_REQUEST['action'])
			{
				case 'nullify_auth':
					$engine->clearAuthSettings();
					$res = array("result" => true);
				break;

				case 'sites_feed':
					$res = $engine->getFeeds();
				break;

				case 'site_add':
					$res = $engine->addSite($arDomain['DOMAIN'], $arDomain['SITE_DIR']);
					$res['_domain'] = $arDomain['DOMAIN'];
				break;

				case 'keywords_feed':
					$res = $engine->getKeywordsFeed($arDomain['DOMAIN'], $arDomain['SITE_DIR']);
				break;

				case 'sitemaps_feed':
					$res = $engine->getSitemapsFeed($arDomain['DOMAIN'], $arDomain['SITE_DIR']);
				break;

				case 'crawlissues_feed':
					$res = $engine->getCrawlIssuesFeed($arDomain['DOMAIN'], $arDomain['SITE_DIR']);
				break;

				case 'save':
					$fieldName = $_REQUEST['name'];
					$fieldValue = $_REQUEST['value'];
					switch($fieldName)
					{
						case 'geolocation':
						case 'preferred-domain':

							$res = $engine->setSiteInfo(
								$arDomain['DOMAIN'],
								$arDomain['SITE_DIR'],
								array(
									$fieldName => $fieldValue
								)
							);

						break;
					}
				break;

				case 'site_verify':
					$res = array('error' => 'Unknown domain');

					if(is_array($arDomain))
					{
						$siteInfo = $engine->getSiteInfo($arDomain['DOMAIN'], $arDomain['SITE_DIR']);
						if($siteInfo[$arDomain['DOMAIN']]['verified'] == 'false')
						{
							$filename = $siteInfo[$arDomain['DOMAIN']]['verification-method']['file-name'];

							// paranoia?
							$filename = preg_replace("/^(.*?)\..*$/", "\\1.html", $filename);

							$path = Path::combine((
								strlen($arDomain['SITE_DOC_ROOT']) > 0
									? $arDomain['SITE_DOC_ROOT']
									: $_SERVER['DOCUMENT_ROOT']
								), $arDomain['SITE_DIR'], $filename);

							$obFile = new \Freetrix\Main\IO\File($path);
							$obFile->putContents($siteInfo[$arDomain['DOMAIN']]['verification-method']['file-content']);

							$res = $engine->verifySite($arDomain['DOMAIN'], $arDomain['SITE_DIR']);

							$obFile->delete();

							$res = $engine->getFeeds();

							$res['_domain'] = $arDomain['DOMAIN'];
						}
						elseif($siteInfo[$arDomain['DOMAIN']]['verified'] == 'true')
						{
							$res = $siteInfo;
							$res['_domain'] = $arDomain['DOMAIN'];
						}
					}
					else
					{
						$res = array('error' => 'No domain');
					}
				break;

				default:
					$res = array('error' => 'unknown action');
				break;
			}
		}
		catch(Exception $e)
		{
			$res = array(
				'error' => $e->getMessage()
			);
		}
	}

	Header('Content-type: application/json');
	echo CUtil::PhpToJsObject($res);
}
?>