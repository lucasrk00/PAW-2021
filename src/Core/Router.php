<?php

namespace Paw\Core;

use Paw\Core\Exceptions\NotFound;
use Exception;

use Paw\Core\Request;

class Router {
	private array $routes = [
		"GET" => [],
		"POST" => [],
		"ERROR" => []
	];

	private function getController($path, $method) {
		if (!array_key_exists($method, $this->routes) || !array_key_exists($path, $this->routes[$method])) {
			throw new NotFound;
		}
		return $this->routes[$method][$path];
	}

	public function loadRoute($path, $controller, $method = "GET") {
		$this->routes[$method][$path] = $controller;
	}

	public function get($path, $controller) {
		$this->loadRoute($path, $controller, "GET");
	}
	public function post($path, $controller) {
		$this->loadRoute($path, $controller, "POST");
	}
	public function error($path, $controller) {
		$this->loadRoute($path, $controller, "ERROR");
	}

	private function _call($path, $httpMethod, $request) {
		list($controllerName, $method) = explode('@', $this->getController($path, $httpMethod));
		
		$controllerPath = "Paw\\App\\Controllers\\{$controllerName}";
		$controller = new $controllerPath;
		$controller -> $method($request);
	}
	public function call($request) {
		list($path, $httpMethod) = $request->route();
		return $this->_call($path, $httpMethod, $request);
	}
	public function callError($errorName, $request) {
		return $this->_call($errorName, "ERROR", $request);
	}
	public function direct(Request $request) {
		try {
			http_response_code(200);
			$this->call($request);
		} catch (NotFound $e) {
			http_response_code(404);
			$this->callError('notFound', $request);
		} catch (Exception $e) {
			http_response_code(500);
			$this->callError('internal', $request);
		}
	}
}