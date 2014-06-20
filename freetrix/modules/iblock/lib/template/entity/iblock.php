<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage iblock
 */
namespace Freetrix\Iblock\Template\Entity;

class Iblock extends Base
{
	protected $catalog = null;
	public function __construct($id)
	{
		parent::__construct($id);
		$this->fieldMap = array(
			"name" => "NAME",
			"previewtext" => "DESCRIPTION",
			"detailtext" => "DESCRIPTION",
			"code" => "CODE",
		);
	}
	public function resolve($entity)
	{
		if ($entity === "catalog")
		{
			if (!$this->catalog && $this->loadFromDatabase())
			{
				if (\Freetrix\Main\Loader::includeModule('catalog'))
					$this->catalog = new ElementCatalog(0);
			}

			if ($this->catalog)
				return $this->catalog;
		}
		return parent::resolve($entity);
	}
	protected function loadFromDatabase()
	{
		if (!isset($this->fields))
		{
			$elementList = \Freetrix\Iblock\IblockTable::getList(array(
				"select" => array_values($this->fieldMap),
				"filter" => array("=ID" => $this->id),
			));
			$this->fields = $elementList->fetch();
		}
		return is_array($this->fields);
	}
}
