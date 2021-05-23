<?php

namespace Paw\App\Models;

use Paw\Core\Model;

class Noticia extends Model
{
	protected static $table = 'noticias';

	public $fields = [
		'nombre' => null,
		'texto' => null,
		'imagenUrl' => null,
	];

	public function setNombre(string $nombre)
	{
		$this->fields['nombre'] = $nombre;

		return $this;
	}

	public function setTexto($texto)
	{
		$this->fields['texto'] = $texto;
		return $this;
	}

	public function setImagenUrl(string $imagenUrl)
	{
		$this->fields['imagenUrl'] = $imagenUrl;
		return $this;
	}
}
