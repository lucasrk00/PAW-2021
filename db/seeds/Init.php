<?php


use Phinx\Seed\AbstractSeed;

class Init extends AbstractSeed {
	public function run() {
		$nombreEspecialidades = array('Kinesiologo', 'Neurocirujano', 'Médico', 'Anestesista', 'Nefrólogo', 'Infectólogo');
		$especialidadesId = [];

		foreach ($nombreEspecialidades as $nombreEspecialidad) {
			$this->table('especialidades')
				->insert([
					'nombre' => $nombreEspecialidad,
					'descripcion' => 'Descripcion de la especialidad'
				])
				->save();
				$especialidadesId[$nombreEspecialidad] = $this->getAdapter()->getConnection()->lastInsertId();
		}

		$this->table('profesionales')
			->insert([
				'nombre' => 'Ali Vefa',
				'estudios' => 'Universidad Austral',
				'imagenUrl' => '/assets/images/profesional1.png'

			])
			->save();

		$aliVefa = $this->getAdapter()->getConnection()->lastInsertId();

		$this->table('profesionales')
				->insert([
					'nombre' => 'Rivero Lucas',
					'estudios' => 'Universidad de Buenos Aires',
					'imagenUrl' => '/assets/images/profesional2.png'
				])
				->save();

		$lucas = $this->getAdapter()->getConnection()->lastInsertId();
		$this->table('profesionales')
				->insert([
					'nombre' => 'Gregory House',
					'estudios' => 'Universidad John Hopkins',
					'imagenUrl' => '/assets/images/profesional3.png'
				])
				->save();

		$house = $this->getAdapter()->getConnection()->lastInsertId();

		$profesionalesEspecialidades = array(
			[
				"id" => $aliVefa,
				"especialidades" => array('Neurocirujano')
			],
			[
				"id" => $lucas,
				"especialidades" => array('Kinesiologo', 'Anestesista')
			],
			[
				"id" => $house,
				"especialidades" => array('Nefrólogo', 'Infectólogo')
			]
		);

		foreach ($profesionalesEspecialidades as $el) {
			$profId = $el['id'];

			foreach ($el['especialidades'] as $espNombre) {
				$especialidadId = $especialidadesId[$espNombre];
	
				$this->table('profesionalEspecialidades')
					->insert([
						'profesionalId' => $profId,
						'especialidadId' => $especialidadId
					])
					->save();
			}
		}

	}
}
