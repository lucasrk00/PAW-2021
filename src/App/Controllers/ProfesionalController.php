<?php

namespace Paw\App\Controllers;

use Paw\Core\Controllers\PaginationController;
use Paw\Core\Request;
use Paw\App\Controllers\BaseController;
use Paw\App\Models\Profesional;

class ProfesionalController extends BaseController
{
	public function profesionales(Request $request) {
		$titulo = "Profesionales";
		$page = $request->getQueryField('page') ?? 1;
		$query = $request ->getQueryField('search');
		$pagination = PaginationController::generatePagination(4, 5, $page);
		$where = null;
		$whereParams = null;
		if (isset($query)) {
			$where = 'lower("nombre") like lower(?)';
			$whereParams = array("%{$query}%");
		}
		$profesionales = Profesional::getAll($where, $whereParams);

		require $this->viewPath . '/profesionales.view.php';
	}
}
