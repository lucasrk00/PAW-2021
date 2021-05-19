<?php
namespace Paw\Core\Controllers;


use Exception;

class PaginationController {
	public static function generatePagination($lastPage, $num = 5, $currentPage = 1) {
		$currentPage = intval($currentPage);
		if ($currentPage < 1) throw new Exception("Min value for current page is 1");
		if ($currentPage > $lastPage) throw new Exception("Current page cannot be grater than  the max value");
		$half = intdiv($num, 2);

		$start = $currentPage - $half;
		if ($start < 1) {
			$start = 1;
		}

		$end = $start + $num - 1;
		if ($end >= $lastPage) {
			$end = $lastPage;
			$start = $end - $num + 1;
			if ($start < 1) {
				$start = 1;
			}
		}

		return [
			"pageStart" => $start,
			"pageEnd" => $end,
			"currentPage" => $currentPage,
			"lastPage" => $lastPage
		];
	}
}