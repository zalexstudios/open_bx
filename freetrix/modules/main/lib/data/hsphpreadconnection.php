<?php
/**
 * Freetrix Framework
 * @package    freetrix
 * @subpackage main
 * @copyright  2001-2013 Freetrix
 */

namespace Freetrix\Main\Data;

/**
 * Class description
 * @package    freetrix
 * @subpackage main
 */
class HsphpReadConnection extends NosqlConnection implements \Freetrix\Main\Entity\INosqlPrimarySelector
{
	protected $host = 'localhost';

	protected $port = '9998';

	public function __construct($configuration)
	{
		parent::__construct($configuration);

		// host validation
		if (array_key_exists('host', $configuration))
		{
			if (!is_string($configuration['host']) || $configuration['host'] == "")
			{
				throw new \Freetrix\Main\Config\ConfigurationException("Invalid host parameter");
			}

			$this->host = $configuration['host'];
		}

		// port validation
		if (array_key_exists('port', $configuration))
		{
			if (!is_string($configuration['port']) || $configuration['port'] == "")
			{
				throw new \Freetrix\Main\Config\ConfigurationException("Invalid port parameter");
			}

			$this->port = $configuration['port'];
		}
	}

	protected function connectInternal()
	{
		if ($this->isConnected)
		{
			return;
		}

		$this->resource = new \HSPHP\ReadSocket();
		$this->resource->connect($this->host, $this->port);
		$this->isConnected = true;
	}

	protected function disconnectInternal()
	{
	}

	public function get($key)
	{
		return null;
	}

	public function set($key, $value)
	{
		return null;
	}

	public function getEntityByPrimary(\Freetrix\Main\Entity\Base $entity, $primary, $select)
	{
		$this->connectInternal();

		$table = $entity->getDBTableName();
		$sqlConfiguration = $entity->getConnection()->getConfiguration();

		$primary = (array) $primary;

		if (count($primary) > 1)
		{
			throw new \Exception('HSPHP Read Socket doesn\'t support multiple select');
		}

		$indexId = $this->resource->getIndexId($sqlConfiguration['database'], $table, '', join(',', (array) $select));
		$this->resource->select($indexId, '=', $primary);
		$response = $this->resource->readResponse();

		//foreach
		$result = array();

		if (is_array($response))
		{
			foreach ($response as $row)
			{
				$newRow = array();

				foreach ($row as $k => $v)
				{
					$newRow[$select[$k]] = $v;
				}

				$result[] = $newRow;
			}
		}

		return $result;
	}
}
