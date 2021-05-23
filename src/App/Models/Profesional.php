<?php

namespace Paw\App\Models;

use Paw\Core\Model;
use Paw\App\Models\ProfesionalEspecialidades;
class Profesional extends Model {
	protected static $table = 'profesionales';

	public $fields = [
		'nombre' => null,
		'estudios' => null,
	];
	public $joinedFields = [
		'especialidades' => null,
		'profesionalEspecialidades' => null,
	];

	public function setNombre(string $nombre) {
		$this->fields['nombre'] = $nombre;

		return $this;
	}
	public function setEstudios(string $estudios) {
		$this->fields['estudios'] = $estudios;
		return $this;
	}
	public function setEspecialidades($especialidades)
	{
		$this->joinedFields['especialidades'] = $especialidades;
		return $this;
	}
	public function setProfesionalEspecialidades($profesionalEspecialidades)
	{
		$this->joinedFields['profesionalEspecialidades'] = $profesionalEspecialidades;
		return $this;
	}

	protected function getExternals() {
		$profesionalEspecialidades = ProfesionalEspecialidades::getAll(' "profesionalId" = ?', array($this->id));
		$where = "\"id\" in (";
		$whereStack = array();
		foreach($profesionalEspecialidades as $profEspc) {
			$where .= "? ,";
			array_push($whereStack, $profEspc->especialidadId);
		}
		$where = substr($where, 0, -1) . ")";

		$especialidades = Especialidad::getAll($where, $whereStack);

		$this->setJoined([
			"especialidades" => $especialidades,
			"profesionalEspecialidades" => $profesionalEspecialidades
		]);

		return $this;
	}
}