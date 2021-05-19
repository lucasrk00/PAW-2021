<?php

namespace Paw\App\Controllers;

use Exception;
use Paw\Core\Request;
use Paw\App\Controllers\BaseController;
use Paw\Core\Exceptions\EmptyRequiredField;

class TurnoController extends BaseController{
	public function solicitarTurnoView(Request $request) {
		$titulo = "Solicitar Turno";
		require $this->viewPath . '/solicitarTurno.view.php';
	}
	public function solicitarTurno(Request $request) {
		$datosTurno = $request->data();

		$this->validateFields($datosTurno, [
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
			],
			"estudioClinico" => [
				"type" => "image",
				"required" => false
			]
		]);

		$this->solicitarTurnoView($request);
	}
	public function validateFields($data, $fields) {
		foreach ($fields as $fieldName => $field) {
			$exists = array_key_exists($fieldName, $data);

			if ($field['required'] && (!$exists || empty($data[$fieldName]))) {
				throw new EmptyRequiredField("El campo \"" . $fieldName . "\" es obligatorio");
			} else if (!$field['required'] && $exists) {
				continue;
			}

			$fieldValue = $this->validateInput($data[$fieldName]);

			$isValidType = true;
			switch ($field['type']) {
				case 'date':
					$isValidType = preg_match( "/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/", $fieldValue) > 0;
					break;
				case 'time':
					$isValidType = preg_match("/^[0-2][0-9]:[0-6][0-9]$/", $fieldValue) > 0;
				case 'email':
					$isValidType = filter_var($fieldValue, FILTER_VALIDATE_EMAIL);
					break;
				case 'phone':
					$isValidType = preg_match("/^[0-9]*$/", $fieldValue) > 0;
					break;
				default:
					$isValidType = gettype($fieldValue) == $field['type'];
					break;
			}
			if (!$isValidType) {
				throw new Exception("El campo \"" . $fieldName . "\" debe ser de tipo \"" . $field['type'] . "\"");
			}
		}
	}
	public function validateInput($value, $isRequired = true) {
		$value = trim($value);
		$value = stripslashes($value);
		$value = htmlspecialchars($value);

		return $value;
	}
}

/*array(8) { ["especialidad"]=> string(8) "dentista" ["profesional"]=> string(13) "idProfesional" 
	["fecha"]=> string(10) "2021-04-30" ["hora"]=> string(5) "19:53" ["nombreape"]=> string(2) "ww" 
	["email"]=> string(13) "lucas@asd.com" ["phone"]=> string(3) "123" ["nacimiento"]=> string(10) "2021-05-04" }*/