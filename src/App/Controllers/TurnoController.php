<?php

namespace Paw\App\Controllers;

use Error;
use Exception;
use Paw\Core\Request;
use Paw\Core\Controllers\FormController;
use Paw\App\Controllers\BaseController;
use Paw\Core\Exceptions\EmptyRequiredField;
use Paw\Core\Exceptions\WrongFieldType;

use Paw\App\Models\Especialidad;
use Paw\App\Models\Profesional;
use Paw\App\Models\ProfesionalEspecialidades;
use Paw\App\Models\Turno;

define("FORM_FIELDS", [
	"especialidad" => [
		"type" => "string",
		"required" => true,
	],
	"profesional" => [
		"type" => "string",
		"required" => true,
	],
	"fecha" => [
		"type" => "date",
		"min" => date("Y-m-d"),
		"required" => true
	],
	"hora" => [
		"type" => "string",
		"required" => true
	],
	"nombreape" => [
		"type" => "string",
		"required" => true,
		"requireError" => 'Debe llenar el campo "Correo Electrónico"',
	],
	"email" => [
		"type" => "email",
		"required" => true,
		"requireError" => 'Debe llenar el campo "Correo Electrónico"',
		"typeError" => "El correo electrónico ingresado es inválido"
	],
	"phone" => [
		"type" => "phone",
		"required" => true,
		"typeError" => "El número de teléfono ingresado es inválido"
	],
	"nacimiento" => [
		"type" => "date",
		"max" => date("Y-m-d"),
		"required" => true
	]
]);
class TurnoController extends BaseController{
	public static function getEspecialidades() {
		return [
			"dentista" => "Dentista",
			"doctor" => "Doctor"
		];
	}
	public static function getProfesionales() {
		return [
			"Dr. Ali Vefa",
			"Dr. Rivero Lucas",
			"Dr. Gregory House"
		];
	}
	public function authMiddleware(Request $request) {
		if (!$request->isLoggedIn()) {
			$request->redirect('/login');
		}
	}
	public function solicitarTurnoView(Request $request, $errorMessage = null) {
		$this->authMiddleware($request);
		$titulo = "Solicitar Turno";
		$especialidades = Especialidad::getAll();
		$profesionales = Profesional::getAll();

		$especialidad = $request->getQueryField('especialidad');
		$profesional = $request->getQueryField('profesional');

		$fecha = $request->getQueryField('fecha');
		$hora = $request->getQueryField('hora');

		$method = $request->method();
		$successMessage = null;
		if ($method == "POST" && !isset($errorMessage)) {
			$successMessage = "Turno solicitado correctamente";
		}
		require $this->viewPath . '/solicitarTurno.view.php';
	}
	public function solicitarTurno(Request $request) {
		$datosTurno = $request->data();
		$file = $request->file('estudioClinico');
		$errorMessage = null;
		$hasFile = false;
		try {
			FormController::validateFields($datosTurno, FORM_FIELDS);
	
			if (isset($file) && $file["size"] > 0) {
				FormController::validateFile($file, 'image');
				$hasFile = true;
			}
		} catch (EmptyRequiredField $e) {
			$errorMessage = $e->getMessage();
			return $this->solicitarTurnoView($request, $errorMessage);
		} catch (WrongFieldType $e) {
			$errorMessage = $e->getMessage();
			return $this->solicitarTurnoView($request, $errorMessage);
		}

		$turno = new Turno;
		$usuario = $request->getAuthUser();
		$turno->setPersonaId($usuario->persona->id);
		$turno->setFechaHora(date('Y-m-d H:i:s', strtotime($datosTurno['fecha'] . " " . $datosTurno['hora'])));
		try {
			$profesionalEspecialidad = ProfesionalEspecialidades::getByCombination($datosTurno['profesional'], $datosTurno['especialidad']);
		} catch (Exception $e) {
			return $this->solicitarTurnoView($request, "La especialidad seleccionada no corresponde al profesional seleccionado");
		}
		$turno->setProfesionalEspecialidadesId($profesionalEspecialidad->id);
		if ($hasFile) {
			$fileDirectory = $this->uploadImage($file);
			$turno->setEstudioClinico($fileDirectory);
		}

		$turno->save();

		$request->redirect('/confirmarTurno?turno='. $turno->id);
	}

	private function uploadImage($file, $filename = null) {
		if (!isset($filename))
			$filename = uniqid();
		$tmp_name = $file['tmp_name'];
		$path = pathinfo($file['name']);
		$extension = $path['extension'];
		$dest = __DIR__. "/../../../uploads/".$filename.".".$extension;
		move_uploaded_file($tmp_name, $dest);
		return $dest;
	}

	public function preConfirmarTurno(Request $request):Turno {
		$turnoId = $request->getQueryField('turno');
		if (isset($turno)) {
			$request->redirect('/solicitarTurno');
		}

		try {
			$turno = Turno::getByPk($turnoId);
		} catch (Exception $e) {
			$request->redirect('/solicitarTurno');
		}
		return $turno;
	}
	public function confirmarTurnoView(Request $request) {
		$turno = $this->preConfirmarTurno($request);
		require $this->viewPath . '/confirmarTurno.view.php';
	}
	public function confirmarTurno(Request $request) {
		$this->authMiddleware($request);
		$turno = $this->preConfirmarTurno($request);
		
		$turno->setConfirmado(true);
		$turno->save();

		echo "Turno confirmado :D";
	}
}