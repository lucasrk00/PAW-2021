<?php
namespace Paw\App\Controllers;

use Paw\App\Controllers\BaseController;
class ErrorsController extends BaseController {
	public function notFound() {
		echo "Not found";
		die;
	}
	public function internalError() {
		echo "Internal error";
		die;
	}
}