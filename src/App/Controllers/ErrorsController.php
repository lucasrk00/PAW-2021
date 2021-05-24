<?php
namespace Paw\App\Controllers;

use Paw\App\Controllers\BaseController;
use Paw\Core\Request;
class ErrorsController extends BaseController {
	public function notFound(Request $request) {

		$errorCode = '404';
		$errorMessage = 'El sitio al que intentas acceder no existe';
		require $this->viewPath . '/error.view.php';
	}
	public function internalError(Request $request) {
		$errorCode = '500';
		require $this->viewPath . '/error.view.php';
	}
}