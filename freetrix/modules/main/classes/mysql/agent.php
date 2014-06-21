<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2013 Freetrix
 */

require($_SERVER["DOCUMENT_ROOT"].FX_ROOT."/modules/main/classes/general/agent.php");

class CAgent extends CAllAgent
{
	function CheckAgents()
	{
		return true;
	}

	function ExecuteAgents($str_crontab)
	{
		return true;
	}
}
