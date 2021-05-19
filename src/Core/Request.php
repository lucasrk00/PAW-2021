<?php

namespace Paw\Core;

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
		return $queries;
	}
	public function data() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			return $_POST;
		}
	}
}