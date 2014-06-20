<?
##############################################
# Freetrix: SiteManager                        #
# Copyright (c) 2002-2005 Freetrix             #
# http://www.freetrixsoft.com                  #
# mailto:admin@freetrixsoft.com                #
##############################################

require_once(dirname(__FILE__)."/../include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

$APPLICATION->SetTitle(GetMessage("MAIN_ADMIN_SECTION_TITLE"));
include($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/include/prolog_admin_after.php");

include($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/include/epilog_admin.php");
?>