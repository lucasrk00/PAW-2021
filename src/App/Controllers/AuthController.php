<?php
namespace Paw\App\Controllers;

use Exception;

use Paw\App\Controllers\BaseController;

use Paw\App\Models\Usuario;
use Paw\App\Models\Persona;

use Paw\Core\Request;
use Paw\Core\Controllers\FormController;


use Paw\Core\Exceptions\EmptyRequiredField;
use Paw\Core\Exceptions\WrongFieldType;

define("LOGIN_FIELDS", [
	"email" => [
		"type" => "email",
		"required" => true
	],
	"password" => [
		"type" => "password",
		"required" => true
	]
]);
define("REGISTER_FIELDS", [
	"email" => [
		"type" => "email",
		"required" => true
	],
	"password" => [
		"type" => "string",
		"required" => true
	],
	"repassword" => [
		"type" => "string",
		"required" => true
	],
	"nombreApellido" => [
		"type" => "string",
		"required" => true
	],
	"telefono" => [
		"type" => "phone",
		"required" => true
	],
	"fechaNacimiento" => [
		"type" => "date",
		"max" => date("Y-m-d"),
		"required" => true
	],
]);

class AuthController extends BaseController {
	public function loginView(Request $request, $fields = array()) {
		if ($request->isLoggedIn()) {
			$request->redirect("/");
		}

		$titulo = "Login";
		require $this->viewPath . '/login.view.php';
	}
	public function registerView(Request $request, $fields = array()) {
		if ($request->isLoggedIn()) {
			$request->redirect("/");
		}
		$titulo = "Registrarse";
		require $this->viewPath . '/registrarse.view.php';
	}

	public function logout(Request $request) {
		$request->clearSession();
		$request->redirect("/login");
	}
	public function login(Request $request) {
		$data = $request->data();
		try {
			FormController::validateFields($data, LOGIN_FIELDS);
		} catch (EmptyRequiredField $e) {
			$errorMessage = $e->getMessage();
		} catch (WrongFieldType $e) {
			$errorMessage = $e->getMessage();
		}

		$insensitiveData = [
			"email" => $data["email"],
		];
		try {
			$usuario = Usuario::getByMail($data['email']);
		} catch (Exception $error) {
			$request->setStatusMessage("Email o contraseña incorrecta", true);
			return $this->loginView($request, $insensitiveData);
		}

		if (password_verify($data['password'], $usuario->password)) {
			$_SESSION["logged"] = true;
			$_SESSION["usuarioId"] = $usuario->id;
			$_SESSION["nombreApellido"] = $usuario->persona->nombreApellido;
			$_SESSION["creationDate"] = time();
		}

		$request->setStatusMessage("Email o contraseña incorrecta", true);
		return $this->loginView($request, $insensitiveData);
	}
	public function register(Request $request) {
		$data = $request->data();
		$hasError = false;
		$errorMessage = "";
		try {
			FormController::validateFields($data, REGISTER_FIELDS);
		} catch (EmptyRequiredField $e) {
			$errorMessage = $e->getMessage();
			$hasError = true;
		} catch (WrongFieldType $e) {
			$errorMessage = $e->getMessage();
			$hasError = true;
		}
		if ($hasError) {
			$request->setStatusMessage($errorMessage, true);
			return $this->registerView($request);
		}
		$insensitiveData = [
			"email" => $data["email"],
			"nombreApellido" => $data["nombreApellido"],
			"telefono" => $data["telefono"],
			"fechaNacimiento" => $data["fechaNacimiento"]
		];
		if ($data['password'] !== $data['repassword']) {
			$request->setStatusMessage("Las contraseñas no coinciden", true);
			return $this->registerView($request, $insensitiveData);
		}

		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$data['repassword'] = null;

		try {
			$exists = Usuario::getByMail($data['email']);
			if (isset($exists)) {
				$request->setStatusMessage("Ya existe un usuario con ese email", true);
				return $this->registerView($request, $insensitiveData);
			}
		} catch (Exception $error) {

		}

		$user = new Usuario;
		$user->set($data);
		$user->save();

		$persona = new Persona;
		$data['usuarioId'] = $user->id;
		$persona->set($data);
		$persona->save();

		$request->setStatusMessage("Registrado correctamente", false, true);
		$request->redirect("/login");
	}
}