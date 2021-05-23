<?php

namespace Paw\App\Models;

use Paw\Core\Model;
use Paw\Core\Database\ConnectionBuilder;
use PDO;
use Exception;

class ProfesionalEspecialidades extends Model {
	protected static $table = 'profesionalEspecialidades';

	public $fields = [
		'especialidadId' => null,
		'profesionalId' => null,
	];

	public function setProfesionalId(string $id) {
		$this->fields['profesionalId'] = $id;

		return $this;
	}
	public function setEspecialidadId(string $id)
	{
		$this->fields['especialidadId'] = $id;

		return $this;
	}

	public static function getByCombination($profesionalId, $especialidadId):ProfesionalEspecialidades {
		$table = static::$table;

		$query = "select * from \"{$table}\" where \"profesionalId\" = ? and \"especialidadId\" = ? limit 1";

		$db = ConnectionBuilder::getInstance();

		$state = self::runQuery($db, $query, array($profesionalId, $especialidadId));

		$result = $state->fetch(PDO::FETCH_ASSOC);
		if (!$result) throw new Exception("Profesional-especialidad combination doesn't exists");

		return self::createInstance($result['id'], $result);
	}
}