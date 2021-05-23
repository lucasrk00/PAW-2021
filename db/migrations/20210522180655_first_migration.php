<?php
declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
use Phinx\Migration\AbstractMigration;

final class FirstMigration extends AbstractMigration
{
	public function change(): void
	{
		$tableProfesionales = $this->table('profesionales');
		$tableProfesionales->addColumn('nombre', 'string')
			->addColumn('estudios', 'string')
			->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
			->create();

		$tableEspecialidades = $this->table('especialidades');
		$tableEspecialidades->addColumn('nombre', 'string')
			->addColumn('descripcion', 'string')
			->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
			->create();

		$tableProfesionalEspecialidades = $this->table('profesionalEspecialidades');
		$tableProfesionalEspecialidades->addColumn('profesionalId', 'biginteger')
			->addColumn('especialidadId', 'biginteger')
			->addForeignKey('profesionalId', 'profesionales', 'id')
			->addForeignKey('especialidadId', 'especialidades', 'id')
			->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
			->create();

		$tableUsuarios = $this->table('usuarios');
		$tableUsuarios->addColumn('email', 'string')
			->addColumn('password', 'string')
			->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
			->create();
		
		$tablePersonas = $this->table('personas')
			->addColumn('usuarioId', 'biginteger')
			->addForeignKey('usuarioId', 'usuarios', 'id')
			->addColumn('nombreApellido', 'string')
			->addColumn('telefono', 'string')
			->addColumn('fechaNacimiento', 'timestamp')
			->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
			->create();

		$tableTurnos = $this->table('turnos');
		$tableTurnos->addColumn('personaId', 'biginteger')
			->addColumn('profesionalEspecialidadesId', 'biginteger')
			->addForeignKey('personaId', 'personas', 'id')
			->addForeignKey('profesionalEspecialidadesId', 'profesionalEspecialidades', 'id')
			->addColumn('fechaHora', 'timestamp')
			->addColumn('estudioClinico', 'string', ['null' => true])
			->addColumn('confirmado', 'boolean', ['default' => false])
			->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
			->create();

		$tableObrasSociales = $this->table('obrasSociales')
			->addColumn('nombre', 'string')
			->addColumn('convenioIntegral', 'boolean')
			->addColumn('convenioAltaComplejidad', 'boolean')
			->addColumn('internacional', 'boolean')
			->addColumn('consultoriosExternos', 'boolean')
			->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
			->create();

		$tableNoticias = $this->table('noticias')
			->addColumn('nombre', 'string')
			->addColumn('texto', 'text')
			->addColumn('imagenUrl', 'string')
			->addColumn('createdAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
			->create();
	}
}
