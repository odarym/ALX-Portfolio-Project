<?php

	// Start output buffering to prevent headers already sent issues
	if (!ob_get_level()) {
		ob_start();
	}

	// Start session if not already started
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	// Loads all required files
	require_once __DIR__ . "/config.php";
	require_once __DIR__ . "/functions.php";
	require_once __DIR__ . "/db/conn.php";




