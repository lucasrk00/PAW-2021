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
				'nombre' => 'Dr. Ali Vefa',
				'estudios' => 'Universidad Austral',
				'imagenUrl' => '/assets/images/profesional1.png'

			])
			->save();

		$aliVefa = $this->getAdapter()->getConnection()->lastInsertId();

		$this->table('profesionales')
				->insert([
					'nombre' => 'Dr. Rivero Lucas',
					'estudios' => 'Universidad de Buenos Aires',
					'imagenUrl' => '/assets/images/profesional2.jpg'
				])
				->save();

		$lucas = $this->getAdapter()->getConnection()->lastInsertId();
		$this->table('profesionales')
				->insert([
					'nombre' => 'Dr. Gregory House',
					'estudios' => 'Universidad John Hopkins',
					'imagenUrl' => '/assets/images/profesional3.jpg'
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

		$this->table('obrasSociales')
			->insert([
				'nombre' => 'ASUNT',
				'convenioIntegral' => true,
				'convenioAltaComplejidad' => true,
				'internacional' => true,
				'consultoriosExternos' => true
			])
			->save();

		$this->table('obrasSociales')
			->insert([
				'nombre' => 'BOREAL',
				'convenioIntegral' => false,
				'convenioAltaComplejidad' => true,
				'internacional' => false,
				'consultoriosExternos' => true
			])
			->save();

		$this->table('obrasSociales')
			->insert([
				'nombre' => 'OSDE',
				'convenioIntegral' => false,
				'convenioAltaComplejidad' => false,
				'internacional' => true,
				'consultoriosExternos' => false
			])
			->save();

		$this->table('obrasSociales')
			->insert([
				'nombre' => 'OSPAGA',
				'convenioIntegral' => false,
				'convenioAltaComplejidad' => true,
				'internacional' => false,
				'consultoriosExternos' => false
			])
			->save();

		$noticiaTexto = "Lorem ipsum dolor sit amet consectetur adipiscing elit nostra non scelerisque facilisi tempor metus tempus tellus quam, pretium nisl vitae rutrum nunc ut mauris lectus etiam maecenas imperdiet duis turpis lobortis nec. Lectus vivamus sodales nunc laoreet senectus orci potenti porttitor tellus vestibulum, justo aptent porta facilisi aliquam egestas himenaeos dignissim sociosqu dapibus, eget nibh eros elementum primis sem torquent a quisque. Lacinia ultricies ad malesuada euismod tristique velit aenean cum viverra rhoncus convallis, tellus arcu bibendum taciti neque ante vestibulum vitae suscipit parturient est, penatibus habitasse venenatis porttitor et odio sagittis dui luctus nec. Sollicitudin mollis eros suscipit convallis pulvinar fusce erat, tortor congue fames dictumst euismod primis, elementum quisque auctor odio purus curabitur. Montes nullam iaculis mollis purus nisl orci fusce, non lobortis et penatibus ornare cum quisque, volutpat mus posuere diam augue faucibus. Facilisi dictumst fames justo risus ridiculus odio bibendum inceptos, leo magnis conubia augue est class interdum imperdiet, ut vulputate sociosqu per praesent aptent himenaeos.";
		$noticiasData = [];
		for ($i=0; $i < 50; $i++) { 
			array_push($noticiasData, array("nombre" => "Noticia", "texto" => $noticiaTexto, "imagenUrl" => '/assets/images/image-placeholder.png'));
		}

		$this->table('noticias')
			->insert($noticiasData)
			->save();
	}
}
