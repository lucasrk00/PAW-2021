<?php

namespace Paw\Core;

use Paw\Core\Controllers\FormController;
use Paw\App\Models\Usuario;
use Exception;
class Request {
	private $messageStatus = [
		'message' => '',
		'type' => 'none'
	];
	public function __construct()
	{
		session_start();
		if (isset($_SESSION['statusMessage']))
			$this->messageStatus['message'] = $_SESSION['statusMessage'];
		if (isset($_SESSION['statusType']))
			$this->messageStatus['type'] = $_SESSION['statusType'];
		
		$_SESSION['statusMessage'] = null;
		$_SESSION['statusType'] = null;
	}
	public function uri() {
		return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	}

	public function method() {
		return $_SERVER["REQUEST_METHOD"];
	}

	public function isLoggedIn() {
		$user = $this->getAuthUser();
		return isset($_SESSION['logged']) && isset($user) && $_SESSION['logged'];
	}

	public function getAuthUser():?Usuario {
		if (!empty($_SESSION['usuarioId']) && isset($_SESSION['usuarioId'])) {
			try {
				return Usuario::getByPk($_SESSION['usuarioId']);
			} catch (Exception $e) {
				$this->clearSession();
				return null;
			}
		}
		return null;
	}
	public function clearSession() {
		$_SESSION = array();
		session_destroy();
	}

	public function redirect($location) {
		header("Location: {$location}", TRUE, 301);
		exit();
	}
	public function setStatusMessage(string $message, bool $isError = false, bool $saveInSession = false) {
		$type = $isError ? 'error':'success';
		if ($saveInSession) {
			$_SESSION['statusMessage'] = $message;
			$_SESSION['statusType'] = $type;
		}

		$this->messageStatus = [
			'message' => $message ?? '',
			'type' => $type ?? 'none'
		];
	}

	public function getStatusMessage() {
		return $this->messageStatus;
	}


	public function route() {
		return [
			$this->uri(),
			$this->method()
		];
	}
	public function query() {
		$queries = array();
		if (isset($_SERVER['QUERY_STRING'])) {
			parse_str($_SERVER['QUERY_STRING'], $queries);
		}
		foreach($queries as $fieldName => $value) {
			$queries[$fieldName] = FormController::validateInput($value);
		}
		return $queries;
	}

	public function getQueryField($field) {
		$query = $this ->  query();
		if (array_key_exists($field, $query)) {
			return $query[$field];
		}
	}
	public function hasQueryField($field) {
		$query = $this->query();
		return array_key_exists($field, $query);
	}
	public function data() {
		$postData = array();
		if ($this->method() == "POST") {
			foreach($_POST as $fieldName => $value) {
				$postData[$fieldName] = FormController::validateInput($value);
			}
		}
		return $postData;
	}
	public function file($fieldName) {
		if ($this->method() == "POST" && array_key_exists($fieldName, $_FILES)) {
			return $_FILES[$fieldName];
		}
		return null;
	}
}