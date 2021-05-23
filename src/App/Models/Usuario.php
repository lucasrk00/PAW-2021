<?php

namespace Paw\App\Models;

use Paw\Core\Model;
use Paw\Core\Database\ConnectionBuilder;
use Paw\App\Models\Persona;
use Exception;
use PDO;

class Usuario extends Model
{
	protected static $table = 'usuarios';

	public $fields = [
		'email' => null,
		'password' => null,
	];

	public $joinedFields = [
		'persona' => []
	];

	public function setEmail(string $email)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception('Campo email debe ser un correo electrónico');
		$this->fields['email'] = $email;

		return $this;
	}
	public function setPassword(string $password)
	{
		$this->fields['password'] = $password;
		return $this;
	}
	public function setPersona($persona){
		$this->joinedFields['persona'] = $persona;
	}

	protected function getExternals() {
		$persona = Persona::getByUser($this->id);
		$this->setPersona($persona);
		return $this;
	}

	public static function getByMail(string $mail):Usuario {
		$table = static::$table;

		$query = "select * from \"{$table}\" where email = ? limit 1";

		$db = ConnectionBuilder::getInstance();

		$state = self::runQuery($db, $query, array($mail));

		$result = $state->fetch(PDO::FETCH_ASSOC);
		if (!$result) throw new Exception("User Doesn't exists");

		return self::createInstance($result['id'], $result);
	}
}
