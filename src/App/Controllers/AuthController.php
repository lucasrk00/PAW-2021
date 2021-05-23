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
		"type" => "password",
		"required" => true
	],
	"repassword" => [
		"type" => "password",
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
		"required" => true
	],
]);

class AuthController extends BaseController {
	public function loginView(Request $request, $fields = array(), $errorMessage = null) {
		if ($request->isLoggedIn()) {
			$request->redirect("/");
		}

		$titulo = "Login";
		require $this->viewPath . '/login.view.php';
	}
	public function registerView(Request $request, $fields = array(), $errorMessage = null) {
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
			return $this->loginView($request, $insensitiveData, "Email o contraseña incorrecta");
		}

		if (password_verify($data['password'], $usuario->password)) {
			$_SESSION["logged"] = true;
			$_SESSION["usuarioId"] = $usuario->id;
			$_SESSION["nombreApellido"] = $usuario->persona->nombreApellido;
			$_SESSION["creationDate"] = time();
		}
		return $this->loginView($request, $insensitiveData, "Email o contraseña incorrecta");
	}
	public function register(Request $request) {
		$data = $request->data();
		try {
			FormController::validateFields($data, REGISTER_FIELDS);
		} catch (EmptyRequiredField $e) {
			$errorMessage = $e->getMessage();
		} catch (WrongFieldType $e) {
			$errorMessage = $e->getMessage();
		}

		$insensitiveData = [
			"email" => $data["email"],
			"nombreApellido" => $data["nombreApellido"],
			"telefono" => $data["telefono"],
			"fechaNacimiento" => $data["fechaNacimiento"]
		];
		if ($data['password'] !== $data['repassword']) {
			$errorMessage = "Las contraseñas no coinciden";
			return $this->registerView($request, $insensitiveData, $errorMessage);
		}

		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		$data['repassword'] = null;

		try {
			$exists = Usuario::getByMail($data['email']);
			if (isset($exists)) {
				return $this->registerView($request, $insensitiveData, "Ya existe un usuario con ese email");
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

		// TODO: Cambiar esto o hacer que se muestre que se registro...
		$request->redirect("/login");
	}
}