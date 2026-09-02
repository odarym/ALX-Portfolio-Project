<?php

	if (!defined('ROOT')) {
		$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
		$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
		$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
		// When running with built-in router, scriptDir may be empty or root
		$base = ($scriptDir === '' || $scriptDir === '.') ? '' : $scriptDir;
		define('ROOT', rtrim($scheme . $host . $base, '/'));
	}