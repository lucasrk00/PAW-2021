<?php

namespace Paw\Core;

use Paw\Core\Database\ConnectionBuilder;
use PDO;
use Exception;

class Model {
	protected ?PDO $db;
	protected static $table;
	protected static string $primaryKey = 'id';
	public $fields = [];
	public $joinedFields = [];
	public $id;
	public function __construct($id = null) {
		$this->db = ConnectionBuilder::getInstance();
		$this->id = $id;
	}

	public function __get($name) {
		if (isset($this->fields[$name]))
			return $this->fields[$name];
		elseif (isset($this->joinedFields[$name]))
			return $this->joinedFields[$name];
		else
			throw new Exception("{$name} doesnt't exstist");
	}

	public function set(array $array) {
		foreach (array_keys($this->fields) as $field) {
			if (!isset($array[$field])) {
				continue;
			}
			$method = 'set' . ucfirst($field);
			$this->$method($array[$field]);
		}
		return $this;
	}

	public function setJoined(array $array) {
		foreach (array_keys($this->joinedFields) as $field) {
			if (!isset($array[$field])) {
				continue;
			}
			$method = 'set' . ucfirst($field);
			$this->$method($array[$field]);
		}
		return $this;
	}

	public function create():object {
		$queryStack = array();
		$query = "insert into \"" . static::$table . "\" (";
		$afterValue = " values (";

		foreach($this->fields as $fieldName => $value) {
			$query .= " \"{$fieldName}\",";
			array_push($queryStack, $value);
			$afterValue .=  " ?,";
		}

		$query = substr($query, 0, -1);
		$afterValue = substr($afterValue, 0, -1);
		$query .= ") " . $afterValue . ")";

		$statement = self::runQuery($this->db, $query, $queryStack);
		$this->id = $this->db->lastInsertId();
		return $this;
	}

	public function save():object {
		$queryStack = array();
		if (!isset($this->id)) return $this->create();
		$query = "update \"". static::$table . "\" set ";

		foreach($this->fields as $fieldName => $value) {
			array_push($queryStack, $value);
			$query .= " \"" . $fieldName . "\" = ?,";
		}
		$query = substr($query, 0, -1);

		array_push($queryStack, $this->id);
		$query .= " where \"" . static::$primaryKey . "\" = ?";

		$state = self::runQuery($this->db, $query, $queryStack);
		return $this;
	}

	protected static function createInstance($pk, $data) {
		$instance = new static($pk);
		$instance->set($data);
		$instance->getExternals();
		return $instance;
	}
	
	
	protected function getExternals() {
		return $this;
	}

	public static function getAll($where = null, $parameters = null):array {
		$query = 'select * from "'. static::$table.'"';
		if (isset($where))
			$query .= " where ".$where;

		$db = ConnectionBuilder::getInstance();
		$state = self::runQuery($db, $query, $parameters);
		$result = $state->fetchAll(PDO::FETCH_ASSOC);

		$instances = array();
		foreach ($result as $el) {
			$instance = self::createInstance($el[static::$primaryKey], $el);
			$instance->getExternals();
			array_push($instances, $instance);
		}
		return $instances;
	}

	public static function getByPk($pk):object {
		$table = static::$table;
		$primaryKey = static::$primaryKey;

		$query = "select * from \"{$table}\" where \"{$primaryKey}\" = ? limit 1";

		$db = ConnectionBuilder::getInstance();
		$state = self::runQuery($db, $query, array($pk));

		$result = $state->fetch(PDO::FETCH_ASSOC);
		if (!isset($result) || !$result) throw new Exception("Doesnt exists");

		$instance = self::createInstance($pk, $result);
		$instance->getExternals();
		return $instance;
	}

	public static function runQuery($db, $query, $parameters = null) {
		$state = $db->prepare($query);
		$queryResult = $state->execute($parameters);
		if (!$queryResult) {
			throw new Exception($state->errorInfo()[2]);
		}

		return $state;
	}
}