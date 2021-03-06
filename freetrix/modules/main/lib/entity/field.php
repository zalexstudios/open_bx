<?php
/**
 * Freetrix Framework
 * @package freetrix
 * @subpackage main
 * @copyright 2001-2012 Freetrix
 */

namespace Freetrix\Main\Entity;
use Freetrix\Main\Localization\Loc;

/**
 * Base entity field class
 * @package freetrix
 * @subpackage main
 */
abstract class Field
{
	/** @var string */
	protected
		$name,
		$dataType;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var null|callback
	 */
	protected $validation = null;

	/**
	 * @var null|callback[]|Validator\Base[]
	 */
	protected $validators = null;

	/** @var Base */
	protected $entity;

	/**
	 * @param string      $name
	 * @param string      $dataType    scalar type or class name
	 * @param Base        $entity
	 * @param array       $parameters
	 * @throws \Exception
	 */
	public function __construct($name, $dataType, Base $entity, $parameters = array())
	{
		if (!strlen($name))
		{
			throw new \Exception('Field name required');
		}

		$this->name = $name;
		$this->dataType = $dataType;
		$this->entity = $entity;

		if (isset($parameters['title']))
		{
			$this->title = $parameters['title'];
		}

		// validation
		if (isset($parameters['validation']))
		{
			if (!is_callable($parameters['validation']))
			{
				throw new \Exception(sprintf(
					'Validation for "%s" field of "%s" entity should be a callback',
					$this->name, $this->entity->getDataClass()
				));
			}

			$this->validation = $parameters['validation'];
		}
	}

	public function validateValue($value, $primary, $row, Result $result)
	{
		$validators = $this->getValidators();

		foreach ($validators as $validator)
		{
			if (is_object($validator))
			{
				$vResult = $validator->validate($value, $primary, $row, $this);
			}
			else
			{
				$vResult = call_user_func_array($validator, array($value, $primary, $row, $this));
			}

			if ($vResult !== true)
			{
				$result->addError(new FieldError($this, $vResult, FieldError::INVALID_VALUE));
				break;
			}
		}
	}

	/**
	 * @return callback[]|Validator\Base[]
	 * @throws \Exception
	 */
	public function getValidators()
	{
		if ($this->validators === null)
		{
			$validators = array();

			if ($this->validation !== null)
			{
				$validators = call_user_func($this->validation);

				if (!is_array($validators))
				{
					throw new \Exception(sprintf(
						'Validation for %s field of %s entity should return array of validators',
						$this->name, $this->entity->getDataClass()
					));
				}

				foreach ($validators as $k => $validator)
				{
					if (!($validator instanceof Validator\Base) && !is_callable($validator))
					{
						throw new \Exception(sprintf(
							'Validator "%s" of "%s" field of "%s" entity should be a Validator\Base or callback',
							$k, $this->name, $this->entity->getDataClass()
						));
					}
				}
			}

			$this->validators = $validators;
		}

		return $this->validators;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getTitle()
	{
		if($this->title !== null)
		{
			return $this->title;
		}

		if(($title = Loc::getMessage($this->getLangCode())) <> '')
		{
			return $this->title = $title;
		}

		return $this->title = $this->name;
	}

	public function getDataType()
	{
		return $this->dataType;
	}

	public function getEntity()
	{
		return $this->entity;
	}

	public function getLangCode()
	{
		return $this->getEntity()->getLangCode().'_'.$this->getName().'_FIELD';
	}
}
