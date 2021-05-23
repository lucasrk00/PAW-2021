<?php

namespace Paw\App\Models;

use Paw\Core\Model;

use Paw\App\Models\Especialidad;
use Paw\App\Models\Profesional;
use Paw\App\Models\ProfesionalEspecialidades;

use Exception;

class Turno extends Model
{
	protected static $table = 'turnos';

	public $fields = [
		'personaId' => null,
		'profesionalEspecialidadesId' => null,
		'fechaHora' => null,
		'estudioClinico' => null,
		'confirmado' => 0,
		'cancelado' => 0,
	];

	public $joinedFields = [
		'especialidad' => null,
		'profesional' => null
	];

	public function setPersonaId(string $personaId) {
		$this->fields['personaId'] = $personaId;
		return $this;
	}

	public function setProfesionalEspecialidadesId(string $profesionalEspecialidadesId) {
		$this->fields['profesionalEspecialidadesId'] = $profesionalEspecialidadesId;
		return $this;
	}

	public function setFechaHora(string $fechaHora) {
		$this->fields['fechaHora'] = $fechaHora;
		return $this;
	}
	public function setEstudioClinico(string $estudioClinico) {
		$this->fields['estudioClinico'] = $estudioClinico;
		return $this;
	}
	public function setConfirmado(bool $val) {
		$this->fields['confirmado'] = $val ? 1 : 0;
		return $this;
	}
	public function setCancelado(bool $val)
	{
		$this->fields['cancelado'] = $val ? 1 : 0;
		return $this;
	}

	public function setEspecialidad($especialidad) {
		$this->joinedFields['especialidad'] = $especialidad;
		return $this;
	}

	public function setProfesional($profesional) {
		$this->joinedFields['profesional'] = $profesional;
		return $this;
	}

	protected function getExternals() {
		$profesionalEspecialidades = ProfesionalEspecialidades::getByPk($this->profesionalEspecialidadesId);
		$especialidad = Especialidad::getByPk($profesionalEspecialidades->especialidadId);
		$profesional = Profesional::getByPk($profesionalEspecialidades->profesionalId);

		$this->setEspecialidad($especialidad);
		$this->setProfesional($profesional);

		return $this;
	}

}
