<?php
namespace Paw\Core\Database;

use PDO;
use PDOException;
use Paw\Core\Config;
use Exception;


class ConnectionBuilder {
	private static ?PDO $instance = null;
	public static function getInstance(): PDO {
		return self::$instance;
	}
	public function make(Config $config): PDO {
		try {
			if (isset(self::$instance)) return ConnectionBuilder::$instance;

			$adapter = $config->get('DB_ADAPTER');
			$hostname = $config->get('DB_HOSTNAME');
			$dbname = $config->get('DB_NAME');
			$port = $config->get('DB_PORT');
			$charset = $config->get('DB_CHARSET');

			$connection = new PDO(
				"{$adapter}:host={$hostname};dbname={$dbname};port={$port}",
				$config->get('DB_USERNAME'),
				$config->get('DB_PASSWORD'),
				[
					'options' => [
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
					]
				]
			);
			self::$instance = $connection;
			return $connection;
		} catch (PDOException $e) {
			throw $e;
			die("Error Interno - Consulte al administrador");
		}
	}
}