<?php

namespace Paw\App\Controllers;

use Paw\Core\Controllers\PaginationController;
use Paw\Core\Request;
use Paw\App\Controllers\BaseController;
use Paw\App\Models\ObraSocial;

class ObrasSocialesController extends BaseController
{
	public function obrasSociales(Request $request) {
		$titulo = "Obras Sociales";
		$validFilters = array('convenioIntegral', 'convenioAltaComplejidad', 'internacional', 'consultoriosExternos');

		$query = null;
		$queryStack = array();

		$nombreQuery = $request->getQueryField('nombre');
		if (isset($nombreQuery)) {
			array_push($queryStack, "%{$nombreQuery}%");
			$query = " lower(nombre) like lower(?) ";
		}

		foreach($validFilters as $filter) {
			$value = $request->getQueryField($filter);
			if (!isset($value)) continue;
			if (isset($query))
				$query .= " and ";

			array_push($queryStack, $value == 'on');
			$query .= '"'.$filter . '" = ? ';
		}

		$obrasSociales = ObraSocial::getAll($query, $queryStack);

		require $this->viewPath . '/obrasSociales.view.php';
	}
}
