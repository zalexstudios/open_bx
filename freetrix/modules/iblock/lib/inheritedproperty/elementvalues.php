<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage iblock
 */
namespace Freetrix\Iblock\InheritedProperty;

class ElementValues extends BaseValues
{
	protected $section_id = 0;
	protected $element_id = 0;
	public function __construct($iblock_id, $element_id)
	{
		parent::__construct($iblock_id);
		$this->element_id = intval($element_id);
	}
	public function getValueTableName()
	{
		return "b_iblock_section_iprop";
	}
	public function getType()
	{
		return "E";
	}
	public function getId()
	{
		return $this->element_id;
	}
	public function  createTemplateEntity()
	{
		return new \Freetrix\Iblock\Template\Entity\Element($this->element_id);
	}
	public function setParents($sectionId)
	{
		if (is_array($sectionId))
		{
			if (!empty($sectionId))
			{
				$sectionId = array_map("intval", $sectionId);
				$this->section_id = min($sectionId);
			}
		}
		else
		{
			$this->section_id = intval($sectionId);
		}
	}
	public function getParents()
	{
		$parents = array();
		if ($this->element_id > 0)
		{
			$elementList = \Freetrix\Iblock\ElementTable::getList(array(
				"select" => array("IBLOCK_SECTION_ID"),
				"filter" => array("=ID" => $this->element_id),
			));
			$element = $elementList->fetch();
			if ($element && $element["IBLOCK_SECTION_ID"] > 0)
				$parents[] = new SectionValues($this->iblock_id, $element["IBLOCK_SECTION_ID"]);
			else
				$parents[] = new IblockValues($this->iblock_id);
		}
		elseif ($this->section_id > 0)
		{
			$parents[] = new SectionValues($this->iblock_id, $this->section_id);
		}
		else
		{
			$parents[] = new IblockValues($this->iblock_id);
		}
		return $parents;
	}
	public function queryValues()
	{
		$result = array();
		if ($this->hasTemplates())
		{
			$connection = \Freetrix\Main\Application::getConnection();
			$query = $connection->query("
				SELECT
					P.ID
					,P.CODE
					,P.TEMPLATE
					,P.ENTITY_TYPE
					,P.ENTITY_ID
					,IP.VALUE
				FROM
					b_iblock_element_iprop IP
					INNER JOIN b_iblock_iproperty P ON P.ID = IP.IPROP_ID
				WHERE
					IP.IBLOCK_ID = ".$this->iblock_id."
					AND IP.ELEMENT_ID = ".$this->element_id."
			");

			while ($row = $query->fetch())
			{
				$result[$row["CODE"]] = $row;
			}

			if (empty($result))
			{
				$result = parent::queryValues();
				if (!empty($result))
				{
					$elementList = \Freetrix\Iblock\ElementTable::getList(array(
						"select" => array("IBLOCK_SECTION_ID"),
						"filter" => array("=ID" => $this->element_id),
					));
					$element = $elementList->fetch();

					foreach ($result as $CODE => $row)
					{
						$connection->add("b_iblock_element_iprop", array(
							"IBLOCK_ID" => $this->iblock_id,
							"SECTION_ID" => intval($element["IBLOCK_SECTION_ID"]),
							"ELEMENT_ID" => $this->element_id,
							"IPROP_ID" => $row["ID"],
							"VALUE" => $row["VALUE"],
						));
					}
				}
			}
		}
		return $result;
	}

	function clearValues()
	{
		$connection = \Freetrix\Main\Application::getConnection();
		$connection->query("
			DELETE FROM b_iblock_element_iprop
			WHERE IBLOCK_ID = ".$this->iblock_id."
			AND ELEMENT_ID = ".$this->element_id."
		");
	}
}
