<?php

namespace Paw\App\Controllers;

use Paw\App\Controllers\BaseController;
use Paw\Core\Request;
use Exception;

class RoutesController extends BaseController {

	private function getNoticias($amount) {
		$noticias = array();
		foreach (range(1, $amount) as $i) {
			$noticia = [
				"title" => "Titulo de la noticia",
				"url" => "url-a-la-noticia",
				"imageUrl" => "assets/images/image-placeholder.png",
				"date" => "18/05/2021",
				"description" => "un texto muy largooooooooo"
			];
			array_push($noticias, $noticia);
		}
		return $noticias;
	}

	private function generatePagination($lastPage, $num = 5, $currentPage = 1) {
		if ($currentPage < 1) throw new Exception("Min value for current page is 1");
		if ($currentPage > $lastPage) throw new Exception("Current page cannot be grater than  the max value");
		$half = intdiv($num, 2);
		// $start = $currentPage >= $half ? $currentPage - $half : $half - $currentPage;
		$start = $currentPage - $half;
		$end = $currentPage + ($half);

		if ($end >= $lastPage) {
			$end = $lastPage - 1;
			$start = $end - $num + 1;
		} else if ($start < 1) {
			$start = 1;
			$end = $start + $num - 1;
		}

		$pages = array();

		return [
			"pageStart" => $start,
			"pageEnd" => $end,
			"currentPage" => $currentPage,
			"lastPage" => $lastPage
		];
	}

	public function index() {
		$noticias = $this->getNoticias(3);
		$titulo = "UNLuPAW Medical Group";
		require $this->viewPath . '/home.view.php';
	}

	public function institucion() {
		$titulo = "Institucion";
		require $this->viewPath . '/institucion.view.php';
	}
	public function listaDeTurnos() {
		$titulo = "Lista de Turnos";
		require $this->viewPath . '/listaDeTurnos.view.php';
	}
	public function login() {
		$titulo = "Login";
		require $this->viewPath . '/login.view.php';
	}
	public function noticias(Request $request) {
		$titulo = "Noticias";
		$noticias = $this->getNoticias(40);
		$page = $request->query()['page'] ?? 1;
		$pagination = $this->generatePagination(40, 5, $page);
		require $this->viewPath . '/noticias.view.php';
	}
	public function obrasSociales() {
		$titulo = "Obras Sociales";
		require $this->viewPath . '/obrasSociales.view.php';
	}
	public function profesionales() {
		$titulo = "Profesionales";
		require $this->viewPath . '/profesionales.view.php';
	}
	public function registrarse() {
		$titulo = "Registrarse";
		require $this->viewPath . '/registrarse.view.php';
	}
}