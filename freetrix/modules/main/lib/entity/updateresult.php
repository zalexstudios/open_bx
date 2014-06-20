<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */

namespace Freetrix\Main\Entity;

use Freetrix\Main\DB\Connection;

class UpdateResult extends Result
{
	/** @var int */
	protected $affectedRowsCount;

	public function __construct()
	{
		parent::__construct();
	}

	public function setAffectedRowsCount(Connection $connection)
	{
		$this->affectedRowsCount = $connection->getAffectedRowsCount();
	}

	/**
	 * @return int
	 */
	public function getAffectedRowsCount()
	{
		return $this->affectedRowsCount;
	}
}
