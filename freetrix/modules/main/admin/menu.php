<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2013 Freetrix
 */

/**
 * Freetrix vars
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if(!method_exists($USER, "CanDoOperation"))
	return false;

IncludeModuleLangFile(__FILE__);

global $DBType, $adminMenu, $adminPage;

$aMenu = array();
if($USER->CanDoOperation('view_all_users') || $USER->CanDoOperation('view_subordinate_users') || $USER->CanDoOperation('edit_own_profile') || $USER->CanDoOperation('view_groups') || $USER->CanDoOperation('view_other_settings'))
{
	$aMenu[] = array(
		"parent_menu" => "global_menu_settings",
		"sort" => 50,
		"text" => GetMessage("MAIN_MENU_FAVORITE_HEADER"),
		"title" => GetMessage("MAIN_MENU_FAVORITE_ALT"),
		"url" => "favorite_list.php?lang=".LANGUAGE_ID,
		"more_url" => array("favorite_edit.php"),
		"icon" => "fav_menu_icon_yellow",
		"page_icon" => "fav_page_icon",
	);
}

if($USER->CanDoOperation('view_all_users') || $USER->CanDoOperation('view_subordinate_users') || $USER->CanDoOperation('edit_subordinate_users') || $USER->CanDoOperation('edit_all_users') || $USER->CanDoOperation('view_groups') || $USER->CanDoOperation('view_tasks'))
{
	$array_user_items = array();
	if ($USER->CanDoOperation('view_all_users') || $USER->CanDoOperation('view_subordinate_users') || $USER->CanDoOperation('edit_subordinate_users') || $USER->CanDoOperation('edit_all_users'))
		$array_user_items[] = array(
				"text" => GetMessage("MAIN_MENU_USER_LIST"),
				"url" => "user_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("user_edit.php"),
				"title" => GetMessage("MAIN_MENU_USERS_ALT"),
			);

	if ($USER->CanDoOperation('view_groups'))
		$array_user_items[] = array(
			"text" => GetMessage("MAIN_MENU_GROUPS"),
			"url" => "group_admin.php?lang=".LANGUAGE_ID,
			"more_url" => array("group_edit.php"),
			"title" => GetMessage("MAIN_MENU_GROUPS_ALT"),
		);

	if ($USER->CanDoOperation('view_tasks'))
		$array_user_items[] = array(
			"text" => GetMessage("MAIN_MENU_TASKS"),
			"url" => "task_admin.php?lang=".LANGUAGE_ID,
			"more_url" => array("task_edit.php"),
			"title" => GetMessage("MAIN_MENU_TASKS_ALT"),
		);

	if ($USER->CanDoOperation('edit_all_users'))
		$array_user_items[] = array(
			"text" => GetMessage("MAIN_MENU_USER_IMPORT"),
			"url" => "user_import.php?lang=".LANGUAGE_ID,
			"title" => GetMessage("MAIN_MENU_USER_IMPORT_ALT"),
		);

	$aMenu[] = array(
		"parent_menu" => "global_menu_settings",
		"section" => "GENERAL",
		"sort" => 100,
		"text" => GetMessage("MAIN_MENU_MANAG"),
		"title" => GetMessage("MAIN_MENU_USERS_ALT"),
		"icon" => "user_menu_icon",
		"page_icon" => "user_page_icon",
		"items_id" => "menu_users",
		"items" => $array_user_items,
	);
}

if($USER->CanDoOperation('edit_own_profile')  && !($USER->CanDoOperation('view_all_users') || $USER->CanDoOperation('view_subordinate_users')))
{
	$aMenu[] = array(
		"parent_menu" => "global_menu_settings",
		"section" => "GENERAL",
		"sort" => 100,
		"text" => GetMessage("MAIN_MENU_PROFILE"),
		"title" => GetMessage("MAIN_MENU_PROFILE_ALT"),
		"icon" => "user_menu_icon",
		"page_icon" => "user_page_icon",
		"url" => "user_edit.php?lang=".LANGUAGE_ID."&amp;ID=".$USER->GetID(),
		"more_url" => array("user_edit.php"),
	);

	$aMenu[] = array(
		"parent_menu" => "global_menu_settings",
		"sort" => 200,
		"text" => GetMessage("MAIN_MENU_INTERFACE"),
		"title" => GetMessage("MAIN_MENU_INTERFACE_TITLE"),
		"icon" => "sys_menu_icon",
		"page_icon" => "sys_page_icon",
		"url" => "user_settings.php?lang=".LANGUAGE_ID,
	);
}

if(!$USER->CanDoOperation('view_other_settings') && $USER->CanDoOperation('lpa_template_edit'))
{
	$aMenu[] = array(
		"parent_menu" => "global_menu_settings",
		"section" => "MAIN",
		"sort" => 1700,
		"text" => GetMessage("MAIN_MENU_SETTINGS"),
		"title" => GetMessage("MAIN_MENU_SETTINGS_TITLE"),
		"icon" => "sys_menu_icon",
		"page_icon" => "sys_page_icon",
		"items_id" => "menu_system",
		"items" => array(
				array(
					"text" => GetMessage("MAIN_MENU_SITES_LIST"),
					"url" => "site_admin.php?lang=".LANGUAGE_ID,
					"more_url" => array("site_edit.php"),
					"title" => GetMessage("MAIN_MENU_SITES_ALT"),
				),
				array(
					"text" => GetMessage("MAIN_MENU_TEMPLATE"),
					"title" => GetMessage("MAIN_MENU_TEMPL_TITLE"),
					"url" => "template_admin.php?lang=".LANGUAGE_ID,
					"more_url" => array(
						"template_edit.php",
						"template_load.php"
					),
				),
			),
		);
}

if($USER->CanDoOperation('view_other_settings'))
{
	$aModuleItems = array();
	if(method_exists($adminMenu, "IsSectionActive"))
	{
		if($adminMenu->IsSectionActive("menu_module_settings") || ($APPLICATION->GetCurPage() == "/freetrix/admin/settings.php" && $_REQUEST["mid_menu"]<>"") || FX_SEARCH_ADMIN === true)
		{
			$adminPage->Init();
			foreach($adminPage->aModules as $module)
			{
				if($module <> "main")
				{
					if($APPLICATION->GetGroupRight($module) < "R")
						continue;

					if(getLocalPath("modules/".$module."/install/index.php") === false || getLocalPath("modules/".$module."/options.php") === false)
						continue;

					$info = CModule::CreateModuleObject($module);
					$name = $info->MODULE_NAME;
					$sort = $info->MODULE_SORT;
				}
				else
				{
					if(!$USER->CanDoOperation('view_other_settings'))
						continue;
					$name = GetMessage("MAIN_MENU_MAIN_MODULE");
					$sort = -1;
				}

				$aModule = array(
					"text" => $name,
					"url" => "settings.php?lang=".LANGUAGE_ID."&amp;mid=".$module."&amp;mid_menu=1",
					"more_url"=>array("settings.php?lang=".LANGUAGE_ID."&mid=".$module."&mid_menu=1"),
					"title" => GetMessage("MAIN_MENU_MODULE_SETT")." &quot;".$name."&quot;",
					"sort" => $sort,
				);

				if(FX_SEARCH_ADMIN===true)
				{
					$lfile = getLocalPath("modules/".$module."/lang/".LANGUAGE_ID."/options.php");
					if($lfile !== false)
					{
						$aModule["keywords"] = implode(' ', __IncludeLang($_SERVER["DOCUMENT_ROOT"].$lfile, true));
					}
				}

				$aModuleItems[] = $aModule;
			}
			usort($aModuleItems, create_function('$a, $b', 'if($a["sort"] == $b["sort"]) return strcasecmp($a["text"], $b["text"]); return ($a["sort"] < $b["sort"])? -1 : 1;'));
		}
	}

	$aItems = array();
	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_SITES"),
		"title" => GetMessage("MAIN_MENU_SITES_TITLE"),
		"items_id" => "menu_site",
		"items" => array(
			array(
				"text" => GetMessage("MAIN_MENU_SITES_LIST"),
				"url" => "site_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("site_edit.php"),
				"title" => GetMessage("MAIN_MENU_SITES_ALT"),
			),
			array(
				"text" => GetMessage("MAIN_MENU_TEMPLATE"),
				"title" => GetMessage("MAIN_MENU_TEMPL_TITLE"),
				"url" => "template_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array(
					"template_edit.php",
					"template_load.php"
				),
			),
		),
	);
	$aItems[] = array(
		"text" => GetMessage("main_menu_lang_param"),
		"title" => GetMessage("main_menu_lang_param_title"),
		"items_id" => "menu_lang",
		"items" => array(
			array(
				"text" => GetMessage("MAIN_MENU_LANG"),
				"url" => "lang_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("lang_edit.php"),
				"title" => GetMessage("MAIN_MENU_LANGS_ALT"),
			),
			array(
				"text" => GetMessage("main_menu_reg_sett"),
				"url" => "culture_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("culture_edit.php"),
				"title" => GetMessage("main_menu_reg_sett_title"),
			),
		),
	);
	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_EVENT"),
		"title" => GetMessage("MAIN_MENU_EVENT_TITLE"),
		"items_id" => "menu_templates",
		"items" => array(
			array(
				"text" => GetMessage("MAIN_MENU_TEMPLATES"),
				"url" => "message_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("message_edit.php"),
				"title" => GetMessage("MAIN_MENU_TEMPLATES_ALT"),
			),
			array(
				"text" => GetMessage("MAIN_MENU_EVENT_TYPES"),
				"title" => GetMessage("MAIN_MENU_EVENT_TYPES_TITLE"),
				"url" => "type_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array(
					"type_edit.php"
				),
			),
		),
	);
	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_MODULES"),
		"url" => "module_admin.php?lang=".LANGUAGE_ID,
		"more_url" => array("module_edit.php"),
		"title" => GetMessage("MAIN_MENU_MODULES_ALT"),
	);
	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_MODULE_SETTINGS"),
		"url" => "settings.php?lang=".LANGUAGE_ID,
		"title" => GetMessage("MAIN_MENU_SETTINGS_ALT"),
		"dynamic"=>true,
		"module_id"=>"main",
		"items_id"=>"menu_module_settings",
		"items"=>$aModuleItems,
	);
	// $aItems[] = array(
	// 	"text" => GetMessage("MAIN_MENU_CACHE"),
	// 	"url" => "cache.php?lang=".LANGUAGE_ID,
	// 	"more_url" => array(),
	// 	"title" => GetMessage("MAIN_MENU_CACHE_ALT"),
	// );

	

	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_URLREWRITE"),
		"title" => GetMessage("main_menu_urlrewrite_title"),
		"items_id" => "urlrewrite",
		"items" => array(
			array(
				"text" => GetMessage("MAIN_MENU_RATING_RULE_LIST"),
				"url" => "urlrewrite_list.php?lang=".LANGUAGE_ID,
				"more_url" => array("urlrewrite_edit.php", "urlrewrite_reindex.php"),
				"title" => GetMessage("MAIN_MENU_URLREWRITE_ALT"),
			),
			array(
				"text" => GetMessage("MAIN_MENU_SHORT_URLS"),
				"url" => "short_uri_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("short_uri_edit.php"),
				"title" => GetMessage("MAIN_MENU_SHORT_URLS_ALT"),
			),
		),
	);
	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_WIZARDS"),
		"url" => "wizard_list.php?lang=".LANGUAGE_ID,
		"more_url" => array("wizard_load.php", "wizard_export.php"),
		"title" => GetMessage("MAIN_MENU_WIZARDS_TITLE"),
	);
	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_USER_FIELD"),
		"url" => "userfield_admin.php?lang=".LANGUAGE_ID,
		"title" => GetMessage("MAIN_MENU_USER_FIELD_TITLE"),
		"more_url" => array("userfield_admin.php", "userfield_edit.php"),
	);
	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_CAPTCHA"),
		"url" => "captcha.php?lang=".LANGUAGE_ID,
		"title" => GetMessage("MAIN_MENU_CAPTCHA_TITLE"),
		"more_url" => array("captcha.php"),
	);
	// $aItems[] = array(
	// 	"text" => GetMessage("MAIN_MENU_AGENT"),
	// 	"url" => "agent_list.php?lang=".LANGUAGE_ID,
	// 	"more_url" => array("agent_list.php", "agent_edit.php"),
	// 	"title" => GetMessage("MAIN_MENU_AGENT_ALT"),
	// );
	$aItems[] = array(
		"text" => GetMessage("MAIN_MENU_INTERFACE"),
		"title" => GetMessage("main_menu_interface_title"),
		"items_id" => "interface",
		"items" => array(
			array(
				"text" => GetMessage("main_menu_interface"),
				"url" => "user_settings.php?lang=".LANGUAGE_ID,
				"title" => GetMessage("MAIN_MENU_INTERFACE_TITLE"),
			),
			array(
				"text" => GetMessage("MAIN_MENU_HOTKEYS"),
				"url" => "hot_keys_list.php?lang=".LANGUAGE_ID."",
				"more_url" => array("hot_keys_edit.php","hot_keys_test.php","hot_keys_list.php"),
				"title" => GetMessage("MAIN_MENU_HOTKEYS_ALT"),
			),
		),
	);

	$aMenu[] = array(
		"parent_menu" => "global_menu_settings",
		"section" => "MAIN",
		"sort" => 1700,
		"text" => GetMessage("MAIN_MENU_SETTINGS"),
		"title" => GetMessage("MAIN_MENU_SETTINGS_TITLE"),
		"icon" => "sys_menu_icon",
		"page_icon" => "sys_page_icon",
		"items_id" => "menu_system",
		"items" => $aItems,
	);

	
}

if($USER->CanDoOperation('edit_other_settings'))
{
	$aMenu[] = array(
		"parent_menu" => "global_menu_services",
		"section" => "smile",
		"sort" => 600,
		"text" => GetMessage("MAIN_MENU_SMILE"),
		"icon" => "smile_menu_icon",
		"page_icon" => "smile_page_icon",
		"items_id" => "menu_smile",
		"items" => array(
			array(
				"page_icon" => "smile_page_icon",
				"text" => GetMessage("MAIN_MENU_SMILE_LIST"),
				"title" => GetMessage("MAIN_MENU_SMILE_LIST_ALT"),
				"url" => "smile.php?lang=".LANGUAGE_ID,
				"more_url" => array("smile_edit.php"),
			),
			array(
				"page_icon" => "smile_set_page_icon",
				"text" => GetMessage("MAIN_MENU_SMILE_SET_LIST"),
				"title" => GetMessage("MAIN_MENU_SMILE_SET_LIST_ALT"),
				"url" => "smile_set.php?lang=".LANGUAGE_ID,
				"more_url" => array("smile_set_edit.php"),
			),
			array(
				"page_icon" => "smile_import_page_icon",
				"text" => GetMessage("MAIN_MENU_SMILE_IMPORT_LIST"),
				"title" => GetMessage("MAIN_MENU_SMILE_IMPORT_LIST_ALT"),
				"url" => "smile_import.php?lang=".LANGUAGE_ID,
			),
		),
	);
}
if($USER->CanDoOperation('edit_ratings'))
{
	$aMenu[] = array(
		"parent_menu" => "global_menu_services",
		"section" => "rating",
		"sort" => 610,
		"text" => GetMessage("MAIN_MENU_RATING"),
		"title" => GetMessage("MAIN_MENU_RATING_ALT"),
		"icon" => "rating_menu_icon",
		"page_icon" => "rating_page_icon",
		"items_id" => "menu_rating",
		"items" => array(
			array(
				"page_icon" => "rating_page_icon",
				"text" => GetMessage("MAIN_MENU_RATING_LIST"),
				"title" => GetMessage("MAIN_MENU_RATING_LIST_ALT"),
				"url" => "rating_list.php?lang=".LANGUAGE_ID,
				"more_url" => array("rating_edit.php"),
			),
			array(
				"page_icon" => "rating_rule_page_icon",
				"text" => GetMessage("MAIN_MENU_RATING_RULE_LIST"),
				"title" => GetMessage("MAIN_MENU_RATING_RULE_LIST_ALT"),
				"url" => "rating_rule_list.php?lang=".LANGUAGE_ID,
				"more_url" => array("rating_rule_edit.php"),
			),
			array(
				"page_icon" => "rating_settings_page_icon",
				"text" => GetMessage("MAIN_MENU_RATING_SETTINGS"),
				"title" => GetMessage("MAIN_MENU_RATING_SETTINGS_ALT"),
				"url" => "rating_settings.php?lang=".LANGUAGE_ID,
			),
		),
	);
}

return $aMenu;
