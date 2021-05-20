<?php

namespace Paw\Core;

use Paw\Core\Controllers\FormController;
class Request {
	public function uri() {
		return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	}

	public function method() {
		return $_SERVER["REQUEST_METHOD"];
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