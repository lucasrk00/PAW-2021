<?php

namespace Paw\Core;

class Config {
	private array $configs;

	public function __construct()
	{
		$this->configs["DB_ADAPTER"] = getenv("DB_ADAPTER", "pgsql");
		$this->configs["DB_HOSTNAME"] = getenv("DB_HOSTNAME", "localhost");
		$this->configs["DB_NAME"] = getenv("DB_NAME", "postgres");
		$this->configs["DB_USERNAME"] = getenv("DB_USERNAME", "postgres");
		$this->configs["DB_PASSWORD"] = getenv("DB_PASSWORD", "admin");
		$this->configs["DB_PORT"] = getenv("DB_PORT", "5432");
		$this->configs["DB_CHARSET"] = getenv("DB_CHARSET", "utf8");
	}

	public function get($name) {
		return $this->configs[$name] ?? null;
	}

	public function joinPaths() {
		$paths = array();
		foreach (func_get_args() as $arg) {
			if ($arg != '') {
				$paths[] = $arg;
			}
		}
		return preg_replace('#/+#', '/', join('/', $paths));
	}
}