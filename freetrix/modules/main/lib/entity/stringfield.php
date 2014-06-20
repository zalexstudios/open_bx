<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */

namespace Freetrix\Main\Entity;

/**
 * Entity field class for string data type
 * @package freetrix
 * @subpackage main
 */
class StringField extends ScalarField
{
	/**
	 * Shortcut for Regexp validator
	 * @var null|string
	 */
	protected $format = null;

	function __construct($name, $dataType, Base $entity, $parameters = array())
	{
		parent::__construct($name, $dataType, $entity, $parameters);

		if (!empty($parameters['format']))
		{
			$this->format = $parameters['format'];
		}
	}

	/**
	 * Shortcut for Regexp validator
	 * @return null|string
	 */
	public function getFormat()
	{
		return $this->format;
	}

	public function getValidators()
	{
		$validators = parent::getValidators();

		if ($this->format !== null)
		{
			$validators[] = new Validator\RegExp($this->format);
		}

		return $validators;
	}
}