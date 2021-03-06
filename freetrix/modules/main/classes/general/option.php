<?
##############################################
# Freetrix: SiteManager                        #
# Copyright (c) 2002-2006 Freetrix             #
# http://www.freetrixsoft.com                  #
# mailto:admin@freetrixsoft.com                #
##############################################

global $MAIN_OPTIONS;
$MAIN_OPTIONS = array();
class CAllOption
{
	public static function err_mess()
	{
		return "<br>Class: CAllOption<br>File: ".__FILE__;
	}

	public static function GetOptionString($module_id, $name, $def="", $site=false, $bExactSite=false)
	{
		$v = null;

		try
		{
			if ($bExactSite)
			{
				$v = \Freetrix\Main\Config\Option::getRealValue($module_id, $name, $site);
				return $v === null ? false : $v;
			}

			$v = \Freetrix\Main\Config\Option::get($module_id, $name, $def, $site);
		}
		catch (\Freetrix\Main\ArgumentNullException $e)
		{

		}

		return $v;
	}

	public static function SetOptionString($module_id, $name, $value="", $desc=false, $site="")
	{
		\Freetrix\Main\Config\Option::set($module_id, $name, $value, $site);
		return true;
	}

	public static function RemoveOption($module_id, $name="", $site=false)
	{
		$filter = array();
		if (strlen($name) > 0)
			$filter["name"] = $name;
		if (strlen($site) > 0)
			$filter["site_id"] = $site;
		\Freetrix\Main\Config\Option::delete($module_id, $filter);
	}

	public static function GetOptionInt($module_id, $name, $def="", $site=false)
	{
		return COption::GetOptionString($module_id, $name, $def, $site);
	}

	public static function SetOptionInt($module_id, $name, $value="", $desc="", $site="")
	{
		return COption::SetOptionString($module_id, $name, IntVal($value), $desc, $site);
	}
}

global $MAIN_PAGE_OPTIONS;
$MAIN_PAGE_OPTIONS = array();
class CAllPageOption
{
	function GetOptionString($module_id, $name, $def="", $site=false)
	{
		global $MAIN_PAGE_OPTIONS;

		if($site===false)
			$site = SITE_ID;

		if(isset($MAIN_PAGE_OPTIONS[$site][$module_id][$name]))
			return $MAIN_PAGE_OPTIONS[$site][$module_id][$name];
		elseif(isset($MAIN_PAGE_OPTIONS["-"][$module_id][$name]))
			return $MAIN_PAGE_OPTIONS["-"][$module_id][$name];
		return $def;
	}

	function SetOptionString($module_id, $name, $value="", $desc=false, $site="")
	{
		global $MAIN_PAGE_OPTIONS;

		if($site===false)
			$site = SITE_ID;
		if(strlen($site)<=0)
			$site = "-";

		$MAIN_PAGE_OPTIONS[$site][$module_id][$name] = $value;
		return true;
	}

	function RemoveOption($module_id, $name="", $site=false)
	{
		global $MAIN_PAGE_OPTIONS;

		if ($site === false)
		{
			foreach ($MAIN_PAGE_OPTIONS as $site => $temp)
			{
				if ($name == "")
					unset($MAIN_PAGE_OPTIONS[$site][$module_id]);
				else
					unset($MAIN_PAGE_OPTIONS[$site][$module_id][$name]);
			}
		}
		else
		{
			if ($name == "")
				unset($MAIN_PAGE_OPTIONS[$site][$module_id]);
			else
				unset($MAIN_PAGE_OPTIONS[$site][$module_id][$name]);
		}
	}

	function GetOptionInt($module_id, $name, $def="", $site=false)
	{
		return CPageOption::GetOptionString($module_id, $name, $def, $site);
	}

	function SetOptionInt($module_id, $name, $value="", $desc="", $site="")
	{
		return CPageOption::SetOptionString($module_id, $name, IntVal($value), $desc, $site);
	}
}
?>