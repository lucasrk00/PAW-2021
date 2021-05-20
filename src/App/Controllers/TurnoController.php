<?php

namespace Paw\App\Controllers;

use Exception;
use Paw\Core\Request;
use Paw\Core\Controllers\FormController;
use Paw\App\Controllers\BaseController;


define("FORM_FIELDS", [
	"especialidad" => [
		"type" => "string",
		"required" => true
	],
	"profesional" => [
		"type" => "string",
		"required" => true
	],
	"fecha" => [
		"type" => "date",
		"required" => true
	],
	"hora" => [
		"type" => "string",
		"required" => true
	],
	"nombreape" => [
		"type" => "string",
		"required" => true
	],
	"email" => [
		"type" => "email",
		"required" => true
	],
	"phone" => [
		"type" => "phone",
		"required" => true
	],
	"nacimiento" => [
		"type" => "date",
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
	public function solicitarTurnoView(Request $request) {
		$titulo = "Solicitar Turno";
		$especialidades = $this -> getEspecialidades();
		$profesionales = $this -> getProfesionales();

		$especialidad = $request->getQueryField('especialidad');
		$profesional = $request->getQueryField('profesional');

		$fecha = $request->getQueryField('fecha');
		$hora = $request->getQueryField('hora');

		require $this->viewPath . '/solicitarTurno.view.php';
	}
	public function solicitarTurno(Request $request) {
		$datosTurno = $request->data();
		$file = $request->file('estudioClinico');

		FormController::validateFields($datosTurno, FORM_FIELDS);

		if (isset($file) && $file["size"] > 0) {
			FormController::validateFile($file, 'image');
		}

		$this->solicitarTurnoView($request);
	}
}

/*array(8) { ["especialidad"]=> string(8) "dentista" ["profesional"]=> string(13) "idProfesional" 
	["fecha"]=> string(10) "2021-04-30" ["hora"]=> string(5) "19:53" ["nombreape"]=> string(2) "ww" 
	["email"]=> string(13) "lucas@asd.com" ["phone"]=> string(3) "123" ["nacimiento"]=> string(10) "2021-05-04" }*/