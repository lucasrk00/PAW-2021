<?php

namespace Paw\App\Models;

use Paw\Core\Model;

class ObraSocial extends Model
{
	protected static $table = 'obrasSociales';

	public $fields = [
		'nombre' => null,
		'convenioIntegral' => null,
		'convenioAltaComplejidad' => null,
		'internacional' => null,
		'consultoriosExternos' => null,
	];

	public function setNombre(string $nombre)
	{
		$this->fields['nombre'] = $nombre;

		return $this;
	}

	public function setConvenioIntegral(bool $val)
	{
		$this->fields['convenioIntegral'] = $val ? 1 : 0;
		return $this;
	}
	public function setConvenioAltaComplejidad(bool $val)
	{
		$this->fields['convenioAltaComplejidad'] = $val ? 1 : 0;
		return $this;
	}
	public function setInternacional(bool $val)
	{
		$this->fields['internacional'] = $val ? 1 : 0;
		return $this;
	}
	public function setConsultoriosExternos(bool $val)
	{
		$this->fields['consultoriosExternos'] = $val ? 1 : 0;
		return $this;
	}

}
