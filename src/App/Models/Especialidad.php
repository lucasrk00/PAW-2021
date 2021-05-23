<?php

namespace Paw\App\Models;

use Paw\Core\Model;

class Especialidad extends Model {
	protected static $table = 'especialidades';

	public $fields = [
		'nombre' => null,
		'descripcion' => null,
	];

	public function setNombre(string $nombre)
	{
		$this->fields['nombre'] = $nombre;

		return $this;
	}

	public function setDescripcion(string $descripcion)
	{
		$this->fields['descripcion'] = $descripcion;
		return $this;
	}
}