<?php

namespace Paw\App\Models;

use Paw\Core\Model;
use Paw\Core\Database\ConnectionBuilder;

use PDO;
use Exception;

class Persona extends Model
{
	protected static $table = 'personas';

	public $fields = [
		'usuarioId' => null,
		'nombreApellido' => null,
		'telefono' => null,
		'fechaNacimiento' => null,
	];

	public function setUsuarioId(string $usuarioId)
	{
		$this->fields['usuarioId'] = $usuarioId;
		return $this;
	}

	public function setNombreApellido(string $nombreApellido)
	{
		$this->fields['nombreApellido'] = $nombreApellido;
		return $this;
	}

	public function setTelefono(string $telefono)
	{
		$this->fields['telefono'] = $telefono;
		return $this;
	}
	public function setFechaNacimiento(string $fechaNacimiento)
	{
		$this->fields['fechaNacimiento'] = $fechaNacimiento;
		return $this;
	}
	public static function getByUser($userId):Persona {
		$table = static::$table;

		$query = "select * from \"{$table}\" where \"usuarioId\"= ? limit 1";

		$db = ConnectionBuilder::getInstance();

		$state = self::runQuery($db, $query, array($userId));

		$result = $state->fetch(PDO::FETCH_ASSOC);
		if (!$result) throw new Exception("Persona Doesn't exists");

		return self::createInstance($result['id'], $result);
	}
}
